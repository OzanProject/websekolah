import { Camera } from "lucide-react";

const GALLERY = [
  { src: "https://images.pexels.com/photos/32279024/pexels-photo-32279024.jpeg", title: "Upacara Bendera Senin Pagi" },
  { src: "https://images.unsplash.com/photo-1514369118554-e20d93546b30", title: "Kegiatan Belajar di Kelas" },
  { src: "https://images.pexels.com/photos/35551010/pexels-photo-35551010.jpeg", title: "Praktikum Lab Komputer" },
  { src: "https://images.pexels.com/photos/35550999/pexels-photo-35550999.jpeg", title: "Perpustakaan Sekolah" },
  { src: "https://images.unsplash.com/photo-1497486751825-1233686d5d80", title: "Lapangan Sekolah" },
  { src: "https://images.unsplash.com/photo-1523240795612-9a054b0db644", title: "Aktivitas Pramuka" },
  { src: "https://images.pexels.com/photos/8197521/pexels-photo-8197521.jpeg", title: "Diskusi Kelompok" },
  { src: "https://images.unsplash.com/photo-1660128359946-5d09e282a8a7", title: "Acara Sekolah" },
];

export default function Gallery() {
  return (
    <section id="gallery" className="py-20 lg:py-28 bg-white" data-testid="gallery-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-2xl mx-auto mb-12">
          <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
            Dokumentasi
          </div>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="gallery-title">
            Galeri Foto Sekolah
          </h2>
          <p className="text-slate-600">
            Momen-momen berharga dari aktivitas, kegiatan, dan keseharian di SMPN 4 Kadupandak.
          </p>
        </div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-4">
          {GALLERY.map((g, i) => (
            <div
              key={i}
              className={`group relative overflow-hidden rounded-xl ${i === 0 || i === 5 ? "row-span-2 aspect-[3/4]" : "aspect-square"}`}
              data-testid={`gallery-item-${i}`}
            >
              <img
                src={g.src}
                alt={g.title}
                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
              <div className="absolute bottom-0 left-0 right-0 p-4 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                <div className="flex items-center gap-2 text-[#F59E0B] text-xs font-semibold uppercase tracking-wider mb-1">
                  <Camera className="w-3.5 h-3.5" /> Galeri
                </div>
                <div className="text-white font-semibold text-sm leading-snug">{g.title}</div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
