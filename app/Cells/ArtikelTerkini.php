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
