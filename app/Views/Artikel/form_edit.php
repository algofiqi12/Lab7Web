<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>
<form action="" method="post">
    <p>
        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" value="<?= $data['judul'];?>" required>
    </p>
    <p>
        <label for="isi">Isi:</label>
        <textarea name="isi" id="isi" cols="50" rows="10" required><?= $data['isi'];?></textarea>
    </p>
    <p><input type="submit" value="Kirim" class="btn btn-large"></p>
</form>

<?= $this->include('template/admin_footer'); ?>