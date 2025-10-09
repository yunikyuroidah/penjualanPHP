<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    session_start();
    // cek apakah yang mengakses halaman ini sudah login
    if($_SESSION['level']==""){
        header("location:index.php");
    }
    ?>
    
    <div class="container">
        <div class="header">
            <div class="welcome-text">
                <i class="fas fa-user"></i>
                Selamat Datang, <strong><?php echo $_SESSION['username']; ?></strong>!
                <span style="color: #667eea; font-size: 14px;">(Pegawai)</span>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>

        <h1><i class="fas fa-cash-register"></i> Dashboard Pegawai</h1>

        <div class="card">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                
                <!-- Menu Transaksi -->
                <div style="background: linear-gradient(45deg, #4facfe, #00f2fe); padding: 40px; border-radius: 20px; text-align: center; color: white; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);">
                    <i class="fas fa-shopping-cart" style="font-size: 64px; margin-bottom: 20px;"></i>
                    <h2 style="margin-bottom: 15px;">Transaksi Penjualan</h2>
                    <p style="margin-bottom: 25px; opacity: 0.9; font-size: 16px;">Buat transaksi penjualan baru dan kelola data transaksi</p>
                    <div>
                        <a href="transaksi/index.php" class="btn btn-primary" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin: 8px; font-size: 16px; padding: 15px 25px;">
                            <i class="fas fa-plus"></i> Transaksi Baru
                        </a>
                        <a href="transaksi/view.php" class="btn btn-primary" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin: 8px; font-size: 16px; padding: 15px 25px;">
                            <i class="fas fa-list"></i> Lihat Transaksi
                        </a>
                    </div>
                </div>

                <!-- Info Ringkas -->
                <div style="background: linear-gradient(45deg, #667eea, #764ba2); padding: 40px; border-radius: 20px; text-align: center; color: white; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
                    <i class="fas fa-chart-line" style="font-size: 64px; margin-bottom: 20px;"></i>
                    <h2 style="margin-bottom: 15px;">Aktivitas Hari Ini</h2>
                    <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px; margin-top: 20px;">
                        <div style="font-size: 36px; font-weight: bold; margin-bottom: 10px;">
                            <?php
                            include 'koneksi.php';
                            $today = date('Y-m-d');
                            // Karena tidak ada kolom tanggal di tabel transaksi, kita tampilkan total transaksi
                            $query_today = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi");
                            $data_today = mysqli_fetch_assoc($query_today);
                            echo $data_today['total'];
                            ?>
                        </div>
                        <div style="opacity: 0.9;">Total Transaksi</div>
                    </div>
                </div>

            </div>

            <!-- Tips Untuk Pegawai -->
            <div style="background: linear-gradient(45deg, #56ab2f, #a8e6cf); padding: 25px; border-radius: 15px; margin-top: 30px; color: white;">
                <h3 style="margin-bottom: 15px;">
                    <i class="fas fa-lightbulb"></i> Tips Penggunaan Sistem
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                    <div>
                        <i class="fas fa-check-circle"></i>
                        <strong>Transaksi Baru:</strong> Klik "Transaksi Baru" untuk membuat transaksi penjualan
                    </div>
                    <div>
                        <i class="fas fa-check-circle"></i>
                        <strong>Lihat Data:</strong> Gunakan "Lihat Transaksi" untuk melihat riwayat penjualan
                    </div>
                    <div>
                        <i class="fas fa-check-circle"></i>
                        <strong>Pencarian:</strong> Manfaatkan fitur pencarian untuk menemukan data dengan cepat
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

