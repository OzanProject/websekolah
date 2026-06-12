import { useEffect } from "react";
import { useParams, Link, Navigate } from "react-router-dom";
import { ArrowLeft, Calendar, User, Tag, Share2, Facebook, Twitter, MessageCircle, Copy } from "lucide-react";
import { toast } from "sonner";
import Navbar from "@/components/site/Navbar";
import Footer from "@/components/site/Footer";
import FloatingWA from "@/components/site/FloatingWA";
import { NEWS, SCHOOL } from "@/lib/siteData";

export default function BeritaDetail() {
  const { id } = useParams();

  // Cari berdasarkan slug atau id (dukung keduanya)
  const article = NEWS.find((n) => n.slug === id || String(n.id) === String(id));

  useEffect(() => {
    if (!article) return;
    const prevTitle = document.title;
    document.title = `${article.title} | ${SCHOOL.shortName}`;
    const meta = document.querySelector('meta[name="description"]');
    const prevDesc = meta?.getAttribute("content");
    meta?.setAttribute("content", article.excerpt);
    window.scrollTo({ top: 0, behavior: "instant" });
    return () => {
      document.title = prevTitle;
      if (prevDesc) meta?.setAttribute("content", prevDesc);
    };
  }, [article]);

  if (!article) {
    return <Navigate to="/berita" replace />;
  }

  const url = typeof window !== "undefined" ? window.location.href : "";
  const shareText = encodeURIComponent(article.title);

  const copyLink = () => {
    navigator.clipboard.writeText(url);
    toast.success("Tautan berita disalin!");
  };

  const related = NEWS.filter((n) => n.id !== article.id).slice(0, 3);

  return (
    <div className="min-h-screen bg-white flex flex-col" data-testid="berita-detail-page">
      <Navbar />

      {/* Breadcrumb */}
      <div className="bg-[#FAFAFA] border-b border-slate-200">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-sm text-slate-600">
          <Link to="/" className="hover:text-[#1E3A8A]" data-testid="bc-home">Beranda</Link>
          <span className="mx-2 text-slate-400">/</span>
          <Link to="/berita" className="hover:text-[#1E3A8A]" data-testid="bc-berita">Berita</Link>
          <span className="mx-2 text-slate-400">/</span>
          <span className="text-[#0F172A] font-medium line-clamp-1">{article.title}</span>
        </div>
      </div>

      <article className="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 w-full">
        <div className="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-12">
          {/* Main content */}
          <div>
            <Link to="/berita" className="inline-flex items-center gap-2 text-sm font-semibold text-[#1E3A8A] hover:text-[#F59E0B] mb-6" data-testid="back-to-berita">
              <ArrowLeft className="w-4 h-4" /> Kembali ke Daftar Berita
            </Link>

            <div className="flex flex-wrap items-center gap-3 mb-4">
              <span className="inline-flex items-center gap-1.5 bg-[#F59E0B] text-white text-xs font-semibold px-3 py-1.5 rounded-full" data-testid="berita-category">
                <Tag className="w-3 h-3" /> {article.category}
              </span>
            </div>

            <h1 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] leading-tight mb-5" style={{ fontFamily: "Outfit" }} data-testid="berita-title">
              {article.title}
            </h1>

            <div className="flex flex-wrap items-center gap-5 text-sm text-slate-600 pb-6 border-b border-slate-200 mb-8">
              <span className="inline-flex items-center gap-1.5"><Calendar className="w-4 h-4 text-[#1E3A8A]" /> {article.fullDate}</span>
              <span className="inline-flex items-center gap-1.5"><User className="w-4 h-4 text-[#1E3A8A]" /> {article.author}</span>
            </div>

            <div className="aspect-[16/9] rounded-2xl overflow-hidden mb-8 bg-slate-100">
              <img src={article.image} alt={article.title} className="w-full h-full object-cover" />
            </div>

            <div className="prose prose-slate max-w-none" data-testid="berita-content">
              <p className="text-lg text-slate-700 font-medium leading-relaxed mb-6 italic border-l-4 border-[#F59E0B] pl-5">
                {article.excerpt}
              </p>
              {article.content.map((para, i) => (
                <p key={i} className="text-base text-slate-700 leading-[1.85] mb-5">
                  {para}
                </p>
              ))}
            </div>

            {/* Share */}
            <div className="mt-12 pt-8 border-t border-slate-200">
              <div className="flex items-center gap-3 flex-wrap">
                <span className="inline-flex items-center gap-2 text-sm font-semibold text-[#0F172A]">
                  <Share2 className="w-4 h-4" /> Bagikan berita ini:
                </span>
                <a
                  href={`https://wa.me/?text=${shareText}%20${encodeURIComponent(url)}`}
                  target="_blank" rel="noopener noreferrer"
                  className="w-10 h-10 rounded-full bg-[#25D366] hover:bg-[#1FAD51] text-white flex items-center justify-center transition"
                  aria-label="Bagikan ke WhatsApp"
                  data-testid="share-wa-btn"
                >
                  <MessageCircle className="w-4 h-4" />
                </a>
                <a
                  href={`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`}
                  target="_blank" rel="noopener noreferrer"
                  className="w-10 h-10 rounded-full bg-[#1877F2] hover:bg-[#0E5BC8] text-white flex items-center justify-center transition"
                  aria-label="Bagikan ke Facebook"
                  data-testid="share-fb-btn"
                >
                  <Facebook className="w-4 h-4" />
                </a>
                <a
                  href={`https://twitter.com/intent/tweet?text=${shareText}&url=${encodeURIComponent(url)}`}
                  target="_blank" rel="noopener noreferrer"
                  className="w-10 h-10 rounded-full bg-[#0F172A] hover:bg-black text-white flex items-center justify-center transition"
                  aria-label="Bagikan ke Twitter"
                  data-testid="share-tw-btn"
                >
                  <Twitter className="w-4 h-4" />
                </a>
                <button
                  onClick={copyLink}
                  className="w-10 h-10 rounded-full border-2 border-slate-200 hover:border-[#1E3A8A] hover:text-[#1E3A8A] text-slate-600 flex items-center justify-center transition"
                  aria-label="Salin tautan"
                  data-testid="share-copy-btn"
                >
                  <Copy className="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>

          {/* Sidebar */}
          <aside className="space-y-6">
            <div className="bg-gradient-to-br from-[#1E3A8A] to-[#1E40AF] rounded-2xl p-6 text-white">
              <div className="text-xs uppercase tracking-wider text-white/70 font-semibold mb-2">PPDB Online</div>
              <h3 className="text-xl font-bold mb-3" style={{ fontFamily: "Outfit" }}>Pendaftaran 2026/2027 Dibuka</h3>
              <p className="text-sm text-white/80 mb-5">Daftar online sekarang & dapatkan nomor pendaftaran instan.</p>
              <Link to="/ppdb" className="block text-center bg-[#F59E0B] hover:bg-[#D97706] text-white font-semibold rounded-lg py-2.5 transition" data-testid="sidebar-ppdb-btn">
                Daftar Sekarang
              </Link>
            </div>

            <div>
              <h3 className="text-lg font-bold text-[#0F172A] mb-4" style={{ fontFamily: "Outfit" }}>Berita Lainnya</h3>
              <div className="space-y-4">
                {related.map((r, idx) => (
                  <Link
                    key={r.id}
                    to={`/berita/${r.slug}`}
                    className="group flex gap-3 items-start"
                    data-testid={`related-news-${idx}`}
                  >
                    <div className="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-slate-100">
                      <img src={r.image} alt={r.title} className="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                    </div>
                    <div className="flex-1 min-w-0">
                      <div className="text-xs text-[#F59E0B] font-semibold mb-1">{r.category}</div>
                      <h4 className="text-sm font-semibold text-[#0F172A] leading-snug line-clamp-2 group-hover:text-[#1E3A8A] transition-colors">{r.title}</h4>
                      <div className="text-xs text-slate-500 mt-1">{r.fullDate}</div>
                    </div>
                  </Link>
                ))}
              </div>
            </div>
          </aside>
        </div>
      </article>

      <Footer />
      <FloatingWA />
    </div>
  );
}
