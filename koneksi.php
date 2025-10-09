<?php
$servername	= "localhost";	// host atau IP
$username	= "root";		// nama penggua
$password	= "";			// password login
$database	= "penjualan";		// database yang digunakan ketika melakukan query
$port = 3306;
// buat koneksi
$conn = mysqli_connect($servername, $username, $password, $database, $port);
// cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_error());
}
?>
