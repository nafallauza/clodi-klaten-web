<?php

require_once "config/database.php";

$resultHero = mysqli_query($conn, "SELECT * FROM hero LIMIT 1");
$hero = mysqli_fetch_assoc($resultHero);

$resultNavbar = mysqli_query($conn, "SELECT * FROM navbar LIMIT 1");
$navbar = mysqli_fetch_assoc($resultNavbar);

$resultFeature = mysqli_query($conn, "SELECT * FROM features WHERE status='active' ORDER BY id ASC"
);

$resultProducts = mysqli_query(
    $conn,
    "SELECT *
     FROM products
     WHERE status='active'
     ORDER BY id DESC"
);

$resultTestimonials = mysqli_query(
    $conn,
    "SELECT *
     FROM testimonials
     WHERE status='active'
     ORDER BY id DESC
     LIMIT 3"
);

$resultFooter = mysqli_query(
    $conn,
    "SELECT * FROM footer LIMIT 1"
);

$footer = mysqli_fetch_assoc($resultFooter);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clodi Klaten Babyshop</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            poppins: ['Poppins', 'sans-serif'],
            fredoka: ['Fredoka', 'sans-serif'],
          },
          colors: {
            babyBlue: '#15A0CE',
            babyMint: '#DFF5F1',
            babyCream: '#FFF1E4',
            babyPink: '#FFECEF',
            babyYellow: '#FFE500'
          },
          boxShadow: {
            soft: '0 18px 45px rgba(31, 39, 52, .08)',
            card: '0 10px 30px rgba(31, 39, 52, .06)'
          }
        }
      }
    }
  </script>

  <link rel="stylesheet" href="css/style.css" />
</head>

<body class="font-poppins text-slate-900 bg-white">
  <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6 h-[92px] flex items-center justify-between">
      <a href="#" class="shrink-0">
        <img
            src="<?= htmlspecialchars($navbar['logo']); ?>?v=<?= filemtime($navbar['logo']); ?>"
            alt="<?= htmlspecialchars($navbar['store_name']); ?>"
            class="w-[104px]">
    </a>

      <nav id="mainMenu" class="hidden md:flex items-center gap-11 text-[13px] font-semibold text-slate-700">
        <a class="hover:text-babyBlue transition" href="#">Home</a>
        <a class="hover:text-babyBlue transition" href="#produk">Produk</a>
        <a class="hover:text-babyBlue transition" href="#footer">Contact</a>
      </nav>

      <div class="flex items-center gap-4">
         

        <form class="hidden sm:flex h-10 w-[245px] rounded-full border border-slate-200 bg-white shadow-sm overflow-hidden">
          <input class="w-full px-5 text-sm outline-none placeholder:text-slate-400" placeholder="Search">
          <button class="m-[2px] w-9 rounded-full bg-babyBlue text-white grid place-items-center hover:bg-cyan-600 transition" type="submit">
            <i class="bi bi-search text-sm"></i>
          </button>
        </form>

        <button id="menuButton" class="md:hidden w-10 h-10 rounded-xl bg-slate-100 text-slate-700">
          <i class="bi bi-list text-2xl"></i>
        </button>
      </div>
    </div>

    <nav id="mobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white px-6 py-5 space-y-3 text-sm font-semibold">
      <a class="block" href="#">Home</a>
      <a class="block" href="#produk">Produk</a>
      <a class="block" href="#kontak">Contact</a>
    </nav>
  </header>

  <main>

<section class="hero-bg min-h-[520px] md:min-h-[570px] relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-6 min-h-[520px] md:min-h-[570px] flex items-center">

        <div class="max-w-[560px] pt-4">

            <h1 class="text-[34px] md:text-[46px] leading-[1.14] tracking-[-.035em] font-semibold text-slate-950">

                <?= nl2br(htmlspecialchars($hero['title'])); ?>

            </h1>

            <p class="mt-7 max-w-[400px] text-[16px] md:text-[18px] leading-relaxed font-medium text-slate-600">

                <?= htmlspecialchars($hero['subtitle']); ?>

            </p>

        </div>

    </div>

</section>

<section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Mengapa Memilih Kami?</h2>
            
            <div class="grid md:grid-cols-4 gap-8">

                <?php while($feature = mysqli_fetch_assoc($resultFeature)): ?>

            <div class="text-center p-6 hover:shadow-lg rounded-xl transition">

            <div class="text-5xl text-sky-500 mb-5">
                
                <i class="<?= htmlspecialchars($feature['icon']); ?>"></i>

            </div>

            <h3 class="text-xl font-bold mb-3">

                <?= htmlspecialchars($feature['title']); ?>

            </h3>

            <p class="text-slate-600 leading-relaxed">

                <?= htmlspecialchars($feature['description']); ?>

            </p>

            </div>

                <?php endwhile; ?>

            </div>

        </div>
    </section>

