# Lab7Web - PHP Framework (CodeIgniter 4)

Praktikum ini mempelajari konsep dasar framework PHP CodeIgniter 4 dengan fokus pada arsitektur MVC dan pembuatan aplikasi web sederhana.

## Praktikum 1 : sistem MVC

**Langkah Langkah**

**Instalasi CodeIgniter 4**

instalasi menggunakan composer :

```bash
composer create-project codeigniter4/appstarter . --no-dev
```

Untuk memastikan instalasi berhasil, akses http://localhost:8081/lab11_php_ci/public/ dan halaman welcome CodeIgniter 4 akan muncul.
![image](https://github.com/user-attachments/assets/d7e1ab9b-9028-4995-b4f5-3b519bddc1d2)

**Konfigurasi Dasar**

Mengaktifkan Mode Debugging :
  - Ubah file env menjadi .env
  - Set CI_ENVIRONMENT = development

```php
CI_ENVIRONMENT = development
```

**Implementasi MVC**
1. Routing
   Menambahkan Route ke app/config/Routes.php :
  ```php
  $routes->get('/about', 'Page::about');
  $routes->get('/contact', 'Page::contact');
  $routes->get('/faqs', 'Page::faqs');
  ```

3. Controller
Buat file controller menggunakan CLI : ```php spark make:controller page```
```php
<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Halaman Contact',
            'content' => 'Ini adalah halaman contact untuk menghubungi kami.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title' => 'Halaman FAQ',
            'content' => 'Ini adalah halaman FAQ yang berisi pertanyaan yang sering diajukan.'
        ]);
    }

    public function tos()
    {
        echo "Ini halaman Terms of Services";
    }
}
```

4. View dengan template
  - Template Header :
    ```html
        <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $title; ?></title>
        <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
    </head>
    <body>
        <div id="container">
            <header>
                <h1>Layout Sederhana</h1>
            </header>
            <nav>
                <a href="<?= base_url('/'); ?>"
                   class="<?= uri_string() == '' ? 'active' : ''; ?>">Home</a>
    
                <a href="<?= base_url('/artikel'); ?>"
                   class="<?= str_starts_with(uri_string(), 'artikel') ? 'active' : ''; ?>">Artikel</a>
    
                <a href="<?= base_url('/about'); ?>"
                   class="<?= str_starts_with(uri_string(), 'about') ? 'active' : ''; ?>">About</a>
    
                <a href="<?= base_url('/contact'); ?>"
                   class="<?= str_starts_with(uri_string(), 'contact') ? 'active' : ''; ?>">Contact</a>
            </nav>
    
            <section id="wrapper">
                <section id="main">
  
    ```  
  
  
  - Template Footer :
    ```html
                    </section>
                <aside id="sidebar">
                    <div class="widget-box">
                        <h3 class="title">Widget Header</h3>
                        <ul>
                            <li><a href="#">Widget Link</a></li>
                            <li><a href="#">Widget Link</a></li>
                        </ul>
                    </div>
                    <div class="widget-box">
                        <h3 class="title">Widget Text</h3>
                        <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt arcu. Proin in leo fringilla, vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc pretium ac.</p>
                    </div>
                </aside>
            </section>
            <footer>
                <p>&copy; 2021 - Universitas Pelita Bangsa</p>
            </footer>
        </div>
    </body>
    </html>
    ```

  - View Pages (contoh about.php)
    ```php
    <?= $this->extend('layout/main') ?>
    
    <?= $this->section('content') ?>
    <h1><?= $title; ?></h1>
    <hr>
    <p><?= $content; ?></p>
    <?= $this->endSection() ?>
    ```

hasil dari view about.php :

![image](https://github.com/user-attachments/assets/4328eaf7-49fc-47ff-b9bd-e3eb28c4db66)

## Praktikum 2 : Sistem CRUD artikel

**Langkah Langkah Praktikum :**

**1. Persiapan Database**

Membuat database dan tabel untuk studi kasus data artikel.

Membuat Database

```sql
CREATE DATABASE lab_ci4;
```

Membuat Tabel Artikel

```sql
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
![image](https://github.com/user-attachments/assets/52f26397-4306-45cf-95fb-5751f2d5fe64)

   
**2. Konfigurasi Database**

Konfigurasi Koneksi ke database melalui file .env 

```env
database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

   
**3. Membuat Model**

Membuat file ArtikelModel dengan ```php spark make:model ArtikelModel```

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar'];
    protected $useTimestamps = true;
}
```
   
**4. Membuat Controller**

Membuat file artikel.php dengan ```php spark make:controller Artikel```

```php
<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/index', compact('artikel', 'title'));
    }
}
```
   
**5. Membuat View**

Membuat file index.php di directory app/views/artikel/ untuk menampilkan daftar artikel

```php
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>

