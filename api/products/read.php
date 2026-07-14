<?php

require_once "../../config/database.php";

header("Content-Type: application/json; charset=UTF-8");

$sql = "
SELECT
    id,
    name,
    category,
    description,
    image,
    price,
    original_price,
    rating,
    is_sale,
    status
FROM products
WHERE status = ?
ORDER BY created_at DESC
";

$stmt = mysqli_prepare($conn, $sql);

$status = "active";

mysqli_stmt_bind_param($stmt, "s", $status);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$products = [];

while ($row = mysqli_fetch_assoc($result)) {

    $products[] = [

        "id" => (int) $row["id"],

        "name" => $row["name"],

        "category" => $row["category"],

        "description" => $row["description"],

        "image" => $row["image"],

        "price" => (int) $row["price"],

        "original_price" => $row["original_price"] !== null
            ? (int) $row["original_price"]
            : null,

        "rating" => (float) $row["rating"],

        "is_sale" => (bool) $row["is_sale"]

    ];

}

echo json_encode(
    $products,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
);

mysqli_stmt_close($stmt);
mysqli_close($conn);