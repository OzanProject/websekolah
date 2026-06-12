import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Menu, X, ChevronDown, GraduationCap, Phone, Mail } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { SCHOOL } from "@/lib/siteData";

const NAV_LINKS = [
  { label: "Beranda", to: "#home" },
  {
    label: "Profil",
    items: [
      { label: "Visi & Misi", to: "#about" },
      { label: "Sambutan Kepala Sekolah", to: "#sambutan" },
      { label: "Legalitas", to: "#tabs" },
    ],
  },
  {
    label: "Akademik",
    items: [
      { label: "Program Unggulan", to: "#programs" },
      { label: "Ekstrakurikuler", to: "#tabs" },
      { label: "Prestasi", to: "#tabs" },
    ],
  },
  { label: "Berita", to: "#news" },
  { label: "Galeri", to: "#gallery" },
  { label: "Agenda", to: "#agenda" },
  { label: "Kontak", to: "#contact" },
];

export default function Navbar() {
  const [open, setOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 20);
    window.addEventListener("scroll", onScroll);
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  const scrollTo = (id) => {
    setOpen(false);
    if (id.startsWith("#")) {
      const el = document.querySelector(id);
      if (el) el.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  };

  return (
    <>
      {/* Top info bar */}
      <div className="hidden md:block bg-[#0F172A] text-white text-xs" data-testid="top-info-bar">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between py-2">
          <div className="flex items-center gap-6">
            <span className="flex items-center gap-2"><Mail className="w-3.5 h-3.5" /> {SCHOOL.email}</span>
            <span className="flex items-center gap-2"><Phone className="w-3.5 h-3.5" /> {SCHOOL.phone}</span>
          </div>
          <div className="flex items-center gap-4 text-white/70">
            <span>NPSN: {SCHOOL.npsn}</span>
            <span>•</span>
            <span>Akreditasi {SCHOOL.accreditation}</span>
          </div>
        </div>
      </div>

      {/* Main navbar */}
      <header
        className={`sticky top-0 z-50 transition-all ${
          scrolled
            ? "bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm"
            : "bg-white border-b border-slate-200"
        }`}
        data-testid="main-navbar"
      >
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-20">
            <a href="#home" className="flex items-center gap-3" data-testid="nav-logo">
              <div className="w-12 h-12 rounded-lg bg-[#1E3A8A] flex items-center justify-center shadow-md">
                <GraduationCap className="w-7 h-7 text-white" />
              </div>
              <div className="leading-tight">
                <div className="font-bold text-[#0F172A] text-base">{SCHOOL.shortName}</div>
                <div className="text-xs text-slate-500">{SCHOOL.tagline}</div>
              </div>
            </a>

            {/* Desktop Nav */}
            <nav className="hidden lg:flex items-center gap-1">
              {NAV_LINKS.map((link) =>
                link.items ? (
                  <DropdownMenu key={link.label}>
                    <DropdownMenuTrigger
                      className="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1E3A8A] flex items-center gap-1 outline-none"
                      data-testid={`nav-${link.label.toLowerCase()}-trigger`}
                    >
                      {link.label}
                      <ChevronDown className="w-4 h-4" />
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="start" className="w-56">
                      {link.items.map((item) => (
                        <DropdownMenuItem
                          key={item.label}
                          onClick={() => scrollTo(item.to)}
                          className="cursor-pointer"
                          data-testid={`nav-item-${item.label.toLowerCase().replace(/\s+/g, "-")}`}
                        >
                          {item.label}
                        </DropdownMenuItem>
                      ))}
                    </DropdownMenuContent>
                  </DropdownMenu>
                ) : (
                  <button
                    key={link.label}
                    onClick={() => scrollTo(link.to)}
                    className="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1E3A8A] transition-colors"
                    data-testid={`nav-link-${link.label.toLowerCase()}`}
                  >
                    {link.label}
                  </button>
                )
              )}
            </nav>

            <div className="hidden lg:flex items-center">
              <Link to="/ppdb">
                <Button
                  className="bg-[#F59E0B] hover:bg-[#D97706] text-white font-semibold rounded-lg px-5"
                  data-testid="nav-ppdb-btn"
                >
                  Daftar PPDB
                </Button>
              </Link>
            </div>

            <button
              className="lg:hidden p-2 rounded-md hover:bg-slate-100"
              onClick={() => setOpen(!open)}
              data-testid="mobile-menu-toggle"
            >
              {open ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>

          {/* Mobile Nav */}
          {open && (
            <div className="lg:hidden border-t border-slate-200 py-4 space-y-1" data-testid="mobile-nav-menu">
              {NAV_LINKS.map((link) =>
                link.items ? (
                  <div key={link.label} className="px-2">
                    <div className="px-3 py-2 text-xs font-semibold text-slate-400 uppercase">{link.label}</div>
                    {link.items.map((item) => (
                      <button
                        key={item.label}
                        onClick={() => scrollTo(item.to)}
                        className="w-full text-left px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-md"
                      >
                        {item.label}
                      </button>
                    ))}
                  </div>
                ) : (
                  <button
                    key={link.label}
                    onClick={() => scrollTo(link.to)}
                    className="w-full text-left px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-md"
                  >
                    {link.label}
                  </button>
                )
              )}
              <div className="px-5 pt-3">
                <Link to="/ppdb">
                  <Button className="w-full bg-[#F59E0B] hover:bg-[#D97706] text-white font-semibold" data-testid="mobile-nav-ppdb-btn">
                    Daftar PPDB
                  </Button>
                </Link>
              </div>
            </div>
          )}
        </div>
      </header>
    </>
  );
}
