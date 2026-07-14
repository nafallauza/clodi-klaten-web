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
  const waNumber = window.GLOBAL_WA_NUMBER || "6285353432343";

  const waMessage = encodeURIComponent(
    `Halo Clodi Klaten! Saya tertarik dengan produk ${product.name} seharga Rp ${Number(product.price).toLocaleString("id-ID")}.`
  );

  return `
    <article class="product-card flex flex-col h-full bg-white rounded-2xl shadow-md overflow-hidden">

      <div class="product-photo relative">
        <img src="${product.image}" alt="${product.name}" loading="lazy" class="w-full h-64 object-cover">

        ${product.sale ? '<span class="sale-label absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">Sale</span>' : ''}
      </div>

      <div class="product-info p-5 flex flex-col flex-grow">
        <span class="text-sm text-sky-600 font-semibold mb-2 block">${product.category}</span>
        <h3 class="product-name text-lg font-bold line-clamp-2">${product.name}</h3>

        <div class="product-rating flex items-center mt-2 text-yellow-400">
          ${makeStars(product.rating)}
        </div>

        <div class="product-price mt-4 flex items-end justify-between">
          <div>
            ${
              product.original_price
                ? `<span class="price-original line-through text-gray-400 text-sm">Rp ${Number(
                    product.original_price
                  ).toLocaleString("id-ID")}</span>`
                : ""
            }
            <span class="price-current text-sky-600 text-xl font-bold block">${formatPrice(
              product.price
            )}</span>
          </div>
        </div>

        <!-- Tombol WhatsApp -->
        <a
          href="https://wa.me/${waNumber}?text=${waMessage}"
          target="_blank"
          class="flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#1ebe57] text-white font-medium py-2.5 rounded-lg transition duration-300 mt-auto text-[15px]"
        >
          <i class="bi bi-whatsapp"></i>
          Pesan via WA
        </a>
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