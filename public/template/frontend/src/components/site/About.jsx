import { Quote, Target, Eye, CheckCircle2 } from "lucide-react";

const VISI = "Mewujudkan peserta didik yang beriman, bertaqwa, berkarakter, cerdas, terampil, dan berwawasan lingkungan menuju generasi unggul Indonesia 2045.";

const MISI = [
  "Menyelenggarakan pendidikan yang berorientasi pada penguatan iman, taqwa, dan akhlak mulia.",
  "Mengembangkan pembelajaran aktif, inovatif, kreatif, dan menyenangkan berbasis Kurikulum Merdeka.",
  "Meningkatkan profesionalisme guru dan tenaga kependidikan secara berkelanjutan.",
  "Mengoptimalkan minat dan bakat peserta didik melalui kegiatan ekstrakurikuler.",
  "Membangun budaya sekolah yang ramah, peduli lingkungan, dan berbudaya literasi.",
];

export default function About() {
  return (
    <section id="about" className="py-20 lg:py-28 bg-[#FAFAFA]" data-testid="about-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-14">
          <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4" data-testid="about-eyebrow">
            Tentang Kami
          </div>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="about-title">
            Visi & Misi Sekolah
          </h2>
          <p className="text-slate-600 leading-relaxed">
            Komitmen kami dalam mendidik generasi penerus bangsa yang berkarakter dan berprestasi.
          </p>
        </div>

        <div className="grid lg:grid-cols-5 gap-8">
          {/* Visi */}
          <div className="lg:col-span-2 bg-[#1E3A8A] text-white rounded-2xl p-8 lg:p-10 relative overflow-hidden" data-testid="visi-card">
            <Quote className="absolute -top-2 -right-2 w-32 h-32 text-white/5" />
            <div className="relative">
              <div className="w-14 h-14 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center mb-6">
                <Eye className="w-7 h-7 text-[#F59E0B]" />
              </div>
              <div className="text-[#F59E0B] text-sm font-semibold uppercase tracking-wider mb-3">Visi</div>
              <p className="text-xl lg:text-2xl font-semibold leading-snug" style={{ fontFamily: "Outfit" }}>
                {VISI}
              </p>
            </div>
          </div>

          {/* Misi */}
          <div className="lg:col-span-3 bg-white rounded-2xl p-8 lg:p-10 border border-slate-200" data-testid="misi-card">
            <div className="flex items-center gap-3 mb-6">
              <div className="w-14 h-14 rounded-xl bg-[#EFF6FF] flex items-center justify-center">
                <Target className="w-7 h-7 text-[#1E3A8A]" />
              </div>
              <div>
                <div className="text-[#1E3A8A] text-sm font-semibold uppercase tracking-wider">Misi</div>
                <div className="text-xl font-bold text-[#0F172A]">5 Pilar Pendidikan Kami</div>
              </div>
            </div>
            <ul className="space-y-4">
              {MISI.map((m, i) => (
                <li key={i} className="flex gap-3" data-testid={`misi-item-${i + 1}`}>
                  <CheckCircle2 className="w-5 h-5 text-[#F59E0B] flex-shrink-0 mt-0.5" />
                  <span className="text-slate-700 leading-relaxed">{m}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>
      </div>
    </section>
  );
}
