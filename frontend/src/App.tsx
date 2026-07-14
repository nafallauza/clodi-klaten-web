import React, { useState, useRef, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
  Search, Sparkles, MapPin, Activity, Image as ImageIcon,
  Camera, X, History, Home, Package, ChevronRight, Filter, 
  Star, Loader2, CheckCircle2, ShieldCheck, Droplets, Sun, AlertCircle,
  User, Bot, Send
} from 'lucide-react';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

// Mock Data
const MOCK_PRODUCTS = [
  { id: 1, brand: 'Somethinc', name: 'Low pH Gentle Jelly Cleanser', category: 'Cleanser', concern: 'Skin Barrier', type: 'All Skin', price: 'Rp 99.000', rating: 4.8, reviews: 1240, image: '✨', benefits: 'Pembersih wajah vegan yang menyeimbangkan pH kulit.', ingredients: 'Japanese Mugwort, Tea Tree' },
  { id: 2, brand: 'Skintific', name: '5X Ceramide Barrier Repair Gel', category: 'Moisturizer', concern: 'Skin Barrier', type: 'Sensitive', price: 'Rp 139.000', rating: 4.9, reviews: 3420, image: '💧', benefits: 'Memperbaiki skin barrier yang rusak dan mengunci hidrasi.', ingredients: '5X Ceramide, Hyaluronic Acid' },
  { id: 3, brand: 'Azarine', name: 'Hydrasoothe Sunscreen Gel SPF45', category: 'Sunscreen', concern: 'Jerawat', type: 'Oily', price: 'Rp 65.000', rating: 4.8, reviews: 2150, image: '☀️', benefits: 'Tabir surya tekstur gel super ringan tanpa whitecast.', ingredients: 'Propolis, Aloe Vera, Green Tea' },
  { id: 4, brand: 'Avoskin', name: 'Miraculous Refining Toner', category: 'Toner', concern: 'Jerawat', type: 'Acne Prone', price: 'Rp 189.000', rating: 4.7, reviews: 890, image: '🌿', benefits: 'Eksfoliasi lembut untuk mencerahkan dan memudarkan bekas jerawat.', ingredients: 'AHA, BHA, PHA' },
  { id: 5, brand: 'Whitelab', name: 'Brightening Face Serum', category: 'Serum', concern: 'Kulit Kusam', type: 'Dull Skin', price: 'Rp 79.000', rating: 4.6, reviews: 1120, image: '🧪', benefits: 'Mencerahkan kulit kusam dan menyamarkan noda hitam.', ingredients: 'Niacinamide 10%, Collagen' },
  { id: 6, brand: 'Wardah', name: 'Acnederm Pure Foaming Cleanser', category: 'Cleanser', concern: 'Jerawat', type: 'Acne Prone', price: 'Rp 32.000', rating: 4.5, reviews: 560, image: '🧼', benefits: 'Pembersih wajah khusus kulit berjerawat dan berminyak.', ingredients: 'Derma Treat Actives' },
];

const CATEGORIES = ['Cleanser', 'Serum', 'Moisturizer', 'Sunscreen', 'Toner'];
const CONCERNS = ['Jerawat', 'Kulit Berminyak', 'Kulit Kering', 'Kulit Kusam', 'Skin Barrier', 'Flek Hitam'];

type ViewState = 'home' | 'products' | 'analysis' | 'history' | 'clinic';

