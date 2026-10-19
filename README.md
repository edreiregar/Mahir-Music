# MAHIR MUSIK (Laravel 11, tema hitam-kuning)

File di folder ini adalah lapisan di atas proyek Laravel 11 yang sudah memakai Breeze (stack Blade).
Salin isinya ke root proyek dan timpa file yang bentrok.

## Pemasangan

1. `composer create-project laravel/laravel mahir-musik` lalu `composer require laravel/breeze --dev` dan `php artisan breeze:install blade`
   (Breeze hanya dipakai sebagai fondasi. Controller, route, dan view auth-nya diganti oleh file di sini.)
2. Salin semua file paket ini ke root proyek (timpa).
3. Hapus baris `require __DIR__.'/auth.php';` bila masih ada di `routes/web.php` (file di paket ini sudah menggantinya).
   Hapus juga `routes/auth.php`, `app/Http/Controllers/Auth/*` bawaan Breeze selain 2 controller di paket ini, dan `app/View/Components/*` bawaan Breeze.
4. Pastikan Tailwind v3: `npm install -D tailwindcss@3 postcss autoprefixer`
5. `.env`:
   ```
   APP_LOCALE=id
   APP_TIMEZONE=Asia/Jakarta
   FILESYSTEM_DISK=local
   ```
   Di Laravel 11 disk `local` berakar di `storage/app/private`, sehingga materi tersimpan privat.
6. `php artisan migrate --seed` lalu `npm install && npm run dev` dan `php artisan serve`.

## Akun seeder (ganti segera)

| Peran | Email | Kata sandi |
|---|---|---|
| Admin | admin@mahirmusik.test | Admin#2026! |
| Pengajar | rina@mahirmusik.test | Pengajar#2026! |

## Catatan keamanan

- `role` tidak ada di `$fillable`; `RegisteredUserController` mengisinya hardcoded `pengajar`.
- Approve pembayaran dijaga dua lapis: middleware `EnsureUserIsAdmin` di route dan `abort_unless(..., 403)` di controller.
- Materi disimpan di `storage/app/private/materials` dan hanya bisa diunduh lewat route terautentikasi
  `schedules.material` (pemilik jadwal atau admin). Landing page tidak memuat link materi.
- Landing page hanya mengambil kolom yang dibutuhkan dan menampilkan nama depan murid saja.
