<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# Sistem Gudang

## Persyaratan Sistem

- **Laravel**: 11.x
- **PHP**: 8.2

## Cara Menjalankan Proyek

### Langkah Pertama (Hanya untuk pertama kali):

1 Clone repository:  
   `git clone https://github.com/umararrosyad/sistem-gudang`
   
2 Masuk ke direktori proyek:  
   `cd sistem-gudang`

3 Install dependencies:  
   `composer install`

4 Salin file `.env` contoh:  
   `cp .env.example .env`

5 Konfigurasi database:  
   Sesuaikan pengaturan database di dalam file `.env` sesuai dengan konfigurasi yang Anda gunakan.

6 Generate application key:  
   `php artisan key:generate`

7 Buat database dengan nama `sistem_gudang`.

8 Jalankan migrasi untuk membuat tabel-tabel yang diperlukan:  
   `php artisan migrate`

9 Seed database dengan data awal:  
   `php artisan db:seed`

10 Jalankan aplikasi:  
    `php artisan serve`

### Catatan Penting

- **Pendaftaran dan Login:** Setelah melakukan pendaftaran pengguna, Anda perlu login untuk mendapatkan token autentikasi yang akan digunakan dalam permintaan API.
  
## Dokumentasi dan Sumber Daya

- **Dokumentasi API Postman:** Dokumentasi API dapat diakses melalui [link ini](https://documenter.getpostman.com/view/21072796/2sAXjM5scX#intro).
- **ERD Database:** Diagram ERD untuk database proyek ini tersedia [di sini](https://dbdiagram.io/d/66d43853eef7e08f0e5754c3).
