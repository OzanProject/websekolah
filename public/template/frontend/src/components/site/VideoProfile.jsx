import { Play } from "lucide-react";

export default function VideoProfile() {
  return (
    <section className="py-20 lg:py-28 bg-[#FAFAFA]" data-testid="video-section">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-2xl mx-auto mb-10">
          <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
            Video Profil
          </div>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="video-title">
            Tonton Profil Sekolah Kami
          </h2>
          <p className="text-slate-600">
            Jelajahi fasilitas, lingkungan belajar, dan suasana di SMP Negeri 4 Kadupandak melalui video.
          </p>
        </div>

        <div className="relative aspect-video rounded-2xl overflow-hidden group cursor-pointer shadow-2xl" data-testid="video-thumbnail">
          <img
            src="https://images.pexels.com/photos/18145430/pexels-photo-18145430.jpeg"
            alt="Profil Sekolah"
            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
          />
          <div className="absolute inset-0 bg-[#0F172A]/40 group-hover:bg-[#0F172A]/30 transition" />
          <div className="absolute inset-0 flex items-center justify-center">
            <div className="relative">
              <div className="absolute inset-0 rounded-full bg-[#F59E0B]/30 animate-ping" />
              <div className="relative w-20 h-20 lg:w-24 lg:h-24 rounded-full bg-white/95 backdrop-blur flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
                <Play className="w-8 h-8 lg:w-10 lg:h-10 text-[#1E3A8A] ml-1" fill="currentColor" />
              </div>
            </div>
          </div>
          <div className="absolute bottom-6 left-6 right-6 text-white">
            <div className="text-xs uppercase tracking-widest font-semibold text-[#F59E0B] mb-1">Durasi 3:42</div>
            <div className="text-xl lg:text-2xl font-bold" style={{ fontFamily: "Outfit" }}>SMP Negeri 4 Kadupandak — Sekolah Pilihan Masa Depan</div>
          </div>
        </div>
      </div>
    </section>
  );
}
