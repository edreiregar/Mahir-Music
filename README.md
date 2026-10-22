# MAHIR MUSIK

---
title: Mahir Music
sdk: docker
app_port: 7860
---



Aplikasi manajemen kursus musik berbasis Laravel 11. Tema gelap hitam-kuning.

Fitur utama:
- Halaman publik untuk murid: jadwal latihan pengajar (hanya dilihat, tanpa materi).
- Login dan registrasi pengajar (akun baru otomatis berperan pengajar).
- Dashboard: jumlah murid, murid absen, total pendapatan, grafik murid per bulan dan pendapatan per bulan.
- Absensi dan jadwal, plus unggah materi musik yang disimpan privat.
- Pendapatan: pengajar memantau, admin meng-approve pembayaran.
- Profil dan Settings.

## Teknologi

PHP 8.2+, Laravel 11, MySQL (atau SQLite), Blade, Tailwind CSS 3, Vite, Chart.js (CDN).

## Kebutuhan

- PHP 8.2 atau lebih baru
- Composer 2
- Node.js 18 atau lebih baru
- MySQL (di Laragon sudah termasuk)

## Instalasi

```bash
git clone <url-repo-ini> mahir-musik
cd mahir-musik

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Buat database kosong bernama `mahir_musik`, lalu sesuaikan `.env`:

```
APP_NAME="MAHIR MUSIK"
APP_URL=http://localhost:8000
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_TIMEZONE=Asia/Jakarta
FILESYSTEM_DISK=local
SESSION_DRIVER=database

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mahir_musik
DB_USERNAME=root
DB_PASSWORD=
```

Buat tabel dan data contoh:

```bash
php artisan migrate --seed
```

## Menjalankan

Buka dua terminal di folder proyek:

```bash
npm run dev
```

```bash
php artisan serve
```

Buka http://localhost:8000. Bila memakai Laragon, alamat otomatisnya `http://nama-folder.test`
(sesuaikan `APP_URL`), dan `php artisan serve` tidak diperlukan.

## Akun contoh (hanya untuk pengembangan)

| Peran | Email | Kata sandi |
|---|---|---|
| Admin | admin@mahirmusik.test | Admin#2026! |
| Pengajar | rina@mahirmusik.test | Pengajar#2026! |

Jangan memakai seeder di server publik. Di produksi, jalankan `php artisan migrate --force`
tanpa `--seed`, lalu buat admin sendiri dan ganti nilai `role` di tabel `users` menjadi `admin`.

## Peran

- **Pengajar:** daftar lewat `/register`. Melihat data miliknya, mengisi absensi, mengunggah materi, memantau pembayaran.
- **Admin:** melihat semua data, mencatat tagihan, dan menekan "Approve Pembayaran".
  Admin tidak bisa dibuat lewat halaman daftar.

## Catatan

- Materi tersimpan di `storage/app/private/materials` dan hanya bisa diunduh setelah login.
- Untuk produksi: `npm run build`, set `APP_ENV=production` dan `APP_DEBUG=false`,
  arahkan document root ke folder `public`.
- Bila `composer install` diblokir peringatan keamanan Laravel 11, jalankan
  `composer install --no-security-blocking`.
- Pastikan file `.env` tidak ikut ter-commit ke GitHub (sudah diabaikan oleh `.gitignore` bawaan Laravel).
