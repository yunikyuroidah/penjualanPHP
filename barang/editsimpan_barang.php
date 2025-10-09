<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();
?>
<?php 
// koneksi database
require "../koneksi.php";
 
// menangkap data yang di kirim dari form
$id_barang = $_GET ['id_barang'];
$nama_barang = $_GET['nama_barang'];
$harga_barang = $_GET['harga_barang'];  

// update data ke database
$query = "UPDATE barang set nama_barang='$nama_barang', harga_barang='$harga_barang' where id_barang='$id_barang'";

if (mysqli_query($conn, $query)) {
    echo "Data Berhasil Di Update";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
 
// mengalihkan halaman kembali ke view.php
header("location:view_barang.php");
 
?>


