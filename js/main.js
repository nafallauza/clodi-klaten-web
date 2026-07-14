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
    <article class="product-card bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-babyBlue hover:shadow-lg transition-all duration-300 flex flex-col h-full group">

      <div class="relative w-full h-56 bg-slate-50 overflow-hidden">
        <img src="${product.image}" alt="${product.name}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        ${product.sale ? '<span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Sale</span>' : ''}
      </div>

      <div class="p-4 flex flex-col flex-grow">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold bg-slate-100 px-2 py-0.5 rounded">
                ${product.category}
            </span>
            <div class="flex items-center text-xs text-slate-600 font-medium">
                <i class="bi bi-star-fill text-yellow-400 mr-1"></i> ${product.rating}
            </div>
        </div>

        <h3 class="text-[15px] font-bold leading-tight text-slate-800 mt-1 line-clamp-2 hover:text-babyBlue transition-colors cursor-pointer">
            ${product.name}
        </h3>

        <div class="mt-3 flex flex-col justify-end flex-grow">
            ${
              product.original_price
                ? `<span class="line-through text-slate-400 text-[13px] font-medium">Rp ${Number(
                    product.original_price
                  ).toLocaleString("id-ID")}</span>`
                : ""
            }
            <div class="text-babyBlue text-lg font-extrabold tracking-tight">
                ${formatPrice(product.price)}
            </div>
        </div>

        <a
          href="https://wa.me/${waNumber}?text=${waMessage}"
          target="_blank"
          class="flex items-center justify-center gap-2 w-full bg-white border-2 border-[#25D366] text-[#25D366] hover:bg-[#25D366] hover:text-white font-semibold py-2 rounded-lg transition-all duration-300 mt-4 text-[14px]"
        >
          <i class="bi bi-whatsapp text-lg"></i>
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