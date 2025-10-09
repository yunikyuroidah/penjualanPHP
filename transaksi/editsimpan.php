<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();
?>
<?php 
// koneksi database
require "../koneksi.php";
 
// menangkap data yang di kirim dari form
$id = $_GET ['id'];
$nama_barang = $_GET['nama_barang'];
$harga = $_GET['harga'];  
$jumlah = $_GET['jumlah'];  
$status = $_GET['status'];  
$ongkos = $_GET['ongkos']; 

// update data ke database
$query = "UPDATE transaksi set nama_barang='$nama_barang', harga='$harga', jumlah='$jumlah', status='$status', ongkos='$ongkos' where id='$id'";

if (mysqli_query($conn, $query)) {
    echo "Data Berhasil Di Update";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
 
// mengalihkan halaman kembali ke view.php
header("location:view.php");
 
?>


