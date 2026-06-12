import { useState } from "react";
import { Quote, ChevronLeft, ChevronRight, Star } from "lucide-react";
import { TESTIMONIALS } from "@/lib/siteData";

export default function Testimoni() {
  const [active, setActive] = useState(0);

  const prev = () => setActive((p) => (p - 1 + TESTIMONIALS.length) % TESTIMONIALS.length);
  const next = () => setActive((p) => (p + 1) % TESTIMONIALS.length);

  return (
    <section className="py-20 lg:py-28 bg-[#0F172A] relative overflow-hidden" data-testid="testimoni-section">
      <div className="absolute inset-0 opacity-5" style={{
        backgroundImage: "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
        backgroundSize: "32px 32px",
      }} />
      <div className="absolute bottom-0 left-0 w-96 h-96 bg-[#1E3A8A]/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2" />

      <div className="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-2xl mx-auto mb-12">
          <div className="inline-block text-sm font-semibold text-[#F59E0B] bg-white/10 px-4 py-1.5 rounded-full mb-4">
            Testimoni
          </div>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" data-testid="testimoni-title">
            Apa Kata Mereka?
          </h2>
          <p className="text-white/70">
            Pengalaman siswa, alumni, dan orang tua tentang SMPN 4 Kadupandak.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {TESTIMONIALS.map((t, i) => (
            <div
              key={i}
              className={`bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6 lg:p-8 hover:bg-white/10 transition-all ${
                i === active ? "ring-2 ring-[#F59E0B]" : ""
              }`}
              data-testid={`testimoni-card-${i}`}
            >
              <Quote className="w-10 h-10 text-[#F59E0B] mb-4" />
              <div className="flex gap-1 mb-4">
                {[...Array(5)].map((_, s) => <Star key={s} className="w-4 h-4 fill-[#F59E0B] text-[#F59E0B]" />)}
              </div>
              <p className="text-white/90 leading-relaxed mb-6 text-sm lg:text-base">"{t.quote}"</p>
              <div className="flex items-center gap-3 pt-4 border-t border-white/10">
                <img src={t.avatar} alt={t.name} className="w-12 h-12 rounded-full object-cover ring-2 ring-[#F59E0B]/40" />
                <div>
                  <div className="font-semibold text-white">{t.name}</div>
                  <div className="text-xs text-white/60">{t.role}</div>
                </div>
              </div>
            </div>
          ))}
        </div>

        <div className="flex justify-center gap-3 mt-10">
          <button onClick={prev} className="w-11 h-11 rounded-full bg-white/10 hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" data-testid="testimoni-prev">
            <ChevronLeft className="w-5 h-5" />
          </button>
          <button onClick={next} className="w-11 h-11 rounded-full bg-white/10 hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" data-testid="testimoni-next">
            <ChevronRight className="w-5 h-5" />
          </button>
        </div>
      </div>
    </section>
  );
}
