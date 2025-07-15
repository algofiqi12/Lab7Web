# Praktikum Pemrograman Web 2 - CodeIgniter 4

Repository ini berisi kumpulan praktikum untuk mata kuliah Pemrograman Web 2 menggunakan framework CodeIgniter 4.

## Daftar Praktikum

### Praktikum 2: Framework Lanjutan (CRUD)
**Tujuan:**
- Memahami konsep dasar Model
- Memahami konsep dasar CRUD
- Membuat program sederhana menggunakan Framework CodeIgniter 4

**Materi yang dipelajari:**
- Konfigurasi database
- Membuat Model (ArtikelModel)
- Membuat Controller (Artikel)
- Membuat View untuk menampilkan data
- Implementasi CRUD (Create, Read, Update, Delete)
- Routing untuk artikel detail dan admin

**Struktur Database:**
```sql
CREATE DATABASE lab_ci4;

CREATE TABLE artikel (
    id INT(11) auto_increment,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    PRIMARY KEY(id)
);
```

**Fitur yang diimplementasikan:**
- Tampilan daftar artikel
- Tampilan detail artikel
- Menu admin untuk mengelola artikel
- Form tambah artikel
- Form edit artikel
- Fungsi hapus artikel

### Praktikum 3: View Layout dan View Cell
**Tujuan:**
- Memahami konsep View Layout di CodeIgniter 4
- Menggunakan View Layout untuk membuat template tampilan
- Memahami dan mengimplementasikan View Cell
- Menggunakan View Cell untuk memanggil komponen UI secara modular

**Materi yang dipelajari:**
- Membuat layout utama (`app/Views/layout/main.php`)
- Modifikasi file view untuk menggunakan layout
- Implementasi View Cell untuk komponen dinamis
- Membuat class View Cell (`app/Cells/ArtikelTerkini.php`)
- Membuat view untuk komponen (`app/Views/components/artikel_terkini.php`)

**Struktur View Layout:**
```php
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- Konten halaman -->
<?= $this->endSection() ?>
```

**View Cell untuk Artikel Terkini:**
- Menampilkan 5 artikel terbaru
- Dapat digunakan di berbagai halaman
- Komponen yang dapat digunakan ulang

### Praktikum 4: Framework Lanjutan (Modul Login)
**Tujuan:**
- Memahami konsep dasar Auth dan Filter
- Memahami konsep dasar Login System
- Membuat modul login menggunakan Framework CodeIgniter 4

**Materi yang dipelajari:**
- Membuat tabel user
- Membuat UserModel
- Membuat Controller User dengan method login
- Membuat view login
- Implementasi database seeder
- Membuat Auth Filter untuk proteksi halaman admin
- Konfigurasi filter dan routes
- Implementasi fungsi logout

**Struktur Database User:**
```sql
CREATE TABLE user (
    id INT(11) auto_increment,
    username VARCHAR(200) NOT NULL,
    useremail VARCHAR(200),
    userpassword VARCHAR(200),
    PRIMARY KEY(id)
);
```

**Fitur Authentication:**
- Form login dengan validasi
- Session management
- Password hashing
- Auth filter untuk proteksi route
- Fungsi logout

### Praktikum 5: Pagination dan Pencarian
**Tujuan:**
- Memahami konsep dasar Pagination
- Memahami konsep dasar Pencarian
- Membuat Paging dan Pencarian menggunakan Framework CodeIgniter 4

**Materi yang dipelajari:**
- Implementasi pagination dengan library bawaan CodeIgniter
- Membuat form pencarian
- Integrasi pagination dengan pencarian
- Konfigurasi pagination links

**Fitur Pagination:**
- Membatasi tampilan data per halaman (10 record)
- Navigasi halaman otomatis
- Integrasi dengan pencarian

**Fitur Pencarian:**
- Form pencarian berdasarkan judul artikel
- Filter data menggunakan method `like()`
- Mempertahankan parameter pencarian di pagination

### Praktikum 6: Upload File Gambar
**Tujuan:**
- Memahami konsep dasar File Upload
- Membuat File Upload menggunakan Framework CodeIgniter 4

