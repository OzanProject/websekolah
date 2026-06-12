import { useEffect, useMemo, useState } from "react";
import { Link } from "react-router-dom";
import { ArrowLeft, Calendar, Search, Tag, ArrowRight } from "lucide-react";
import Navbar from "@/components/site/Navbar";
import Footer from "@/components/site/Footer";
import FloatingWA from "@/components/site/FloatingWA";
import { NEWS, SCHOOL } from "@/lib/siteData";

export default function BeritaList() {
  const [query, setQuery] = useState("");
  const [activeCat, setActiveCat] = useState("Semua");

  useEffect(() => {
    const prevTitle = document.title;
    document.title = `Berita & Pengumuman | ${SCHOOL.shortName}`;
    const meta = document.querySelector('meta[name="description"]');
    const prevDesc = meta?.getAttribute("content");
    meta?.setAttribute("content", `Kumpulan berita, prestasi, dan pengumuman terbaru dari ${SCHOOL.name}.`);
    window.scrollTo({ top: 0, behavior: "instant" });
    return () => {
      document.title = prevTitle;
      if (prevDesc) meta?.setAttribute("content", prevDesc);
    };
  }, []);

  const categories = useMemo(() => {
    const set = new Set(NEWS.map((n) => n.category));
    return ["Semua", ...Array.from(set)];
  }, []);

  const filtered = useMemo(() => {
    const q = query.trim().toLowerCase();
    return NEWS.filter((n) => {
      const matchCat = activeCat === "Semua" || n.category === activeCat;
      const matchQ = !q || n.title.toLowerCase().includes(q) || n.excerpt.toLowerCase().includes(q);
      return matchCat && matchQ;
    });
  }, [query, activeCat]);

  const featured = filtered[0];
  const rest = filtered.slice(1);

  return (
    <div className="min-h-screen bg-white flex flex-col" data-testid="berita-list-page">
      <Navbar />

      {/* Header */}
      <div className="bg-[#1E3A8A] text-white py-16 lg:py-20 relative overflow-hidden">
        <div
          className="absolute inset-0 opacity-10"
          style={{
            backgroundImage: "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
            backgroundSize: "32px 32px",
          }}
        />
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <Link
            to="/"
            className="inline-flex items-center gap-2 text-white/70 hover:text-white text-sm mb-4"
            data-testid="berita-back-link"
          >
            <ArrowLeft className="w-4 h-4" /> Kembali ke Beranda
          </Link>
          <div className="inline-block text-xs font-semibold text-[#F59E0B] bg-white/10 px-3 py-1.5 rounded-full mb-3">
            Berita & Informasi
          </div>
          <h1 className="text-3xl md:text-4xl lg:text-5xl font-bold mb-3" style={{ fontFamily: "Outfit" }} data-testid="berita-list-title">
            Berita & Pengumuman Sekolah
          </h1>
          <p className="text-white/80 max-w-2xl">
            Ikuti perkembangan terbaru kegiatan, prestasi, dan pengumuman penting dari {SCHOOL.shortName}.
          </p>
        </div>
      </div>

      {/* Filter bar */}
      <div className="border-b border-slate-200 bg-white sticky top-[64px] lg:top-[80px] z-30">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row md:items-center gap-4">
          <div className="relative flex-1">
            <Search className="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
            <input
              type="text"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder="Cari berita..."
              className="w-full pl-11 pr-4 h-11 rounded-full border border-slate-200 focus:border-[#1E3A8A] focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/20 text-sm"
              data-testid="berita-search-input"
            />
          </div>
          <div className="flex flex-wrap gap-2">
            {categories.map((cat) => (
              <button
                key={cat}
                onClick={() => setActiveCat(cat)}
                className={`px-4 h-9 rounded-full text-xs font-semibold transition border ${
                  activeCat === cat
                    ? "bg-[#1E3A8A] border-[#1E3A8A] text-white"
                    : "bg-white border-slate-200 text-slate-600 hover:border-[#1E3A8A] hover:text-[#1E3A8A]"
                }`}
                data-testid={`berita-cat-${cat.toLowerCase()}`}
              >
                {cat}
              </button>
            ))}
          </div>
        </div>
      </div>

      <section className="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 w-full">
        {filtered.length === 0 && (
          <div className="text-center py-20" data-testid="berita-empty">
            <p className="text-slate-500">Tidak ada berita yang cocok dengan pencarian Anda.</p>
          </div>
        )}

        {/* Featured */}
        {featured && (
          <Link
            to={`/berita/${featured.slug}`}
            className="group grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-12 lg:mb-16 items-center"
            data-testid="berita-featured"
          >
            <div className="aspect-[16/10] rounded-2xl overflow-hidden bg-slate-100 order-2 lg:order-1">
              <img
                src={featured.image}
                alt={featured.title}
                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
            </div>
            <div className="order-1 lg:order-2">
              <div className="inline-flex items-center gap-1.5 bg-[#F59E0B] text-white text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                <Tag className="w-3 h-3" /> {featured.category}
              </div>
              <h2 className="text-2xl md:text-3xl lg:text-4xl font-bold text-[#0F172A] leading-tight mb-4 group-hover:text-[#1E3A8A] transition-colors" style={{ fontFamily: "Outfit" }}>
                {featured.title}
              </h2>
              <div className="inline-flex items-center gap-2 text-sm text-slate-500 mb-4">
                <Calendar className="w-4 h-4 text-[#1E3A8A]" /> {featured.fullDate}
              </div>
              <p className="text-base text-slate-600 leading-relaxed mb-6 line-clamp-3">
                {featured.excerpt}
              </p>
              <span className="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1E3A8A] group-hover:text-[#F59E0B] transition-colors">
                Baca Selengkapnya <ArrowRight className="w-4 h-4" />
              </span>
            </div>
          </Link>
        )}

        {/* Grid */}
        {rest.length > 0 && (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {rest.map((n, idx) => (
              <Link
                key={n.id}
                to={`/berita/${n.slug}`}
                className="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:shadow-xl transition-all duration-300"
                data-testid={`berita-card-${idx}`}
              >
                <div className="relative aspect-[16/10] overflow-hidden bg-slate-100">
                  <img
                    src={n.image}
                    alt={n.title}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                  <div className="absolute top-4 left-4 bg-white rounded-lg px-3 py-2 shadow-md text-center leading-tight">
                    <div className="text-xl font-bold text-[#1E3A8A]" style={{ fontFamily: "Outfit" }}>
                      {n.date.split(" ")[0]}
                    </div>
                    <div className="text-xs uppercase font-semibold text-slate-600 tracking-wider">
                      {n.date.split(" ")[1]}
                    </div>
                  </div>
                  <div className="absolute top-4 right-4 bg-[#F59E0B] text-white text-xs font-semibold px-3 py-1 rounded-full">
                    {n.category}
                  </div>
                </div>
                <div className="p-6">
                  <div className="flex items-center gap-2 text-xs text-slate-500 mb-3">
                    <Calendar className="w-3.5 h-3.5" /> {n.fullDate}
                  </div>
                  <h3 className="text-lg font-bold text-[#0F172A] leading-snug mb-3 group-hover:text-[#1E3A8A] transition-colors line-clamp-2">
                    {n.title}
                  </h3>
                  <p className="text-sm text-slate-600 leading-relaxed line-clamp-3 mb-4">{n.excerpt}</p>
                  <span className="text-sm font-semibold text-[#1E3A8A] group-hover:text-[#F59E0B] inline-flex items-center gap-1.5 transition-colors">
                    Baca Selengkapnya <ArrowRight className="w-4 h-4" />
                  </span>
                </div>
              </Link>
            ))}
          </div>
        )}
      </section>

      <Footer />
      <FloatingWA />
    </div>
  );
}
