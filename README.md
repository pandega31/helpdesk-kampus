# Helpdesk Kampus

Aplikasi web untuk pelaporan dan penanganan keluhan di lingkungan kampus. Mahasiswa melaporkan keluhan dalam bentuk **tiket**, lalu petugas menanganinya lewat percakapan di dalam tiket sampai selesai.

## Fitur

**Mahasiswa**
- Registrasi, login, dan logout
- Membuat tiket (judul, kategori, prioritas, deskripsi, dan lampiran foto opsional)
- Melihat dan membalas tiket miliknya sendiri
- Melihat riwayat status tiket dalam bentuk timeline
- Mengunduh riwayat tiket miliknya sebagai PDF
- Melihat daftar **Keluhan Umum** milik semua mahasiswa (ringkas: judul, kategori, status, tanggal)
- Mengubah profil dan password

**Petugas**
- Melihat semua tiket, mencari, dan memfilter berdasarkan kategori dan status
- Membalas tiket dan mengubah status (`open`, `proses`, `selesai`)
- Mengunduh PDF tiket mana pun

**Admin**
- Semua hak petugas
- Mengelola kategori

**Dashboard**
- Kartu statistik (total, open, proses, selesai) dan 5 tiket terbaru, diambil lewat REST API internal memakai Laravel HTTP Client

## Teknologi

- Laravel 13, PHP 8.3
- MySQL
- Blade templating
- Bootstrap 5 dan Bootstrap Icons (CDN)
- barryvdh/laravel-dompdf (ekspor PDF)

## Prasyarat

- PHP 8.3 atau lebih baru (ekstensi `gd` aktif agar foto muncul di PDF)
- Composer
- MySQL
- Git

## Instalasi

```bash
git clone https://github.com/pandega31/helpdesk-kampus.git
cd helpdesk-kampus
composer install
copy .env.example .env      # Mac/Linux: cp .env.example .env
php artisan key:generate
```

Buat database kosong bernama `helpdesk_kampus`, lalu atur `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=helpdesk_kampus
DB_USERNAME=root
DB_PASSWORD=

INTERNAL_API_URL=http://127.0.0.1:8001
```

Jalankan migration, seeder, dan tautan penyimpanan file:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

`storage:link` diperlukan agar foto lampiran bisa ditampilkan. Di Windows, jalankan terminal sebagai Administrator kalau muncul error izin.

## Menjalankan Aplikasi (Wajib 2 Server)

Dashboard mengambil datanya lewat `Http::get()` ke API internal. Karena `php artisan serve` hanya melayani satu request pada satu waktu, aplikasi harus dijalankan di **dua terminal**:

```bash
# Terminal 1: server utama (dibuka di browser)
php artisan serve

# Terminal 2: server untuk INTERNAL_API_URL
php artisan serve --port=8001
```

Buka `http://127.0.0.1:8000`. Kalau server kedua tidak berjalan, Dashboard menampilkan pesan peringatan dan tidak memuat statistik.

## Akun Demo

Password semua akun: `password`

| Role | Email |
|---|---|
| Admin | `admin@helpdesk.test` |
| Petugas | `petugas@helpdesk.test` |
| Mahasiswa | `mahasiswa1@helpdesk.test` |
| Mahasiswa | `mahasiswa2@helpdesk.test` |

Seeder juga membuat 6 mahasiswa tambahan, 30 tiket, beserta balasan dan riwayat status secara acak.

## Struktur Data

| Tabel | Isi | Relasi |
|---|---|---|
| `users` | nama, email, password, `role` (admin/petugas/mahasiswa) | hasMany tickets, ticket_replies |
| `categories` | nama kategori | hasMany tickets |
| `tickets` | judul, deskripsi, lampiran (opsional), prioritas, status | belongsTo user, belongsTo category, hasMany ticket_replies, hasMany ticket_status_logs |
| `ticket_replies` | isi balasan | belongsTo ticket, belongsTo user |
| `ticket_status_logs` | status, waktu perubahan | belongsTo ticket, belongsTo user |

## REST API

Base URL: `http://127.0.0.1:8001/api`. Kirim header `Accept: application/json`.

API sengaja **tidak memakai token atau session** (sesuai cakupan modul). Karena itu endpoint tiket hanya membaca dan hanya mengeluarkan data yang aman: judul, kategori, prioritas, status, dan tanggal. Deskripsi, lampiran, dan data pelapor tidak pernah dikirim.

| Method | Endpoint | Keterangan | Status |
|---|---|---|---|
| GET | `/stats` | Jumlah tiket per status | 200 |
| GET | `/tickets` | Daftar tiket (paginasi). Filter: `status`, `category_id`, `per_page` | 200 |
| GET | `/tickets/{id}` | Detail satu tiket | 200, 404 |
| GET | `/categories` | Daftar kategori beserta `jumlah_tiket` | 200 |
| GET | `/categories/{id}` | Detail kategori | 200, 404 |
| POST | `/categories` | Tambah kategori (`nama`) | 201, 422 |
| PUT | `/categories/{id}` | Ubah kategori | 200, 404, 422 |
| DELETE | `/categories/{id}` | Hapus kategori | 200, 404, 409 (masih dipakai tiket) |

## Catatan

- Versi yang dipakai: Laravel 13, PHP 8.3.26, MySQL.
- Struktur commit mengikuti checkpoint per tahap pengerjaan di branch `dev`, fitur tambahan dikerjakan di branch `feature/*`, lalu semuanya digabung ke `main`.

## Pembuat

Pandega Surya Abditama (3125600091), kelas 2 D4 IT D
