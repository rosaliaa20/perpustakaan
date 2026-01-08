<?php
session_start();
include 'includes/db.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    
    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        
        // Simpan data ke Session
        $_SESSION['status'] = "login";
        $_SESSION['nama']   = $data['nama_lengkap'];
        $_SESSION['level']  = $data['level']; 
        
        // REDIRECT BERDASARKAN LEVEL
        if ($_SESSION['level'] == 'admin') {
            header("location: dashboard.php"); // Admin ke Monitoring
        } else {
            header("location: menu.php");      // User ke Portal Menu
        }
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Petugas - Perpus Insight</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-soft" style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <div class="card" style="width: 350px; padding: 40px;">
        <h2 style="text-align: center; color: var(--primary); margin-bottom: 20px;">Masuk ke Sistem</h2>
        <?php if(isset($error)) echo "<p style='color:var(--danger); text-align:center; font-size:13px;'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Masuk</button>
        </form>
        <p style="text-align: center; font-size: 12px; color: #64748b; margin-top: 20px;">Perpustakaan Soekarno-Hatta</p>
    </div>
</body>
</html>