# Sistem Manajemen Pengelolaan Zakat
Sistem Manajemen Pengelolaan Zakat adalah sistem terstruktur yang dirancang untuk mengelola seluruh proses pengumpulan, pendistribusian, dan pelaporan zakat secara efisien, transparan, dan akuntabel. Sistem ini umumnya diterapkan oleh lembaga zakat (seperti BAZNAS atau LAZ) dan bisa berbentuk manual, semi-digital, atau berbasis aplikasi terkomputerisasi.

## ✅ Tujuan Utama
1. <b>Meningkatkan efektivitas dan efisiensi</b> pengelolaan zakat.
2. <b>Memastikan distribusi zakat tepat sasaran</b> sesuai asnaf.
3. <b>Meningkatkan kepercayaan muzakki</b> melalui transparansi.
4. <b>Mendukung pelaporan dan akuntabilitas</b> ke publik dan regulator (seperti Kementerian Agama atau BAZNAS pusat).

## 🛠️ System Requirements
Pastikan environment kamu telah memiliki:

### ✅ Untuk instalasi manual:
- PHP >= 8.2
- Composer >= 2.0
- MySQL / MariaDB
- Node.js >= 18.x & npm
- Git

### ✅ Untuk Docker:
- Docker Engine
- Docker Compose

## 🚀 Cara Instalasi Manual
```bash
# 1. Clone repository
git clone https://github.com/hendriam/sistem-manajemen-pengelolaan-zakat.git
cd sistem-manajemen-pengelolaan-zakat

# 2. Install dependencies Laravel
composer install

# 3. Salin file .env dan konfigurasi
cp .env.example .env
php artisan key:generate

# 4. Sesuaikan koneksi database di file .env
DB_DATABASE=sistem_manajemen_pengelolaan_zakat
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrasi dan seed database
php artisan migrate --seed

# 6. Jalankan server Laravel
php artisan serve
```

Akses: http://localhost:8000

## 🚀 Cara Instalasi Menggunakan Docker
```bash
# 1. Clone repo
git clone https://github.com/hendriam/sistem-manajemen-pengelolaan-zakat.git
cd sistem-manajemen-pengelolaan-zakat

# 2. Salin file .env
cp .env.example .env

# 3. Jalankan docker
docker-compose up -d --build

# 4. Masuk ke container sistem_manajemen_pengelolaan_zakat_app
docker exec -it sistem_manajemen_pengelolaan_zakat_app bash

# 5. Jalankan migrasi dan build asset
php artisan migrate --seed

# 6. Jalankan server Laravel
php artisan serve --host=0.0.0.0 --port=8000
```
Akses: http://0.0.0.0:8000

## 👤 Admin Default (Seeder)
```bash
username: admin123
password: admin123
```
Ganti kredensial setelah login pertama untuk alasan keamanan!