<?php
include 'includes/db.php';

if (isset($_POST['kat'])) {
    $kategori = mysqli_real_escape_string($conn, $_POST['kat']);
    $nama = "Pengunjung " . $kategori;
    
    mysqli_query($conn, "INSERT INTO kunjungan (nama, status, kategori) VALUES ('$nama', 'Non-Anggota', '$kategori')");
    echo "<script>alert('Kunjungan Berhasil Tercatat!'); window.location='index.php';</script>";
}
?>