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
                <?= $this->renderSection('content') ?>
            </section>
            <aside id="sidebar">
                <?= view_cell('App\\Cells\\ArtikelTerkini::render') ?>
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