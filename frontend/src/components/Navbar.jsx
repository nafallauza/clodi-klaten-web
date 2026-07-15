import React from 'react';

const Navbar = ({ navbarData }) => {
  return (
    <header className="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-100">
      <div className="max-w-7xl mx-auto px-6 h-[92px] flex items-center justify-between">
        <a href="#" className="shrink-0">
          <img
            src={navbarData?.logo ? `${import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'}/${navbarData.logo}` : `${import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'}/assets/img/logo.png`}
            alt={navbarData?.store_name || "Clodi Klaten"}
            className="w-[104px]"
          />
        </a>

        <nav id="mainMenu" className="hidden md:flex items-center gap-11 text-[13px] font-semibold text-slate-700">
          <a className="hover:text-[#15A0CE] transition" href="#">Home</a>
          <a className="hover:text-[#15A0CE] transition" href="#produk">Produk</a>
          <a className="hover:text-[#15A0CE] transition" href="#footer">Contact</a>
        </nav>

        <div className="flex items-center gap-4">
          <form className="hidden sm:flex h-10 w-[245px] rounded-full border border-slate-200 bg-white shadow-sm overflow-hidden">
            <input className="w-full px-5 text-sm outline-none placeholder:text-slate-400" placeholder="Search" />
            <button className="m-[2px] w-9 rounded-full bg-[#15A0CE] text-white grid place-items-center hover:bg-cyan-600 transition" type="submit">
              <i className="bi bi-search text-sm"></i>
            </button>
          </form>

          <button id="menuButton" className="md:hidden w-10 h-10 rounded-xl bg-slate-100 text-slate-700">
            <i className="bi bi-list text-2xl"></i>
          </button>
        </div>
      </div>
    </header>
  );
};

export default Navbar;
