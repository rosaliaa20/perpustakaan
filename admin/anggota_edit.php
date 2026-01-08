<?php 
include '../includes/cek_login.php'; 
include '../includes/db.php';

$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM anggota WHERE id = '$id'");
$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 500px; margin-top: 50px;">
        <div class="card">
            <h3>Edit Data Anggota</h3>
            <form action="anggota_aksi.php?act=edit" method="POST">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <div class="form-group">
                    <label>UID RFID</label>
                    <input type="text" name="rfid_uid" class="form-control" value="<?= $data['rfid_uid'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Instansi</label>
                    <input type="text" name="instansi" class="form-control" value="<?= $data['instansi'] ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="anggota_list.php" class="btn" style="background:#ccc; color:black;">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>