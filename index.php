<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-title">
                <i class="fas fa-shopping-cart" style="margin-right: 10px; color: #667eea;"></i>
                Sistem Penjualan
            </div>
            
            <?php 
            if(isset($_GET['pesan'])){
                if($_GET['pesan']=="gagal"){
                    echo "<div class='alert alert-danger'>
                            <i class='fas fa-exclamation-circle'></i> 
                            Username dan Password tidak sesuai!
                          </div>";
                }
            }
            ?>
            
            <form action="cek_login.php" method="post" name="login">
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
                    <button type="submit" name="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                    <button type="reset" name="reset" class="btn btn-warning" style="width: 100%;">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
            
            <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="color: #666;">Belum punya akun? 
                    <a href='registrasi.php' style="color: #667eea; font-weight: 600; text-decoration: none;">
                        Daftar Sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
