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
    <style>
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .summary-card {
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            color: white;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        .summary-card i {
            font-size: 32px;
            margin-bottom: 5px;
        }
        .summary-card.gradient-blue { background: linear-gradient(45deg, #4facfe, #00f2fe); }
        .summary-card.gradient-green { background: linear-gradient(45deg, #56ab2f, #a8e6cf); }
        .summary-card.gradient-pink { background: linear-gradient(45deg, #f093fb, #f5576c); }
        .report-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .report-card {
            background: #fff;
            border: 1px solid #e0e7ff;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            transition: box-shadow 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }
        .report-card i {
            font-size: 32px;
            color: #667eea;
        }
        .report-card p {
            margin: 0;
            color: #555;
            line-height: 1.5;
        }
        .report-card button {
            width: 100%;
        }
        .report-card.active {
            border-color: #667eea;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
        }
        .print-only { display: none; }
        @media print {
            body { background: #fff; color: #000; }
            .container { box-shadow: none; }
            .header, #nav, .logout-btn { display: none !important; }
            .card { box-shadow: none; border: none; padding: 0; }
            .summary-card {
                background: #fff !important;
                color: #000 !important;
                border: 1px solid #ccc;
                box-shadow: none;
            }
            .summary-card i { color: #000 !important; }
            .report-card {
                border: 1px solid #ccc;
                box-shadow: none;
                transform: none !important;
            }
            .report-card i { color: #000; }
            .report-card button { display: none !important; }
            .report-selector { gap: 12px; }
            .table-container { box-shadow: none; margin-bottom: 25px; page-break-inside: avoid; }
            table { border-collapse: collapse; }
            table th, table td {
                border: 1px solid #444 !important;
                color: #000 !important;
                padding: 8px !important;
            }
            .btn { display: none !important; }
            .print-only { display: block; margin-bottom: 20px; font-size: 14px; color: #555; }
        }
    </style>
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
        </div>

        <h1><i class="fas fa-chart-bar"></i> Laporan Rekap Penjualan</h1>
        <div class="print-only">
            Dicetak pada: <?php echo date('d F Y H:i'); ?> WIB
        </div>

        <div class="card">
            <!-- Summary Cards -->
            <div class="summary-grid">
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
                
                <div class="summary-card gradient-blue">
                    <i class="fas fa-box"></i>
                    <h3 style="margin: 0; font-size: 24px;"><?php echo $barang_count; ?></h3>
                    <p style="margin: 0; opacity: 0.9;">Total Barang</p>
                </div>

                <div class="summary-card gradient-green">
                    <i class="fas fa-shopping-cart"></i>
                    <h3 style="margin: 0; font-size: 24px;"><?php echo $transaksi_count; ?></h3>
                    <p style="margin: 0; opacity: 0.9;">Total Transaksi</p>
                </div>

                <div class="summary-card gradient-pink">
                    <i class="fas fa-money-bill-wave"></i>
                    <h3 style="margin: 0; font-size: 18px;">Rp <?php echo number_format($revenue, 0, ',', '.'); ?></h3>
                    <p style="margin: 0; opacity: 0.9;">Total Pendapatan</p>
                </div>
            </div>

            <!-- Filter Options -->
            <div style="background: #f8f9fa; padding: 25px; border-radius: 15px; margin-bottom: 30px;">
                <h3 style="margin-bottom: 10px; color: #667eea; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-filter"></i> Pilih Jenis Laporan
                </h3>
                <p style="margin: 0; color: #555;">Pilih tampilan data yang diinginkan untuk menganalisis performa penjualan.</p>
                <div class="report-selector">
                    <div class="report-card" id="card-inner">
                        <i class="fas fa-link"></i>
                        <div>
                            <strong>Inner Join</strong>
                            <p>Menampilkan barang yang sudah terjual lengkap dengan jumlah dan total penjualannya.</p>
                        </div>
                        <button type="button" onclick="showReport('inner', 'card-inner')" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Tampilkan Laporan
                        </button>
                    </div>
                    <div class="report-card" id="card-left">
                        <i class="fas fa-list"></i>
                        <div>
                            <strong>Left Join</strong>
                            <p>Daftar seluruh barang, termasuk status apakah sudah memiliki transaksi atau belum.</p>
                        </div>
                        <button type="button" onclick="showReport('left', 'card-left')" class="btn btn-success">
                            <i class="fas fa-eye"></i> Tampilkan Laporan
                        </button>
                    </div>
                    <div class="report-card" id="card-right">
                        <i class="fas fa-exchange-alt"></i>
                        <div>
                            <strong>Right Join</strong>
                            <p>Menampilkan semua transaksi terbaru beserta nilai total dan kuantitasnya.</p>
                        </div>
                        <button type="button" onclick="showReport('right', 'card-right')" class="btn btn-warning">
                            <i class="fas fa-eye"></i> Tampilkan Laporan
                        </button>
                    </div>
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
                <button type="button" onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Print Laporan
                </button>
            </div>
        </div>
    </div>

    <script>
        function showReport(type, cardId) {
            // Hide all reports
            document.getElementById('inner-report').style.display = 'none';
            document.getElementById('left-report').style.display = 'none';
            document.getElementById('right-report').style.display = 'none';
            
            // Show selected report
            document.getElementById(type + '-report').style.display = 'block';
            
            // Update card highlighting
            const cards = document.querySelectorAll('.report-card');
            cards.forEach(card => card.classList.remove('active'));
            if (cardId) {
                const activeCard = document.getElementById(cardId);
                if (activeCard) {
                    activeCard.classList.add('active');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            showReport('inner', 'card-inner');
        });
    </script>
</body>
</html>
