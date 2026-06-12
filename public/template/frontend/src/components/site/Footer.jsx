import { GraduationCap, MapPin, Phone, Mail, Facebook, Instagram, Youtube, ArrowUpRight } from "lucide-react";
import { SCHOOL } from "@/lib/siteData";

const LINKS_NAV = [
  { label: "Beranda", to: "#home" },
  { label: "Profil Sekolah", to: "#about" },
  { label: "Sambutan Kepsek", to: "#sambutan" },
  { label: "Program Unggulan", to: "#programs" },
  { label: "Berita & Agenda", to: "#news" },
  { label: "Kontak", to: "#contact" },
];

const LINKS_TERKAIT = [
  { label: "Kemdikbud RI", href: "https://www.kemdikbud.go.id" },
  { label: "Dinas Pendidikan Cianjur", href: "#" },
  { label: "Dapodik", href: "https://dapo.kemdikbud.go.id" },
  { label: "BAN-S/M", href: "https://bansm.kemdikbud.go.id" },
  { label: "Rumah Belajar", href: "https://belajar.kemdikbud.go.id" },
];

export default function Footer() {
  const scrollTo = (id) => {
    if (id.startsWith("#")) document.querySelector(id)?.scrollIntoView({ behavior: "smooth" });
  };

  return (
    <footer className="bg-[#0F172A] text-white relative overflow-hidden" data-testid="footer">
      <div className="absolute top-0 right-0 w-96 h-96 bg-[#1E3A8A]/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2" />

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
          {/* Brand */}
          <div className="lg:col-span-4">
            <div className="flex items-center gap-3 mb-5">
              <div className="w-12 h-12 rounded-lg bg-[#1E3A8A] flex items-center justify-center">
                <GraduationCap className="w-7 h-7 text-white" />
              </div>
              <div>
                <div className="font-bold text-lg">{SCHOOL.shortName}</div>
                <div className="text-xs text-white/60">{SCHOOL.tagline}</div>
              </div>
            </div>
            <p className="text-sm text-white/70 leading-relaxed mb-6">
              {SCHOOL.name} adalah sekolah menengah pertama negeri yang berkomitmen mendidik siswa berkarakter, berprestasi, dan berakhlak mulia.
            </p>
            <div className="flex gap-2">
              <a href="#" className="w-10 h-10 rounded-lg bg-white/5 hover:bg-[#F59E0B] flex items-center justify-center transition" data-testid="footer-facebook"><Facebook className="w-4 h-4" /></a>
              <a href="#" className="w-10 h-10 rounded-lg bg-white/5 hover:bg-[#F59E0B] flex items-center justify-center transition" data-testid="footer-instagram"><Instagram className="w-4 h-4" /></a>
              <a href="#" className="w-10 h-10 rounded-lg bg-white/5 hover:bg-[#F59E0B] flex items-center justify-center transition" data-testid="footer-youtube"><Youtube className="w-4 h-4" /></a>
            </div>
          </div>

          {/* Navigation */}
          <div className="lg:col-span-2">
            <h4 className="text-sm font-semibold text-white uppercase tracking-wider mb-5">Navigasi</h4>
            <ul className="space-y-2.5">
              {LINKS_NAV.map((l) => (
                <li key={l.label}>
                  <button onClick={() => scrollTo(l.to)} className="text-sm text-white/70 hover:text-[#F59E0B] transition-colors" data-testid={`footer-nav-${l.label.toLowerCase().replace(/\s+/g, "-")}`}>
                    {l.label}
                  </button>
                </li>
              ))}
            </ul>
          </div>

          {/* Link Terkait */}
          <div className="lg:col-span-3">
            <h4 className="text-sm font-semibold text-white uppercase tracking-wider mb-5">Link Terkait</h4>
            <ul className="space-y-2.5">
              {LINKS_TERKAIT.map((l) => (
                <li key={l.label}>
                  <a href={l.href} target="_blank" rel="noreferrer" className="text-sm text-white/70 hover:text-[#F59E0B] transition-colors inline-flex items-center gap-1.5">
                    {l.label} <ArrowUpRight className="w-3.5 h-3.5" />
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div className="lg:col-span-3">
            <h4 className="text-sm font-semibold text-white uppercase tracking-wider mb-5">Kontak</h4>
            <ul className="space-y-3 text-sm text-white/70">
              <li className="flex gap-3"><MapPin className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /><span>{SCHOOL.address}</span></li>
              <li className="flex gap-3"><Phone className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /><span>{SCHOOL.phone}</span></li>
              <li className="flex gap-3"><Mail className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /><span>{SCHOOL.email}</span></li>
            </ul>
          </div>
        </div>

        <div className="mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-sm text-white/50">
          <div>© {new Date().getFullYear()} {SCHOOL.name}. Hak Cipta Dilindungi.</div>
          <div className="flex items-center gap-5">
            <span>NPSN: {SCHOOL.npsn}</span>
            <span>NSS: {SCHOOL.nss}</span>
            <span>Akreditasi {SCHOOL.accreditation}</span>
          </div>
        </div>
      </div>
    </footer>
  );
}