export default function App() {
  const [view, setView] = useState<ViewState>('home');
  const [pendingAnalysisFile, setPendingAnalysisFile] = useState<File | null>(null);
  
  const navigate = (v: ViewState) => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    setView(v);
  };

  const handleStartAnalysisWithFile = (file: File) => {
    setPendingAnalysisFile(file);
    navigate('analysis');
  };

  return (
    <div className="min-h-screen bg-background text-slate-900 font-sans flex flex-col selection:bg-primary/20 selection:text-primary">
      {/* Top Navigation */}
      <nav className="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-soft">
        <div className="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
          <div className="flex items-center gap-3 cursor-pointer" onClick={() => navigate('home')}>
            <div className="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-primary/20">
              <Sparkles className="w-5 h-5 text-white" />
            </div>
            <span className="font-extrabold text-2xl tracking-tight text-slate-900">DermaCare</span>
          </div>
          <div className="hidden md:flex items-center gap-2">
            {[
              { id: 'home', label: 'Home' },
              { id: 'products', label: 'Products' },
              { id: 'analysis', label: 'Skin Analysis' },
              { id: 'history', label: 'History' },
              { id: 'clinic', label: 'Nearby Clinic' },
            ].map(item => (
              <button 
                key={item.id}
                onClick={() => navigate(item.id as ViewState)} 
                className={cn(
                  "px-5 py-2.5 rounded-xl text-[15px] font-semibold transition-all duration-300", 
                  view === item.id 
                    ? 'text-primary bg-primary/10 shadow-sm' 
                    : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'
                )}
              >
                {item.label}
              </button>
            ))}
          </div>
        </div>
      </nav>

      <main className="flex-1 w-full">
        {view === 'home' && <HomeView onNavigate={navigate} onStartAnalysis={handleStartAnalysisWithFile} />}
        {view === 'products' && <ProductsView />}
        {view === 'analysis' && <AnalysisView pendingFile={pendingAnalysisFile} clearPendingFile={() => setPendingAnalysisFile(null)} onNavigate={navigate} />}
        {view === 'history' && <HistoryView />}
        {view === 'clinic' && <ClinicView />}
      </main>

      <footer className="bg-white border-t border-slate-100 py-12 mt-24">
        <div className="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
          <div className="flex items-center gap-2">
            <Sparkles className="w-6 h-6 text-primary" />
            <span className="font-bold text-xl text-slate-800">DermaCare</span>
          </div>
          <p className="text-slate-500 font-medium">© 2026 DermaCare Professional Platform. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}

// ==========================================
// VIEWS
// ==========================================

