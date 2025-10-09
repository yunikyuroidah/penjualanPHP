<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi - Sistem Penjualan</title>
    <link rel="stylesheet" href="../style.css"/>
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

        <h1><i class="fas fa-cash-register"></i> Form Transaksi Penjualan</h1>

        <div class="card">
            <div class="form-container">
                <form method="post" action="proses.php">
                    <div class="form-group">
                        <label for="nama_barang">
                            <i class="fas fa-tag"></i> Nama Barang
                        </label>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" required />
                    </div>

                    <div class="form-group">
                        <label for="harga">
                            <i class="fas fa-money-bill-wave"></i> Harga (Rp)
                        </label>
                        <input type="number" id="harga" name="harga" class="form-control" placeholder="Masukkan harga barang" required />
                    </div>

                    <div class="form-group">
                        <label for="jumlah">
                            <i class="fas fa-sort-numeric-up"></i> Jumlah (Quantity)
                        </label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Masukkan jumlah barang" required />
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-users"></i> Status Pelanggan
                        </label>
                        <div style="display: flex; gap: 20px; margin-top: 10px;">
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" name="status" value="Pelanggan" checked style="margin-right: 8px; transform: scale(1.2);" />
                                <span>Pelanggan</span>
                            </label>
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" name="status" value="Bukan pelanggan" style="margin-right: 8px; transform: scale(1.2);" />
                                <span>Bukan Pelanggan</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kota">
                            <i class="fas fa-map-marker-alt"></i> Kota Pengiriman
                        </label>
                        <select name="kota" id="kota" class="form-control" required>
                            <option value="">Pilih Kota Pengiriman</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Purwokerto">Purwokerto</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Yogyakarta">Yogyakarta</option>
                            <option value="Semarang">Semarang</option>
                        </select>
                    </div>

                    <div class="form-group" style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary" style="min-width: 150px;">
                            <i class="fas fa-save"></i> Proses Transaksi
                        </button>
                        <button type="reset" class="btn btn-warning" style="min-width: 150px;">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>

            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <a href="view.php" class="btn btn-success" style="min-width: 200px;">
                    <i class="fas fa-list-ul"></i> Lihat Data Transaksi
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto calculate subtotal when harga or jumlah changes
        document.getElementById('harga').addEventListener('input', calculateSubtotal);
        document.getElementById('jumlah').addEventListener('input', calculateSubtotal);

        function calculateSubtotal() {
            const harga = parseFloat(document.getElementById('harga').value) || 0;
            const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
            const subtotal = harga * jumlah;
            
            // You can add a subtotal display field if needed
            // document.getElementById('subtotal_display').textContent = 'Subtotal: Rp ' + subtotal.toLocaleString('id-ID');
        }
    </script>
</body>
</html>