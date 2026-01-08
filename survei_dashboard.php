<?php 
include 'includes/cek_login.php'; 
include 'includes/db.php';

// Mengambil tanggal dari filter, default hari ini
$tgl = isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d');

// --- LOGIKA STATISTIK ---

// 1. Hitung Rata-rata Rating (Handling Null untuk PHP 8+)
$q_avg = mysqli_query($conn, "SELECT AVG(rating) as rata FROM survei WHERE DATE(waktu_survei) = '$tgl'");
$data_avg = mysqli_fetch_assoc($q_avg);
$avg_rating = $data_avg['rata'] !== null ? round($data_avg['rata'], 1) : 0;

// 2. Rekap Jumlah per Rating (1-5)
$rekap_rating = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0];
$q_rekap = mysqli_query($conn, "SELECT rating, COUNT(*) as jml FROM survei WHERE DATE(waktu_survei) = '$tgl' GROUP BY rating");
while($r = mysqli_fetch_assoc($q_rekap)){
    $rekap_rating[$r['rating']] = (int)$r['jml'];
}

// 3. Total Responden
$total_survei = array_sum($rekap_rating);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Survei - Perpus Insight</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-soft">

    <div class="dash-header">
        <div class="brand">
            <h2>Perpus Insight</h2>
            <span class="badge-library">Dashboard Analisis Kepuasan</span>
        </div>

        <nav class="dash-nav">
            <a href="dashboard.php" class="nav-link">📊 Monitoring</a>
            <a href="survei_dashboard.php" class="nav-link active">📝 Rekap Survei</a>
            <a href="admin/anggota_list.php" class="nav-link">👥 Anggota</a>
            <div class="nav-divider"></div>
            <a href="logout.php" class="nav-link logout">Logout</a>
        </nav>
    </div>

    <div class="container">
        <div class="filter-box" style="margin-top: 20px;">
            <form method="GET" class="card" style="display:inline-block; padding: 10px 20px; text-align: left;">
                <label style="font-weight: 600; font-size: 14px;">Pilih Periode Data: </label>
                <input type="date" name="tgl" value="<?= $tgl ?>" onchange="this.form.submit()" class="form-control" style="width: auto; display: inline; margin-left: 10px;">
            </form>
        </div>

        <div class="stats-grid">
            <div class="stat-card blue">
                <h4>Total Responden</h4>
                <h1><?= $total_survei ?></h1>
                <small>Orang telah mengisi survei pada <?= $tgl ?></small>
            </div>
            <div class="stat-card green">
                <h4>Indeks Kepuasan</h4>
                <h1><?= $avg_rating ?> <span style="font-size: 18px;">/ 5.0</span></h1>
                <small>Rata-rata penilaian pengunjung</small>
            </div>
        </div>

        <div class="chart-grid">
            <div class="card">
                <h3>Distribusi Penilaian</h3>
                <div style="height: 300px;">
                    <canvas id="surveiChart"></canvas>
                </div>
            </div>
            <div class="card">
                <h3>Kesan Pengunjung</h3>
                <div class="emoji-summary">
                    <div class="emoji-stat"><span>😍 Sangat Puas</span> <strong><?= $rekap_rating[5] ?></strong></div>
                    <div class="emoji-stat"><span>🙂 Puas</span> <strong><?= $rekap_rating[4] ?></strong></div>
                    <div class="emoji-stat"><span>😐 Cukup</span> <strong><?= $rekap_rating[3] ?></strong></div>
                    <div class="emoji-stat"><span>☹️ Buruk</span> <strong><?= $rekap_rating[2] ?></strong></div>
                    <div class="emoji-stat"><span>😡 Sangat Buruk</span> <strong><?= $rekap_rating[1] ?></strong></div>
                </div>
            </div>
        </div>

        <div class="card full" style="margin-top: 30px; text-align: left;">
            <h3 style="color: #ef4444; border-bottom: 2px solid #fee2e2; padding-bottom: 10px;">
                Daftar Keluhan & Saran (Rating Buruk)
            </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th width="15%">Waktu</th>
                        <th width="20%">Rating</th>
                        <th>Alasan / Masukan Pengunjung</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Mengambil data rating 1 dan 2 yang memiliki alasan
                    $q_alasan = mysqli_query($conn, "SELECT * FROM survei WHERE rating <= 2 AND DATE(waktu_survei) = '$tgl' ORDER BY waktu_survei DESC");
                    
                    if(mysqli_num_rows($q_alasan) == 0) {
                        echo "<tr><td colspan='3' style='text-align:center; padding: 30px; color: #94a3b8;'>Tidak ada keluhan tertulis untuk tanggal ini.</td></tr>";
                    } else {
                        while($row = mysqli_fetch_assoc($q_alasan)): 
                    ?>
                    <tr>
                        <td><?= date('H:i', strtotime($row['waktu_survei'])) ?></td>
                        <td>
                            <span class="badge-rating <?= $row['rating'] == 1 ? 'red' : 'orange' ?>">
                                <?= $row['rating'] == 1 ? "😡 Sangat Buruk" : "☹️ Buruk" ?>
                            </span>
                        </td>
                        <td style="font-style: italic; color: #475569;">
                             "<?= htmlspecialchars($row['alasan'] ?? '') ?>"
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const ctxSurvei = document.getElementById('surveiChart').getContext('2d');
        new Chart(ctxSurvei, {
            type: 'bar',
            data: {
                labels: ['Sangat Buruk', 'Buruk', 'Cukup', 'Puas', 'Sangat Puas'],
                datasets: [{
                    label: 'Jumlah Suara',
                    data: [<?= implode(',', $rekap_rating) ?>],
                    backgroundColor: [
                        '#ef4444', // Merah
                        '#f97316', // Oranye
                        '#f59e0b', // Kuning
                        '#10b981', // Hijau
                        '#4f46e5'  // Indigo
                    ],
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</body>
</html>