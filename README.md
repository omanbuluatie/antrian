# Aplikasi Antrian Digital

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

## Tentang Aplikasi Antrian Digital

Aplikasi Antrian Digital adalah solusi modern untuk mengelola antrian di berbagai layanan umum, seperti bank, rumah sakit, kantor pemerintahan, atau layanan pelanggan. Aplikasi ini dirancang untuk memudahkan pengelolaan antrian dengan fitur-fitur yang fleksibel dan antarmuka yang user-friendly. Dengan menggunakan aplikasi ini, proses antrian menjadi lebih efisien, terorganisir, dan nyaman bagi pengguna.

### Fitur Utama

1. **Dukungan Jumlah Loket yang Fleksibel**  
   Aplikasi ini dapat disesuaikan dengan jumlah loket yang dibutuhkan. Baik itu untuk satu loket atau beberapa loket, aplikasi ini dapat diatur sesuai kebutuhan.

2. **Tiga Antarmuka yang Terintegrasi**  
   - **Display**: Menampilkan nomor antrian terakhir yang sedang dilayani, sehingga pengunjung dapat melihat informasi secara real-time.  
   - **Operator**: Digunakan oleh petugas untuk memanggil nomor antrian berikutnya.  
   - **Admin**: Memungkinkan administrator untuk mengatur jumlah loket, reset nomor urut, dan melakukan konfigurasi lainnya.

3. **Desain User-Friendly**  
   Antarmuka aplikasi dirancang sederhana dan mudah digunakan, baik oleh petugas maupun pengunjung. Tampilan yang jelas dan intuitif memastikan pengguna dapat berinteraksi dengan aplikasi tanpa kesulitan.

4. **Reset Nomor Urut**  
   Admin dapat dengan mudah mereset nomor urut antrian setiap hari atau sesuai kebutuhan, memastikan sistem antrian selalu siap digunakan.

5. **Notifikasi Suara**  
   Fitur notifikasi suara membantu pengunjung mengetahui kapan giliran mereka dipanggil, sehingga mengurangi kebingungan dan antrian yang tidak teratur.

6. **Dukungan Multi-Layanan**  
   Aplikasi ini dapat digunakan untuk berbagai jenis layanan, baik itu layanan kesehatan, perbankan, atau layanan umum lainnya.

### Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan **Laravel**, sebuah framework PHP yang powerful dan populer untuk pengembangan aplikasi web. Laravel dipilih karena kemampuannya dalam menyediakan struktur kode yang rapi, fitur keamanan yang kuat, serta dukungan komunitas yang luas. Selain itu, Laravel memudahkan pengembang dalam mengelola database, routing, dan autentikasi, sehingga proses pengembangan aplikasi menjadi lebih cepat dan efisien.

---

## Cara Memulai

### Clone atau Download Aplikasi

Anda dapat mengunduh atau meng-clone repositori aplikasi ini dengan menjalankan perintah berikut:

```bash
git clone https://github.com/username/repository-name.git
```

Atau, Anda dapat mengunduh langsung dalam bentuk file ZIP melalui tombol **"Download ZIP"** di halaman repositori.

### Instalasi

1. **Persyaratan Sistem**  
   Pastikan sistem Anda telah terinstal:
   - PHP (versi 8.0 atau lebih baru)
   - Composer
   - MySQL atau database lainnya yang didukung Laravel
   - Node.js (untuk mengompilasi aset frontend)

2. **Instalasi Dependensi**  
   Jalankan perintah berikut untuk menginstal dependensi PHP dan JavaScript:

   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**  
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:

   ```bash
   cp .env.example .env
   ```

   Buka file `.env` dan sesuaikan dengan detail database Anda:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=username_database_anda
   DB_PASSWORD=password_database_anda
   ```

4. **Generate Key**  
   Jalankan perintah berikut untuk menghasilkan application key:

   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database**  
   Jalankan migrasi database untuk membuat tabel-tabel yang diperlukan:

   ```bash
   php artisan migrate
   ```

6. **Seed Database (Opsional)**  
   Jika Anda ingin mengisi database dengan data dummy, jalankan perintah berikut:

   ```bash
   php artisan db:seed
   ```

7. **Import SQL Dump (Opsional)**  
   Jika Anda ingin menggunakan data yang sudah disediakan, import file SQL dump yang terdapat di folder `database/dump` ke dalam database Anda. Anda dapat menggunakan perintah berikut:

   ```bash
   mysql -u username_database_anda -p nama_database_anda < database/dump/nama_file_dump.sql
   ```

8. **Jalankan Aplikasi**  
   Jalankan server development dengan perintah:

   ```bash
   php artisan serve
   ```

   Aplikasi akan berjalan di `http://localhost:8000`.

---

### Keunggulan Aplikasi

- **Mudah Digunakan**: Antarmuka yang sederhana dan intuitif membuat aplikasi ini mudah digunakan oleh siapa saja, baik petugas maupun pengunjung.
- **Fleksibel**: Dapat disesuaikan dengan berbagai kebutuhan layanan dan jumlah loket.
- **Real-Time Update**: Informasi antrian diperbarui secara real-time, memastikan pengunjung selalu mendapatkan informasi terbaru.
- **Skalabel**: Aplikasi dapat dikembangkan lebih lanjut untuk menambahkan fitur-fitur baru sesuai kebutuhan.

---

### Kontribusi

Kami sangat menghargai kontribusi dari komunitas untuk pengembangan aplikasi ini. Jika Anda ingin berkontribusi, silakan baca [panduan kontribusi](https://laravel.com/docs/contributions) yang tersedia di dokumentasi Laravel.

### Pelaporan Kerentanan Keamanan

Jika Anda menemukan kerentanan keamanan dalam aplikasi ini, silakan hubungi kami melalui email di [oman.buluatie@gmail.com](mailto:oman.buluatie@gmail.com). Semua laporan kerentanan akan segera ditindaklanjuti.

### Lisensi

Aplikasi Antrian Digital adalah perangkat lunak open-source yang dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

---

Dengan Aplikasi Antrian Digital, pengelolaan antrian menjadi lebih efisien dan terorganisir. Dukung layanan Anda dengan teknologi terbaru untuk memberikan pengalaman terbaik kepada pelanggan!