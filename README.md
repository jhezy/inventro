# Inventro

Inventro – Aplikasi Inventaris Barang Sekolah

Inventro adalah aplikasi berbasis web yang dirancang khusus untuk mengelola inventaris barang di lingkungan sekolah. Dibangun menggunakan Laravel 10, aplikasi ini memudahkan pencatatan, pengelompokan, pencarian, serta pencetakan data barang secara efisien.

### Prasyarat

Berikut beberapa hal yang perlu diinstal terlebih dahulu:

-   Composer (https://getcomposer.org/)
-   PHP ^8.1
-   MySQL
-   XAMPP

Jika Anda menggunakan XAMPP, untuk PHP dan MySQL sudah menjadi 1 (bundle) di dalam aplikasi XAMPP

### Fitur

-   CRUD Data Barang
-   CRUD Data Perolehan
-   CRUD Data Ruangan
-   CRUD Data Pengguna
-   Pengaturan Profil

### Langkah-langkah instalasi

-   Clone repository ini

```bash
$ git clone https://github.com/jhezy/inventro.git
```

-   Install seluruh packages yang dibutuhkan

```bash
$ composer install
```

-   Siapkan database dan atur file .env sesuai dengan konfigurasi Anda

-   Masukan nama sekolah pada konfigurasi .env untuk menampilkan nama sekolah pada print barang. Berikan tanda kutip jika nama sekolah mengandung spasi

Contoh:

```
NAMA_SEKOLAH="SD Sawunggaling"
```

-   Jika sudah, migrate seluruh migrasi dan seeding data

```bash
$ php artisan migrate --seed
```

-   Jalankan local server

```
$ php artisan serve
```

-   User default aplikasi untuk login

Administrator

```
Email       : admin@mail.com
Password    : secret
```

Staff TU (Tata Usaha)

```
Email       : stafftu@mail.com
Password    : secret
```

### Dibuat dengan

-   [Laravel](https://laravel.com) - Web Framework
