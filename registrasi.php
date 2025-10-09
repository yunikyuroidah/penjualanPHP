<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require('koneksi.php');
    // If form submitted, insert values into the database.
    if (isset($_REQUEST['username'])){
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($conn,$username); 
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn,$password);
        $level = stripslashes($_REQUEST['level']);
        $level = mysqli_real_escape_string($conn,$level);
        $nama = stripslashes($_REQUEST['nama']);
        $nama = mysqli_real_escape_string($conn,$nama);
        
        $query = "INSERT into `user` (nama, username, password, level) 
            VALUES ('$nama', '$username', '$password', '$level')";
        $result = mysqli_query($conn,$query);
        
        if($result){
    ?>
    <div class="login-container">
        <div class="login-card">
            <div class="login-title" style="color: #56ab2f;">
                <i class="fas fa-check-circle"></i>
                Registrasi Berhasil!
            </div>
            <div class="alert alert-success">
                <i class="fas fa-user-plus"></i> 
                Akun Anda telah berhasil didaftarkan dengan username: <strong><?php echo $username; ?></strong>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </a>
            </div>
        </div>
    </div>
    <?php
        } else {
    ?>
    <div class="login-container">
        <div class="login-card">
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> 
                Registrasi gagal! Silakan coba lagi.
            </div>
        </div>
    </div>
    <?php
        }
    } else {
    ?>
    <div class="login-container">
        <div class="login-card">
            <div class="login-title">
                <i class="fas fa-user-plus" style="margin-right: 10px; color: #667eea;"></i>
                Registrasi Akun Baru
            </div>
            
            <form name="registration" action="" method="post">
                <div class="form-group">
                    <label for="nama">
                        <i class="fas fa-id-card"></i> Nama Lengkap
                    </label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required />
                </div>

                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required />
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required />
                </div>

                <div class="form-group">
                    <label for="level">
                        <i class="fas fa-user-shield"></i> Level Akses
                    </label>
                    <select name="level" id="level" class="form-control" required>
                        <option value="">Pilih Level Akses</option>
                        <option value="admin">Administrator</option>
                        <option value="pegawai">Pegawai</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-user-plus"></i> Daftar Akun
                    </button>
                </div>
            </form>

            <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="color: #666;">Sudah punya akun? 
                    <a href='index.php' style="color: #667eea; font-weight: 600; text-decoration: none;">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
    <?php } ?>
</body>
</html>
