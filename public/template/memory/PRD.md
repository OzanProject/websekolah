# PRD — SMP Negeri 4 Kadupandak (Landing Page)

> Dokumen ini adalah Single Source of Truth untuk pengembangan website
> SMP Negeri 4 Kadupandak. Pembaruan terakhir: **Februari 2026**.

---

## 1. Original Problem Statement
Membangun landing page sekolah yang bersih, modern, dan fully featured
dengan layout terinspirasi dari `kingster.datagoe.com`.

- **Nama Sekolah:** SMP Negeri 4 Kadupandak
- **Tipe Aplikasi:** Static landing page (Frontend only — tanpa backend)
- **Section Wajib:** Home, About, Programs/Jurusan, Events, News/Blog,
  Gallery, Contact, Online Registration (PPDB), Testimonials, Facilities
- **Tema Visual:** Classic Navy Blue
- **Bahasa Konten:** Bahasa Indonesia

---

## 2. Target User / Persona

| Persona | Kebutuhan Utama |
|---------|-----------------|
| Calon Siswa & Orang Tua Wali | Informasi sekolah, jadwal & syarat PPDB, profil, fasilitas, prestasi |
| Siswa Aktif & Alumni | Berita sekolah, agenda kegiatan, galeri, kontak |
| Guru / Staf Sekolah | Publikasi resmi, profil sekolah, kanal informasi |
| Masyarakat Umum | Profil & lokasi sekolah, kontak, informasi PPDB |

---

## 3. Tech Stack

- **React 19** (Create React App) + **React Router DOM v7**
- **Tailwind CSS** + **Shadcn UI** components
- **Lucide-react** icons
- **Sonner** untuk toast notifications
- **LocalStorage** untuk penyimpanan data PPDB (tanpa backend)
- **No FastAPI / No MongoDB** — sesuai keputusan eksplisit user

---

## 4. Arsitektur Kode

```
/app/frontend/
├── public/
│   ├── index.html            # SEO meta tags, OG tags, favicon
│   ├── robots.txt            # Allow all + sitemap reference
│   └── sitemap.xml           # / , /ppdb , /berita
└── src/
    ├── App.js                # Routing: / , /ppdb , /berita , /berita/:id
    ├── index.css, App.css    # Tailwind base + custom variables
    ├── lib/
    │   └── siteData.js       # Semua konten statis (SCHOOL, NEWS, GALLERY, dll)
    ├── components/site/      # 18 komponen section
    │   ├── Navbar.jsx            • Hero.jsx           • QuickInfo.jsx
    │   ├── About.jsx             • Sambutan.jsx       • Stats.jsx
    │   ├── Programs.jsx          • News.jsx           • InfoTabs.jsx
    │   ├── Agenda.jsx            • Gallery.jsx        • VideoProfile.jsx
    │   ├── Facilities.jsx        • Testimoni.jsx      • PPDBCTA.jsx
    │   ├── Contact.jsx           • Footer.jsx         • FloatingWA.jsx
    │   └── (FloatingWA = tombol WhatsApp mengambang global)
    └── pages/
        ├── Home.jsx          # Komposisi semua section landing page
        ├── PPDB.jsx          # Form PPDB online + modal sukses
        ├── BeritaList.jsx    # Daftar semua berita (list view)
        └── BeritaDetail.jsx  # Detail berita per ID (/berita/:id)
```

### Routing Map
| Path | Komponen | Deskripsi |
|------|----------|-----------|
| `/` | `Home` | Landing page utama (semua section) |
| `/ppdb` | `PPDB` | Form pendaftaran PPDB online |
| `/berita` | `BeritaList` | Daftar berita sekolah |
| `/berita/:id` | `BeritaDetail` | Detail satu berita |

---

## 5. Fitur yang Telah Diimplementasikan

### Phase 1 — Landing Page Core (Selesai)
- ✅ Navbar responsif dengan anchor scroll ke setiap section
- ✅ Hero section dengan CTA utama "Daftar PPDB Online"
- ✅ Quick Info (3 highlight card)
- ✅ About + Sambutan Kepala Sekolah
- ✅ Stats counter (siswa, guru, kelas, prestasi)
- ✅ Programs / Jurusan / Ekstrakurikuler
- ✅ News cards (preview 3 berita terbaru)
- ✅ Info Tabs (Visi, Misi, Sejarah, Prestasi)
- ✅ Agenda / Kalender kegiatan
- ✅ Gallery foto sekolah
- ✅ Video Profile sekolah (embed)
- ✅ Facilities (fasilitas sekolah)
- ✅ Testimoni dari siswa & alumni
- ✅ PPDB CTA banner
- ✅ Contact section + Footer lengkap

