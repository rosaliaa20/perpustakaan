<?php 
include 'includes/cek_login.php'; 
include 'includes/db.php';

$tgl = isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d');

// Statistik
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM kunjungan"))['jml'];
$hari_ini = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM kunjungan WHERE DATE(waktu_kunjungan) = '$tgl'"))['jml'];

// Grafik per jam
$jam_labels = ['08','09','10','11','12','13','14','15','16'];
$jam_data = [];
foreach($jam_labels as $j){
    $q = mysqli_query($conn, "SELECT COUNT(*) as jml FROM kunjungan WHERE DATE(waktu_kunjungan)='$tgl' AND HOUR(waktu_kunjungan)='$j'");
    $jam_data[] = mysqli_fetch_assoc($q)['jml'];
}

// Pie
$q_pie = mysqli_query($conn, "SELECT status, COUNT(*) as jml FROM kunjungan WHERE DATE(waktu_kunjungan)='$tgl' GROUP BY status");
$pie = ['Anggota'=>0,'Non-Anggota'=>0];
while($r = mysqli_fetch_assoc($q_pie)){
    $pie[$r['status']] = $r['jml'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Perpustakaan</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-soft">

<div class="dash-header">
    <div class="brand">
        <h2>Dashboard Admin</h2>
        <span class="badge-library">Perpustakaan Soekarno-Hatta</span>
    </div>

    <nav class="dash-nav">
        <a href="dashboard.php" class="nav-link active">
            <span class="nav-icon">📊</span> Monitoring
        </a>
        <a href="survei_dashboard.php" class="nav-link">
            <span class="nav-icon">📝</span> Survei
        </a>
        <a href="admin/anggota_list.php" class="nav-link">
            <span class="nav-icon">👥</span> Anggota
        </a>
        <div class="nav-divider"></div>
        <a href="logout.php" class="nav-link logout">
            <span class="nav-icon">🚪</span> Logout
        </a>
    </nav>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <h4>Total Kunjungan</h4>
        <h1><?= $total ?></h1>
    </div>
    <div class="stat-card green">
        <h4>Kunjungan Hari Ini</h4>
        <h1><?= $hari_ini ?></h1>
    </div>
</div>

<div class="filter-box">
    <form method="GET">
        <label>Pilih Tanggal:</label>
        <input type="date" name="tgl" value="<?= $tgl ?>" onchange="this.form.submit()">
    </form>
</div>

<div class="chart-grid">
    <div class="card">
        <h3>Grafik Kunjungan per Jam</h3>
        <div style="height: 300px; position: relative;"> <canvas id="barChart"></canvas>
        </div>
    </div>
    <div class="card">
        <h3>Proporsi Pengunjung</h3>
        <div style="height: 300px; position: relative;"> <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>


<div class="card full">
    <h3>Log Kunjungan Terbaru</h3>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $log = mysqli_query($conn, "SELECT * FROM kunjungan WHERE DATE(waktu_kunjungan)='$tgl' ORDER BY waktu_kunjungan DESC LIMIT 8");
            while($l = mysqli_fetch_assoc($log)): ?>
            <tr>
                <td><?= date('H:i', strtotime($l['waktu_kunjungan'])) ?></td>
                <td><?= $l['nama'] ?></td>
                <td><?= $l['status'] ?></td>
                <td><?= $l['kategori'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <form action="export_excel.php" method="GET" class="export-form">
        <select name="periode" required>
            <option value="">-- Pilih Periode --</option>
            <option value="harian">Hari Ini</option>
            <option value="mingguan">Mingguan</option>
            <option value="bulanan">Bulanan</option>
            <option value="tahunan">Tahunan</option>
            <option value="custom">Custom</option>
        </select>
        <input type="date" name="from">
        <input type="date" name="to">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Anggota">Anggota</option>
            <option value="Non-Anggota">Non-Anggota</option>
        </select>
        <button type="submit" class="btn-success">Export Excel</button>
    </form>
</div>

<script>
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($jam_labels) ?>,
        datasets: [{
            label: 'Jumlah Pengunjung',
            data: <?= json_encode($jam_data) ?>,
            // Menggunakan array warna agar setiap bar punya warna berbeda/gradasi
            backgroundColor: [
                'rgba(79, 70, 229, 0.8)',
                'rgba(99, 102, 241, 0.8)',
                'rgba(129, 140, 248, 0.8)',
                'rgba(165, 180, 252, 0.8)',
                'rgba(79, 70, 229, 0.8)',
                'rgba(99, 102, 241, 0.8)',
                'rgba(129, 140, 248, 0.8)',
                'rgba(165, 180, 252, 0.8)',
                'rgba(79, 70, 229, 0.8)'
            ],
            borderColor: '#4f46e5',
            borderWidth: 1,
            borderRadius: 5 // Membuat ujung bar sedikit melengkung (rounded)
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false } // Sembunyikan label legend agar lebih clean
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// 2. Grafik Pie (Pie Chart)
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Anggota','Non-Anggota'],
        datasets: [{
            data: [<?= $pie['Anggota'] ?>, <?= $pie['Non-Anggota'] ?>],
            backgroundColor: ['#10b981','#f59e0b']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Memungkinkan pengecilan ukuran
        layout: {
            padding: 45 // Menambah jarak di dalam canvas agar pie chart terlihat mengecil
        },
        plugins: {
            legend: {
                position: 'bottom', // Pindah ke bawah agar visual pie chart lebih fokus
                labels: { boxWidth: 12, padding: 20 }
            }
        }
    }
});
</script>

</body>
</html>
