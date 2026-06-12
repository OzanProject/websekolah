import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { ArrowLeft, CheckCircle2, GraduationCap, Calendar, FileText, Upload, MessageCircle, Phone, Mail, Copy } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { toast } from "sonner";
import Navbar from "@/components/site/Navbar";
import Footer from "@/components/site/Footer";
import FloatingWA from "@/components/site/FloatingWA";
import { SCHOOL } from "@/lib/siteData";

const STORAGE_KEY = "ppdb_pendaftar_smpn4kadupandak";

const initialState = {
  nama: "",
  nisn: "",
  tempatLahir: "",
  tanggalLahir: "",
  jenisKelamin: "",
  alamat: "",
  asalSekolah: "",
  namaOrtu: "",
  noTelp: "",
  email: "",
  catatan: "",
};

export default function PPDB() {
  const [form, setForm] = useState(initialState);
  const [submitted, setSubmitted] = useState(false);
  const [pendaftaranId, setPendaftaranId] = useState("");

  useEffect(() => {
    const prevTitle = document.title;
    document.title = "PPDB Online 2026/2027 | SMP Negeri 4 Kadupandak";
    const meta = document.querySelector('meta[name="description"]');
    const prevDesc = meta?.getAttribute("content");
    meta?.setAttribute("content", "Pendaftaran Peserta Didik Baru (PPDB) SMP Negeri 4 Kadupandak tahun ajaran 2026/2027. Daftar online dengan mudah, gratis, dan langsung dapat nomor pendaftaran.");
    return () => {
      document.title = prevTitle;
      if (prevDesc) meta?.setAttribute("content", prevDesc);
    };
  }, []);

  const update = (k, v) => setForm({ ...form, [k]: v });

  const handleSubmit = (e) => {
    e.preventDefault();
    const required = ["nama", "nisn", "tempatLahir", "tanggalLahir", "jenisKelamin", "alamat", "asalSekolah", "namaOrtu", "noTelp"];
    const missing = required.filter((k) => !form[k]);
    if (missing.length) {
      toast.error("Mohon lengkapi semua data wajib yang ditandai (*)");
      return;
    }

    // Generate nomor pendaftaran
    const tahun = new Date().getFullYear();
    const random = Math.floor(Math.random() * 90000) + 10000;
    const nomor = `PPDB-${tahun}-${random}`;

    // Simpan ke localStorage
    const record = {
      ...form,
      nomorPendaftaran: nomor,
      tanggalDaftar: new Date().toISOString(),
    };
    try {
      const existing = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
      existing.push(record);
      localStorage.setItem(STORAGE_KEY, JSON.stringify(existing));
    } catch (err) {
      console.error("Gagal menyimpan data ke localStorage", err);
    }

    setPendaftaranId(nomor);
    setSubmitted(true);
    toast.success("Pendaftaran berhasil disimpan!");
  };

  const copyNomor = () => {
    navigator.clipboard.writeText(pendaftaranId);
    toast.success("Nomor pendaftaran disalin!");
  };

  const waMessage = encodeURIComponent(
    `Halo Panitia PPDB SMPN 4 Kadupandak,\n\nSaya baru saja melakukan pendaftaran online dengan rincian:\n\nNomor Pendaftaran: ${pendaftaranId}\nNama: ${form.nama}\nNISN: ${form.nisn}\nAsal Sekolah: ${form.asalSekolah}\n\nMohon konfirmasi dan informasi langkah selanjutnya. Terima kasih.`
  );

  if (submitted) {
    return (
      <div className="min-h-screen bg-[#FAFAFA] flex flex-col">
        <Navbar />
        <div className="flex-1 flex items-center justify-center py-20 px-4">
          <div className="max-w-2xl w-full bg-white rounded-2xl border border-slate-200 p-8 lg:p-12 shadow-xl" data-testid="ppdb-success">
            <div className="text-center mb-6">
              <div className="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                <CheckCircle2 className="w-12 h-12 text-green-600" />
              </div>
              <h1 className="text-3xl font-bold text-[#0F172A] mb-3">Pendaftaran Berhasil Tersimpan!</h1>
              <p className="text-slate-600 leading-relaxed">
                Terima kasih, <strong className="text-[#0F172A]">{form.nama}</strong>. Data pendaftaran Anda telah kami simpan.
              </p>
            </div>

            <div className="bg-gradient-to-br from-[#1E3A8A] to-[#1E40AF] rounded-xl p-6 my-6 text-white">
              <div className="text-xs uppercase tracking-wider text-white/70 font-semibold mb-1">Nomor Pendaftaran Anda</div>
              <div className="flex items-center justify-between gap-3">
                <div className="text-2xl lg:text-3xl font-bold tracking-wide" style={{ fontFamily: "Outfit" }} data-testid="ppdb-nomor">
                  {pendaftaranId}
                </div>
                <button
                  onClick={copyNomor}
                  className="flex items-center gap-2 bg-white/10 hover:bg-white/20 transition px-3 py-2 rounded-lg text-sm font-medium"
                  data-testid="ppdb-copy-nomor-btn"
                >
                  <Copy className="w-4 h-4" /> Salin
                </button>
              </div>
              <p className="text-xs text-white/70 mt-3">Simpan nomor ini untuk konfirmasi & pengecekan status pendaftaran.</p>
            </div>

            <div className="bg-[#FFF7ED] border border-[#FDE68A] rounded-xl p-5 mb-6">
              <h3 className="font-bold text-[#0F172A] mb-3 flex items-center gap-2">
                <MessageCircle className="w-5 h-5 text-[#F59E0B]" />
                Langkah Selanjutnya
              </h3>
              <ol className="text-sm text-slate-700 space-y-2 list-decimal list-inside">
                <li>Konfirmasi pendaftaran Anda dengan menghubungi panitia PPDB via WhatsApp di bawah.</li>
                <li>Siapkan & bawa dokumen persyaratan (Akta Lahir, KK, KTP Ortu, Pas Foto 3x4) ke sekolah.</li>
                <li>Tunggu informasi jadwal seleksi melalui WA / Email yang Anda daftarkan.</li>
              </ol>
            </div>

            <div className="space-y-3">
              <a
                href={`https://wa.me/${SCHOOL.adminWa}?text=${waMessage}`}
                target="_blank"
                rel="noopener noreferrer"
                className="flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#1FAD51] text-white font-semibold rounded-lg h-12 transition"
                data-testid="ppdb-wa-btn"
              >
                <MessageCircle className="w-5 h-5" /> Konfirmasi via WhatsApp Panitia
              </a>
              <div className="grid grid-cols-2 gap-3 text-sm">
                <a
                  href={`tel:${SCHOOL.phone.replace(/\s/g, "")}`}
                  className="flex items-center justify-center gap-2 border-2 border-slate-200 hover:border-[#1E3A8A] rounded-lg h-11 text-[#0F172A] font-medium transition"
                  data-testid="ppdb-call-btn"
                >
                  <Phone className="w-4 h-4" /> Telepon
                </a>
                <a
                  href={`mailto:${SCHOOL.email}`}
                  className="flex items-center justify-center gap-2 border-2 border-slate-200 hover:border-[#1E3A8A] rounded-lg h-11 text-[#0F172A] font-medium transition"
                  data-testid="ppdb-email-btn"
                >
                  <Mail className="w-4 h-4" /> Email
                </a>
              </div>
            </div>

            <div className="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t border-slate-200">
              <Link to="/" className="flex-1">
                <Button variant="outline" className="w-full border-2 border-[#1E3A8A] text-[#1E3A8A] hover:bg-[#1E3A8A] hover:text-white" data-testid="ppdb-back-home-btn">
                  <ArrowLeft className="w-4 h-4 mr-2" /> Kembali ke Beranda
                </Button>
              </Link>
              <Button onClick={() => { setForm(initialState); setSubmitted(false); setPendaftaranId(""); }} className="flex-1 bg-[#1E3A8A] hover:bg-[#1E40AF] text-white" data-testid="ppdb-daftar-lagi-btn">
                Daftar Lagi
              </Button>
            </div>
          </div>
        </div>
        <Footer />
        <FloatingWA />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#FAFAFA]">
      <Navbar />

      {/* Header */}
      <div className="bg-[#1E3A8A] py-16 lg:py-20 relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{
          backgroundImage: "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
          backgroundSize: "32px 32px",
        }} />
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
          <Link to="/" className="inline-flex items-center gap-2 text-white/70 hover:text-white text-sm mb-4" data-testid="ppdb-back-link">
            <ArrowLeft className="w-4 h-4" /> Kembali ke Beranda
          </Link>
          <div className="inline-block text-sm font-semibold text-[#F59E0B] bg-white/10 px-4 py-1.5 rounded-full mb-3">
            PPDB 2026/2027
          </div>
          <h1 className="text-3xl md:text-4xl lg:text-5xl font-bold mb-3" data-testid="ppdb-title">
            Formulir Pendaftaran Peserta Didik Baru
          </h1>
          <p className="text-white/80 max-w-2xl">
            Lengkapi formulir di bawah ini dengan data yang benar dan valid. Pastikan semua kolom wajib (*) terisi.
          </p>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid lg:grid-cols-3 gap-8">
          {/* Sidebar info */}
          <div className="lg:col-span-1 space-y-4">
            <div className="bg-white rounded-2xl border border-slate-200 p-6">
              <div className="w-12 h-12 rounded-xl bg-[#EFF6FF] flex items-center justify-center mb-4">
                <Calendar className="w-6 h-6 text-[#1E3A8A]" />
              </div>
              <h3 className="font-bold text-[#0F172A] mb-2">Jadwal Penting</h3>
              <ul className="text-sm text-slate-600 space-y-2">
                <li><strong className="text-[#0F172A]">Pendaftaran:</strong> 15 Jan - 28 Feb 2026</li>
                <li><strong className="text-[#0F172A]">Seleksi:</strong> 5 Mar - 12 Mar 2026</li>
                <li><strong className="text-[#0F172A]">Pengumuman:</strong> 20 Mar 2026</li>
                <li><strong className="text-[#0F172A]">Daftar Ulang:</strong> 25 Mar - 5 Apr 2026</li>
              </ul>
            </div>

            <div className="bg-white rounded-2xl border border-slate-200 p-6">
              <div className="w-12 h-12 rounded-xl bg-[#EFF6FF] flex items-center justify-center mb-4">
                <FileText className="w-6 h-6 text-[#1E3A8A]" />
              </div>
              <h3 className="font-bold text-[#0F172A] mb-2">Persyaratan</h3>
              <ul className="text-sm text-slate-600 space-y-2">
                <li className="flex gap-2"><CheckCircle2 className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /> Lulus SD/MI</li>
                <li className="flex gap-2"><CheckCircle2 className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /> Maks usia 15 tahun (1 Juli 2026)</li>
                <li className="flex gap-2"><CheckCircle2 className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /> Fotokopi Akta Lahir</li>
                <li className="flex gap-2"><CheckCircle2 className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /> Fotokopi KK & KTP Orang Tua</li>
                <li className="flex gap-2"><CheckCircle2 className="w-4 h-4 text-[#F59E0B] flex-shrink-0 mt-0.5" /> Pas Foto 3x4 (4 lembar)</li>
              </ul>
            </div>

            <div className="bg-[#1E3A8A] text-white rounded-2xl p-6">
              <GraduationCap className="w-10 h-10 text-[#F59E0B] mb-3" />
              <h3 className="font-bold mb-2">Butuh Bantuan?</h3>
              <p className="text-sm text-white/80 mb-4">Hubungi panitia PPDB untuk informasi lebih lanjut.</p>
              <a href="tel:+622635550188" className="text-sm font-semibold text-[#F59E0B] hover:underline">+62 263 555 0188</a>
            </div>
          </div>

          {/* Form */}
          <form onSubmit={handleSubmit} className="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 lg:p-10 space-y-6" data-testid="ppdb-form">
            <div>
              <h2 className="text-xl font-bold text-[#0F172A] mb-1">Data Calon Siswa</h2>
              <p className="text-sm text-slate-500 mb-5">Isi dengan data yang sesuai dokumen resmi.</p>
              <div className="grid sm:grid-cols-2 gap-5">
                <div>
                  <Label className="mb-1.5 block">Nama Lengkap *</Label>
                  <Input value={form.nama} onChange={(e) => update("nama", e.target.value)} placeholder="Sesuai akta lahir" className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-nama" />
                </div>
                <div>
                  <Label className="mb-1.5 block">NISN *</Label>
                  <Input value={form.nisn} onChange={(e) => update("nisn", e.target.value.replace(/\D/g, ""))} placeholder="10 digit NISN" maxLength={10} inputMode="numeric" className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-nisn" />
                </div>
                <div>
                  <Label className="mb-1.5 block">Tempat Lahir *</Label>
                  <Input value={form.tempatLahir} onChange={(e) => update("tempatLahir", e.target.value)} placeholder="Kota kelahiran" className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-tempat-lahir" />
                </div>
                <div>
                  <Label className="mb-1.5 block">Tanggal Lahir *</Label>
                  <Input type="date" value={form.tanggalLahir} onChange={(e) => update("tanggalLahir", e.target.value)} className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-tanggal-lahir" />
                </div>
                <div>
                  <Label className="mb-1.5 block">Jenis Kelamin *</Label>
                  <Select value={form.jenisKelamin} onValueChange={(v) => update("jenisKelamin", v)}>
                    <SelectTrigger className="h-11 focus:ring-[#1E3A8A]" data-testid="ppdb-jenis-kelamin">
                      <SelectValue placeholder="Pilih..." />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="L">Laki-laki</SelectItem>
                      <SelectItem value="P">Perempuan</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
                <div>
                  <Label className="mb-1.5 block">Asal Sekolah (SD/MI) *</Label>
                  <Input value={form.asalSekolah} onChange={(e) => update("asalSekolah", e.target.value)} placeholder="Nama sekolah asal" className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-asal-sekolah" />
                </div>
                <div className="sm:col-span-2">
                  <Label className="mb-1.5 block">Alamat Lengkap *</Label>
                  <Textarea value={form.alamat} onChange={(e) => update("alamat", e.target.value)} placeholder="Jl, RT/RW, Desa/Kel, Kec, Kab" rows={3} className="focus-visible:ring-[#1E3A8A]" data-testid="ppdb-alamat" />
                </div>
              </div>
            </div>

            <div className="border-t border-slate-200 pt-6">
              <h2 className="text-xl font-bold text-[#0F172A] mb-1">Data Orang Tua / Wali</h2>
              <p className="text-sm text-slate-500 mb-5">Informasi kontak penting untuk komunikasi.</p>
              <div className="grid sm:grid-cols-2 gap-5">
                <div>
                  <Label className="mb-1.5 block">Nama Orang Tua / Wali *</Label>
                  <Input value={form.namaOrtu} onChange={(e) => update("namaOrtu", e.target.value)} placeholder="Nama lengkap" className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-nama-ortu" />
                </div>
                <div>
                  <Label className="mb-1.5 block">No. Telepon / WA *</Label>
                  <Input value={form.noTelp} onChange={(e) => update("noTelp", e.target.value)} placeholder="08xx-xxxx-xxxx" inputMode="tel" className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-no-telp" />
                </div>
                <div className="sm:col-span-2">
                  <Label className="mb-1.5 block">Email</Label>
                  <Input type="email" value={form.email} onChange={(e) => update("email", e.target.value)} placeholder="nama@email.com" className="h-11 focus-visible:ring-[#1E3A8A]" data-testid="ppdb-email" />
                </div>
                <div className="sm:col-span-2">
                  <Label className="mb-1.5 block">Catatan / Keterangan</Label>
                  <Textarea value={form.catatan} onChange={(e) => update("catatan", e.target.value)} placeholder="Informasi tambahan (opsional)" rows={3} className="focus-visible:ring-[#1E3A8A]" data-testid="ppdb-catatan" />
                </div>
              </div>
            </div>

            <div className="border-t border-slate-200 pt-6 flex flex-col sm:flex-row gap-3">
              <Link to="/" className="sm:order-1">
                <Button type="button" variant="outline" className="w-full border-2 border-slate-300 text-slate-700">
                  Batal
                </Button>
              </Link>
              <Button type="submit" size="lg" className="bg-[#F59E0B] hover:bg-[#D97706] text-white font-semibold rounded-lg h-12 px-8 sm:ml-auto sm:order-2" data-testid="ppdb-submit-btn">
                <Upload className="w-4 h-4 mr-2" /> Kirim Pendaftaran
              </Button>
            </div>
          </form>
        </div>
      </div>

      <Footer />
      <FloatingWA />
    </div>
  );
}
