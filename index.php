<?php
session_start();
$koneksi = new mysqli("localhost","root","","tokoaura");

if (!isset($_SESSION['admin']))
{
    echo "<script>alert('Anda harus login');</script>";
    echo "<script>location='login.php';</script>";
    header('location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Admin</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <script>
    $(document).ready(function() {
        $(".sidebar-collapse").removeClass("collapse").show();
    });
</script>

<style>
 /* Navbar Styling */
.navbar-default {
    background-color: #1a1a2e; /* Biru tua */
    border-color: #1a1a2e;
}
.navbar-default .navbar-brand {
    color: #e94560; /* Merah muda */
    font-weight: bold;
    font-size: 20px;
    display: flex;
    align-items: center;
    text-decoration: none; /* Hilangkan underline */
}

.navbar-default .navbar-brand img {
    width: 40px; /* Ukuran logo navbar */
    height: 40px;
    margin-right: 10px;
    border-radius: 50%; /* Membuat logo menjadi bulat */
    border: 2px solid #fff; /* Border putih */
    object-fit: cover; /* Pastikan gambar tidak terdistorsi */
}

.navbar-default .navbar-brand:hover {
    color: #f8f9fa; /* Putih */
    text-decoration: none;
}

/* Sidebar Styling */
.sidebar-collapse {
    background-color: #343a40; /* Warna latar belakang sidebar */
    width: 250px; /* Lebar sidebar */
    min-height: 100vh; /* Sidebar penuh tinggi layar */
    position: fixed; /* Sidebar tetap */
    top: 0;
    left: 0;
    overflow-y: auto; /* Scroll jika menu panjang */
}

/* Mengatur tampilan menu di dalam sidebar */
.sidebar-collapse ul.nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-collapse ul.nav li {
    padding: 10px 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    m
}

/* Styling untuk logo di sidebar */
.sidebar-collapse .user-image {
    width: 150px; /* Ukuran logo di sidebar */
    height: 150px;
    border-radius: 50%; /* Bulatkan */
    border: 3px solid #fff; /* Tambahkan border */
    display: block;
    margin: 20px auto; /* Tengah */
    object-fit: cover; /* Tidak terdistorsi */
}

/* Styling untuk link menu */
.sidebar-collapse ul.nav li a {
    
    font-weight: bold;
    padding: 10px 15px;
    display: block;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s; /* Efek hover */
}

/* Efek hover */
.sidebar-collapse ul.nav li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffffff;
}

/* Jika sidebar menghilang di layar kecil, tampilkan kembali */
@media (max-width: 768px) {
    .sidebar-collapse {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        z-index: 999;
    }
}

/* Page Content Styling */
#page-wrapper {
    background-color: rgba(248, 249, 250, 0.29); /* Abu-abu terang */
    padding: 20px;
    border-radius: 5px;
}
#page-inner {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Footer Styling */
footer {
    text-align: center;
    padding: 10px;
    background-color: #1a1a2e; /* Biru tua */
    color: rgba(248, 249, 250, 0.24); /* Putih */
    margin-top: 20px;
}

</style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="n<a class="navbar-brand" href="#"> <img src="Logo_Toko.jpg" style="width: 40px; height: 40px; margin-right: 10px; border-radius: 50%; border: 2px solid #fff; object-fit: cover;"> Admin Aura Store</a>avbar-brand" > Admin Aura Store</a>
 
     
</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Last access : 30 May 2014 &nbsp; <a href="index.php?halaman=logout.php" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="Logo_Toko.jpg" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a class="active-menu"  href="index.php"><i class="fa fa-dashboard fa-3x"></i> Home</a>
                    </li>
                     <li>
                        <a  href="index.php?halaman=produk"><i class="fa fa-desktop fa-3x"></i> produk</a>
                    </li>
                    <li>
                        <a  href="index.php?halaman=pelanggan"><i class="fa fa-qrcode fa-3x"></i>pelanggan</a>
                    </li>
						   <li  >
                        <a   href="index.php?halaman=pembelian"><i class="fa fa-bar-chart-o fa-3x"></i>pembelian</a>
                    </li>	
                      <li  >
                        <a  href="index.php?halaman=karyawan"><i class="fa fa-table fa-3x"></i>karyawan</a>
                    </li>
                    <li  >
                        <a  href="index.php?halaman=logout"><i class="fa fa-edit fa-3x"></i> logout </a>
                    </li>				
					
					                   
                
                                  

                         
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <?php
                if (isset($_GET['halaman']))
                {
                if ($_GET['halaman']=="produk")
                {
                    include 'produk.php';
                }
                elseif ($_GET['halaman']=="pelanggan")
                {
                    include 'pelanggan.php';
                }
                elseif ($_GET['halaman']=="pembelian")
                {
                    include 'pembelian.php';
                }
                elseif ($_GET['halaman']=="detail")
                {
                    include 'detail.php';
                }
                elseif ($_GET['halaman']=="karyawan")
                {
                    include 'karyawan.php';
                }
                elseif ($_GET['halaman']=="tambahproduk")
                {
                    include 'tambahproduk.php';
                }
                elseif ($_GET['halaman']=="tambahpelanggan")
                {
                    include 'tambahpelanggan.php';
                }
                elseif ($_GET['halaman']=="hapusproduk")
                {
                    include 'hapusproduk.php';
                }
                elseif ($_GET['halaman']=="ubahproduk")
                {
                    include 'ubahproduk.php';
                }
                elseif ($_GET['halaman']=="logout")
                {
                    include 'logout.php';
                }
                elseif ($_GET['halaman']=="hapuspelanggan")
                {
                    include 'hapuspelanggan.php';
                }
                }
                else 
                {
                    include 'home.php';
                }
             
               ?>
               
              
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js" defer></script>
<script src="assets/js/bootstrap.min.js" defer></script>
<script src="assets/js/jquery.metisMenu.js" defer></script>
<script src="assets/js/morris/raphael-2.1.0.min.js" defer></script>
<script src="assets/js/morris/morris.js" defer></script>
<script src="assets/js/custom.js" defer></script>
   
</body>
</html>