function HomeView({ onNavigate, onStartAnalysis }: { onNavigate: (v: ViewState) => void, onStartAnalysis: (f: File) => void }) {
  const [isCameraOpen, setIsCameraOpen] = useState(false);
  const videoRef = useRef<HTMLVideoElement>(null);
  const canvasRef = useRef<HTMLCanvasElement>(null);
  const [stream, setStream] = useState<MediaStream | null>(null);

  const openCamera = async () => {
    try {
      const mediaStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
      setStream(mediaStream);
      setIsCameraOpen(true);
      setTimeout(() => {
        if (videoRef.current) videoRef.current.srcObject = mediaStream;
      }, 100);
    } catch (e) {
      alert("Kamera tidak dapat diakses.");
    }
  };

  const closeCamera = () => {
    if (stream) stream.getTracks().forEach(track => track.stop());
    setIsCameraOpen(false);
  };

  const capturePhoto = () => {
    if (videoRef.current && canvasRef.current) {
      const video = videoRef.current;
      const canvas = canvasRef.current;
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const ctx = canvas.getContext('2d');
      if (ctx) {
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        canvas.toBlob((blob) => {
          if (blob) {
            onStartAnalysis(new File([blob], "capture.jpg", { type: "image/jpeg" }));
            closeCamera();
          }
        }, 'image/jpeg');
      }
    }
  };

  const handleFileSelect = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) {
      onStartAnalysis(e.target.files[0]);
    }
  };

  return (
    <div className="animate-in fade-in duration-700">
      {/* Unified Hero & Upload Section */}
      <section className="bg-white relative overflow-hidden pb-24">
        <div className="absolute top-0 right-0 w-[800px] h-[800px] bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none" />
        <div className="max-w-7xl mx-auto px-6 pt-24 pb-12 flex flex-col lg:flex-row items-center gap-16 relative z-10">
          
          {/* Left: Hero Text */}
          <div className="flex-1 space-y-8 text-center lg:text-left">
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-50 border border-slate-100 text-slate-600 font-semibold text-sm shadow-sm">
              <ShieldCheck className="w-4 h-4 text-primary" /> Didukung oleh Teknologi AI Medis
            </div>
            <h1 className="text-5xl md:text-6xl xl:text-7xl font-extrabold tracking-tight leading-[1.1] text-slate-900">
              Temukan Skincare yang <span className="text-primary relative inline-block">
                Tepat
                <svg className="absolute -bottom-2 left-0 w-full" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0,10 Q50,20 100,10" stroke="currentColor" strokeWidth="4" fill="none" opacity="0.3"/></svg>
              </span><br className="hidden lg:block"/> untuk Kulitmu
            </h1>
            <p className="text-xl text-slate-500 max-w-xl mx-auto lg:mx-0 leading-relaxed">
              Analisis kondisi kulitmu dengan akurasi tinggi dan dapatkan rekomendasi skincare yang disusun khusus untuk kebutuhan wajahmu.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 pt-4 justify-center lg:justify-start">
              <button onClick={() => onNavigate('products')} className="bg-slate-50 hover:bg-slate-100 text-slate-900 border border-slate-200 px-8 py-4 rounded-2xl font-bold text-lg transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5">
                <Package className="w-5 h-5" /> Lihat Katalog Produk
              </button>
            </div>
          </div>

          {/* Right: Upload Card */}
          <div className="w-full lg:w-[480px] shrink-0 relative">
            <div className="absolute inset-0 bg-gradient-to-tr from-primary/20 to-accent/20 rounded-[2.5rem] blur-2xl transform rotate-3" />
            <div className="bg-white/90 backdrop-blur-md rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-white p-8 relative flex flex-col items-center text-center">
              <div className="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                <ImageIcon className="w-8 h-8 text-primary" />
              </div>
              <h2 className="text-2xl font-extrabold text-slate-900 mb-2">Mulai AI Analisis</h2>
              <p className="text-slate-500 mb-8 text-sm">Unggah foto atau ambil gambar wajah untuk pemindaian medis instan.</p>
              
              <div className="flex flex-col gap-3 w-full">
                <button onClick={() => document.getElementById('homeFileUpload')?.click()} className="w-full bg-slate-900 hover:bg-slate-800 text-white px-6 py-4 rounded-xl font-bold flex items-center justify-center gap-2 transition-colors">
                  <ImageIcon className="w-5 h-5" /> Pilih dari Galeri
                </button>
                <input type="file" id="homeFileUpload" className="hidden" accept="image/*" onChange={handleFileSelect} />
                
                <button onClick={openCamera} className="w-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-6 py-4 rounded-xl font-bold flex items-center justify-center gap-2 transition-colors">
                  <Camera className="w-5 h-5" /> Buka Kamera
                </button>
              </div>

              <div className="mt-8 pt-6 border-t border-slate-100 w-full text-left">
                <p className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Panduan Hasil Akurat</p>
                <ul className="space-y-3">
                  {['Pastikan tanpa riasan (bare face)', 'Gunakan pencahayaan alami/terang', 'Pastikan foto fokus tidak buram'].map((rule, i) => (
                    <li key={i} className="flex gap-2 items-center text-sm text-slate-600 font-medium">
                      <CheckCircle2 className="w-4 h-4 text-primary shrink-0" /> {rule}
                    </li>
                  ))}
                </ul>
              </div>
            </div>
          </div>
          
        </div>
      </section>


      {/* Camera Modal (Home) */}
      {isCameraOpen && (
        <div className="fixed inset-0 z-[100] bg-slate-900 flex flex-col">
          <div className="p-6 flex justify-between absolute top-0 w-full z-10 bg-gradient-to-b from-slate-900/80 to-transparent">
            <span className="text-white font-bold text-lg">Ambil Foto Wajah</span>
            <button onClick={closeCamera} className="text-white bg-white/20 p-2 rounded-full hover:bg-white/30"><X className="w-6 h-6"/></button>
          </div>
          <video ref={videoRef} autoPlay playsInline className="flex-1 object-cover w-full h-full" />
          <canvas ref={canvasRef} className="hidden" />
          <div className="absolute inset-0 border-[60px] border-slate-900/40 pointer-events-none" />
          <div className="h-32 bg-slate-900 flex items-center justify-center pb-8 z-10">
            <button onClick={capturePhoto} className="w-20 h-20 bg-white rounded-full border-4 border-slate-500 active:scale-95 transition-transform" />
          </div>
        </div>
      )}
    </div>
  );
}

