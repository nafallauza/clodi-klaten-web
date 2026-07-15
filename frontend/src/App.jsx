import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';

function App() {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const API_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000';
    fetch(`${API_URL}/api/frontend-data`)
      .then(res => {
        if (!res.ok) throw new Error('Failed to fetch data');
        return res.json();
      })
      .then(json => {
        setData(json);
        setLoading(false);
      })
      .catch(err => {
        setError(err.message);
        setLoading(false);
      });
  }, []);

  if (loading) return <div className="min-h-screen flex items-center justify-center">Loading...</div>;
  if (error) return <div className="min-h-screen flex items-center justify-center text-red-500">Error: {error}</div>;

  return (
    <div className="font-poppins text-slate-900 bg-white">
      <Navbar navbarData={data.navbar} />
      
      {/* Hero Section */}
      <section className="hero-bg min-h-[520px] md:min-h-[570px] relative overflow-hidden bg-gradient-to-r from-sky-50 to-blue-50">
        <div className="max-w-7xl mx-auto px-6 min-h-[520px] md:min-h-[570px] flex items-center">
          <div className="max-w-[560px] pt-4">
            <h1 className="text-[34px] md:text-[46px] leading-[1.14] tracking-[-.035em] font-semibold text-slate-950"
                dangerouslySetInnerHTML={{ __html: data.hero.title }}>
            </h1>
            <p className="mt-7 max-w-[400px] text-[16px] md:text-[18px] leading-relaxed font-medium text-slate-600">
              {data.hero.subtitle}
            </p>
          </div>
        </div>
      </section>

      {/* Feature Section */}
      <section className="py-16 md:py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl md:text-4xl font-bold text-center mb-12">Mengapa Memilih Kami?</h2>
          <div className="grid md:grid-cols-4 gap-8">
            {data.features.map(feature => (
              <div key={feature.id} className="text-center p-6 hover:shadow-lg rounded-xl transition">
                <div className="text-5xl text-sky-500 mb-5">
                  <i className={feature.icon}></i>
                </div>
                <h3 className="text-xl font-bold mb-3">{feature.title}</h3>
                <p className="text-slate-600 leading-relaxed">{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Products Section */}
      <section id="produk" className="py-20 bg-slate-50">
        <div className="max-w-7xl mx-auto px-6">
          <h2 className="text-[28px] font-bold text-center mb-12">Produk Unggulan</h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            {data.products.map(product => {
              const WA_PHONE = data.footer.phone || "6281234567890";
              const waText = `Halo Clodi Klaten! Saya tertarik dengan produk *${product.name}* seharga *Rp ${parseInt(product.price).toLocaleString('id-ID')}*.`;
              const waLink = `https://api.whatsapp.com/send?phone=${WA_PHONE}&text=${encodeURIComponent(waText)}`;
              
              return (
                <div key={product.id} className="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-300">
                  <div className="relative pt-[100%] overflow-hidden bg-slate-100">
                    <img src={`${import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'}/${product.image}`} alt={product.name} className="absolute inset-0 w-full h-full object-cover" />
                  </div>
                  <div className="p-4">
                    <p className="text-xs font-semibold text-slate-500 mb-1">{product.category}</p>
                    <h3 className="font-bold text-slate-800 leading-tight mb-2 line-clamp-2">{product.name}</h3>
                    <div className="flex flex-col mb-3">
                      <span className="font-bold text-lg text-emerald-600">Rp {parseInt(product.price).toLocaleString('id-ID')}</span>
                      {product.original_price > 0 && (
                        <span className="text-sm text-slate-400 line-through">Rp {parseInt(product.original_price).toLocaleString('id-ID')}</span>
                      )}
                    </div>
                    <a href={waLink} target="_blank" rel="noopener noreferrer" className="block w-full text-center bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 rounded-xl transition">
                      Beli Sekarang
                    </a>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-6">
          <h2 className="text-[28px] font-bold text-center mb-12">Apa Kata Bunda?</h2>
          <div className="grid md:grid-cols-3 gap-6">
            {data.testimonials.map((testi) => (
              <div key={testi.id} className="bg-slate-50 p-6 rounded-2xl border border-slate-100 relative">
                <div className="text-yellow-400 text-lg mb-4 flex gap-1">
                  {[...Array(5)].map((_, i) => (
                    <i key={i} className={`bi bi-star-fill ${i < Math.floor(testi.rating) ? 'text-yellow-400' : 'text-slate-200'}`}></i>
                  ))}
                </div>
                <p className="text-slate-600 mb-6 italic leading-relaxed">"{testi.comment}"</p>
                <div className="flex items-center gap-4">
                  <div className="w-12 h-12 rounded-full overflow-hidden bg-slate-200">
                    <img src={`${import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'}/${testi.photo}`} alt={testi.customer_name} className="w-full h-full object-cover" />
                  </div>
                  <div>
                    <h4 className="font-bold text-slate-800">{testi.customer_name}</h4>
                    <p className="text-sm text-slate-500">Customer Clodi</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer id="footer" className="bg-slate-900 text-white pt-16 pb-8">
        <div className="max-w-7xl mx-auto px-6 text-center">
          <h3 className="text-2xl font-bold mb-4">{data.navbar.store_name}</h3>
          <p className="text-slate-400 max-w-lg mx-auto mb-8">{data.footer.address}</p>
          <div className="flex justify-center gap-6 mb-8 text-2xl">
             {data.footer.instagram && <a href={data.footer.instagram} className="hover:text-pink-500"><i className="bi bi-instagram"></i></a>}
             {data.footer.whatsapp && <a href={data.footer.whatsapp} className="hover:text-green-500"><i className="bi bi-whatsapp"></i></a>}
          </div>
          <p className="text-sm text-slate-500">{data.footer.copyright}</p>
        </div>
      </footer>
    </div>
  );
}

export default App;