<section class="py-16 bg-[#FFF8F0]">
    <div class="max-w-6xl mx-auto px-4">

        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-slate-900 mb-8">
                Merek Favorit Si Kecil
            </h2>

            <!-- Brand List -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-5">

                <!-- MamyPoko -->
                <div class="group h-24 rounded-2xl border border-gray-200 flex items-center justify-center bg-white hover:shadow-lg hover:-translate-y-1 transition duration-300 cursor-pointer">
                    <img src="assets/img/mamypoko.jpg"
                        alt="MamyPoko"
                        class="h-10 object-contain group-hover:scale-105 transition">
                </div>

                <!-- Chicco -->
                <div class="group h-24 rounded-2xl border border-gray-200 flex items-center justify-center bg-white hover:shadow-lg hover:-translate-y-1 transition duration-300 cursor-pointer">
                    <img src="assets/img/Chicco.png"
                        alt="Chicco"
                        class="h-10 object-contain group-hover:scale-105 transition">
                </div>

                <!-- Cussons -->
                <div class="group h-24 rounded-2xl border border-gray-200 flex items-center justify-center bg-white hover:shadow-lg hover:-translate-y-1 transition duration-300 cursor-pointer">
                    <img src="assets/img/CussonsBaby.png"
                        alt="Cussons Baby"
                        class="h-10 object-contain group-hover:scale-105 transition">
                </div>

                <!-- Pigeon -->
                <div class="group h-24 rounded-2xl border border-gray-200 flex items-center justify-center bg-white hover:shadow-lg hover:-translate-y-1 transition duration-300 cursor-pointer">
                    <img src="assets/img/Pigeon.png"
                        alt="Pigeon"
                        class="h-9 object-contain group-hover:scale-105 transition">
                </div>

                <!-- Kodomo -->
                <div class="group h-24 rounded-2xl border border-gray-200 flex items-center justify-center bg-white hover:shadow-lg hover:-translate-y-1 transition duration-300 cursor-pointer">
                    <img src="assets/img/Kodomo.png"
                        alt="Kodomo"
                        class="h-10 object-contain group-hover:scale-105 transition">
                </div>

                <!-- Johnson -->
                <div class="group h-24 rounded-2xl border border-gray-200 flex items-center justify-center bg-white hover:shadow-lg hover:-translate-y-1 transition duration-300 cursor-pointer">
                    <img src="assets/img/Johnson.png"
                        alt="Johnson's Baby"
                        class="h-10 object-contain group-hover:scale-105 transition">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Promo 1 -->
                <div class="bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl p-8 md:p-12 flex flex-col justify-between">
                    <div>
                        <div class="inline-block bg-primary text-white px-4 py-2 rounded-full text-sm font-bold mb-4">
                            PROMO SPESIAL
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                            Promo Spesial Minggu Ini!
                        </h3>
                        <p class="text-gray-700 mb-6">
                            Dapatkan diskon hingga 50% untuk berbagai produk pilihan.
                        </p>
                    </div>
                </div>
                        <div class="bg-gradient-to-r from-green-200 to-green-100 rounded-2xl p-8 md:p-12 flex flex-col justify-between">
                    <div>
                        <div class="inline-block bg-success text-white px-4 py-2 rounded-full text-sm font-bold mb-4">
                            GRATIS ONGKIR
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                            Gratis Ongkir
                        </h3>
                        <p class="text-gray-700 mb-6">
                            Belanja minimal Rp150.000 GRATIS ONGKIR ke seluruh Indonesia!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>        

    <section id="produk" class="max-w-7xl mx-auto px-6 pt-20 pb-16">
      <div class="flex items-center justify-between mb-7">
        <h2 class="text-[28px] md:text-[31px] font-extrabold tracking-[-.04em]">Produk Populer</h2>
        <a href="#" class="text-sm font-semibold text-slate-500 hover:text-babyBlue">Lihat Semua Produk</a>
      </div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

<?php while($product=mysqli_fetch_assoc($resultProducts)): ?>

