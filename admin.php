<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    session_start();
    // Bagian untuk mengecek apakah yang mengakses halaman ini sudah login
    if($_SESSION['level']==""){
        header("location:index.php");
    }
    ?>
    
    <div class="container">
        <div class="header">
            <div class="welcome-text">
                <i class="fas fa-user-shield"></i>
                Selamat Datang, <strong><?php echo $_SESSION['username']; ?></strong>!
                <span style="color: #667eea; font-size: 14px;">(Administrator)</span>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>

        <h1><i class="fas fa-tachometer-alt"></i> Dashboard Administrator</h1>

        <div class="card">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                
                <!-- Menu Transaksi -->
                <div style="background: linear-gradient(45deg, #4facfe, #00f2fe); padding: 30px; border-radius: 15px; text-align: center; color: white; box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);">
                    <i class="fas fa-shopping-cart" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <h3 style="margin-bottom: 15px;">Kelola Transaksi</h3>
                    <p style="margin-bottom: 20px; opacity: 0.9;">Tambah, edit, dan lihat transaksi penjualan</p>
                    <div>
                        <a href="transaksi/index.php" class="btn btn-primary" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin: 5px;">
                            <i class="fas fa-plus"></i> Form Transaksi
                        </a>
                        <a href="transaksi/view.php" class="btn btn-primary" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin: 5px;">
                            <i class="fas fa-list"></i> Lihat Data
                        </a>
                    </div>
                </div>

                <!-- Menu Barang -->
                <div style="background: linear-gradient(45deg, #56ab2f, #a8e6cf); padding: 30px; border-radius: 15px; text-align: center; color: white; box-shadow: 0 8px 25px rgba(86, 171, 47, 0.3);">
                    <i class="fas fa-box" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <h3 style="margin-bottom: 15px;">Kelola Barang</h3>
                    <p style="margin-bottom: 20px; opacity: 0.9;">Tambah, edit, dan lihat data barang</p>
                    <div>
                        <a href="barang/input_barang.php" class="btn btn-success" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin: 5px;">
                            <i class="fas fa-plus"></i> Form Barang
                        </a>
                        <a href="barang/view_barang.php" class="btn btn-success" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin: 5px;">
                            <i class="fas fa-list"></i> Lihat Data
                        </a>
                    </div>
                </div>

                <!-- Menu Laporan -->
                <div style="background: linear-gradient(45deg, #f093fb, #f5576c); padding: 30px; border-radius: 15px; text-align: center; color: white; box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);">
                    <i class="fas fa-chart-bar" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <h3 style="margin-bottom: 15px;">Laporan</h3>
                    <p style="margin-bottom: 20px; opacity: 0.9;">Lihat laporan penjualan dan statistik</p>
                    <div>
                        <a href="barang/rekap.php" class="btn btn-warning" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin: 5px;">
                            <i class="fas fa-file-alt"></i> Rekap Data
                        </a>
                    </div>
                </div>

            </div>

            <!-- Statistik Singkat -->
            <div style="background: rgba(102, 126, 234, 0.1); padding: 20px; border-radius: 15px; margin-top: 20px;">
                <h3 style="color: #667eea; margin-bottom: 15px;">
                    <i class="fas fa-info-circle"></i> Informasi Sistem
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div style="text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #667eea;">
                            <?php
                            include 'koneksi.php';
                            $query_barang = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang");
                            $data_barang = mysqli_fetch_assoc($query_barang);
                            echo $data_barang['total'];
                            ?>
                        </div>
                        <div style="color: #666;">Total Barang</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #667eea;">
                            <?php
                            $query_transaksi = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi");
                            $data_transaksi = mysqli_fetch_assoc($query_transaksi);
                            echo $data_transaksi['total'];
                            ?>
                        </div>
                        <div style="color: #666;">Total Transaksi</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #667eea;">
                            <?php
                            $query_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM user");
                            $data_user = mysqli_fetch_assoc($query_user);
                            echo $data_user['total'];
                            ?>
                        </div>
                        <div style="color: #666;">Total User</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

