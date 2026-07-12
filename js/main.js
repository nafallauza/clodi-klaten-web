const products = [
  {
    name: "Mobil Mainan Disney Smart Wheels",
    price: "Rp 185.000",
    oldPrice: "Rp210.000",
    image: "assets/img/produk-disney-cars.jpg",
    sale: true,
    rating: 5
  },
  {
    name: "Sepeda Keseimbangan Anak Pink",
    price: "Rp 320.000",
    oldPrice: "Rp360.000",
    image: "assets/img/produk-balance-bike.jpg",
    sale: true,
    rating: 5
  },
  {
    name: "Sterilizer Botol Susu Philips Avent",
    price: "Rp 450.000",
    oldPrice: "Rp520.000",
    image: "assets/img/produk-avent-sterilizer.jpg",
    sale: false,
    rating: 4
  },
  {
    name: "Playmat Bayi Chicco Baby Gym",
    price: "Rp 275.000",
    oldPrice: "",
    image: "assets/img/produk-chicco-playmat.jpg",
    sale: false,
    rating: 5
  },
  {
    name: "Stroller Bayi Biru",
    price: "Rp 399.000",
    oldPrice: "Rp450.000",
    image: "assets/img/produk-stroller-blue.jpg",
    sale: false,
    rating: 4
  },
  {
    name: "Bouncer Bayi Cokelat",
    price: "Rp 285.000",
    oldPrice: "",
    image: "assets/img/produk-bouncer-brown.jpg",
    sale: false,
    rating: 5
  },
  {
    name: "Stroller Bayi Lipat Pink",
    price: "Rp 420.000",
    oldPrice: "Rp480.000",
    image: "assets/img/produk-stroller-pink.jpg",
    sale: false,
    rating: 4
  },
  {
    name: "Popok Bayi Pampers Confort Sec",
    price: "Rp 135.000",
    oldPrice: "Rp160.000",
    image: "assets/img/produk-pampers.jpg",
    sale: true,
    rating: 5
  },
  {
    name: "Gendongan Bayi Ergobaby Adapt",
    price: "Rp 550.000",
    oldPrice: "Rp620.000",
    image: "assets/img/produk-ergobaby-carrier.jpg",
    sale: false,
    rating: 5
  }
];

const popularTarget = document.getElementById("popularProducts");
const recommendedTarget = document.getElementById("recommendedProducts");

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
          <span class="price">${product.price}</span>

          ${product.oldPrice ? `<span class="old-price">${product.oldPrice}</span>` : ''}
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

render(popularTarget, products.slice(0, 8));
render(recommendedTarget, [
  products[8],
  products[6],
  products[2],
  products[5]
]);

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