<div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col h-full">

    <img
        src="<?= htmlspecialchars($product['image']); ?>"
        class="w-full h-64 object-cover">

    <div class="p-5 flex flex-col flex-grow">

        <span class="text-sm text-sky-600 font-semibold">

            <?= htmlspecialchars($product['category']); ?>

        </span>

        <h3 class="text-lg font-bold mt-2 line-clamp-2">

            <?= htmlspecialchars($product['name']); ?>

        </h3>

        <div class="flex items-center mt-2">

            ⭐ <?= $product['rating']; ?>

        </div>

        <div class="mt-4 flex items-end justify-between">
            <div>
                <?php if($product['original_price']) : ?>
                    <span class="line-through text-gray-400 text-sm">
                        Rp <?= number_format($product['original_price'],0,",","."); ?>
                    </span>
                <?php endif; ?>
                <div class="text-sky-600 text-xl font-bold">
                    Rp <?= number_format($product['price'],0,",","."); ?>
                </div>
            </div>
        </div>

        <?php 
        $rawPhone = isset($footer['phone']) ? $footer['phone'] : "085353432343";
        $waNumber = preg_replace('/[^0-9]/', '', $rawPhone);
        if (substr($waNumber, 0, 1) === '0') {
            $waNumber = '62' . substr($waNumber, 1);
        }
        $waMessage = rawurlencode("Halo Clodi Klaten! Saya tertarik dengan produk {$product['name']} seharga Rp " . number_format($product['price'],0,",",".") . ".");
        $waLink = "https://wa.me/{$waNumber}?text={$waMessage}";
        ?>
        <a href="<?= $waLink; ?>" target="_blank" class="flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#1ebe57] text-white font-medium py-2.5 rounded-lg transition duration-300 mt-auto text-[15px]">
            <i class="bi bi-whatsapp"></i> Pesan via WA
        </a>

    </div>

</div>

<?php endwhile; ?>

</div>

    </section>

    <section class="max-w-7xl mx-auto px-6 pt-12 pb-16">
      <div class="flex items-center justify-between mb-7">
        <h2 class="text-[28px] md:text-[31px] font-extrabold tracking-[-.04em]">Rekomendasi Untuk Anda</h2>
        <a href="#" class="text-sm font-semibold text-slate-500 hover:text-babyBlue">Lihat Semua Produk</a>
      </div>

      <div id="recommendedProducts" class="grid grid-cols-2 lg:grid-cols-4 gap-x-5 gap-y-10"></div>
    </section>

    <section class="bg-[#FFF1E9] py-12">
      <div class="max-w-7xl mx-auto px-6 relative">
        <div class="text-center">
          <h2 class="font-fredoka text-[30px] md:text-[34px] font-bold tracking-[-.02em]">Dengar dari Orang Tua Bahagia</h2>
        </div>

        <button class="testimonials-nav left-0 md:left-3"><i class="bi bi-chevron-left"></i></button>
        <button class="testimonials-nav right-0 md:right-3"><i class="bi bi-chevron-right"></i></button>

        <div class="mt-9 grid grid-cols-1 md:grid-cols-3 gap-6 md:px-12">
          
<?php while($testimonials=mysqli_fetch_assoc($resultTestimonials)): ?>

<article class="testimonials-card">

<div class="text-yellow-400 text-sm tracking-wide">

<?php

$rating = (int)$testimonials['rating'];

for($i=1;$i<=5;$i++){

    echo $i <= $rating ? "★" : "☆";

}

?>

</div>

<p>

<?= htmlspecialchars($testimonials['comment']); ?>

</p>

<div class="flex items-center gap-3 mt-4">

<div class="w-14 h-14 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xl">
    <?= strtoupper(substr($testimonials['customer_name'], 0, 1)); ?>
</div>

<strong>

<?= htmlspecialchars($testimonials['customer_name']); ?>

</strong>

</div>

</article>

<?php endwhile; ?>

        </div>
      </div>
    </section>

<section id="lokasi" class="py-20 bg-white">

<div class="max-w-7xl mx-auto px-6">

<div class="text-center mb-12">

<h2 class="text-4xl font-bold">

📍 Lokasi Toko Kami

</h2>

<p class="text-slate-500 mt-3">

Datang langsung ke Clodi Klaten Babyshop atau buka navigasi melalui Google Maps.

</p>

</div>

<div class="grid lg:grid-cols-2 gap-10 items-center">

<!-- Google Maps -->

<div class="rounded-3xl overflow-hidden shadow-xl border border-slate-200">

<iframe
src="https://www.google.com/maps?q=Clodi+Klaten+Babyshop&output=embed"
width="100%"
height="420"
style="border:0;"
loading="lazy"
allowfullscreen>
</iframe>

