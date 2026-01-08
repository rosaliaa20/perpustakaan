<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Kunjungan Perpustakaan</title>
    <style>
        :root {
            --primary: #2980b9;
            --secondary: #e67e22;
            --bg: #f8fafc;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg);
            margin: 0;
            padding-bottom: 50px;
        }

        .header {
        background: linear-gradient(135deg, #1e3cff, #838be5ff);
        color: white;
        padding: 35px 20px;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 10px 25px rgba(30, 60, 255, 0.3);
        }


        .container {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 0 20px;
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            width: 45%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
        }

        .btn-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 20px;
        }

        .btn-kat {
            padding: 15px;
            border: 2px solid #eee;
            border-radius: 12px;
            cursor: pointer;
            background: white;
            font-weight: 600;
            color: #555;
            transition: 0.3s;
        }

        .btn-kat:hover {
            background: var(--secondary);
            color: white;
            border-color: var(--secondary);
        }

        .pelajar-group {
            display: flex;
            gap: 8px;
            grid-column: span 2;
        }

        input[type="text"] {
            width: 80%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin: 20px 0;
            text-align: center;
            font-size: 18px;
        }

        small {
            color: #888;
        }
    </style>
</head>
<body>

    <div class="header">
    <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: auto;">
        <div style="text-align: left;">
            <h1>Sistem Pencatatan Pengunjung Perpustakaan</h1>
            <p>Soekarno-Hatta Kabupaten Tegal</p>
        </div>
        <a href="menu.php" class="btn-kat" style="text-decoration: none; padding: 10px 20px;">🏠 Ke Menu Utama</a>
    </div>
</div>

    <div class="container">

        <!-- ================== ANGGOTA ================== -->
        <div class="card">
            <h2 style="color: var(--primary);"> 👤 Anggota</h2>
            <p>Silakan Tap Kartu RFID Anda</p>

            <img src="assets/img/rfid.png" class="icon-rfid" width="120" style="margin: 20px 0;">

            <form action="proses_rfid.php" method="POST">
                <input type="text" name="rfid_uid" placeholder="Menunggu Kartu..." autofocus required>
            </form>

            <small>Letakkan kursor pada kotak input di atas</small>
        </div>

        <!-- ================== NON ANGGOTA ================== -->
        <div class="card">
            <h2 style="color: var(--secondary);">📝Buku Tamu</h2>
            <p>Pilih kategori kunjungan untuk masuk</p>

            <form action="proses_umum.php" method="POST">
                <div class="btn-grid">

                    <!-- Pelajar -->
                    <div class="pelajar-group">
                        <button type="submit" name="kat" value="Pelajar (SD)" class="btn-kat" style="flex:1">SD</button>
                        <button type="submit" name="kat" value="Pelajar (SMP)" class="btn-kat" style="flex:1">SMP</button>
                        <button type="submit" name="kat" value="Pelajar (SMA)" class="btn-kat" style="flex:1">SMA</button>
                    </div>

                    <button type="submit" name="kat" value="Mahasiswa" class="btn-kat">Mahasiswa</button>
                    <button type="submit" name="kat" value="Peneliti" class="btn-kat">Peneliti</button>
                    <button type="submit" name="kat" value="Umum" class="btn-kat">Umum</button>
                    <button type="submit" name="kat" value="Anak-anak" class="btn-kat">Anak-anak</button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