**Materi yang dipelajari:**
- Menambahkan field input file pada form
- Konfigurasi form dengan `enctype="multipart/form-data"`
- Implementasi upload file di controller
- Validasi dan pemrosesan file gambar
- Penyimpanan file ke direktori public

**Implementasi Upload:**
- Menambahkan input file pada form tambah artikel
- Memproses upload file dengan `getFile()`
- Memindahkan file ke folder `public/gambar`
- Menyimpan nama file ke database

## Instalasi dan Konfigurasi

### Persiapan Environment
1. Install XAMPP atau web server lainnya
2. Install Composer
3. Install CodeIgniter 4

### Konfigurasi Database
1. Buat database `lab_ci4`
2. Konfigurasi database di file `.env`:
```
database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### Menjalankan Aplikasi
1. Buka terminal/command prompt
2. Navigate ke folder project
3. Jalankan perintah: `php spark serve`
4. Akses aplikasi melalui browser: `http://localhost:8080`

## Struktur Folder

```
lab7_php_ci/
├── app/
│   ├── Controllers/
│   │   ├── Artikel.php
│   │   └── User.php
│   ├── Models/
│   │   ├── ArtikelModel.php
│   │   └── UserModel.php
│   ├── Views/
│   │   ├── layout/
│   │   │   └── main.php
│   │   ├── components/
│   │   │   └── artikel_terkini.php
│   │   ├── artikel/
│   │   │   ├── index.php
│   │   │   ├── detail.php
│   │   │   ├── admin_index.php
│   │   │   ├── form_add.php
│   │   │   └── form_edit.php
│   │   └── user/
│   │       └── login.php
│   ├── Cells/
│   │   └── ArtikelTerkini.php
│   ├── Filters/
│   │   └── Auth.php
│   └── Database/
│       └── Seeds/
│           └── UserSeeder.php
├── public/
│   ├── gambar/
│   └── style.css
└── .env
```

## Routing

### Route Utama
```php
$routes->get('/', 'Home::index');
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');
```

### Route Admin (dengan Auth Filter)
```php
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```

### Route User
```php
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');
```

## Fitur Utama

### 1. Manajemen Artikel
- **Create**: Tambah artikel baru dengan upload gambar
- **Read**: Tampilan daftar artikel dan detail artikel
- **Update**: Edit artikel yang sudah ada
- **Delete**: Hapus artikel
- **Pagination**: Navigasi halaman untuk daftar artikel
- **Search**: Pencarian artikel berdasarkan judul

### 2. Sistem Authentication
- **Login**: Form login dengan validasi
- **Session**: Manajemen session user
- **Auth Filter**: Proteksi halaman admin
- **Logout**: Fungsi logout dan destroy session

### 3. Template System
- **View Layout**: Template layout yang dapat digunakan ulang
- **View Cell**: Komponen UI modular
- **Responsive**: Layout yang responsif

### 4. File Upload
- **Image Upload**: Upload gambar untuk artikel
- **File Validation**: Validasi file yang diupload
- **File Storage**: Penyimpanan file di direktori public

## Cara Penggunaan

### 1. Akses Halaman Utama
- Buka browser dan akses `http://localhost:8080`
- Lihat daftar artikel yang tersedia

### 2. Login Admin
- Akses `http://localhost:8080/user/login`
- Gunakan kredensial default:
  - Email: admin@email.com
  - Password: admin123

### 3. Kelola Artikel
- Setelah login, akses `http://localhost:8080/admin/artikel`
- Tambah, edit, atau hapus artikel
- Upload gambar untuk artikel

### 4. Pencarian dan Pagination
- Gunakan form pencarian untuk filter artikel
- Navigasi halaman menggunakan pagination links

## Database Seeder

Untuk membuat data dummy user admin:

```bash
php spark make:seeder UserSeeder
php spark db:seed UserSeeder
```

## Teknologi yang Digunakan

- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Web Server**: Apache (XAMPP)
- **PHP Version**: 7.4 atau lebih baru

## Kontribusi

Praktikum ini dikembangkan oleh:
- **Dosen**: Agung Nugroho (agung@pelitabangsa.ac.id)
- **Universitas**: Pelita Bangsa, Bekasi

## Lisensi

Materi praktikum ini untuk keperluan edukasi di Universitas Pelita Bangsa.
