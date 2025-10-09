<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();

require "../koneksi.php";

$nama_barang = $_POST['nama_barang'];  
$harga = $_POST['harga'];  
$jumlah = $_POST['jumlah'];  
$status = $_POST['status'];  
$kota = $_POST['kota'];

$subtotal = $harga * $jumlah;  
  
switch ($status){  
 case "Pelanggan":   
  $diskon = $subtotal * 0.1;  
 break;   
 default:   
  $diskon = 0;   
}  

// Ongkos kirim berdasarkan kota
$ongkos = 0;
switch($kota) {
    case "Jakarta":
        $ongkos = 20000;
        break;
    case "Bandung":
        $ongkos = 10000;
        break;
    case "Purwokerto":
        $ongkos = 30000;
        break;
    case "Surabaya":
        $ongkos = 25000;
        break;
    case "Yogyakarta":
        $ongkos = 15000;
        break;
    case "Semarang":
        $ongkos = 18000;
        break;
    default:
        $ongkos = 20000;
}

$total = $subtotal - $diskon + $ongkos; 

$sql = "INSERT INTO transaksi (nama_barang, harga, jumlah, subtotal, Status, kota, diskon, ongkos, total)
        VALUES ('$nama_barang', '$harga', '$jumlah', '$subtotal', '$status', '$kota', '$diskon', '$ongkos', '$total')";

$success = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Transaksi - Sistem Penjualan</title>
    <link rel="stylesheet" href="../style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome-text">
                <i class="fas fa-user"></i>
                Selamat Datang, <strong><?php echo $_SESSION['username']; ?></strong>!
            </div>
            <a href="../logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>

        <div id="nav">
            <a href="index.php"><i class="fas fa-shopping-cart"></i> Form Transaksi</a>
            <a href="../barang/input_barang.php"><i class="fas fa-box"></i> Form Barang</a>
            <a href="view.php"><i class="fas fa-list"></i> Lihat Transaksi</a>
        </div>

        <h1><i class="fas fa-receipt"></i> Hasil Transaksi</h1>

        <div class="card">
            <?php if($success): ?>
                <div class="alert alert-success" style="margin-bottom: 30px;">
                    <i class="fas fa-check-circle"></i>
                    <strong>Transaksi Berhasil!</strong> Data transaksi telah disimpan ke database.
                </div>
            <?php else: ?>
                <div class="alert alert-danger" style="margin-bottom: 30px;">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Transaksi Gagal!</strong> <?php echo mysqli_error($conn); ?>
                </div>
            <?php endif; ?>

            <!-- Receipt Style -->
            <div style="max-width: 500px; margin: 0 auto; background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden;">
                
                <!-- Header -->
                <div style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 25px; text-align: center;">
                    <h2 style="margin: 0; font-size: 24px;">
                        <i class="fas fa-receipt" style="margin-right: 10px;"></i>
                        STRUK TRANSAKSI
                    </h2>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">ID: TRX-<?php echo date('Ymd').'-'.time(); ?></p>
                </div>

                <!-- Content -->
                <div style="padding: 30px;">
                    <table style="width: 100%; border: none; background: transparent;">
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; font-weight: 600; color: #555;">
                                <i class="fas fa-tag" style="margin-right: 8px; color: #667eea;"></i>Nama Barang
                            </td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; text-align: right;">
                                <?php echo htmlspecialchars($nama_barang); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; font-weight: 600; color: #555;">
                                <i class="fas fa-money-bill-wave" style="margin-right: 8px; color: #667eea;"></i>Harga Satuan
                            </td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; text-align: right;">
                                Rp <?php echo number_format($harga, 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; font-weight: 600; color: #555;">
                                <i class="fas fa-sort-numeric-up" style="margin-right: 8px; color: #667eea;"></i>Quantity
                            </td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; text-align: right;">
                                <?php echo $jumlah; ?> pcs
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; font-weight: 600; color: #555;">
                                <i class="fas fa-calculator" style="margin-right: 8px; color: #667eea;"></i>Subtotal
                            </td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; text-align: right;">
                                Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; font-weight: 600; color: #555;">
                                <i class="fas fa-user-tag" style="margin-right: 8px; color: #667eea;"></i>Status
                            </td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; text-align: right;">
                                <span style="padding: 4px 12px; border-radius: 15px; font-size: 12px; font-weight: 500; 
                                      background: <?php echo $status == 'Pelanggan' ? '#e7f3ff' : '#fff3e0'; ?>; 
                                      color: <?php echo $status == 'Pelanggan' ? '#1976d2' : '#f57c00'; ?>;">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; font-weight: 600; color: #555;">
                                <i class="fas fa-percentage" style="margin-right: 8px; color: #667eea;"></i>Diskon
                            </td>
                            <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0; text-align: right; color: #e74c3c;">
                                - Rp <?php echo number_format($diskon, 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 2px solid #667eea; font-weight: 600; color: #555;">
                                <i class="fas fa-truck" style="margin-right: 8px; color: #667eea;"></i>Ongkir (<?php echo $kota; ?>)
                            </td>
                            <td style="padding: 12px 0; border-bottom: 2px solid #667eea; text-align: right;">
                                Rp <?php echo number_format($ongkos, 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px 0 10px 0; font-size: 18px; font-weight: bold; color: #667eea;">
                                <i class="fas fa-receipt" style="margin-right: 8px;"></i>TOTAL BAYAR
                            </td>
                            <td style="padding: 20px 0 10px 0; text-align: right; font-size: 20px; font-weight: bold; color: #667eea;">
                                Rp <?php echo number_format($total, 0, ',', '.'); ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <div style="background: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e9ecef;">
                    <p style="margin: 0; color: #666; font-size: 14px;">
                        <i class="fas fa-calendar-alt"></i> 
                        <?php echo date('d F Y, H:i:s'); ?>
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="index.php" class="btn btn-primary" style="margin-right: 15px;">
                    <i class="fas fa-plus"></i> Transaksi Baru
                </a>
                <a href="view.php" class="btn btn-success" style="margin-right: 15px;">
                    <i class="fas fa-list"></i> Lihat Semua Transaksi
                </a>
                <button onclick="window.print()" class="btn btn-warning">
                    <i class="fas fa-print"></i> Print Struk
                </button>
            </div>
        </div>
    </div>
</body>
</html>  