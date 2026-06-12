import { useState } from "react";
import { MapPin, Phone, Mail, Clock, Send, Facebook, Instagram, Youtube } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { toast } from "sonner";
import { SCHOOL } from "@/lib/siteData";

const CONTACT = [
  { icon: MapPin, title: "Alamat", value: SCHOOL.address },
  { icon: Phone, title: "Telepon", value: SCHOOL.phone },
  { icon: Mail, title: "Email", value: SCHOOL.email },
  { icon: Clock, title: "Jam Operasional", value: "Senin - Jumat: 07.00 - 15.00 WIB" },
];

export default function Contact() {
  const [form, setForm] = useState({ name: "", email: "", subject: "", message: "" });
  const [loading, setLoading] = useState(false);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!form.name || !form.email || !form.message) {
      toast.error("Mohon lengkapi semua field yang wajib diisi");
      return;
    }
    setLoading(true);
    setTimeout(() => {
      toast.success("Pesan Anda berhasil terkirim! Kami akan segera menghubungi Anda.");
      setForm({ name: "", email: "", subject: "", message: "" });
      setLoading(false);
    }, 800);
  };

  return (
    <section id="contact" className="py-20 lg:py-28 bg-white" data-testid="contact-section">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-2xl mx-auto mb-14">
          <div className="inline-block text-sm font-semibold text-[#1E3A8A] bg-[#EFF6FF] px-4 py-1.5 rounded-full mb-4">
            Hubungi Kami
          </div>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F172A] mb-4" data-testid="contact-title">
            Mari Terhubung dengan Kami
          </h2>
          <p className="text-slate-600">
            Ada pertanyaan? Tim kami siap membantu. Silakan hubungi atau kirim pesan kepada kami.
          </p>
        </div>

        <div className="grid lg:grid-cols-5 gap-8">
          {/* Contact info + map */}
          <div className="lg:col-span-2 space-y-4">
            {CONTACT.map((c, i) => {
              const Icon = c.icon;
              return (
                <div key={i} className="flex gap-4 p-5 bg-[#FAFAFA] rounded-xl border border-slate-100 hover:border-[#1E3A8A]/30 transition" data-testid={`contact-info-${i}`}>
                  <div className="flex-shrink-0 w-12 h-12 rounded-xl bg-[#1E3A8A] flex items-center justify-center">
                    <Icon className="w-5 h-5 text-white" />
                  </div>
                  <div>
                    <div className="font-semibold text-[#0F172A]">{c.title}</div>
                    <div className="text-sm text-slate-600 leading-relaxed mt-0.5">{c.value}</div>
                  </div>
                </div>
              );
            })}

            <div className="rounded-xl overflow-hidden border border-slate-200 aspect-[4/3]" data-testid="contact-map">
              <iframe
                title="Lokasi Sekolah"
                src="https://www.openstreetmap.org/export/embed.html?bbox=107.0683%2C-7.3683%2C107.1683%2C-7.2683&layer=mapnik&marker=-7.3183%2C107.1183"
                className="w-full h-full"
                style={{ border: 0 }}
                loading="lazy"
              />
            </div>

            <div className="flex items-center gap-3 pt-2">
              <span className="text-sm font-semibold text-slate-700">Ikuti kami:</span>
              <a href="#" className="w-9 h-9 rounded-full bg-[#1E3A8A] hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" data-testid="social-facebook">
                <Facebook className="w-4 h-4" />
              </a>
              <a href="#" className="w-9 h-9 rounded-full bg-[#1E3A8A] hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" data-testid="social-instagram">
                <Instagram className="w-4 h-4" />
              </a>
              <a href="#" className="w-9 h-9 rounded-full bg-[#1E3A8A] hover:bg-[#F59E0B] text-white flex items-center justify-center transition-colors" data-testid="social-youtube">
                <Youtube className="w-4 h-4" />
              </a>
            </div>
          </div>

          {/* Form */}
          <form onSubmit={handleSubmit} className="lg:col-span-3 bg-[#FAFAFA] rounded-2xl p-6 lg:p-10 border border-slate-100" data-testid="contact-form">
            <h3 className="text-2xl font-bold text-[#0F172A] mb-2">Kirim Pesan</h3>
            <p className="text-slate-600 mb-6">Sampaikan pertanyaan, saran, atau pesan Anda kepada kami.</p>

            <div className="grid sm:grid-cols-2 gap-4 mb-4">
              <div>
                <label className="text-sm font-semibold text-slate-700 mb-1.5 block">Nama Lengkap *</label>
                <Input
                  value={form.name}
                  onChange={(e) => setForm({ ...form, name: e.target.value })}
                  placeholder="Masukkan nama Anda"
                  className="h-12 rounded-lg bg-white border-slate-200 focus-visible:ring-[#1E3A8A]"
                  data-testid="contact-name-input"
                />
              </div>
              <div>
                <label className="text-sm font-semibold text-slate-700 mb-1.5 block">Email *</label>
                <Input
                  type="email"
                  value={form.email}
                  onChange={(e) => setForm({ ...form, email: e.target.value })}
                  placeholder="nama@email.com"
                  className="h-12 rounded-lg bg-white border-slate-200 focus-visible:ring-[#1E3A8A]"
                  data-testid="contact-email-input"
                />
              </div>
            </div>

            <div className="mb-4">
              <label className="text-sm font-semibold text-slate-700 mb-1.5 block">Subjek</label>
              <Input
                value={form.subject}
                onChange={(e) => setForm({ ...form, subject: e.target.value })}
                placeholder="Topik pesan Anda"
                className="h-12 rounded-lg bg-white border-slate-200 focus-visible:ring-[#1E3A8A]"
                data-testid="contact-subject-input"
              />
            </div>

            <div className="mb-6">
              <label className="text-sm font-semibold text-slate-700 mb-1.5 block">Pesan *</label>
              <Textarea
                value={form.message}
                onChange={(e) => setForm({ ...form, message: e.target.value })}
                placeholder="Tulis pesan Anda di sini..."
                rows={5}
                className="rounded-lg bg-white border-slate-200 focus-visible:ring-[#1E3A8A]"
                data-testid="contact-message-input"
              />
            </div>

            <Button
              type="submit"
              disabled={loading}
              size="lg"
              className="bg-[#1E3A8A] hover:bg-[#1E40AF] text-white font-semibold rounded-lg w-full sm:w-auto px-8 h-12"
              data-testid="contact-submit-btn"
            >
              {loading ? "Mengirim..." : <>Kirim Pesan <Send className="w-4 h-4 ml-2" /></>}
            </Button>
          </form>
        </div>
      </div>
    </section>
  );
}
