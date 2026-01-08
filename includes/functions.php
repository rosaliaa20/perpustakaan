<?php
// Fungsi untuk memformat tanggal Indonesia
function tgl_indo($tanggal){
    $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

// Fungsi untuk membersihkan input agar aman dari SQL Injection
function clean($data, $conn) {
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}
?>