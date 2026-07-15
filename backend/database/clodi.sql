


SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS admins;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- TABLE ADMIN
-- =====================================================

CREATE TABLE admins (

    id INT AUTO_INCREMENT PRIMARY KEY,

    fullname VARCHAR(100) NOT NULL,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- =====================================================
-- DEFAULT ADMIN
-- Username : admin
-- Password : admin123
--
-- Hash dibuat menggunakan password_hash()
-- dan akan diverifikasi menggunakan
-- password_verify() pada login.php
-- =====================================================

INSERT INTO admins
(
    fullname,
    username,
    password
)
VALUES
(
    'Administrator',
    'admin',
    '$2y$10$SZdBNtOb9DbyczPnfJZRGurEveYA8SjVmDCycfLtbDmS9uu8KIh4K'
);

-- =====================================================
-- TABLE PRODUCTS
-- =====================================================

CREATE TABLE products (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(200) NOT NULL,

    category VARCHAR(100) NOT NULL,

    description TEXT,

    image VARCHAR(255) NOT NULL,

    price INT NOT NULL,

    original_price INT DEFAULT NULL,

    rating DECIMAL(2,1) DEFAULT 5.0,

    is_sale TINYINT(1) DEFAULT 0,

    status ENUM('active','inactive')
    DEFAULT 'active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

-- =====================================================
-- DATA AWAL
-- =====================================================

INSERT INTO products
(
    name,
    category,
    description,
    image,
    price,
    original_price,
    rating,
    is_sale,
    status
)

VALUES

(
'Mobil Mainan Disney Smart Wheels',
'Mainan',
'Mobil mainan anak dengan karakter Disney Cars.',
'assets/img/produk-disney-cars.jpg',
185000,
210000,
5,
1,
'active'
),

(
'Sepeda Keseimbangan Anak Pink',
'Mainan',
'Balance bike anak berbahan ringan.',
'assets/img/produk-balance-bike.jpg',
320000,
360000,
5,
1,
'active'
),

(
'Sterilizer Botol Susu Philips Avent',
'Peralatan Makan',
'Sterilizer elektrik untuk botol susu bayi.',
'assets/img/produk-avent-sterilizer.jpg',
450000,
520000,
4,
0,
'active'
),

(
'Playmat Bayi Chicco Baby Gym',
'Mainan',
'Playmat bayi edukatif.',
'assets/img/produk-chicco-playmat.jpg',
275000,
NULL,
5,
0,
'active'
),

(
'Stroller Bayi Biru',
'Stroller',
'Stroller bayi ringan.',
'assets/img/produk-stroller-blue.jpg',
399000,
450000,
4,
0,
'active'
),

(
'Bouncer Bayi Cokelat',
'Bouncer',
'Bouncer bayi berkualitas.',
'assets/img/produk-bouncer-brown.jpg',
285000,
NULL,
5,
0,
'active'
),

(
'Stroller Bayi Lipat Pink',
'Stroller',
'Stroller lipat praktis.',
'assets/img/produk-stroller-pink.jpg',
420000,
480000,
4,
0,
'active'
),

(
'Popok Bayi Pampers Comfort Sec',
'Popok',
'Popok bayi premium.',
'assets/img/produk-pampers.jpg',
135000,
160000,
5,
1,
'active'
),

(
'Gendongan Bayi Ergobaby Adapt',
'Gendongan',
'Gendongan ergonomis.',
'assets/img/produk-ergobaby-carrier.jpg',
550000,
620000,
5,
0,
'active'
);

-- =====================================================
-- TABLE HERO
-- =====================================================

CREATE TABLE hero (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,

    subtitle TEXT NOT NULL,

    image VARCHAR(255) NOT NULL,

    cta_text VARCHAR(100) NOT NULL,

    cta_link VARCHAR(255) NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

INSERT INTO hero
(
title,
subtitle,
image,
cta_text,
cta_link
)

VALUES
(
'Lengkapi Kebutuhan Si Kecil Dengan Produk Terbaik',

'Clodi Klaten Babyshop menyediakan berbagai perlengkapan bayi berkualitas, aman, nyaman, dan terpercaya untuk buah hati Anda.',

'assets/img/hero.png',

'Belanja Sekarang',

'#products'
);

-- =====================================================
-- TABLE NAVBAR
-- =====================================================

CREATE TABLE navbar (

    id INT AUTO_INCREMENT PRIMARY KEY,

    logo VARCHAR(255) NOT NULL,

    store_name VARCHAR(150) NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

INSERT INTO navbar
(
logo,
store_name
)

VALUES
(
'assets/img/logo.png',

'Clodi Klaten Babyshop'
);

-- =====================================================
-- TABLE FEATURES
-- =====================================================

CREATE TABLE features (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(150) NOT NULL,

    description TEXT NOT NULL,

    icon VARCHAR(100) NOT NULL,

    status ENUM('active','inactive') DEFAULT 'active',

    sort_order INT DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

INSERT INTO features
(
title,
description,
icon,
sort_order
)

VALUES

(
'Produk Berkualitas',

'Semua produk telah dipilih dengan kualitas terbaik.',

'fa-box',

1
),

(
'Harga Terjangkau',

'Memberikan harga terbaik untuk seluruh pelanggan.',

'fa-tags',

2
),

(
'Pengiriman Cepat',

'Pesanan diproses dan dikirim dengan cepat.',

'fa-truck',

3
),

(
'Pelayanan Ramah',

'Siap membantu kebutuhan pelanggan setiap hari.',

'fa-heart',

4
);

-- =====================================================
-- TABLE TESTIMONIALS
-- =====================================================

CREATE TABLE testimonials (

    id INT AUTO_INCREMENT PRIMARY KEY,

    customer_name VARCHAR(150) NOT NULL,

    photo VARCHAR(255) DEFAULT NULL,

    rating DECIMAL(2,1) DEFAULT 5.0,

    comment TEXT NOT NULL,

    status ENUM('active','inactive') DEFAULT 'active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

INSERT INTO testimonials
(
customer_name,
photo,
rating,
comment,
status
)

VALUES

(
'Siti Rahma',
'assets/img/testimoni-1.jpg',
5.0,
'Pelayanannya sangat ramah dan produknya berkualitas. Sangat puas berbelanja di Clodi Klaten Babyshop.',
'active'
),

(
'Andi Pratama',
'assets/img/testimoni-2.jpg',
4.5,
'Harga terjangkau dan pengiriman cepat. Produk sesuai dengan deskripsi.',
'active'
),

(
'Dewi Lestari',
'assets/img/testimoni-3.jpg',
5.0,
'Pilihan produk bayi sangat lengkap dan original. Recommended!',
'active'
);

-- =====================================================
-- TABLE FOOTER
-- =====================================================

CREATE TABLE footer (

    id INT AUTO_INCREMENT PRIMARY KEY,

    address TEXT NOT NULL,

    phone VARCHAR(30) NOT NULL,

    email VARCHAR(150) NOT NULL,

    facebook VARCHAR(255) DEFAULT NULL,

    instagram VARCHAR(255) DEFAULT NULL,

    youtube VARCHAR(255) DEFAULT NULL,

    tiktok VARCHAR(255) DEFAULT NULL,

    copyright VARCHAR(255) NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

INSERT INTO footer
(
address,
phone,
email,
facebook,
instagram,
youtube,
tiktok,
copyright
)

VALUES
(
'Jl. Klaten No. 123, Klaten, Jawa Tengah',

'0812-3456-7890',

'admin@clodiklatenbabyshop.com',

'https://facebook.com/clodiklatenbabyshop',

'https://instagram.com/clodiklatenbabyshop',

'https://youtube.com/@clodiklatenbabyshop',

'https://tiktok.com/@clodiklatenbabyshop',

'© 2026 Clodi Klaten Babyshop. All Rights Reserved.'
);
