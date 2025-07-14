<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<?php if (session()->getFlashdata('errors')): ?>
<div style="color: red; margin-bottom: 15px;">
    <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" required value="<?= old('judul') ?>">
    </p>
    <p>
        <label for="isi">Isi:</label>
        <textarea name="isi" id="isi" cols="50" rows="10" required><?= old('isi') ?></textarea>
    </p>
    <p>
        <label for="gambar">Gambar:</label>
        <input type="file" name="gambar" id="gambar" accept="image/*">
        <small style="color: #666;">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
    </p>
    <p>
        <input type="submit" value="Kirim" class="btn btn-large">
        <a href="<?= base_url('admin/artikel') ?>" style="margin-left: 10px;">Batal</a>
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>