### Phase 2 — PPDB Online (Selesai)
- ✅ Form PPDB online dengan validasi field wajib
- ✅ Data tersimpan ke `localStorage` (key: `ppdb_pendaftar_smpn4kadupandak`)
- ✅ Modal sukses menampilkan **nomor pendaftaran**
- ✅ Tombol salin nomor, tombol WhatsApp, telepon, & email
- ✅ Toast notification (sonner) untuk feedback aksi

### Phase 3 — News / Blog (Selesai)
- ✅ `/berita` — List view semua berita
- ✅ `/berita/:id` — Detail berita dengan konten lengkap
- ✅ Card berita di Home.jsx ter-link ke detail (via `<Link>`)

### Phase 4 — SEO & UX (Selesai)
- ✅ Meta tags (title, description, keywords)
- ✅ Open Graph tags (og:title, og:description, og:image)
- ✅ `robots.txt` + `sitemap.xml`
- ✅ Dynamic document title per page
- ✅ FloatingWA — tombol WhatsApp mengambang global
- ✅ Tema Navy Blue (`#1E3A8A`) + accent oranye (`#F59E0B`)
- ✅ Fully responsive (mobile, tablet, desktop)
- ✅ `data-testid` lengkap pada elemen interaktif

---

## 6. Data Model (LocalStorage)

### PPDB Pendaftar
```js
// Key: ppdb_pendaftar_smpn4kadupandak
[
  {
    nomor: "PPDB-2026-0001",
    nama: "...",
    tempatLahir: "...",
    tanggalLahir: "YYYY-MM-DD",
    jenisKelamin: "L" | "P",
    nisn: "...",
    asalSekolah: "...",
    alamat: "...",
    noHp: "...",
    email: "...",
    namaOrtu: "...",
    pekerjaanOrtu: "...",
    noHpOrtu: "...",
    createdAt: "ISO timestamp"
  }
]
```

---

## 7. Backlog / Roadmap

### P1 — High Priority
- ⬜ Google Analytics 4 atau Plausible untuk traffic tracking (perlu approval user)
- ⬜ Optimasi performa (lazy load gambar, code-splitting per route)

### P2 — Medium Priority
- ⬜ Halaman detail program / jurusan (`/program/:id`)
- ⬜ Export data PPDB ke CSV / PDF (admin tool via console)
- ⬜ Animasi micro-interactions tambahan (framer-motion)
- ⬜ Pagination & search di `/berita`
- ⬜ Filter agenda berdasarkan bulan / kategori

### P3 — Low Priority / Nice-to-Have
- ⬜ PWA support (offline browsing, installable)
- ⬜ Dark mode toggle
- ⬜ Multi-language (ID/EN)
- ⬜ Integrasi backend ringan (Firebase / Supabase) untuk PPDB persistent

---

## 8. Constraints & Decisions

- **STATIC ONLY** — Tidak ada backend FastAPI / MongoDB. Semua data
  dari `lib/siteData.js`. PPDB disimpan di `localStorage` browser.
- **Bahasa** — Seluruh UI text & komunikasi user dalam Bahasa Indonesia.
- **Tema** — Navy Blue klasik, tidak boleh diganti tanpa konfirmasi.
- **Kepatuhan `data-testid`** — Wajib pada semua tombol, link, form
  input, dan elemen interaktif lain.

---

## 9. Test Coverage Status

| Area | Metode | Status |
|------|--------|--------|
| Landing Page render | Screenshot smoke test | ✅ Pass |
| PPDB form & localStorage | Manual + screenshot | ✅ Pass |
| Routing `/berita` & `/berita/:id` | Screenshot smoke test | ✅ Pass |
| FloatingWA integration | Visual check | ✅ Pass |
| E2E flow lengkap | `testing_agent_v3_fork` | ⏳ Pending |

---

## 10. Riwayat Update PRD

- **Feb 2026** — Tambah News pages (`/berita`, `/berita/:id`), FloatingWA,
  SEO meta tags, sitemap.xml. Update arsitektur & roadmap.
- **Feb 2026 (initial)** — PRD pertama dibuat saat landing page +
  PPDB form selesai.
