import {
  GraduationCap, BookMarked, Globe, Laptop,
} from "lucide-react";
import { PROGRAMS } from "@/lib/siteData";

const ICONS = { GraduationCap, BookMarked, Globe, Laptop };

export default function Programs() {
  return (
    <section id="programs" className="py-20 lg:py-28 bg-white" data-testid="programs-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-14">
          <div className="max-w-2xl">
            <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
              Program Akademik
            </div>
            <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="programs-title">
              Program Unggulan Sekolah
            </h2>
            <p className="text-slate-600 leading-relaxed">
              Pembelajaran modern yang dirancang untuk mengembangkan potensi akademik, karakter, dan keterampilan siswa.
            </p>
          </div>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {PROGRAMS.map((p, i) => {
            const Icon = ICONS[p.icon];
            return (
              <div
                key={p.title}
                className="group relative bg-white rounded-2xl border border-slate-200 p-6 hover:border-[#1E3A8A] hover:shadow-lg transition-all duration-300"
                data-testid={`program-${i}`}
              >
                <div className="absolute top-6 right-6 text-6xl font-bold text-slate-100 group-hover:text-[#EFF6FF] transition" style={{ fontFamily: "Outfit" }}>
                  0{i + 1}
                </div>
                <div className="relative">
                  <div className="w-14 h-14 rounded-xl bg-[#EFF6FF] flex items-center justify-center mb-5 group-hover:bg-[#1E3A8A] transition-colors">
                    {Icon && <Icon className="w-7 h-7 text-[#1E3A8A] group-hover:text-white transition-colors" strokeWidth={2} />}
                  </div>
                  <h3 className="text-lg font-bold text-[#0F172A] mb-2">{p.title}</h3>
                  <p className="text-sm text-slate-600 leading-relaxed">{p.desc}</p>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
