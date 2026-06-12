import {
  ClipboardList, CalendarDays, Users, FileText, Award, BookOpenCheck, Building2, Newspaper,
} from "lucide-react";

const ITEMS = [
  { icon: ClipboardList, title: "PPDB Online", desc: "Pendaftaran Siswa Baru", href: "/ppdb", color: "bg-[#F59E0B]" },
  { icon: CalendarDays, title: "Agenda", desc: "Kegiatan Sekolah", href: "#agenda", color: "bg-[#1E3A8A]" },
  { icon: Users, title: "Pegawai", desc: "Tenaga Pendidik", href: "#sambutan", color: "bg-[#1E3A8A]" },
  { icon: FileText, title: "Visi & Misi", desc: "Profil Sekolah", href: "#about", color: "bg-[#1E3A8A]" },
  { icon: Award, title: "Prestasi", desc: "Penghargaan", href: "#tabs", color: "bg-[#1E3A8A]" },
  { icon: BookOpenCheck, title: "Akademik", desc: "Program Unggulan", href: "#programs", color: "bg-[#1E3A8A]" },
  { icon: Building2, title: "Fasilitas", desc: "Sarana Prasarana", href: "#facilities", color: "bg-[#1E3A8A]" },
  { icon: Newspaper, title: "Berita", desc: "Info Terkini", href: "#news", color: "bg-[#1E3A8A]" },
];

export default function QuickInfo() {
  const handleClick = (href) => {
    if (href.startsWith("#")) {
      document.querySelector(href)?.scrollIntoView({ behavior: "smooth" });
    } else if (href.startsWith("/")) {
      window.location.href = href;
    }
  };

  return (
    <section className="relative -mt-16 z-20 px-4 sm:px-6 lg:px-8" data-testid="quick-info-section">
      <div className="max-w-7xl mx-auto">
        <div className="bg-white rounded-2xl shadow-xl border border-slate-100 p-4 sm:p-6 lg:p-8">
          <div className="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4">
            {ITEMS.map(({ icon: Icon, title, desc, href, color }, idx) => (
              <button
                key={title}
                onClick={() => handleClick(href)}
                className="group flex flex-col items-center text-center p-3 rounded-xl hover:bg-slate-50 transition-all"
                data-testid={`quick-info-${title.toLowerCase().replace(/\s+/g, "-")}`}
              >
                <div className={`${color} w-14 h-14 rounded-xl flex items-center justify-center mb-3 shadow-md group-hover:scale-110 group-hover:-translate-y-0.5 transition-transform`}>
                  <Icon className="w-7 h-7 text-white" strokeWidth={2.2} />
                </div>
                <div className="font-semibold text-sm text-[#0F172A] leading-tight">{title}</div>
                <div className="text-xs text-slate-500 mt-1 hidden sm:block">{desc}</div>
              </button>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
