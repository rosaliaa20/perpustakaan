<?php include '../includes/cek_login.php'; ?>
<!DOCTYPE html>
<html>
<head><title>Tambah Anggota</title></head>
<body style="font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background: #f0f4f8;">
    <div style="background: white; padding: 30px; border-radius: 10px; width: 400px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3>Registrasi Kartu Baru</h3>
        <form action="anggota_aksi.php?act=tambah" method="POST">
            <label>UID RFID (Tap Kartu Sekarang):</label><br>
            <input type="text" name="rfid_uid" autofocus required style="width: 100%; padding: 10px; margin: 10px 0;"><br>
            <label>Nama Lengkap:</label><br>
            <input type="text" name="nama" required style="width: 100%; padding: 10px; margin: 10px 0;"><br>
            <label>Instansi:</label><br>
            <input type="text" name="instansi" required style="width: 100%; padding: 10px; margin: 20px 0;"><br>
            <button type="submit" style="width: 100%; padding: 10px; background: #27ae60; color: white; border: none; cursor: pointer;">Simpan Anggota</button>
        </form>
    </div>
</body>
</html>