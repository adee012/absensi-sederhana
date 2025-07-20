# 🚀 Laravel Absensi Karyawan

Aplikasi web absensi sederhana berbasis Laravel. Karyawan dapat melakukan absensi masuk dan keluar tanpa perlu login, dan admin dapat melihat riwayat absensi melalui panel admin.

---

## 🧰 Teknologi

-   Laravel 11
-   MySQL
-   Tailwind CSS
-   Blade Template
-   Eloquent ORM

---

### 1. Clone Project

```bash
git clone https://github.com/adee012/absensi-sederhana.git
cd project-absensi
```

### 2. Clone Project

```bash
composer install
npm install && npm run dev
```

### 3. Copy & Konfigurasi File .env

```bash
cp .env.example .env
```

Sesuaikan konfigurasi database kamu di file .env:

```bash
DB_DATABASE=absensi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

Akun admin default dari seeder:

```bash
Email   : admin@gmail.com
Password: admin123
```

## Authors

-   [github@adee012](https://www.github.com/adee012)
-   [instagram@adedwiputra02](https://www.instagram.com/adedwiputra02/)
