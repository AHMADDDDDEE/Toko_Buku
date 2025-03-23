<h2>Tambah Pelanggan</h2>
<form method="post" enctype="multipart/form-data">
     <div class="form-group">
        <label>nama pelanggan</label>
        <input type="text" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>email pelanggan</label>
        <textarea class="form-control" name="email" rows="1"></textarea>
    </div>
    <div class="form-group">
        <label>Nomor telepon</label>
        <input type="number" class="form-control" name="Nomor">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>

<?php
if (isset($_POST['save'])) {
    $koneksi->query("INSERT INTO pelanggan
    (nama_pelanggan,email_pelanggan,telepon_pelanggan)
    VALUES('$_POST[nama]','$_POST[email]','$_POST[Nomor]')");

    echo "<div class='alert alert-info'>data tersimpan</div>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=pelanggan'>";
}
?>