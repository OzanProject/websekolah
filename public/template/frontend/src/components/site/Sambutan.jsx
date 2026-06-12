import { Quote } from "lucide-react";

export default function Sambutan() {
  return (
    <section id="sambutan" className="py-20 lg:py-28 bg-white" data-testid="sambutan-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          {/* Image side */}
          <div className="relative">
            <div className="absolute -top-6 -left-6 w-32 h-32 bg-[#F59E0B] rounded-2xl -z-10" />
            <div className="absolute -bottom-6 -right-6 w-40 h-40 bg-[#EFF6FF] rounded-2xl -z-10" />
            <div className="relative rounded-2xl overflow-hidden border-4 border-white shadow-2xl">
              <img
                src="https://images.pexels.com/photos/8197521/pexels-photo-8197521.jpeg"
                alt="Kepala Sekolah"
                className="w-full aspect-[4/5] object-cover"
                data-testid="kepsek-image"
              />
            </div>
            <div className="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur rounded-xl p-4 shadow-lg" data-testid="kepsek-badge">
              <div className="font-bold text-[#0F172A]">Drs. H. Asep Mulyana, M.Pd</div>
              <div className="text-sm text-[#1E3A8A] font-medium">Kepala Sekolah</div>
            </div>
          </div>

          {/* Content side */}
          <div>
            <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4" data-testid="sambutan-eyebrow">
              Sambutan
            </div>
            <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-6" data-testid="sambutan-title">
              Sambutan Kepala Sekolah
            </h2>

            <Quote className="w-12 h-12 text-[#F59E0B] mb-4" />

            <div className="space-y-4 text-slate-700 leading-relaxed">
              <p>
                <span className="font-semibold text-[#0F172A]">Assalamu'alaikum Warahmatullahi Wabarakatuh.</span>
                {" "}Puji syukur kita panjatkan kehadirat Allah SWT atas segala nikmat dan karunia-Nya, sehingga website resmi SMP Negeri 4 Kadupandak ini dapat hadir untuk Bapak/Ibu serta seluruh siswa-siswi.
              </p>
              <p>
                Website ini kami hadirkan sebagai sarana informasi, komunikasi, dan transparansi pelayanan pendidikan. Mari bersama-sama kita wujudkan SMPN 4 Kadupandak sebagai sekolah unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan siap menghadapi tantangan masa depan.
              </p>
              <p className="text-slate-600">
                Terima kasih atas kepercayaan dan dukungan Bapak/Ibu kepada sekolah kami. Semoga tahun ajaran ini menjadi tahun yang penuh berkah dan prestasi.
              </p>
            </div>

            <div className="mt-8 pt-8 border-t border-slate-200 flex items-center gap-6 text-sm" data-testid="sambutan-credentials">
              <div>
                <div className="text-slate-500">NIP</div>
                <div className="font-semibold text-[#0F172A]">19720315 199801 1 002</div>
              </div>
              <div>
                <div className="text-slate-500">Masa Jabatan</div>
                <div className="font-semibold text-[#0F172A]">2022 - Sekarang</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
