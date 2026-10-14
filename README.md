# 🏫 Hubinas & BKK — Sistem Kerjasama Sekolah & Industri

Sistem informasi manajemen kerjasama (MoU) antara sekolah dan industri/perusahaan. Mengelola profil perusahaan mitra, pendaftaran rekrutmen, program kerjasama, serta tracking status aktif/non-aktif dan masa berlaku (expired) kerjasama.

---

## 📋 Daftar Isi

- [Roles & Hak Akses](#-roles--hak-akses)
- [ERD (Entity Relationship Diagram)](#-erd-entity-relationship-diagram)
- [Penjelasan Entitas](#-penjelasan-entitas)
- [Flowchart Sistem](#-flowchart-sistem)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)

---

## 👥 Roles & Hak Akses

Sistem menggunakan **3 role** utama:

| No | Role | Deskripsi | Hak Akses |
|----|------|-----------|-----------|
| 1 | **Admin** | Pengelola utama sistem (Kepala Humas/BKK) | CRUD semua data, approval MoU, manage user, kelola status aktif/non-aktif PT, dashboard & laporan |
| 2 | **Staff** | Staff Hubinas/BKK | Input data perusahaan, buat MoU draft, upload dokumen, kelola program kerjasama & rekrutmen |
| 3 | **Industri** | Perwakilan perusahaan/industri mitra | Lihat & lengkapi profil perusahaan, ajukan program kerjasama, isi form rekrutmen, lihat status MoU |

---

## 📊 ERD (Entity Relationship Diagram)

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string email UK
        string password
        enum role "admin | staff | industri"
        bigint perusahaan_id FK "nullable, hanya untuk role industri"
        timestamp email_verified_at
        timestamp created_at
        timestamp updated_at
    }

    PERUSAHAAN {
        bigint id PK
        string nama_perusahaan
        string bidang_usaha
        string alamat
        string kota
        string provinsi
        string kode_pos
        string no_telepon
        string email
        string website "nullable"
        string nama_pimpinan
        string nama_pic "Person In Charge / kontak"
        string telepon_pic
        string email_pic
        text deskripsi "nullable"
        string logo "nullable, path file"
        enum status "aktif | non-aktif"
        timestamp created_at
        timestamp updated_at
    }

    MOU {
        bigint id PK
        string nomor_mou UK
        bigint perusahaan_id FK
        bigint created_by FK "user yang membuat"
        string judul
        text deskripsi
        date tanggal_mulai
        date tanggal_berakhir
        enum status "draft | review | approved | active | expired | terminated"
        string dokumen_path "nullable, file MoU upload"
        text catatan "nullable"
        timestamp approved_at "nullable"
        bigint approved_by FK "nullable"
        timestamp created_at
        timestamp updated_at
    }

    PROGRAM_KERJASAMA {
        bigint id PK
        bigint mou_id FK
        string nama_program
        enum jenis "pkl | magang | rekrutmen | pelatihan | kunjungan_industri | lainnya"
        text deskripsi
        date tanggal_mulai "nullable"
        date tanggal_selesai "nullable"
        int kuota "nullable, jumlah peserta"
        enum status "planned | ongoing | completed | cancelled"
        timestamp created_at
        timestamp updated_at
    }

    REKRUTMEN {
        bigint id PK
        bigint program_kerjasama_id FK
        bigint perusahaan_id FK
        string judul_lowongan
        text persyaratan
        text deskripsi_pekerjaan
        string lokasi_kerja
        enum jenis_kerja "fulltime | parttime | kontrak | magang"
        int kuota "nullable"
        date batas_pendaftaran
        enum status "open | closed | filled"
        string link_gform "nullable, link Google Form pendaftaran"
        timestamp created_at
        timestamp updated_at
    }

    DOKUMEN {
        bigint id PK
        string dokumentable_type "polymorphic: MoU / Perusahaan / Rekrutmen"
        bigint dokumentable_id
        string nama_dokumen
        string file_path
        string tipe_file
        bigint file_size
        bigint uploaded_by FK
        timestamp created_at
        timestamp updated_at
    }

    LOG_AKTIVITAS {
        bigint id PK
        bigint user_id FK
        string aksi "created | updated | deleted | approved | rejected | status_changed"
        string model_type "polymorphic"
        bigint model_id
        json data_lama "nullable"
        json data_baru "nullable"
        string ip_address
        timestamp created_at
    }

    %% RELATIONSHIPS
    USERS ||--o| PERUSAHAAN : "belongs to (industri)"
    PERUSAHAAN ||--o{ MOU : "has many"
    USERS ||--o{ MOU : "created by"
    USERS ||--o{ MOU : "approved by"
    MOU ||--o{ PROGRAM_KERJASAMA : "has many"
    PROGRAM_KERJASAMA ||--o{ REKRUTMEN : "has many"
    PERUSAHAAN ||--o{ REKRUTMEN : "has many"
    USERS ||--o{ DOKUMEN : "uploaded by"
    USERS ||--o{ LOG_AKTIVITAS : "has many"
```

---

## 📖 Penjelasan Entitas

### 1. `USERS` — Pengguna Sistem
Menyimpan data semua pengguna. Field `role` menentukan level akses (`admin`, `staff`, `industri`). User dengan role `industri` terhubung ke satu perusahaan via `perusahaan_id`.

### 2. `PERUSAHAAN` — Profil Perusahaan Mitra
Data lengkap perusahaan/industri yang menjadi mitra. Termasuk PIC (Person In Charge) sebagai kontak utama. Field `status` mengatur **aktif/non-aktif** perusahaan.

### 3. `MOU` — Memorandum of Understanding
Dokumen perjanjian kerjasama antara sekolah dan perusahaan. Memiliki lifecycle status:
- `draft` → dibuat oleh Staff
- `review` → diajukan untuk ditinjau Admin
- `approved` → disetujui Admin
- `active` → MoU sedang berjalan
- `expired` → sudah melewati `tanggal_berakhir`
- `terminated` → dibatalkan sebelum expired

### 4. `PROGRAM_KERJASAMA` — Program dalam MoU
Setiap MoU bisa memiliki beberapa program (PKL, Magang, Rekrutmen, Pelatihan, Kunjungan Industri, dll). Terhubung ke MoU sebagai induk.

### 5. `REKRUTMEN` — Lowongan & Pendaftaran
Data rekrutmen/lowongan dari perusahaan mitra. Bisa dikaitkan ke program kerjasama. Mendukung **link Google Form** (`link_gform`) untuk pendaftaran eksternal.

### 6. `DOKUMEN` — Dokumen Pendukung (Polymorphic)
Menyimpan file dokumen (PDF MoU, surat perjanjian, dll) yang bisa di-attach ke MoU, Perusahaan, atau Rekrutmen menggunakan polymorphic relation.

### 7. `LOG_AKTIVITAS` — Audit Trail
Mencatat semua aktivitas penting dalam sistem untuk keperluan audit dan tracking.

---

## 🔄 Flowchart Sistem

### Flow 1: Registrasi & Onboarding Perusahaan Mitra

```mermaid
flowchart TD
    A(["🏭 Perusahaan Baru"]) --> B["Mengisi Form Registrasi Online"]
    B --> C["Input Data Profil Perusahaan"]
    C --> D["Upload Dokumen Legalitas"]
    D --> E{"Staff Verifikasi Data"}
    E -->|Data Lengkap| F["Admin Review & Approval"]
    E -->|Data Kurang| G["Notifikasi Revisi ke Perusahaan"]
    G --> C
    F -->|Disetujui| H["✅ Status: Aktif"]
    F -->|Ditolak| I["❌ Status: Non-Aktif"]
    H --> J["Perusahaan Dapat Akun Login"]
    J --> K(["🎉 Siap Menjalin Kerjasama"])

    style A fill:#4F46E5,color:#fff,stroke:#3730A3
    style H fill:#059669,color:#fff,stroke:#047857
    style I fill:#DC2626,color:#fff,stroke:#B91C1C
    style K fill:#059669,color:#fff,stroke:#047857
```

### Flow 2: Pembuatan & Approval MoU

```mermaid
flowchart TD
    A(["📝 Mulai Proses MoU"]) --> B["Staff Buat Draft MoU"]
    B --> C["Input Detail MoU: Judul, Deskripsi, Periode"]
    C --> D["Pilih Perusahaan Mitra"]
    D --> E["Upload Dokumen MoU"]
    E --> F["Status: Draft"]
    F --> G["Staff Submit untuk Review"]
    G --> H["Status: Review"]
    H --> I{"Admin Review MoU"}
    I -->|Perlu Revisi| J["Admin Beri Catatan"]
    J --> K["Status: Draft - Revisi"]
    K --> G
    I -->|Disetujui| L["Status: Approved"]
    L --> M["Admin Set Tanggal Aktif"]
    M --> N["✅ Status: Active"]
    N --> O{"Cek Tanggal Berakhir"}
    O -->|Belum Expired| P["MoU Tetap Aktif"]
    P --> O
    O -->|Sudah Expired| Q["⏰ Status: Expired"]
    Q --> R{"Perpanjang?"}
    R -->|Ya| B
    R -->|Tidak| S["🔚 MoU Selesai"]

    style A fill:#4F46E5,color:#fff,stroke:#3730A3
    style N fill:#059669,color:#fff,stroke:#047857
    style Q fill:#F59E0B,color:#fff,stroke:#D97706
    style S fill:#6B7280,color:#fff,stroke:#4B5563
```

### Flow 3: Program Kerjasama & Rekrutmen

```mermaid
flowchart TD
    A(["🤝 MoU Aktif"]) --> B["Buat Program Kerjasama"]
    B --> C{"Jenis Program?"}
    C -->|PKL/Magang| D["Set Kuota & Periode"]
    C -->|Rekrutmen| E["Buat Lowongan Rekrutmen"]
    C -->|Pelatihan| F["Set Detail Pelatihan"]
    C -->|Kunjungan Industri| G["Set Jadwal Kunjungan"]

    E --> H["Input Detail Lowongan: Persyaratan, Deskripsi, Lokasi"]
    H --> I["Set Link Google Form"]
    I --> J["Publikasi Lowongan"]
    J --> K["Status: Open"]
    K --> L{"Batas Pendaftaran?"}
    L -->|Belum| M["Terima Pendaftar via GForm"]
    M --> L
    L -->|Sudah| N["Status: Closed"]
    N --> O["Proses Seleksi oleh Perusahaan"]
    O --> P["✅ Status: Filled"]

    D --> Q["Publikasi Program"]
    F --> Q
    G --> Q
    Q --> R["Status: Ongoing"]
    R --> S["✅ Status: Completed"]

    style A fill:#4F46E5,color:#fff,stroke:#3730A3
    style P fill:#059669,color:#fff,stroke:#047857
    style S fill:#059669,color:#fff,stroke:#047857
```

### Flow 4: Monitoring Status Perusahaan (Aktif/Non-Aktif/Expired)

```mermaid
flowchart TD
    A(["📊 Sistem Monitoring"]) --> B{"Cek Semua MoU Perusahaan"}
    B --> C{"Ada MoU Aktif?"}
    C -->|Ya| D["🟢 PT Status: Aktif"]
    C -->|Tidak| E{"Ada MoU Expired?"}
    E -->|Ya Semua Expired| F["🟡 PT Perlu Perpanjangan"]
    E -->|Tidak Ada MoU| G["🔴 PT Status: Non-Aktif"]
    
    D --> H{"MoU Mendekati Tanggal Expired?"}
    H -->|Kurang dari 30 Hari| I["⚠️ Notifikasi Warning ke Admin & Staff"]
    H -->|Masih Lama| J["Monitoring Lanjut"]
    I --> K{"Admin Action"}
    K -->|Perpanjang| L["Buat MoU Baru"]
    K -->|Tidak Perpanjang| M["Tunggu Expired"]
    M --> F

    F --> N{"Admin Decision"}
    N -->|Aktifkan Kembali| L
    N -->|Non-aktifkan| G

    style D fill:#059669,color:#fff,stroke:#047857
    style F fill:#F59E0B,color:#fff,stroke:#D97706
    style G fill:#DC2626,color:#fff,stroke:#B91C1C
    style I fill:#F59E0B,color:#fff,stroke:#D97706
```

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Otorisasi
- Login multi-role (Admin, Staff, Industri)
- Middleware role-based access control
- Profil pengguna

### 🏢 Manajemen Perusahaan
- CRUD profil perusahaan lengkap
- Upload logo perusahaan
- Status **aktif/non-aktif** perusahaan
- PIC (Person In Charge) sebagai kontak utama

### 📄 Manajemen MoU
- Pembuatan MoU dengan nomor unik
- Workflow approval: `Draft → Review → Approved → Active → Expired`
- Upload dokumen MoU (PDF)
- Tracking masa berlaku & **auto-expired**
- Catatan revisi dari Admin

### 💼 Program Kerjasama
- Multi-program per MoU (PKL, Magang, Rekrutmen, Pelatihan, Kunjungan Industri)
- Tracking status program (Planned → Ongoing → Completed)
- Kuota peserta

### 📝 Rekrutmen & Pendaftaran
- Lowongan rekrutmen dari perusahaan mitra
- Integrasi **Google Form** untuk pendaftaran
- Jenis kerja: Fulltime, Parttime, Kontrak, Magang
- Batas pendaftaran & kuota

### 📁 Manajemen Dokumen
- Upload multi-dokumen (polymorphic)
- Attach ke MoU, Perusahaan, atau Rekrutmen

### 📊 Dashboard & Monitoring
- Statistik jumlah perusahaan aktif/non-aktif
- Statistik MoU per status
- **Warning expired** (< 30 hari)
- Log aktivitas / audit trail

---

## 🛠 Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12.x (PHP 8.2+) |
| Frontend | Blade Templates + Vite |
| Database | MySQL / MariaDB |
| Auth | Laravel Breeze / Fortify |
| File Storage | Laravel Storage (local/S3) |
| UI Framework | Bootstrap 5 / Tailwind CSS |

---

## 🚀 Instalasi & Setup

```bash
# Clone repository
git clone <repo-url>
cd sistem-kerjasama

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate --seed

# Jalankan
npm run dev
php artisan serve
```

---

## 📜 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
