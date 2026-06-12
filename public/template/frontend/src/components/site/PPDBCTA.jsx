import { Link } from "react-router-dom";
import { Calendar, Users, FileCheck, ArrowRight } from "lucide-react";
import { Button } from "@/components/ui/button";

const STEPS = [
  { icon: Users, title: "Pendaftaran", desc: "Isi formulir online dengan data lengkap" },
  { icon: FileCheck, title: "Verifikasi", desc: "Upload dokumen dan tunggu verifikasi" },
  { icon: Calendar, title: "Tes & Wawancara", desc: "Mengikuti tes seleksi & wawancara" },
];

export default function PPDBCTA() {
  return (
    <section className="py-20 lg:py-28 bg-[#EFF6FF]" data-testid="ppdb-cta-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="relative bg-[#1E3A8A] rounded-3xl overflow-hidden p-8 sm:p-12 lg:p-16">
          {/* Decoration */}
          <div className="absolute top-0 right-0 w-96 h-96 bg-[#F59E0B]/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2" />
          <div className="absolute bottom-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2" />

          <div className="relative grid lg:grid-cols-5 gap-10 items-center">
            <div className="lg:col-span-3 text-white">
              <div className="inline-block text-sm font-semibold text-[#F59E0B] bg-white/10 px-4 py-1.5 rounded-full mb-5">
                PPDB Tahun Ajaran 2026/2027
              </div>
              <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight mb-5" data-testid="ppdb-cta-title">
                Penerimaan Peserta Didik Baru Telah Dibuka
              </h2>
              <p className="text-white/85 text-base lg:text-lg leading-relaxed mb-8">
                Bergabunglah dengan keluarga besar SMPN 4 Kadupandak. Daftarkan putra-putri Anda secara online sekarang dan jadilah bagian dari generasi unggul masa depan.
              </p>
              <div className="flex flex-wrap gap-3">
                <Link to="/ppdb">
                  <Button size="lg" className="bg-[#F59E0B] hover:bg-[#D97706] text-white font-semibold rounded-lg px-7 h-12" data-testid="ppdb-cta-register-btn">
                    Daftar Sekarang <ArrowRight className="w-4 h-4 ml-2" />
                  </Button>
                </Link>
                <Button size="lg" variant="outline" className="border-2 border-white/40 bg-transparent text-white hover:bg-white hover:text-[#1E3A8A] rounded-lg px-7 h-12 font-semibold" data-testid="ppdb-cta-info-btn">
                  Info Selengkapnya
                </Button>
              </div>
            </div>

            <div className="lg:col-span-2 space-y-3">
              {STEPS.map((s, i) => {
                const Icon = s.icon;
                return (
                  <div key={i} className="flex items-center gap-4 bg-white/10 backdrop-blur border border-white/15 rounded-xl p-4">
                    <div className="flex-shrink-0 w-12 h-12 rounded-xl bg-[#F59E0B] flex items-center justify-center">
                      <Icon className="w-6 h-6 text-white" />
                    </div>
                    <div className="text-white">
                      <div className="text-xs font-semibold text-[#F59E0B] uppercase tracking-wider">Langkah {i + 1}</div>
                      <div className="font-bold">{s.title}</div>
                      <div className="text-sm text-white/70">{s.desc}</div>
                    </div>
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
