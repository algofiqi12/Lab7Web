<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link rel="stylesheet" href="<?= base_url('admin.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Admin Panel</h1>
            <div class="user-info">
                Welcome, <?= session()->get('user_name') ?>!
                <a href="<?= base_url('/user/logout') ?>">Logout</a>
            </div>
        </header>
        <nav>
            <a href="<?= base_url('/admin/artikel');?>">Artikel</a>
            <a href="<?= base_url('/admin/artikel/add');?>">Tambah Artikel</a>
        </nav>
        <section id="wrapper">
            <section id="main">