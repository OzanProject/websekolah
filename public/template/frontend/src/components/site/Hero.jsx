import { useState, useEffect } from "react";
import { ChevronRight, Award, Sparkles } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Link } from "react-router-dom";
import { SCHOOL } from "@/lib/siteData";

const SLIDES = [
  {
    image: "https://images.pexels.com/photos/18145430/pexels-photo-18145430.jpeg",
    tag: "Selamat Datang",
    title: "Mendidik Generasi Berkarakter & Berprestasi",
    desc: "SMP Negeri 4 Kadupandak hadir sebagai sekolah unggulan di Kabupaten Cianjur dengan kurikulum merdeka, fasilitas modern, dan tenaga pendidik berpengalaman.",
  },
  {
    image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644",
    tag: "PPDB 2026/2027",
    title: "Pendaftaran Peserta Didik Baru Telah Dibuka",
    desc: "Bergabung bersama keluarga besar SMPN 4 Kadupandak. Daftar online sekarang dan raih masa depan yang lebih cemerlang bersama kami.",
  },
  {
    image: "https://images.unsplash.com/photo-1497486751825-1233686d5d80",
    tag: "Prestasi",
    title: "Sekolah Adiwiyata & Juara Olimpiade Sains",
    desc: "Kami bangga atas berbagai prestasi siswa di tingkat kabupaten dan provinsi yang terus diraih setiap tahunnya.",
  },
];

export default function Hero() {
  const [active, setActive] = useState(0);

  useEffect(() => {
    const t = setInterval(() => setActive((p) => (p + 1) % SLIDES.length), 6000);
    return () => clearInterval(t);
  }, []);

  return (
    <section id="home" className="relative h-[88vh] min-h-[640px] overflow-hidden" data-testid="hero-section">
      {SLIDES.map((s, i) => (
        <div
          key={i}
          className={`absolute inset-0 transition-opacity duration-1000 ${i === active ? "opacity-100" : "opacity-0"}`}
        >
          <img src={s.image} alt={s.title} className="w-full h-full object-cover" />
          <div className="absolute inset-0 bg-gradient-to-b from-[#0F172A]/85 via-[#0F172A]/70 to-[#1E3A8A]/80" />
        </div>
      ))}

      {/* Pattern overlay */}
      <div className="absolute inset-0 opacity-10" style={{
        backgroundImage: "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
        backgroundSize: "40px 40px",
      }} />

      <div className="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
        <div className="max-w-3xl text-white">
          <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-4 py-2 text-sm font-medium mb-6" data-testid="hero-tag">
            <Sparkles className="w-4 h-4 text-[#F59E0B]" />
            {SLIDES[active].tag}
          </div>

          <h1 className="text-4xl sm:text-5xl lg:text-6xl font-bold leading-[1.1] mb-6" data-testid="hero-title">
            {SLIDES[active].title}
          </h1>

          <p className="text-base sm:text-lg text-white/85 leading-relaxed max-w-2xl mb-8" data-testid="hero-desc">
            {SLIDES[active].desc}
          </p>

          <div className="flex flex-wrap gap-3">
            <Link to="/ppdb">
              <Button
                size="lg"
                className="bg-[#F59E0B] hover:bg-[#D97706] text-white font-semibold rounded-lg px-7 h-12 text-base"
                data-testid="hero-ppdb-btn"
              >
                Daftar PPDB Online
                <ChevronRight className="w-5 h-5 ml-1" />
              </Button>
            </Link>
            <Button
              size="lg"
              variant="outline"
              onClick={() => document.getElementById("about")?.scrollIntoView({ behavior: "smooth" })}
              className="border-2 border-white/40 bg-white/10 backdrop-blur-md text-white hover:bg-white hover:text-[#1E3A8A] rounded-lg px-7 h-12 text-base font-semibold"
              data-testid="hero-profile-btn"
            >
              Profil Sekolah
            </Button>
          </div>

          {/* Mini badges */}
          <div className="mt-12 flex flex-wrap gap-6 text-white/90 text-sm" data-testid="hero-badges">
            <div className="flex items-center gap-2">
              <Award className="w-5 h-5 text-[#F59E0B]" />
              <span>Akreditasi {SCHOOL.accreditation}</span>
            </div>
            <div className="flex items-center gap-2">
              <Award className="w-5 h-5 text-[#F59E0B]" />
              <span>Berdiri sejak {SCHOOL.established}</span>
            </div>
            <div className="flex items-center gap-2">
              <Award className="w-5 h-5 text-[#F59E0B]" />
              <span>NPSN {SCHOOL.npsn}</span>
            </div>
          </div>
        </div>
      </div>

      {/* Slide indicators */}
      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-10" data-testid="hero-slider-dots">
        {SLIDES.map((_, i) => (
          <button
            key={i}
            onClick={() => setActive(i)}
            className={`h-1.5 rounded-full transition-all ${i === active ? "w-10 bg-[#F59E0B]" : "w-6 bg-white/40"}`}
            data-testid={`hero-dot-${i}`}
          />
        ))}
      </div>
    </section>
  );
}
