import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { CheckCircle2, Trophy, ScrollText, Sparkles, Calendar } from "lucide-react";
import { KEUNGGULAN, PENGHARGAAN, LEGALITAS, EKSTRAKURIKULER } from "@/lib/siteData";

export default function InfoTabs() {
  return (
    <section id="tabs" className="py-20 lg:py-28 bg-white" data-testid="info-tabs-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-2xl mx-auto mb-12">
          <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
            Tentang Sekolah
          </div>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="info-tabs-title">
            Keunggulan, Prestasi & Legalitas
          </h2>
          <p className="text-slate-600">
            Mengenal lebih dekat berbagai keunggulan dan capaian SMPN 4 Kadupandak
          </p>
        </div>

        <Tabs defaultValue="keunggulan" className="w-full">
          <TabsList className="grid w-full grid-cols-2 lg:grid-cols-4 h-auto bg-slate-100 p-1.5 rounded-xl mb-10 max-w-3xl mx-auto">
            <TabsTrigger value="keunggulan" className="data-[state=active]:bg-[#1E3A8A] data-[state=active]:text-white py-3 rounded-lg font-semibold" data-testid="tab-keunggulan">
              <Sparkles className="w-4 h-4 mr-1.5" /> Keunggulan
            </TabsTrigger>
            <TabsTrigger value="penghargaan" className="data-[state=active]:bg-[#1E3A8A] data-[state=active]:text-white py-3 rounded-lg font-semibold" data-testid="tab-penghargaan">
              <Trophy className="w-4 h-4 mr-1.5" /> Penghargaan
            </TabsTrigger>
            <TabsTrigger value="legalitas" className="data-[state=active]:bg-[#1E3A8A] data-[state=active]:text-white py-3 rounded-lg font-semibold" data-testid="tab-legalitas">
              <ScrollText className="w-4 h-4 mr-1.5" /> Legalitas
            </TabsTrigger>
            <TabsTrigger value="ekstra" className="data-[state=active]:bg-[#1E3A8A] data-[state=active]:text-white py-3 rounded-lg font-semibold" data-testid="tab-ekstra">
              <Calendar className="w-4 h-4 mr-1.5" /> Ekstrakurikuler
            </TabsTrigger>
          </TabsList>

          <TabsContent value="keunggulan" className="mt-0" data-testid="tabpanel-keunggulan">
            <div className="grid md:grid-cols-2 gap-4">
              {KEUNGGULAN.map((k, i) => (
                <div key={i} className="flex gap-4 p-5 bg-[#FAFAFA] rounded-xl border border-slate-100 hover:border-[#1E3A8A]/30 transition">
                  <div className="flex-shrink-0 w-10 h-10 rounded-lg bg-[#EFF6FF] flex items-center justify-center">
                    <CheckCircle2 className="w-5 h-5 text-[#1E3A8A]" />
                  </div>
                  <p className="text-slate-700 leading-relaxed pt-1.5">{k}</p>
                </div>
              ))}
            </div>
          </TabsContent>

          <TabsContent value="penghargaan" className="mt-0" data-testid="tabpanel-penghargaan">
            <div className="grid md:grid-cols-2 gap-5">
              {PENGHARGAAN.map((p, i) => (
                <div key={i} className="relative p-6 bg-gradient-to-br from-[#EFF6FF] to-white rounded-2xl border border-[#1E3A8A]/10">
                  <div className="absolute top-4 right-4 text-xs font-bold text-[#F59E0B] bg-white px-2.5 py-1 rounded-full border border-[#F59E0B]/20">
                    {p.year}
                  </div>
                  <Trophy className="w-8 h-8 text-[#F59E0B] mb-4" />
                  <h3 className="text-lg font-bold text-[#0F172A] mb-2 leading-snug pr-12">{p.title}</h3>
                  <p className="text-sm text-slate-600">{p.desc}</p>
                </div>
              ))}
            </div>
          </TabsContent>

          <TabsContent value="legalitas" className="mt-0" data-testid="tabpanel-legalitas">
            <div className="bg-[#FAFAFA] rounded-2xl p-6 lg:p-10 border border-slate-100">
              <div className="grid sm:grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-6">
                {LEGALITAS.map((l, i) => (
                  <div key={i} className="border-l-4 border-[#1E3A8A] pl-4">
                    <div className="text-xs uppercase tracking-wider text-slate-500 font-semibold">{l.label}</div>
                    <div className="text-lg font-bold text-[#0F172A] mt-1" style={{ fontFamily: "Outfit" }}>{l.value}</div>
                  </div>
                ))}
              </div>
            </div>
          </TabsContent>

          <TabsContent value="ekstra" className="mt-0" data-testid="tabpanel-ekstra">
            <div className="bg-[#FAFAFA] rounded-2xl p-6 lg:p-10 border border-slate-100">
              <p className="text-slate-600 mb-6">
                Kami menyediakan beragam kegiatan ekstrakurikuler untuk mengembangkan minat dan bakat siswa di luar pembelajaran formal:
              </p>
              <div className="flex flex-wrap gap-3">
                {EKSTRAKURIKULER.map((e, i) => (
                  <span
                    key={i}
                    className="px-4 py-2 bg-white border border-slate-200 rounded-full text-sm font-medium text-slate-700 hover:bg-[#1E3A8A] hover:text-white hover:border-[#1E3A8A] transition-all cursor-default"
                    data-testid={`ekstra-${i}`}
                  >
                    {e}
                  </span>
                ))}
              </div>
            </div>
          </TabsContent>
        </Tabs>
      </div>
    </section>
  );
}
