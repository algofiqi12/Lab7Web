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