// ==========================================
// PRODUCTS VIEW
// ==========================================
function ProductsView() {
  return (
    <div className="max-w-7xl mx-auto px-6 py-12 animate-in fade-in duration-500">
      <div className="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
          <h1 className="text-4xl font-extrabold text-slate-900 mb-2">Katalog Skincare</h1>
          <p className="text-slate-500 text-lg">Eksplorasi ribuan produk untuk rutinitas kulit sehat Anda.</p>
        </div>
        <div className="flex items-center gap-2 bg-white border border-slate-200 rounded-xl p-1.5 shadow-sm w-full md:w-auto focus-within:border-primary transition-colors">
           <input type="text" placeholder="Cari nama produk..." className="py-2.5 px-4 focus:outline-none bg-transparent text-base w-full md:w-64 font-medium" />
           <button className="bg-slate-900 p-2.5 rounded-lg text-white hover:bg-slate-800"><Search className="w-5 h-5"/></button>
        </div>
      </div>

      <div className="flex flex-col lg:flex-row gap-10">
        {/* Sidebar Filter */}
        <div className="w-full lg:w-72 shrink-0 space-y-8">
          <div className="flex items-center gap-2 font-bold text-xl text-slate-900 pb-4 border-b border-slate-100">
            <Filter className="w-5 h-5" /> Filter Produk
          </div>
          
          <div>
            <h4 className="font-bold text-slate-800 mb-4">Kategori</h4>
            <div className="space-y-3">
              {CATEGORIES.map(c => (
                <label key={c} className="flex items-center gap-3 cursor-pointer group">
                  <div className="w-5 h-5 border-2 border-slate-300 rounded group-hover:border-primary flex items-center justify-center transition-colors"></div>
                  <span className="text-slate-600 font-medium group-hover:text-slate-900 transition-colors">{c}</span>
                </label>
              ))}
            </div>
          </div>

          <div>
            <h4 className="font-bold text-slate-800 mb-4">Skin Concern</h4>
            <div className="space-y-3">
              {CONCERNS.map(c => (
                <label key={c} className="flex items-center gap-3 cursor-pointer group">
                  <div className="w-5 h-5 border-2 border-slate-300 rounded group-hover:border-primary flex items-center justify-center transition-colors"></div>
                  <span className="text-slate-600 font-medium group-hover:text-slate-900 transition-colors">{c}</span>
                </label>
              ))}
            </div>
          </div>

          <button className="w-full py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-bold hover:bg-slate-100 transition-colors">Reset Filter</button>
        </div>

        {/* Grid Products */}
        <div className="flex-1 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
          {MOCK_PRODUCTS.map(prod => (
            <ProductCard key={prod.id} product={prod} />
          ))}
        </div>
      </div>
    </div>
  );
}

function ProductCard({ product }: { product: any }) {
  return (
    <div className="bg-white rounded-[2rem] p-5 flex flex-col hover:shadow-xl hover:border-primary/30 transition-all duration-300 group cursor-pointer border border-slate-100 shadow-soft">
      <div className="w-full h-56 bg-slate-50 rounded-[1.5rem] mb-5 flex items-center justify-center text-7xl group-hover:scale-105 transition-transform duration-500">
        {product.image}
      </div>
      <div className="flex flex-col flex-1">
        <p className="text-xs font-extrabold text-primary uppercase tracking-wider mb-2">{product.brand}</p>
        <h3 className="font-bold text-lg text-slate-900 leading-snug mb-3">{product.name}</h3>
        <p className="text-sm text-slate-500 line-clamp-2 mb-4 leading-relaxed">{product.benefits}</p>
        
        <div className="mt-auto flex items-center justify-between pt-4 border-t border-slate-50">
          <span className="font-extrabold text-lg text-slate-900">{product.price}</span>
          <div className="flex items-center gap-1 text-sm font-bold bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg">
            <Star className="w-4 h-4 fill-current" /> {product.rating}
          </div>
        </div>
      </div>
    </div>
  );
}

// ==========================================
// SKIN ANALYSIS VIEW (Restored Chat UI)
// ==========================================
interface ChatMessage {
  id: string;
  role: 'user' | 'ai';
  type: 'text' | 'image' | 'analysis_progress' | 'analysis_result' | 'recommendations' | 'clinic';
  text?: string;
  imageUrl?: string;
  analysisData?: any;
  recommendationsData?: any[];
  progressStage?: string;
}

