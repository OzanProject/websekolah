import { Link } from "react-router-dom";
import { ArrowRight, Calendar } from "lucide-react";
import { Button } from "@/components/ui/button";
import { NEWS } from "@/lib/siteData";

export default function News() {
  return (
    <section id="news" className="py-20 lg:py-28 bg-[#FAFAFA]" data-testid="news-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
          <div className="max-w-2xl">
            <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
              Berita & Informasi
            </div>
            <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-3" data-testid="news-title">
              Berita & Update Terbaru
            </h2>
            <p className="text-slate-600">Informasi terkini seputar kegiatan, prestasi, dan pengumuman dari sekolah.</p>
          </div>
          <Link to="/berita" className="self-start lg:self-auto" data-testid="news-view-all-link">
            <Button
              variant="outline"
              className="border-2 border-[#1E3A8A] text-[#1E3A8A] hover:bg-[#1E3A8A] hover:text-white"
              data-testid="news-view-all-btn"
            >
              Lihat Semua Berita <ArrowRight className="w-4 h-4 ml-2" />
            </Button>
          </Link>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {NEWS.slice(0, 3).map((n, idx) => (
            <Link
              key={n.id}
              to={`/berita/${n.slug}`}
              className="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:shadow-xl transition-all duration-300"
              data-testid={`news-card-${idx}`}
            >
              <div className="relative aspect-[16/10] overflow-hidden">
                <img
                  src={n.image}
                  alt={n.title}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                <div className="absolute top-4 left-4 bg-white rounded-lg px-3 py-2 shadow-md text-center leading-tight">
                  <div className="text-xl font-bold text-[#1E3A8A]" style={{ fontFamily: "Outfit" }}>{n.date.split(" ")[0]}</div>
                  <div className="text-xs uppercase font-semibold text-slate-600 tracking-wider">{n.date.split(" ")[1]}</div>
                </div>
                <div className="absolute top-4 right-4 bg-[#F59E0B] text-white text-xs font-semibold px-3 py-1 rounded-full">
                  {n.category}
                </div>
              </div>
              <div className="p-6">
                <div className="flex items-center gap-3 text-xs text-slate-500 mb-3">
                  <span className="flex items-center gap-1"><Calendar className="w-3.5 h-3.5" /> {n.fullDate}</span>
                </div>
                <h3 className="text-lg font-bold text-[#0F172A] leading-snug mb-3 group-hover:text-[#1E3A8A] transition-colors line-clamp-2">
                  {n.title}
                </h3>
                <p className="text-sm text-slate-600 leading-relaxed line-clamp-3 mb-4">{n.excerpt}</p>
                <span className="text-sm font-semibold text-[#1E3A8A] group-hover:text-[#F59E0B] inline-flex items-center gap-1.5 transition-colors" data-testid={`news-read-${idx}`}>
                  Baca Selengkapnya <ArrowRight className="w-4 h-4" />
                </span>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
