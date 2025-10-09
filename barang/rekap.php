<?php
session_start();
include("../koneksi.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap - Sistem Penjualan</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome-text">
                <i class="fas fa-user"></i>
                Selamat Datang, <strong><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></strong>!
            </div>
            <a href="../logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>

        <div id="nav">
            <a href="../transaksi/index.php"><i class="fas fa-shopping-cart"></i> Form Transaksi</a>
            <a href="input_barang.php"><i class="fas fa-box"></i> Form Barang</a>
            <a href="view_barang.php"><i class="fas fa-list"></i> Data Barang</a>
        </div>

        <h1><i class="fas fa-chart-bar"></i> Laporan Rekap Penjualan</h1>

        <div class="card">
            <!-- Summary Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <?php
                // Total Barang
                $total_barang = mysqli_query($conn, "SELECT COUNT(*) as count FROM barang");
                $barang_count = mysqli_fetch_assoc($total_barang)['count'];
                
                // Total Transaksi
                $total_transaksi = mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi");
                $transaksi_count = mysqli_fetch_assoc($total_transaksi)['count'];
                
                // Total Revenue
                $total_revenue = mysqli_query($conn, "SELECT SUM(total) as revenue FROM transaksi");
                $revenue = mysqli_fetch_assoc($total_revenue)['revenue'] ?? 0;
                ?>
                
                <div style="background: linear-gradient(45deg, #4facfe, #00f2fe); padding: 20px; border-radius: 15px; text-align: center; color: white;">
                    <i class="fas fa-box" style="font-size: 32px; margin-bottom: 10px;"></i>
                    <h3 style="margin: 0; font-size: 24px;"><?php echo $barang_count; ?></h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Barang</p>
                </div>

                <div style="background: linear-gradient(45deg, #56ab2f, #a8e6cf); padding: 20px; border-radius: 15px; text-align: center; color: white;">
                    <i class="fas fa-shopping-cart" style="font-size: 32px; margin-bottom: 10px;"></i>
                    <h3 style="margin: 0; font-size: 24px;"><?php echo $transaksi_count; ?></h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Transaksi</p>
                </div>

                <div style="background: linear-gradient(45deg, #f093fb, #f5576c); padding: 20px; border-radius: 15px; text-align: center; color: white;">
                    <i class="fas fa-money-bill-wave" style="font-size: 32px; margin-bottom: 10px;"></i>
                    <h3 style="margin: 0; font-size: 18px;">Rp <?php echo number_format($revenue, 0, ',', '.'); ?></h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Pendapatan</p>
                </div>
            </div>

            <!-- Filter Options -->
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                <h3 style="margin-bottom: 15px; color: #667eea;">
                    <i class="fas fa-filter"></i> Pilih Jenis Laporan
                </h3>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <button onclick="showReport('inner')" class="btn btn-primary" style="font-size: 14px;">
                        <i class="fas fa-link"></i> Inner Join (Barang Terjual)
                    </button>
                    <button onclick="showReport('left')" class="btn btn-success" style="font-size: 14px;">
                        <i class="fas fa-list"></i> Left Join (Semua Barang)
                    </button>
                    <button onclick="showReport('right')" class="btn btn-warning" style="font-size: 14px;">
                        <i class="fas fa-exchange-alt"></i> Right Join (Semua Transaksi)
                    </button>
                </div>
            </div>

            <!-- Tables -->
            <div class="table-container">
                <!-- Inner Join Table -->
                <div id="inner-report">
                    <h3 style="color: #667eea; margin-bottom: 15px;">
                        <i class="fas fa-chart-line"></i> Barang yang Sudah Terjual (Inner Join)
                    </h3>
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID Barang</th>
                                <th><i class="fas fa-tag"></i> Nama Barang</th>
                                <th><i class="fas fa-money-bill-wave"></i> Harga Barang</th>
                                <th><i class="fas fa-chart-bar"></i> Total Penjualan</th>
                                <th><i class="fas fa-sort-numeric-up"></i> Qty Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_inner = "SELECT barang.id_barang, barang.nama_barang, barang.harga_barang, 
                                         COALESCE(SUM(transaksi.subtotal), 0) AS total_penjualan,
                                         COALESCE(SUM(transaksi.jumlah), 0) AS qty_terjual
                                         FROM barang 
                                         INNER JOIN transaksi ON barang.nama_barang = transaksi.nama_barang
                                         GROUP BY barang.id_barang, barang.nama_barang, barang.harga_barang
                                         ORDER BY total_penjualan DESC";
                            $result_inner = $conn->query($sql_inner);
                            
                            if ($result_inner && $result_inner->num_rows > 0) {
                                while ($row = $result_inner->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['id_barang']."</td>";
                                    echo "<td>".htmlspecialchars($row['nama_barang'])."</td>";
                                    echo "<td>Rp ".number_format($row['harga_barang'], 0, ',', '.')."</td>";
                                    echo "<td><strong>Rp ".number_format($row['total_penjualan'], 0, ',', '.')."</strong></td>";
                                    echo "<td>".$row['qty_terjual']." pcs</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='text-align: center; color: #999;'>
                                        <i class='fas fa-inbox' style='font-size: 24px; display: block; margin-bottom: 10px;'></i>
                                        Belum ada barang yang terjual
                                      </td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Left Join Table -->
                <div id="left-report" style="display: none;">
                    <h3 style="color: #667eea; margin-bottom: 15px;">
                        <i class="fas fa-boxes"></i> Semua Barang (Left Join)
                    </h3>
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID Barang</th>
                                <th><i class="fas fa-tag"></i> Nama Barang</th>
                                <th><i class="fas fa-money-bill-wave"></i> Harga Barang</th>
                                <th><i class="fas fa-chart-bar"></i> Total Penjualan</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_left = "SELECT barang.id_barang, barang.nama_barang, barang.harga_barang, 
                                        COALESCE(SUM(transaksi.subtotal), 0) AS total_penjualan
                                        FROM barang 
                                        LEFT JOIN transaksi ON barang.nama_barang = transaksi.nama_barang
                                        GROUP BY barang.id_barang, barang.nama_barang, barang.harga_barang
                                        ORDER BY total_penjualan DESC";
                            $result_left = $conn->query($sql_left);
                            
                            if ($result_left && $result_left->num_rows > 0) {
                                while ($row = $result_left->fetch_assoc()) {
                                    $status = $row['total_penjualan'] > 0 ? 'Terjual' : 'Belum Terjual';
                                    $status_class = $row['total_penjualan'] > 0 ? '#e7f3ff; color: #1976d2' : '#fff3e0; color: #f57c00';
                                    
                                    echo "<tr>";
                                    echo "<td>".$row['id_barang']."</td>";
                                    echo "<td>".htmlspecialchars($row['nama_barang'])."</td>";
                                    echo "<td>Rp ".number_format($row['harga_barang'], 0, ',', '.')."</td>";
                                    echo "<td>Rp ".number_format($row['total_penjualan'], 0, ',', '.')."</td>";
                                    echo "<td><span style='padding: 4px 12px; border-radius: 15px; font-size: 12px; font-weight: 500; background: ".$status_class.";'>".$status."</span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='text-align: center; color: #999;'>Tidak ada data barang</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Right Join Table -->
                <div id="right-report" style="display: none;">
                    <h3 style="color: #667eea; margin-bottom: 15px;">
                        <i class="fas fa-list-alt"></i> Semua Transaksi (Right Join)
                    </h3>
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-tag"></i> Nama Barang</th>
                                <th><i class="fas fa-money-bill-wave"></i> Harga</th>
                                <th><i class="fas fa-sort-numeric-up"></i> Qty</th>
                                <th><i class="fas fa-receipt"></i> Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_right = "SELECT transaksi.id, transaksi.nama_barang, transaksi.harga, 
                                         transaksi.jumlah, transaksi.total
                                         FROM barang 
                                         RIGHT JOIN transaksi ON barang.nama_barang = transaksi.nama_barang
                                         ORDER BY transaksi.id DESC";
                            $result_right = $conn->query($sql_right);
                            
                            if ($result_right && $result_right->num_rows > 0) {
                                while ($row = $result_right->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['id']."</td>";
                                    echo "<td>".htmlspecialchars($row['nama_barang'])."</td>";
                                    echo "<td>Rp ".number_format($row['harga'], 0, ',', '.')."</td>";
                                    echo "<td>".$row['jumlah']." pcs</td>";
                                    echo "<td><strong>Rp ".number_format($row['total'], 0, ',', '.')."</strong></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='text-align: center; color: #999;'>Tidak ada data transaksi</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Actions -->
            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <a href="view_barang.php" class="btn btn-primary" style="margin-right: 15px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Data Barang
                </a>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Print Laporan
                </button>
            </div>
        </div>
    </div>

    <script>
        function showReport(type) {
            // Hide all reports
            document.getElementById('inner-report').style.display = 'none';
            document.getElementById('left-report').style.display = 'none';
            document.getElementById('right-report').style.display = 'none';
            
            // Show selected report
            document.getElementById(type + '-report').style.display = 'block';
            
            // Update button styles
            const buttons = document.querySelectorAll('button[onclick^="showReport"]');
            buttons.forEach(btn => {
                btn.style.opacity = '0.7';
                btn.style.transform = 'none';
            });
            
            event.target.style.opacity = '1';
            event.target.style.transform = 'translateY(-2px)';
        }
    </script>
</body>
</html>
