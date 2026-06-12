import { MapPin, Clock, ArrowRight } from "lucide-react";
import { Button } from "@/components/ui/button";
import { AGENDA } from "@/lib/siteData";

export default function Agenda() {
  return (
    <section id="agenda" className="py-20 lg:py-28 bg-[#FAFAFA]" data-testid="agenda-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid lg:grid-cols-3 gap-10">
          <div className="lg:col-span-1">
            <div className="lg:sticky lg:top-32">
              <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
                Kalender Sekolah
              </div>
              <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-5" data-testid="agenda-title">
                Agenda Kegiatan
              </h2>
              <p className="text-slate-600 leading-relaxed mb-6">
                Jadwal kegiatan, acara, dan kalender akademik SMPN 4 Kadupandak yang akan datang.
              </p>
              <Button className="bg-[#1E3A8A] hover:bg-[#1E40AF] text-white" data-testid="agenda-view-all-btn">
                Lihat Semua Agenda <ArrowRight className="w-4 h-4 ml-2" />
              </Button>
            </div>
          </div>

          <div className="lg:col-span-2 space-y-4">
            {AGENDA.map((a, i) => (
              <div
                key={i}
                className="group flex gap-5 bg-white p-5 lg:p-6 rounded-2xl border border-slate-200 hover:border-[#1E3A8A] hover:shadow-md transition-all"
                data-testid={`agenda-item-${i}`}
              >
                <div className="flex-shrink-0 w-20 lg:w-24 bg-[#EFF6FF] group-hover:bg-[#1E3A8A] transition-colors rounded-xl flex flex-col items-center justify-center py-3">
                  <div className="text-3xl lg:text-4xl font-bold text-[#1E3A8A] group-hover:text-white transition-colors" style={{ fontFamily: "Outfit" }}>
                    {a.day}
                  </div>
                  <div className="text-xs uppercase font-semibold tracking-wider text-[#1E3A8A] group-hover:text-[#F59E0B] transition-colors">
                    {a.month}
                  </div>
                </div>
                <div className="flex-1 min-w-0">
                  <h3 className="text-lg font-bold text-[#0F172A] mb-2 leading-snug group-hover:text-[#1E3A8A] transition-colors">
                    {a.title}
                  </h3>
                  <div className="flex flex-wrap gap-x-5 gap-y-1.5 text-sm text-slate-600">
                    <span className="flex items-center gap-1.5"><Clock className="w-4 h-4 text-[#F59E0B]" /> {a.time}</span>
                    <span className="flex items-center gap-1.5"><MapPin className="w-4 h-4 text-[#F59E0B]" /> {a.location}</span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