function AnalysisView({ pendingFile, clearPendingFile, onNavigate }: { pendingFile: File | null, clearPendingFile: () => void, onNavigate: (v:ViewState)=>void }) {
  const [messages, setMessages] = useState<ChatMessage[]>([{
    id: '1',
    role: 'ai',
    type: 'text',
    text: 'Selamat datang di DermaCare AI. Saya siap membantu Anda. Silakan unggah foto wajah Anda, atau tanyakan apapun seputar perawatan kulit Anda.'
  }]);
  const [inputValue, setInputValue] = useState('');
  const chatEndRef = useRef<HTMLDivElement>(null);
  
  const [isCameraOpen, setIsCameraOpen] = useState(false);
  const videoRef = useRef<HTMLVideoElement>(null);
  const canvasRef = useRef<HTMLCanvasElement>(null);
  const [stream, setStream] = useState<MediaStream | null>(null);

  useEffect(() => {
    chatEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages]);

  // Handle incoming file from Home Tab
  useEffect(() => {
    if (pendingFile) {
      handleFileUpload(pendingFile);
      clearPendingFile();
    }
  }, [pendingFile]);

  const addMessage = (msg: Omit<ChatMessage, 'id'>) => {
    const id = Date.now().toString() + Math.random().toString();
    setMessages(prev => [...prev, { ...msg, id }]);
    return id;
  };
  const updateMessage = (id: string, updates: Partial<ChatMessage>) => {
    setMessages(prev => prev.map(m => m.id === id ? { ...m, ...updates } : m));
  };

  const openCamera = async () => {
    try {
      const mediaStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
      setStream(mediaStream);
      setIsCameraOpen(true);
      setTimeout(() => {
        if (videoRef.current) videoRef.current.srcObject = mediaStream;
      }, 100);
    } catch (e) {
      alert("Kamera tidak dapat diakses.");
    }
  };

  const closeCamera = () => {
    if (stream) stream.getTracks().forEach(track => track.stop());
    setIsCameraOpen(false);
  };

  const capturePhoto = () => {
    if (videoRef.current && canvasRef.current) {
      const video = videoRef.current;
      const canvas = canvasRef.current;
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const ctx = canvas.getContext('2d');
      if (ctx) {
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        canvas.toBlob((blob) => {
          if (blob) {
            handleFileUpload(new File([blob], "capture.jpg", { type: "image/jpeg" }));
            closeCamera();
          }
        }, 'image/jpeg');
      }
    }
  };

  const handleFileSelect = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) handleFileUpload(e.target.files[0]);
  };

  const handleFileUpload = async (file: File) => {
    const imageUrl = URL.createObjectURL(file);
    addMessage({ role: 'user', type: 'image', imageUrl });
    const progressId = addMessage({ role: 'ai', type: 'analysis_progress', progressStage: 'Menganalisis gambar...' });

    try {
      const formData = new FormData();
      formData.append("file", file);
      
      const res = await fetch("http://localhost:8000/vision/analyze", { method: "POST", body: formData });
      const data = await res.json();
      
      setMessages(prev => prev.filter(m => m.id !== progressId));

      if(data.status === "success") {
        const resultData = { severity: data.data.severity, confidence: data.data.confidence * 100 || 92, details: data.data.details, issues: data.data.detected_issues };
        addMessage({ role: 'ai', type: 'analysis_result', analysisData: resultData });

        const recRes = await fetch("http://localhost:8000/recommendation", {
          method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify({ cv_results: resultData })
        });
        const recData = await recRes.json();
        
        if(recData.status === "success") {
          addMessage({ role: 'ai', type: 'recommendations', recommendationsData: recData.data });
        }

        if (resultData.severity.toLowerCase().includes('berat')) {
          addMessage({ role: 'ai', type: 'text', text: 'Berdasarkan keparahan kondisi, kami sangat menyarankan Anda mengunjungi profesional medis terdekat.' });
          addMessage({ role: 'ai', type: 'clinic' });
        }

        // Save to History
        const savedHistory = localStorage.getItem('derma_history');
        const historyArr = savedHistory ? JSON.parse(savedHistory) : [];
        historyArr.unshift({
          id: Date.now().toString(), date: new Date().toISOString().split('T')[0], imageUrl,
          severity: resultData.severity, confidence: resultData.confidence,
          recommendations: recData.data || []
        });
        localStorage.setItem('derma_history', JSON.stringify(historyArr));
      }
    } catch(e) {
      setMessages(prev => prev.filter(m => m.id !== progressId));
      addMessage({ role: 'ai', type: 'text', text: 'Maaf, gagal terhubung ke server medis. Pastikan API berjalan.' });
    }
  };

  const sendTextMessage = async () => {
    if(!inputValue.trim()) return;
    const txt = inputValue;
    setInputValue('');
    addMessage({ role: 'user', type: 'text', text: txt });

    const lastAnalysisMsg = [...messages].reverse().find(m => m.type === 'analysis_result');
    const cv_results = lastAnalysisMsg ? lastAnalysisMsg.analysisData : {};

    try {
      const res = await fetch("http://localhost:8000/chat", {
        method: "POST", headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ query: txt, cv_results })
      });
      const data = await res.json();
      if(data.status === "success") addMessage({ role: 'ai', type: 'text', text: data.data.answer });
    } catch(e) {
      addMessage({ role: 'ai', type: 'text', text: 'Maaf, jaringan ke server AI terputus.' });
    }
  };

  return (
    <div className="max-w-4xl mx-auto flex flex-col h-[calc(100vh-144px)] bg-white border border-slate-200 rounded-[2rem] overflow-hidden mt-8 shadow-2xl shadow-slate-200/50 animate-in fade-in">
      {/* Header */}
      <div className="bg-white border-b border-slate-100 p-5 flex items-center gap-4 shadow-sm z-10">
        <div className="w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20"><Activity className="w-6 h-6"/></div>
        <div>
          <h2 className="font-extrabold text-slate-900 text-lg">AI Medical Assistant</h2>
          <p className="text-sm text-slate-500 font-medium">Terhubung dengan cerdas</p>
        </div>
      </div>

      {/* Chat Messages */}
      <div className="flex-1 overflow-y-auto p-4 sm:p-8 space-y-8 bg-slate-50/50">
        {messages.map(msg => (
          <div key={msg.id} className={cn("flex gap-4 max-w-[90%]", msg.role === 'user' ? "ml-auto flex-row-reverse" : "")}>
            <div className={cn("w-10 h-10 rounded-xl flex shrink-0 items-center justify-center mt-1 shadow-sm", msg.role === 'user' ? "bg-slate-200 text-slate-600" : "bg-primary text-white shadow-primary/20")}>
              {msg.role === 'user' ? <User className="w-5 h-5" /> : <Bot className="w-5 h-5" />}
            </div>
            
            <div className={cn("p-5 rounded-2xl text-[15px] leading-relaxed shadow-soft border", 
              msg.role === 'user' 
                ? "bg-slate-900 text-white border-transparent rounded-tr-none" 
                : "bg-white border-slate-100 rounded-tl-none text-slate-800"
            )}>
              {msg.type === 'text' && <p className="whitespace-pre-wrap">{msg.text}</p>}
              
              {msg.type === 'image' && <img src={msg.imageUrl} className="max-w-[240px] rounded-xl border border-slate-700" />}
              
              {msg.type === 'analysis_progress' && (
                <div className="flex items-center gap-3 text-primary font-bold"><Loader2 className="w-5 h-5 animate-spin" /> {msg.progressStage}</div>
              )}
              
              {msg.type === 'analysis_result' && (
                <div className="space-y-4 min-w-[280px]">
                  <h4 className="font-extrabold border-b border-slate-100 pb-3 flex items-center gap-2"><Activity className="w-5 h-5 text-primary"/> Hasil Diagnosis</h4>
                  <div className="flex justify-between items-center text-sm font-bold uppercase text-slate-500">
                    Severity 
                    <span className={cn("px-2 py-1 rounded text-white text-xs", msg.analysisData.severity?.toLowerCase().includes('berat') ? 'bg-red-500' : 'bg-amber-500')}>{msg.analysisData.severity}</span>
                  </div>
                  <div className="flex justify-between items-center text-sm font-bold uppercase text-slate-500">
                    Confidence <span className="text-slate-900">{Math.round(msg.analysisData.confidence)}%</span>
                  </div>
                  <p className="text-sm bg-slate-50 border border-slate-100 p-4 rounded-xl leading-relaxed text-slate-600">{msg.analysisData.details}</p>
                </div>
              )}
              
              {msg.type === 'recommendations' && (
                <div className="space-y-4">
                  <h4 className="font-extrabold flex items-center gap-2"><Sparkles className="w-5 h-5 text-primary"/> Rutinitas Disarankan</h4>
                  <div className="space-y-3">
                    {msg.recommendationsData?.map((rec, i) => (
                      <div key={i} onClick={()=>onNavigate('products')} className="flex gap-4 items-center bg-white border border-slate-100 p-3 rounded-2xl hover:border-primary/50 hover:shadow-md transition-all cursor-pointer">
                        <div className="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center shrink-0 text-2xl">✨</div>
                        <div>
                          <p className="text-[10px] text-primary font-extrabold uppercase tracking-wider">{rec.brand}</p>
                          <p className="font-bold text-sm text-slate-900 leading-snug">{rec.product_name}</p>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {msg.type === 'clinic' && (
                <div className="bg-red-50 border border-red-200 p-4 rounded-2xl min-w-[250px] relative overflow-hidden">
                  <div className="absolute left-0 top-0 bottom-0 w-1 bg-red-500"/>
                  <h4 className="font-bold text-red-700 text-sm flex items-center gap-2 mb-2"><MapPin className="w-4 h-4"/> Rujukan Spesialis</h4>
                  <p className="text-xs text-red-600 mb-3 font-medium">Klinik dr. Erha (SP.KK) - 2.4km</p>
                  <button onClick={()=>onNavigate('clinic')} className="w-full bg-red-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-red-700">Lihat Peta</button>
                </div>
              )}
            </div>
          </div>
        ))}
        <div ref={chatEndRef} />
      </div>

      {/* Input Form */}
      <div className="p-5 bg-white border-t border-slate-100 shadow-[0_-10px_40px_rgba(0,0,0,0.03)] z-10">
        <div className="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-[1.5rem] p-2 focus-within:border-primary focus-within:ring-4 ring-primary/10 transition-all">
          <button onClick={() => document.getElementById('aiFileInput')?.click()} className="p-3 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-xl transition-colors"><ImageIcon className="w-6 h-6"/></button>
          <input type="file" id="aiFileInput" className="hidden" accept="image/*" onChange={handleFileSelect} />
          
          <button onClick={openCamera} className="p-3 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-xl transition-colors"><Camera className="w-6 h-6"/></button>
          
          <input 
            value={inputValue} onChange={e => setInputValue(e.target.value)} 
            onKeyDown={e => { if (e.key === 'Enter') sendTextMessage(); }}
            placeholder="Ketik keluhan atau unggah foto wajah Anda..." 
            className="flex-1 bg-transparent border-none focus:outline-none text-base px-2 text-slate-700 font-medium placeholder-slate-400"
          />
          
          <button onClick={sendTextMessage} disabled={!inputValue.trim()} className="bg-primary text-white p-3.5 rounded-xl disabled:opacity-50 hover:bg-primary-dark transition-colors shadow-sm"><Send className="w-5 h-5"/></button>
        </div>
        <p className="text-center text-[11px] text-slate-400 mt-3 font-medium">AI DermaCare dapat berbuat salah. Selalu konsultasikan kondisi berat ke dokter.</p>
      </div>

      {/* Camera Modal */}
      {isCameraOpen && (
        <div className="fixed inset-0 z-[100] bg-slate-900 flex flex-col">
          <div className="p-6 flex justify-between absolute top-0 w-full z-10 bg-gradient-to-b from-slate-900/80 to-transparent">
            <span className="text-white font-bold text-lg">Ambil Foto Wajah</span>
            <button onClick={closeCamera} className="text-white bg-white/20 p-2 rounded-full hover:bg-white/30"><X className="w-6 h-6"/></button>
          </div>
          <video ref={videoRef} autoPlay playsInline className="flex-1 object-cover w-full h-full" />
          <canvas ref={canvasRef} className="hidden" />
          <div className="absolute inset-0 border-[60px] border-slate-900/40 pointer-events-none" />
          <div className="h-32 bg-slate-900 flex items-center justify-center pb-8 z-10">
            <button onClick={capturePhoto} className="w-20 h-20 bg-white rounded-full border-4 border-slate-500 active:scale-95 transition-transform" />
          </div>
        </div>
      )}
    </div>
  );
}

// ==========================================
// HISTORY VIEW
// ==========================================
function HistoryView() {
  const [history, setHistory] = useState<any[]>([]);
  useEffect(() => {
    const data = localStorage.getItem('derma_history');
    if(data) setHistory(JSON.parse(data));
  }, []);

  return (
    <div className="max-w-7xl mx-auto px-6 py-16 animate-in fade-in">
      <h1 className="text-4xl font-extrabold mb-4 text-slate-900">Riwayat Analisis</h1>
      <p className="text-lg text-slate-500 mb-12">Pantau perkembangan kesehatan kulit Anda dari waktu ke waktu.</p>
      
      {history.length === 0 ? (
        <div className="text-center py-32 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
           <History className="w-16 h-16 mx-auto mb-4 text-slate-300"/>
           <p className="text-lg font-medium text-slate-500">Belum ada riwayat analisis.</p>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {history.map(h => (
            <div key={h.id} className="bg-white rounded-[2rem] border border-slate-100 p-6 flex flex-col gap-4 shadow-soft hover:shadow-xl hover:border-primary/30 transition-all cursor-pointer">
              <div className="flex gap-5">
                <img src={h.imageUrl} className="w-24 h-24 rounded-2xl object-cover border border-slate-100" />
                <div>
                  <p className="text-sm font-extrabold text-primary mb-1 uppercase tracking-wider">{h.date}</p>
                  <h4 className="font-bold text-lg text-slate-900 mb-1 leading-snug">Keparahan:<br/><span className="text-slate-600">{h.severity}</span></h4>
                </div>
              </div>
              <div className="pt-4 border-t border-slate-50">
                 <p className="text-sm font-bold text-slate-700 mb-2">Rekomendasi Utama:</p>
                 <p className="text-sm text-slate-500 line-clamp-2 leading-relaxed">{h.recommendations?.[0]?.product_name || 'Tidak ada rekomendasi khusus.'}</p>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

// ==========================================
// CLINIC VIEW
// ==========================================
function ClinicView() {
  return (
    <div className="max-w-7xl mx-auto px-6 py-16 animate-in fade-in">
      <h1 className="text-4xl font-extrabold mb-4 text-slate-900">Klinik Terdekat</h1>
      <p className="text-lg text-slate-500 mb-12">Daftar dokter spesialis kulit berlisensi (SP.KK) di sekitar Anda.</p>
      
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {[
          { name: 'Klinik Estetika dr. Erha', doc: 'dr. Erha, Sp.KK', dist: '2.4 km', rate: 4.9 },
          { name: 'Natasha Skin Clinic Center', doc: 'dr. Natasha, Sp.KK', dist: '3.1 km', rate: 4.7 },
          { name: 'Erha Apothecary', doc: 'Klinik Pratama', dist: '5.0 km', rate: 4.8 },
          { name: 'Dermaster Clinic Indonesia', doc: 'dr. Jessy, Sp.KK', dist: '7.2 km', rate: 4.9 }
        ].map((c,i) => (
          <div key={i} className="bg-white rounded-[2rem] shadow-soft border border-slate-100 p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 hover:border-primary/30 hover:shadow-xl transition-all cursor-pointer">
            <div className="flex gap-5 items-center">
              <div className="w-16 h-16 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center text-primary shrink-0">
                <MapPin className="w-8 h-8" />
              </div>
              <div>
                <h3 className="font-bold text-xl text-slate-900 mb-1">{c.name}</h3>
                <p className="font-medium text-slate-500">{c.doc}</p>
              </div>
            </div>
            <div className="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
              <div className="flex flex-col items-start sm:items-end">
                <div className="flex items-center gap-1 text-sm font-bold text-amber-500 mb-1">
                  <Star className="w-4 h-4 fill-current"/> {c.rate}
                </div>
                <div className="text-sm font-bold text-slate-400">{c.dist}</div>
              </div>
              <button className="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-800 transition-colors">Detail</button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
