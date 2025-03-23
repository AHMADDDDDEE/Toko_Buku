<?php
session_start();
include 'koneksi.php';

// Debug: Cek isi session keranjang
echo "<pre>";
print_r($_SESSION['keranjang']);
echo "</pre>";

if(empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"]))
{
    echo "<script>alert('keranjang kosong, silahkan belanja dulu');</script>";
    echo "<script>location='index.php';</script>";
}
?>
<html>
    <head>
        <title>Keranjang Belanja</title>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
$nomor = 1;

// Validasi isi keranjang dengan data di database
foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
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
    <td>
        <a href="hapuskeranjang.php?id=<?php echo $id_produk?>" class="btn btn-danger btn-xs">Hapus</a>
</tr>
<?php $nomor++; ?>
<?php } ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-default">Lanjutkan Belanja</a>
        <a href="checkout.php" class="btn btn-primary">Checkout</a>
    </div>
</section>
</body>
</html>
