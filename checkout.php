<?php
session_start();
include 'koneksi.php';
?>
<?php
// Validasi jika keranjang kosong
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang belanja kosong, silakan tambahkan produk terlebih dahulu.');</script>";
    echo "<script>location='index.php';</script>";
    exit();
}
?>
<?php
//jk tidak ada session pelanggan(blm login,).mk dilarikan ke login.php
if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('silahkan login terlebih dahulu');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <section class="konten">
    <div class="container">
        <h1>Keranjang Belanja</h1>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subharga</th>
                  
                </tr>
            </thead>
            <tbody>
            
<?php $nomor = 1; ?>
<?php $totalbelanja = 0; ?>

<?php foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
    // Ambil data produk dari database
    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
    $pecah = $ambil->fetch_assoc();

    // Validasi jika produk tidak ditemukan
    if (!$pecah) {
        unset($_SESSION['keranjang'][$id_produk]);
        continue; // Lewati iterasi jika produk tidak ditemukan
    }

    // Hitung subharga
    $subharga = $pecah["harga_produk"] * $jumlah;
?>
<tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $pecah["nama_produk"]; ?></td>
    <td>Rp. <?php echo number_format($pecah["harga_produk"]); ?></td>
    <td><?php echo $jumlah; ?></td>
    <td>Rp. <?php echo number_format($subharga); ?></td>

</tr>
<?php $nomor++; ?>
<?php $totalbelanja+=$subharga; ?>
<?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total belanja</th>
                    <th>Rp. <?php echo number_format($totalbelanja)?></th>
</tr>
</tfoot>
        </table>
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                <div class="form-group">
            <input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['nama_pelanggan']
            ?>" class="form-control">
            </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
            <input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['telepon_pelanggan']
            ?>" class="form-control">
            </div>
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="id_ongkir">
                        <option value="">pilih ongkos kirim</option>
                        <?php
                        $ambil = $koneksi->query("SELECT * FROM ongkir");
                        while($perongkir = $ambil->fetch_assoc()){
                        ?>
                        <option value="<?php echo $perongkir["id_ongkir"] ?>">
                            <?php echo $perongkir['nama_kota'] ?> 
                        Rp.  <?php echo number_format($perongkir['tarif']) ?> 
                        </option>  
                        <?php } ?>   
                    </select>
                    </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap Pengiriman</label>
                            <textarea class="form-control" name="alamat_pengiriman" placeholder="masukkan alamat lengkap pengiriman(termasuk kode pos)"></textarea>
                        </div>
                        <button class="btn btn-primary" name="checkout">Checkout</button>
                    </form>
                    
                <?php
                
                if (isset($_POST["checkout"])) {
                    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
                    $id_ongkir = $_POST["id_ongkir"];
                    $tanggal_pembelian = date("Y-m-d");
                    $alamat_pengiriman = $_POST["alamat_pengiriman"];
                
                    // Validasi jika ongkir tidak dipilih
                    if (empty($id_ongkir)) {
                        echo "<script>alert('Silakan pilih ongkos kirim terlebih dahulu');</script>";
                        exit();
                    }
                
                    // Ambil data ongkir dari database
                    $ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
                    $arrayongkir = $ambil->fetch_assoc();
                
                    // Validasi jika ongkir tidak ditemukan
                    if (!$arrayongkir) {
                        echo "<script>alert('Data ongkos kirim tidak valid');</script>";
                        exit();
                    }
                
                    $tarif = $arrayongkir['tarif'];
                    $nama_kota = $arrayongkir['nama_kota'];
                    $total_pembelian = $totalbelanja + $tarif;
                
                    // 1. Menyimpan data ke tabel pembelian
                    $koneksi->query("INSERT INTO pembelian 
                        (id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian, nama_kota, tarif, alamat_pengiriman) 
                        VALUES ('$id_pelanggan', '$id_ongkir', '$tanggal_pembelian', '$total_pembelian', '$nama_kota', '$tarif ', '$alamat_pengiriman')");
                
                    // Mendapatkan ID pembelian yang baru saja terjadi
                    $id_pembelian_barusan = $koneksi->insert_id;

                    foreach ($_SESSION["keranjang"] as $id_produk => $jumlah)
                    {
                        // mendapatkan data produk berdasarkan id_produk
                        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                        $perproduk = $ambil->fetch_assoc();

                        $nama = $perproduk['nama_produk'];
                        $harga = $perproduk['harga_produk'];
                        $berat = $perproduk['berat_produk'];

                        $subberat = $perproduk['berat_produk']*$jumlah;
                        $subharga = $perproduk['harga_produk']*$jumlah;
                        $koneksi->query("INSERT INTO pembelian_produk 
                        (id_pembelian, id_produk, nama, harga, berat, jumlah, subberat, subharga) 
                        VALUES ('$id_pembelian_barusan', '$id_produk', '$nama', '$harga', '$berat', '$jumlah', '$subberat', 
                        '$subharga')");

                        // Skrip update stok
                        $koneksi->query("UPDATE produk SET stok_produk=stok_produk-$jumlah
                         WHERE id_produk='$id_produk'");

                    }
                    // Mengkosongkan keranjang belanja
                    unset($_SESSION["keranjang"]);
                
                    // Tampilkan pesan sukses tanpa mengarahkan ke halaman lain
                    echo "<script>alert('Checkout berhasil! ID Pembelian Anda: $id_pembelian_barusan');</script>";
                    echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
                }
                
                    ?>
                     </div>
                </section>

<pre><?php print_r($_SESSION['pelanggan'])?></pre>
<pre><?php print_r($_SESSION['keranjang'])?></pre>
</body>
</html>