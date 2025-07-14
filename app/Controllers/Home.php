<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $title = 'Home';
        $content = 'Selamat datang di website kami. Ini adalah halaman utama.';
        return view('home', compact('title', 'content'));
    }
}