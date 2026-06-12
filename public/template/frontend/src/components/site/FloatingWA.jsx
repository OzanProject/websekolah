import { useEffect, useState } from "react";
import { MessageCircle, X } from "lucide-react";
import { SCHOOL } from "@/lib/siteData";

export default function FloatingWA() {
  const [open, setOpen] = useState(false);
  const [visible, setVisible] = useState(false);

  useEffect(() => {
    const t = setTimeout(() => setVisible(true), 1500);
    return () => clearTimeout(t);
  }, []);

  const defaultMsg = encodeURIComponent(
    `Halo Panitia PPDB ${SCHOOL.shortName}, saya ingin bertanya seputar pendaftaran dan informasi sekolah. Terima kasih.`
  );

  return (
    <div className="fixed bottom-5 right-5 z-50 flex flex-col items-end gap-3" data-testid="floating-wa">
      {open && (
        <div
          className="bg-white shadow-2xl rounded-2xl border border-slate-200 w-[300px] overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-300"
          data-testid="floating-wa-card"
        >
          <div className="bg-[#25D366] text-white px-5 py-4 flex items-center justify-between">
            <div>
              <div className="text-sm font-semibold">Hubungi Kami</div>
              <div className="text-[11px] text-white/80">Panitia PPDB {SCHOOL.shortName}</div>
            </div>
            <button
              onClick={() => setOpen(false)}
              className="w-7 h-7 rounded-full hover:bg-white/20 flex items-center justify-center"
              aria-label="Tutup"
              data-testid="floating-wa-close"
            >
              <X className="w-4 h-4" />
            </button>
          </div>
          <div className="p-5">
            <div className="flex gap-3 items-start mb-4">
              <div className="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center flex-shrink-0">
                <MessageCircle className="w-5 h-5" />
              </div>
              <div className="bg-slate-100 rounded-2xl rounded-tl-sm px-4 py-3 text-sm text-slate-700 leading-relaxed">
                Halo! Ada yang bisa kami bantu seputar PPDB atau informasi sekolah?
              </div>
            </div>
            <a
              href={`https://wa.me/${SCHOOL.adminWa}?text=${defaultMsg}`}
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#1FAD51] text-white font-semibold rounded-lg h-11 transition text-sm"
              data-testid="floating-wa-start-chat"
            >
              <MessageCircle className="w-4 h-4" /> Mulai Chat WhatsApp
            </a>
            <p className="text-[11px] text-slate-400 text-center mt-3">
              Biasanya balas dalam 5–30 menit (jam kerja)
            </p>
          </div>
        </div>
      )}

      <button
        onClick={() => setOpen((v) => !v)}
        className={`group relative bg-[#25D366] hover:bg-[#1FAD51] text-white w-14 h-14 rounded-full shadow-xl flex items-center justify-center transition-all duration-300 ${
          visible ? "opacity-100 scale-100" : "opacity-0 scale-50"
        }`}
        aria-label="Hubungi via WhatsApp"
        data-testid="floating-wa-btn"
      >
        <span className="absolute inset-0 rounded-full bg-[#25D366] opacity-60 animate-ping" />
        <MessageCircle className="w-7 h-7 relative" />
      </button>
    </div>
  );
}