<?php if($artikel): foreach($artikel as $row): ?>
<article class="entry">
    <h2><a href="<?= base_url('/artikel/' . $row['slug']);?>"><?= $row['judul']; ?></a></h2>
    <?php if($row['gambar']): ?>
        <img src="<?= base_url('/gambar/' . $row['gambar']);?>" alt="<?= $row['judul']; ?>">
    <?php endif; ?>
    <p><?= substr($row['isi'], 0, 200); ?></p>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry">
    <h2>Belum ada data.</h2>
</article>
<?php endif; ?>
<?= $this->endSection() ?>
```

   
**6. Menambahkan Data Sample**

Menambahkan data Sampel ke database untuk testing

```sql
INSERT INTO artikel (judul, isi, slug) VALUES
('Artikel pertama', 'Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf.', 'artikel-pertama'),
('Artikel kedua', 'Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah teks-teks yang diacak. Ia berakar dari sebuah naskah sastra latin klasik dari era 45 sebelum masehi, hingga bisa dipastikan usianya telah mencapai lebih dari 2000 tahun.', 'artikel-kedua');
```

**7. Membuat Halaman Detail Artikel**

menambahkan method **view()** di controller artikel.php dan membuat halaman viewnya di directory app/views/artikel/detail.php

```php
<?= $this->include('template/header'); ?>

<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <?php if($artikel['gambar']): ?>
        <img src="<?= base_url('/gambar/' . $artikel['gambar']);?>" alt="<?= $artikel['judul']; ?>">
    <?php endif; ?>
    <p><?= $artikel['isi']; ?></p>
</article>

<?= $this->include('template/footer'); ?>
```

![image](https://github.com/user-attachments/assets/6c325a92-bb43-4df9-a5ce-06006f713bd1)


**8. Membuat Menu Admin**

membuat method halaman admin untuk operasi CRUD serta membuat halaman viewsnya di directory app/views/artikel/admin_index.php 

```php
<?= $this->include('template/admin_header'); ?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if($artikel): foreach($artikel as $row): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td>
                <b><?= $row['judul']; ?></b>
                <p><small><?= substr($row['isi'], 0, 50); ?></small></p>
            </td>
            <td><?= $row['status']; ?></td>
            <td>
                <a class="btn" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="4">Belum ada data.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>


<?= $this->include('template/admin_footer'); ?>
```

![image](https://github.com/user-attachments/assets/f7cc43df-968c-49df-baf1-69162e9ca6c8)


**9. Membuat Routing**

tambahkan routing di app/config/routes.php

```php
$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```


**10. Implementasi CRUD**

- Menambah Data
  
  ```php
  public function add()
  {
      $validation = \Config\Services::validation();
      $validation->setRules(['judul' => 'required']);
      $isDataValid = $validation->withRequest($this->request)->run();
      
      if ($isDataValid) {
          $artikel = new ArtikelModel();
          $artikel->insert([
              'judul' => $this->request->getPost('judul'),
              'isi' => $this->request->getPost('isi'),
              'slug' => url_title($this->request->getPost('judul')),
          ]);
          return redirect('admin/artikel');
      }
      
      $title = "Tambah Artikel";
      return view('artikel/form_add', compact('title'));
  }
  ```

- Update Data
  
  ```php
  public function edit($id)
  {
      $artikel = new ArtikelModel();
      $validation = \Config\Services::validation();
      $validation->setRules(['judul' => 'required']);
      $isDataValid = $validation->withRequest($this->request)->run();
      
      if ($isDataValid) {
          $artikel->update($id, [
              'judul' => $this->request->getPost('judul'),
              'isi' => $this->request->getPost('isi'),
          ]);
          return redirect('admin/artikel');
      }
      
      $data = $artikel->where('id', $id)->first();
      $title = "Edit Artikel";
      return view('artikel/form_edit', compact('title', 'data'));
  }
  ```

- Delete Data

  ```php
  public function delete($id)
  {
      $artikel = new ArtikelModel();
      $artikel->delete($id);
      return redirect('admin/artikel');
  }
  ```

## Praktikum 3 : View Layout dan View Cell

**Langkah Langkah :**

**1. Membuat Layout Utama**

Membuat folder layout di dalam app/Views/ dan membuat file main.php sebagai template utama aplikasi.


**2. Modifikasi View Dengan Layout**

Mengubah view yang sudah ada untuk menggunakan layout baru dengan menggunakan ```$this->extend()``` dan ```$this->section()```

Contoh modifikasi app/Views/home.php:
```php

