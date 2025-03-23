<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "tokoaura");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - TOKO AURA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Base URL -->
    <base href="http://localhost/TOKO_AURA/admin/">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    
    <!-- CSS Dependencies -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form role="form" method="post">
                    <span class="login100-form-title p-b-49">Login</span>

                  

<!-- Tambahkan logo di bawah tulisan Login -->
<div class="text-center p-b-20">
    <img src="Logo_Toko.jpg" alt="Logo" style="width: 150px; height: auto;">
</div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Username is required">
                        <span class="label-input100">Username</span>
                        <input class="input100" type="text" name="user" placeholder="Type your username">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="pass" placeholder="Type your password">
                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

                    <div class="text-right p-t-8 p-b-31">
                        <a href="#">Forgot password?</a>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit" name="login">Login</button>
                        </div>
                    </div>
                </form>

                <?php
                if (isset($_POST['login'])) {
                    $username = $_POST['user'];
                    $password = $_POST['pass'];

                   
                    $ambil = $koneksi->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");
                    $yangcocok = $ambil->num_rows;

                    if ($yangcocok == 1) {
                        $_SESSION['admin'] = $ambil->fetch_assoc();
                        echo "<div class='alert alert-info'>Login Sukses</div>";
                        echo "<meta http-equiv='refresh' content='1;url=index.php'>";
                    } else {
                        echo "<div class='alert alert-danger'>Login Gagal</div>";
                        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>
    
    <!-- JavaScript Dependencies -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>