</div>

<!-- Informasi -->

<div>

<h3 class="text-2xl font-bold mb-6">

Clodi Klaten Babyshop

</h3>

<div class="space-y-5">

<div class="flex gap-4">

<div class="text-pink-500 text-2xl">

<i class="fas fa-map-marker-alt"></i>

</div>

<div>

<h4 class="font-semibold">

Alamat

</h4>

<p class="text-slate-600">

<?= htmlspecialchars($footer['address']); ?>

</p>

</div>

</div>



<a
href="https://maps.google.com/?q=Clodi+Klaten+Babyshop"
target="_blank"
class="inline-flex items-center gap-3 mt-8 bg-sky-600 hover:bg-sky-700 text-white px-7 py-4 rounded-xl transition">

<i class="fas fa-location-arrow"></i>

Buka Google Maps

</a>

</div>

</div>

</div>

</div>

</section>


<footer
id="footer"
class="bg-[#FFF1E9] border-t border-[#F1DDCF] mt-16">

<div class="max-w-7xl mx-auto px-6 py-14">

<div class="grid lg:grid-cols-4 md:grid-cols-2 gap-10">

<!-- Kolom 1 -->

<div>

<h3 class="text-2xl font-bold text-slate-900 mb-4">

<i class="fas fa-baby text-pink-500 mr-2"></i>

Clodi Klaten Babyshop

</h3>

<p class="text-slate-500 leading-7">

Toko perlengkapan bayi terpercaya dengan produk berkualitas tinggi dari berbagai brand terbaik.

</p>

</div>

<!-- Kolom 2 -->

<div>

<h3 class="font-bold text-xl mb-5">

Kontak

</h3>

<div class="space-y-4 text-slate-600">

<p>

<i class="fas fa-phone w-6 text-green-500"></i>

<?= htmlspecialchars($footer['phone']); ?>

</p>

<p>

<i class="fas fa-envelope w-6 text-blue-500"></i>

<?= htmlspecialchars($footer['email']); ?>

</p>

</div>

</div>

<!-- Kolom 3 -->

<div>

<h3 class="font-bold text-xl mb-5">

Sosial Media

</h3>

<div class="space-y-4">

<a
href="<?= htmlspecialchars($footer['instagram']); ?>"
target="_blank"
class="flex items-center gap-3 hover:text-pink-500">

<i class="fab fa-instagram text-xl"></i>

Instagram

</a>

<a
href="<?= htmlspecialchars($footer['facebook']); ?>"
target="_blank"
class="flex items-center gap-3 hover:text-blue-600">

<i class="fab fa-facebook text-xl"></i>

Facebook

</a>

<a
href="<?= htmlspecialchars($footer['youtube']); ?>"
target="_blank"
class="flex items-center gap-3 hover:text-red-600">

<i class="fab fa-youtube text-xl"></i>

YouTube

</a>

<a
href="<?= htmlspecialchars($footer['tiktok']); ?>"
target="_blank"
class="flex items-center gap-3 hover:text-black">

<i class="fab fa-tiktok text-xl"></i>

TikTok

</a>

</div>

</div>

<!-- Kolom 4 -->

<div>

<h3 class="font-bold text-xl mb-5">

Layanan

</h3>

<div class="space-y-3 text-slate-600">

<p>

<i class="fas fa-credit-card text-blue-500"></i>

Pembayaran Aman

</p>

<p>

<i class="fas fa-truck text-green-500"></i>

Pengiriman Cepat

</p>

<p>

<i class="fas fa-shield-alt text-cyan-500"></i>

Produk Original

</p>

<p>

<i class="fas fa-headset text-orange-500"></i>

Customer Support

</p>

</div>

</div>

</div>

<hr class="my-10 border-[#E8D6C8]">

<div class="text-center text-slate-500">

<?= htmlspecialchars($footer['copyright']); ?>

</div>

</div>

</footer>

  <script>
    <?php 
      $rawPhoneJs = isset($footer['phone']) ? $footer['phone'] : "085353432343";
      $waNumberJs = preg_replace('/[^0-9]/', '', $rawPhoneJs);
      if (substr($waNumberJs, 0, 1) === '0') {
          $waNumberJs = '62' . substr($waNumberJs, 1);
      }
    ?>
    window.GLOBAL_WA_NUMBER = "<?= $waNumberJs ?>";
  </script>
  <script src="js/main.js"></script>
</body>
</html>