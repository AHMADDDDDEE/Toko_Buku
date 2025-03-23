<h2>Logout<h2>
<?php
session_destroy();
echo "<script>alert('Anda telah logout');</script>";
echo "<script>location='login.php';</script>";
?>