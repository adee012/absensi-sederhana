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

## Documentation

### 1. Halaman Absensi

![Tampilan Absensi](public/dokumentasi/absens%201.jpg)
![Tampilan Absensi](public/dokumentasi/absens%202.jpg)

Karyawan hanya perlu menginput Employee ID. Nama dan departemen akan otomatis muncul sebagai validasi tambahan.
Setelah itu bisa langsung klik Absen Masuk atau Absen Keluar sesuai waktunya.

### 2. Validasi Absensi

![Sudah Pernah Absen](public/dokumentasi/absensi%203.jpg)
![Berhasil Absen](public/dokumentasi/absensi%204.jpg)

Sistem akan otomatis menolak absen keluar jika:

-   Belum absen masuk.
-   Belum waktunya pulang.
-   Sudah melakukan absen keluar sebelumnya.

### 3. Halaman Admin (Riwayat Absensi)

Admin dapat:

-   Melihat seluruh riwayat absensi.
    ![History Absen](public/dokumentasi/admin%20history.jpg)

-   Memfilter berdasarkan tanggal atau departemen.
    ![Filter Absen](public/dokumentasi/admin%20filter.jpg)

-   Melakukan pengelolaan data karyawan dan departemen.
    ![Data Karyawan](public/dokumentasi/admin%20karyawan.jpg)
    ![Data Departemen](public/dokumentasi/admin%20dpt.jpg)

## Authors

-   [github@adee012](https://www.github.com/adee012)
-   [instagram@adedwiputra02](https://www.instagram.com/adedwiputra02/)
