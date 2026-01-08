<?php
include 'includes/db.php';

$periode = $_GET['periode'] ?? '';
$status  = $_GET['status'] ?? '';

$today = date('Y-m-d');

switch ($periode) {
    case 'harian':
        $from = $today;
        $to   = $today;
        break;

    case 'mingguan':
        $from = date('Y-m-d', strtotime('-6 days'));
        $to   = $today;
        break;

    case 'bulanan':
        $from = date('Y-m-01');
        $to   = date('Y-m-t');
        break;

    case 'tahunan':
        $from = date('Y-01-01');
        $to   = date('Y-12-31');
        break;

    case 'custom':
        $from = $_GET['from'];
        $to   = $_GET['to'];
        break;

    default:
        die("Periode tidak valid");
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Kunjungan_$from-$to.xls");

$sql = "SELECT * FROM kunjungan WHERE DATE(waktu_kunjungan) BETWEEN '$from' AND '$to'";
if ($status != "") {
    $sql .= " AND status = '$status'";
}
$sql .= " ORDER BY waktu_kunjungan DESC";

$data = mysqli_query($conn, $sql);
?>

<h3>LAPORAN KUNJUNGAN PERPUSTAKAAN SOEKARNO-HATTA</h3>
<p>Periode: <?= $from ?> s/d <?= $to ?></p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Waktu</th>
        <th>Nama</th>
        <th>Status</th>
        <th>Kategori</th>
    </tr>
    <?php $no=1; while($d = mysqli_fetch_assoc($data)): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['waktu_kunjungan'] ?></td>
        <td><?= $d['nama'] ?></td>
        <td><?= $d['status'] ?></td>
        <td><?= $d['kategori'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
