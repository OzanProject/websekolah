import { useEffect, useState, useRef } from "react";
import { Users, GraduationCap, BookOpen, Award } from "lucide-react";

const STATS = [
  { value: 487, label: "Jumlah Siswa", suffix: "+", icon: Users },
  { value: 38, label: "Guru & Staf", suffix: "", icon: GraduationCap },
  { value: 18, label: "Rombongan Belajar", suffix: "", icon: BookOpen },
  { value: 52, label: "Prestasi Diraih", suffix: "+", icon: Award },
];

function useCounter(target, isActive, duration = 2000) {
  const [count, setCount] = useState(0);
  useEffect(() => {
    if (!isActive) return;
    let start = 0;
    const step = (timestamp, startTime) => {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      setCount(Math.floor(progress * target));
      if (progress < 1) requestAnimationFrame((t) => step(t, startTime));
    };
    requestAnimationFrame((t) => step(t));
  }, [target, isActive, duration]);
  return count;
}

function StatItem({ stat, active }) {
  const count = useCounter(stat.value, active);
  const Icon = stat.icon;
  return (
    <div className="text-center" data-testid={`stat-${stat.label.toLowerCase().replace(/\s+/g, "-")}`}>
      <div className="inline-flex w-16 h-16 rounded-2xl bg-white/10 backdrop-blur items-center justify-center mb-5">
        <Icon className="w-8 h-8 text-[#F59E0B]" strokeWidth={2} />
      </div>
      <div className="text-5xl lg:text-6xl font-bold text-white mb-2" style={{ fontFamily: "Outfit" }}>
        {count.toLocaleString("id-ID")}{stat.suffix}
      </div>
      <div className="text-white/80 font-medium">{stat.label}</div>
    </div>
  );
}

export default function Stats() {
  const ref = useRef(null);
  const [active, setActive] = useState(false);

  useEffect(() => {
    const obs = new IntersectionObserver(
      ([entry]) => entry.isIntersecting && setActive(true),
      { threshold: 0.3 }
    );
    if (ref.current) obs.observe(ref.current);
    return () => obs.disconnect();
  }, []);

  return (
    <section ref={ref} className="relative py-20 lg:py-28 bg-[#1E3A8A] overflow-hidden" data-testid="stats-section">
      {/* Decorative */}
      <div className="absolute inset-0 opacity-10" style={{
        backgroundImage: "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
        backgroundSize: "32px 32px",
      }} />
      <div className="absolute top-0 right-0 w-96 h-96 bg-[#F59E0B]/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2" />

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-2xl mx-auto mb-14">
          <div className="inline-block text-sm font-semibold text-[#F59E0B] bg-white/10 px-4 py-1.5 rounded-full mb-4">
            Mengapa Memilih Kami
          </div>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" data-testid="stats-title">
            Pencapaian Sekolah Kami
          </h2>
          <p className="text-white/75 leading-relaxed">
            Angka-angka yang menunjukkan dedikasi dan kualitas pendidikan di SMPN 4 Kadupandak
          </p>
        </div>

        <div className="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
          {STATS.map((s) => <StatItem key={s.label} stat={s} active={active} />)}
        </div>
      </div>
    </section>
  );
}
