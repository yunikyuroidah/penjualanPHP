<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();
?>
<html>
<head><title>Delete</title></head>
<body>
<?php require "../koneksi.php";
$id_barang = $_GET['id_barang'];

// sql to delete a record
$sql = "DELETE FROM barang WHERE id_barang='$id_barang'";

if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
// mengalihkan ke halaman index.php
header("location:view_barang.php");
?>
<br>
</body>  
</html>  