<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h1><?= $title; ?></h1>

<hr>

<p><?= $content; ?></p>

<?= $this->endSection() ?>
```

![image](https://github.com/user-attachments/assets/e028d5a8-6979-4170-8747-c8f51fa09f43)

**3. Membuat View Cell**

Membuat folder Cells di dalam app/ dan membuat file ArtikelTerkini.php menggunakan ```php spark make:cell ArtikelTerkini``` untuk menampilkan artikel terkini secara dinamis.

```php
<?php

namespace App\Cells;

use App\Models\ArtikelModel;
use CodeIgniter\View\Cells\Cell;

class ArtikelTerkini extends Cell
{
    public function render(): string
    {
        $model = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();

        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}
```


**4. Membuat View Component**

Membuat folder components di dalam app/Views/components dan membuat file artikel_terkini.php untuk template artikel terkini.

```php
<div class="widget-box">
    <h3 class="title">Artikel Terkini</h3>
    <ul>
        <?php foreach ($artikel as $row): ?>
            <li><a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?= $row['judul'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
```

Setelah implementasi View Layout dan View Cell, tampilan website menjadi lebih terstruktur dan modular:

- Layout utama yang konsisten di semua halaman
- Sidebar yang menampilkan artikel terkini secara dinamis
- Kode yang lebih mudah di-maintain dan reusable

## Praktikum 4

**Langkah Langkah :**

**1. Persiapan Database**
Membuat tabel user untuk sistem login.

```sql
CREATE TABLE user (
    id INT(11) auto_increment,
    username VARCHAR(200) NOT NULL,
    useremail VARCHAR(200),
    userpassword VARCHAR(200),
    PRIMARY KEY(id)
);
```

![image](https://github.com/user-attachments/assets/29c41bfd-9ddf-45b2-a4c1-31b2eb1f414e)


**2. Membuat Model User**

Membuat file UserModel.php di app/Models/ menggunakan ```php spark make:model userModel``` untuk mengelola data user.

```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['username', 'useremail', 'userpassword'];
}
```

**3. Membuat Controller User**

Membuat file User.php di app/Controllers/ menggunakan ```php spark make:controller user``` dengan method untuk login dan logout.

```php
<?php
namespace App\Controllers;
use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();
        return view('user/index', compact('users', 'title'));
    }

    public function login()
    {
        helper(['form']);
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        if (!$email) {
            return view('user/login');
        }
        
        $session = session();
        $model = new UserModel();
        $login = $model->where('useremail', $email)->first();
        
        if ($login) {
            $pass = $login['userpassword'];
            if (password_verify($password, $pass)) {
                $login_data = [
                    'user_id' => $login['id'],
                    'user_name' => $login['username'],
                    'user_email' => $login['useremail'],
                    'logged_in' => TRUE,
                ];
                $session->set($login_data);
                return redirect('admin/artikel');
            } else {
                $session->setFlashdata("flash_msg", "Password salah.");
                return redirect()->to('/user/login');
            }
        } else {
            $session->setFlashdata("flash_msg", "Email tidak terdaftar.");
            return redirect()->to('/user/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}
```

**4. Membuat View Login**

Membuat direktori user di app/views/ dan membuat file login.php untuk form login.

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="login-wrapper">
        <h1>Sign In</h1>
        <?php if(session()->getFlashdata('flash_msg')):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('flash_msg') ?></div>
        <?php endif;?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="InputForEmail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>">
            </div>
            <div class="mb-3">
                <label for="InputForPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="InputForPassword">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
```

**5. Membuat Database Seeder**

Membuat seeder untuk data dummy user menggunakan CLI. ```php spark make:seeder userSeeder```

kemudian isi file UserSeeder.php :

```php
<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = model('UserModel');
        $model->insert([
            'username' => 'admin',
            'useremail' => 'admin@email.com',
            'userpassword' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);
    }
}
```

untuk menjalankan seeder menggunakan command cli : ```php spark db:seed UserSeeder```

![image](https://github.com/user-attachments/assets/0c409ded-e900-464e-ab0a-a0c60fdce09b)

**6. Membuat Middleware Auth**

Membuat filter menggunakan ```php spark make:filter Auth``` untuk proteksi halaman admin di app/Filters/Auth.php.
```php
<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // jika user belum login
        if(! session()->get('logged_in')){
            // maka redirect ke halaman login
            return redirect()->to('/user/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
```

**7. Konfigurasi Filter**

tambahkan filter auth yang tadi dengan menambahkan baris **'auth' => App\Filters\Auth::class** ke dalam file App/config/filters.php di bagian aliases

```php
public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'auth'          => \App\Filters\Auth::class,
    ];
```

**8. Konfigurasi Routes**

Mengupdate routes agar halaman login bisa di akses dan  menggunakan filter auth pada halaman admin :

```
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```

**9. Test sistem login**

Mengakses halaman admin tanpa login akan redirect ke halaman login:

- URL: http://localhost:8080/admin/artikel
- Akan redirect ke: http://localhost:8080/user/login

**10. Login Dengan Kredensial**

Login menggunakan:

Email: admin@email.com
Password: admin123

Setelah login berhasil, akan redirect ke halaman admin artikel.

## Praktikum 5

**Langkah Langkah :**

**1. Membuat Pagination**

Pagination merupakan proses yang digunakan untuk membatasi tampilan data yang panjang dengan memecah tampilan menjadi beberapa halaman.

Modifikasi Controller Artikel pada method admin_index():

```php
public function admin_index()
{
    $title = 'Daftar Artikel';
    $model = new ArtikelModel();
    $data = [
        'title' => $title,
        'artikel' => $model->paginate(10), // data dibatasi 10 record per halaman
        'pager' => $model->pager,
    ];
    return view('artikel/admin_index', $data);
}
```

Tambahkan kode pagination di file views/artikel/admin_index.php:

```php
<?= $pager->links(); ?>
```

<img width="1018" height="466" alt="image" src="https://github.com/user-attachments/assets/25acbeca-61cd-41e4-bf8d-658c715d779e" />


**2. Membuat Pencarian**

Pencarian data digunakan untuk memfilter data berdasarkan kata kunci tertentu.

Modifikasi method admin_index() untuk mendukung pencarian:

```php
public function admin_index()
{
    $title = 'Daftar Artikel';
    $q = $this->request->getVar('q') ?? '';
    $model = new ArtikelModel();
    $data = [
        'title' => $title,
        'q' => $q,
        'artikel' => $model->like('judul', $q)->paginate(10), // data dibatasi 10 record per halaman
        'pager' => $model->pager,
    ];
    return view('artikel/admin_index', $data);
}
```

Tambahkan form pencarian di file views/artikel/admin_index.php:

```php
<form method="get" class="form-search">
    <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
    <input type="submit" value="Cari" class="btn btn-primary">
</form>
```

Update link pager untuk mempertahankan parameter pencarian:

```php
<?= $pager->only(['q'])->links(); ?>
```

<img width="1018" height="621" alt="image" src="https://github.com/user-attachments/assets/bcec1ac8-b021-4105-89cd-752a6fa25947" />



**3. Testing Fitur**

- Pagination: Menampilkan maksimal 10 artikel per halaman dengan navigasi halaman
- Pencarian: Filter artikel berdasarkan judul dengan kata kunci tertentu
- Kombinasi: Pencarian dengan pagination yang tetap mempertahankan kata kunci


## Praktikum 6: Upload File Gambar

**Langkah Langkah :**

**1. Tujuan Praktikum**
- Memahami konsep dasar File Upload
- Membuat File Upload menggunakan Framework CodeIgniter 4

**2. Modifikasi Controller Artikel**

Mengubah method `add()` di Controller Artikel untuk menambahkan fungsi upload gambar:

```php
public function add()
{
    // validasi data.
    $validation = \Config\Services::validation();
    $validation->setRules(['judul' => 'required']);
    $isDataValid = $validation->withRequest($this->request)->run();
    
    if ($isDataValid)
    {
        $file = $this->request->getFile('gambar');
        $file->move(ROOTPATH . 'public/gambar');
        
        $artikel = new ArtikelModel();
        $artikel->insert([
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'slug' => url_title($this->request->getPost('judul')),
            'gambar' => $file->getName(),
        ]);
        
        return redirect('admin/artikel');
    }
    
    $title = "Tambah Artikel";
    return view('artikel/form_add', compact('title'));
}
```

**3. Modifikasi View Form**

Menambahkan field input file di `views/artikel/form_add.php`:

```php
<p>
    <input type="file" name="gambar">
</p>
```

**4. Update Form Tag**

Menambahkan `enctype="multipart/form-data"` pada tag form:

```php
<form action="" method="post" enctype="multipart/form-data">
```

<img width="1018" height="734" alt="image" src="https://github.com/user-attachments/assets/eadd7135-f2c1-4607-8adf-e1aa04d24625" />


**5. Membuat Folder Upload**

Membuat folder `gambar` di dalam direktori `public/` untuk menyimpan file upload.

**6. Testing Upload**

Mengakses menu tambah artikel dan mencoba upload file gambar. Sistem akan:
- Memvalidasi form
- Mengupload file gambar ke folder `public/gambar`
- Menyimpan nama file ke database
- Redirect ke halaman admin artikel

**7. Tampilan Gambar**

Gambar yang diupload akan ditampilkan di halaman detail artikel dan daftar artikel dengan menggunakan:

```php
<?php if($artikel['gambar']): ?>
    <img src="<?= base_url('/gambar/' . $artikel['gambar']);?>" alt="<?= $artikel['judul']; ?>">
<?php endif; ?>
```

<img width="760" height="442" alt="image" src="https://github.com/user-attachments/assets/3d872615-ec51-47e9-8dcc-b9ee244436de" />


# Kesimpulan

**Praktikum 1 :**

CodeIgniter 4 memudahkan pengembangan aplikasi web dengan arsitektur MVC yang jelas. Framework ini menyediakan struktur yang baik untuk memisahkan logika aplikasi, memudahkan maintenance, dan meningkatkan produktivitas development.

**Praktikum 2 :**

Praktikum ini berhasil mengimplementasikan sistem CRUD sederhana menggunakan CodeIgniter 4 dengan fitur:

- Manajemen artikel (Create, Read, Update, Delete)
- Validasi form
- Routing yang terstruktur
- Pemisahan logic dengan pattern MVC
- Interface admin untuk pengelolaan data

**Praktikum 3 :**

Praktikum View Layout dan View Cell memberikan pemahaman tentang:

- Penggunaan layout template yang konsisten
- Implementasi View Cell untuk komponen yang dapat digunakan ulang
- Struktur kode yang lebih modular dan maintainable
- Pemisahan concern antara layout, content, dan komponen

**Praktikum 4 :**

Praktikum sistem login berhasil mengimplementasikan:

- Sistem autentikasi user dengan password hashing
- Session management untuk maintain login state
- Filter untuk proteksi halaman admin
- Redirect system untuk unauthorized access
- Database seeder untuk data dummy user

**Praktikum 5 :**

Praktikum pagination dan pencarian berhasil mengimplementasikan:

- Sistem pagination untuk membatasi tampilan data per halaman
- Fitur pencarian dengan filter berdasarkan judul artikel
- Integrasi pagination dengan pencarian yang seamless
- Penggunaan library pagination CodeIgniter 4 yang mudah digunakan

**Praktikum 6 :**

Praktikum upload file gambar berhasil mengimplementasikan:

- Sistem upload file gambar menggunakan CodeIgniter 4
- Validasi dan handling file upload
- Penyimpanan file ke direktori public
- Integrasi upload file dengan sistem CRUD artikel
- Tampilan gambar pada halaman artikel

Semua fitur berfungsi dengan baik dan sesuai dengan requirements yang diberikan. Kombinasi dari keenam praktikum ini memberikan pemahaman yang komprehensif tentang penggunaan CodeIgniter 4 dari konsep dasar hingga implementasi aplikasi web yang lebih kompleks dengan sistem keamanan, pagination, pencarian, dan upload file.
