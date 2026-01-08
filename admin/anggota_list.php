<?php include '../includes/cek_login.php'; include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Anggota</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .btn { padding: 8px 15px; text-decoration: none; border-radius: 5px; color: white; }
    </style>
</head>
<body>
    <h2>Manajemen Anggota</h2>
    <a href="anggota_add.php" class="btn" style="background: #27ae60;">+ Tambah Anggota</a>
    <a href="../dashboard.php" style="margin-left: 10px;">Kembali ke Dashboard</a>
    
    <table>
        <tr style="background: #eee;"><th>UID RFID</th><th>Nama</th><th>Instansi</th><th>Aksi</th></tr>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id DESC");
        while($r = mysqli_fetch_assoc($q)): ?>
        <tr>
            <td><?= $r['rfid_uid'] ?></td>
            <td><?= $r['nama'] ?></td>
            <td><?= $r['instansi'] ?></td>
            <td>
                <a href="anggota_aksi.php?act=hapus&id=<?= $r['id'] ?>" style="color:red" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>