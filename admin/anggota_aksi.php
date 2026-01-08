<?php
include '../includes/db.php';
$act = $_GET['act'];

if ($act == "tambah") {
    $uid = $_POST['rfid_uid'];
    $nama = $_POST['nama'];
    $instansi = $_POST['instansi'];
    mysqli_query($conn, "INSERT INTO anggota (rfid_uid, nama, instansi) VALUES ('$uid', '$nama', '$instansi')");
    header("location: anggota_list.php");

} elseif ($act == "edit") {
    $id = $_POST['id'];
    $uid = $_POST['rfid_uid'];
    $nama = $_POST['nama'];
    $instansi = $_POST['instansi'];
    mysqli_query($conn, "UPDATE anggota SET rfid_uid='$uid', nama='$nama', instansi='$instansi' WHERE id='$id'");
    header("location: anggota_list.php");

} elseif ($act == "hapus") {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM anggota WHERE id='$id'");
    header("location: anggota_list.php");
}
?>