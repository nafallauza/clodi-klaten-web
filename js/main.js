const products = [
  {
    name: "Mobil Mainan Disney Smart Wheels",
    price:185.000,
    oldPrice:210.000,
    image: "assets/img/produk-disney-cars.jpg",
    sale: true,
    rating: 5
  },
  {
    name: "Sepeda Keseimbangan Anak Pink",
    price:320.000,
    oldPrice:360.000,
    image: "assets/img/produk-balance-bike.jpg",
    sale: true,
    rating: 5
  },
  {
    name: "Sterilizer Botol Susu Philips Avent",
    price:450.000,
    oldPrice:520.000,
    image: "assets/img/produk-avent-sterilizer.jpg",
    sale: false,
    rating: 4
  },
  {
    name: "Playmat Bayi Chicco Baby Gym",
    price:275.000,
    oldPrice:290.000,
    image: "assets/img/produk-chicco-playmat.jpg",
    sale: false,
    rating: 5
  },
  {
    name: "Stroller Bayi Biru",
    price:399.000,
    oldPrice:450.000,
    image: "assets/img/produk-stroller-blue.jpg",
    sale: false,
    rating: 4
  },
  {
    name: "Bouncer Bayi Cokelat",
    price:250.000,
    oldPrice:290.000,
    image: "assets/img/produk-bouncer-brown.jpg",
    sale: false,
    rating: 5
  },
  {
    name: "Stroller Bayi Lipat Pink",
    price:420.000,
    oldPrice:480.000,
    image: "assets/img/produk-stroller-pink.jpg",
    sale: false,
    rating: 4
  },
  {
    name: "Popok Bayi Pampers Confort Sec",
    price: 135.000,
    oldPrice:160.000,
    image: "assets/img/produk-pampers.jpg",
    sale: true,
    rating: 5
  },
  {
    name: "Gendongan Bayi Ergobaby Adapt",
    price:550.000,
    oldPrice:620.000,
    image: "assets/img/produk-ergobaby-carrier.jpg",
    sale: false,
    rating: 5
  }
];

const popularTarget = document.getElementById("popularProducts");
const recommendedTarget = document.getElementById("recommendedProducts");

function formatPrice(price){

    if(price===null || price==="")
        return "";

    if(typeof price==="string"){

        price = price.replace(/[^\d]/g,"");

    }

    return "Rp " + Number(price).toLocaleString("id-ID");

}

function makeStars(rating) {
  return Array.from({ length: 5 }, (_, index) => {
    return `<span class="${index >= rating ? "empty" : ""}">☆</span>`;
  }).join("");
}

function createProductCard(product) {
  const waNumber = "085353432343";

  const waMessage = encodeURIComponent(
    `Halo Clodi Klaten, saya ingin bertanya mengenai produk "${product.name}". Apakah masih tersedia?`
  );

  return `
    <article class="product-card">

      <div class="product-photo">
        <img src="${product.image}" alt="${product.name}" loading="lazy">

        ${product.sale ? '<span class="sale-label">Sale</span>' : ''}

        <div class="product-actions">
          <button class="product-action" aria-label="Tambah ke favorit">
            <i class="bi bi-heart"></i>
          </button>

          <button class="product-action" aria-label="Tambah ke keranjang">
            <i class="bi bi-cart3"></i>
          </button>
        </div>
      </div>

      <!-- Tombol WhatsApp -->
      <div class="px-4 mt-4">
        <a
          href="https://wa.me/${waNumber}?text=${waMessage}"
          target="_blank"
          class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-xl transition duration-300"
        >
          <i class="bi bi-whatsapp"></i>
          Tanya via WhatsApp
        </a>
      </div>

      <div class="product-info">
        <h3 class="product-name">${product.name}</h3>

        <div>
          <span class="price">${formatPrice(product.price)}</span>

${product.original_price
  ? `<span class="old-price">${formatPrice(product.original_price)}</span>`
  : ""}
        </div>

        <div class="star-row">
          ${makeStars(product.rating)}
        </div>
        
      </div>

    </article>
  `;
}

function render(target, data) {
  if (!target) return;
  target.innerHTML = data.map(createProductCard).join("");
}

loadProducts();

async function loadProducts() {

  try {

    const response = await fetch("api/products/read.php");

    if (!response.ok) {
      throw new Error("Gagal mengambil data produk.");
    }

    const apiProducts = await response.json();

render(popularTarget, apiProducts.slice(0, 8));

render(recommendedTarget, [
  apiProducts[8],
  apiProducts[6],
  apiProducts[2],
  apiProducts[5]
].filter(Boolean));

  } catch (error) {

    console.error(error);

    // Fallback jika API gagal
    render(popularTarget, products.slice(0, 8));

    render(recommendedTarget, [
      products[8],
      products[6],
      products[2],
      products[5]
    ]);

  }

}

document.querySelectorAll("form").forEach((form) => {
  form.addEventListener("submit", (event) => event.preventDefault());
});

const menuButton = document.getElementById("menuButton");
const mobileMenu = document.getElementById("mobileMenu");

if (menuButton && mobileMenu) {
  menuButton.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
  });
}