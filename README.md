# PenjualanPHP

Proyek ini merupakan sistem penjualan sederhana berbasis **PHP dan MySQL** yang dijalankan menggunakan **Laragon** sebagai local server environment.

---

## 🧰 Teknologi yang digunakan
- **PHP** (Native)
- **MySQL Database**
- **Laragon** (Apache + PHPMyAdmin)
- **HTML, CSS**

---

## 📸 Tampilan Aplikasi
Berikut beberapa tampilan dari sistem yang dijalankan secara lokal menggunakan Laragon:

| No | Tampilan | Gambar |
|----|-----------|--------|
| 1 | Halaman Login | ![Login](https://github.com/yunikyuroidah/penjualanPHP/blob/87e3f1068b9bf26dd576a03c78b06caacda824d6/login.png) |
| 2 | Halaman Dashboard | ![Dashboard](https://github.com/yunikyuroidah/penjualanPHP/blob/dc4605373664667aec65908721ff80df7ef81479/dashboard.png) |
| 3 | Halaman Transaksi | ![Transaksi1](https://github.com/yunikyuroidah/penjualanPHP/blob/674c1116d3a00fa68d4d34b2a25ccdfb199869ec/Transaksi1.png)<br>![Transaksi2](https://github.com/yunikyuroidah/penjualanPHP/blob/674c1116d3a00fa68d4d34b2a25ccdfb199869ec/Transaksi2.png) |
| 4 | Halaman Barang | ![Barang1](https://github.com/yunikyuroidah/penjualanPHP/blob/674c1116d3a00fa68d4d34b2a25ccdfb199869ec/barang1.png)<br>![Barang2](https://github.com/yunikyuroidah/penjualanPHP/blob/674c1116d3a00fa68d4d34b2a25ccdfb199869ec/barang2.png) |
| 5 | Halaman Laporan | ![Laporan](https://github.com/yunikyuroidah/penjualanPHP/blob/674c1116d3a00fa68d4d34b2a25ccdfb199869ec/laporan.png) |

- Metode: pembagian (modulus 5) — nama barang di-hash berdasarkan nilai ASCII dan dimasukkan ke dalam 5 bucket.
- Penggunaan: logika hash dipakai sebagai helper untuk lookup cepat di halaman transaksi dan manajemen barang. UI hanya menampilkan hasil pencarian (tanpa menyebut istilah "hash table"), sementara implementasi hash berada di sisi server.
