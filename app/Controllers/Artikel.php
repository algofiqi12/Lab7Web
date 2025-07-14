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

    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->where(['slug' => $slug])->first();
        
        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }
        
        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $q = $this->request->getVar('q') ?? '';
        $model = new ArtikelModel();

         if (!empty($q)) {
            $model->like('judul', $q)
                ->orLike('isi', $q);
        }

        $data  = [
            'title'     => $title,
            'q'         => $q,
            'artikel'   => $model->paginate(5),
            'pager'     => $model->pager,
        ];
        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();
        
        if ($isDataValid) {
            $file = $this->request->getFile('gambar');
            
            // Validasi file
            if ($file->isValid() && !$file->hasMoved()) {
                // Generate nama file unik
                $newFileName = $file->getRandomName();
                
                // Pindahkan file ke folder public/gambar
                $file->move(ROOTPATH . 'public/gambar', $newFileName);
                
                // Resize gambar menggunakan Image Library CodeIgniter
                $this->resizeImage(ROOTPATH . 'public/gambar/' . $newFileName);
                
                $artikel = new ArtikelModel();
                $artikel->insert([
                    'judul'     => $this->request->getPost('judul'),
                    'isi'       => $this->request->getPost('isi'),
                    'slug'      => url_title($this->request->getPost('judul'), '-', true),
                    'gambar'    => $newFileName,
                ]);
                
                return redirect('admin/artikel')->with('success', 'Artikel berhasil ditambahkan');
            }
        }
        
        $title = "Tambah Artikel";
        return view('artikel/form_add', compact('title'));
    }

    public function edit($id)
    {
        $artikel = new ArtikelModel();
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        
        if ($isDataValid) {
            $updateData = [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'), '-', true),
            ];
            
            // Jika ada gambar baru yang diupload
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Hapus gambar lama jika ada
                $oldData = $artikel->where('id', $id)->first();
                if ($oldData && $oldData['gambar']) {
                    $oldImagePath = ROOTPATH . 'public/gambar/' . $oldData['gambar'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Upload gambar baru
                $newFileName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $newFileName);
                $this->resizeImage(ROOTPATH . 'public/gambar/' . $newFileName);
                $updateData['gambar'] = $newFileName;
            }
            
            $artikel->update($id, $updateData);
            return redirect('admin/artikel')->with('success', 'Artikel berhasil diperbarui');
        }
        
        $data = $artikel->where('id', $id)->first();
        $title = "Edit Artikel";
        return view('artikel/form_edit', compact('title', 'data'));
    }

    public function delete($id)
    {
        $artikel = new ArtikelModel();
        $data = $artikel->where('id', $id)->first();
        
        // Hapus gambar jika ada
        if ($data && $data['gambar']) {
            $imagePath = ROOTPATH . 'public/gambar/' . $data['gambar'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $artikel->delete($id);
        return redirect('admin/artikel')->with('success', 'Artikel berhasil dihapus');
    }

    private function resizeImage($imagePath)
    {
        try {
            $image = \Config\Services::image();
            
            // Resize gambar dengan lebar maksimal 800px dan tinggi maksimal 600px
            $image->withFile($imagePath)
                  ->resize(800, 600, true, 'height')
                  ->save($imagePath, 85); // Quality 85%
                  
        } catch (\Exception $e) {
            // Jika ada error saat resize, gambar tetap tersimpan dalam ukuran asli
            log_message('error', 'Error resizing image: ' . $e->getMessage());
        }
    }
}