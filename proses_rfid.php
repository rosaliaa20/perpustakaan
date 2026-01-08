<?php
include 'includes/db.php';

if (isset($_POST['rfid_uid'])) {
    $uid = mysqli_real_escape_string($conn, $_POST['rfid_uid']);
    $query = mysqli_query($conn, "SELECT * FROM anggota WHERE rfid_uid = '$uid'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $nama = $data['nama'];
        mysqli_query($conn, "INSERT INTO kunjungan (nama, status, kategori) VALUES ('$nama', 'Anggota', 'Anggota Tetap')");
        echo "<script>alert('Selamat Datang, $nama!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Kartu Tidak Dikenali! Silakan hubungi petugas.'); window.location='index.php';</script>";
    }
}
?>