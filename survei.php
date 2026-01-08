<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Survei Kepuasan - Perpus Insight</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Tambahan style khusus untuk textarea alasan */
        #alasan-container {
            margin-top: 20px;
            text-align: left;
            animation: fadeIn 0.3s ease-in-out;
        }
        textarea.form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-top: 8px;
            font-family: inherit;
            resize: none;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .success-message {
            text-align: center;
            padding: 40px 0;
        }
        .success-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-soft">
    <div class="dash-header">
    <div class="brand">
        <h2>Perpus Insight</h2>
        <span class="badge-library">Survei Kepuasan Pengunjung</span>
    </div>
    <nav class="dash-nav">
        <a href="menu.php" class="nav-link">🏠 Kembali ke Menu</a>
    </nav>
</div>

    <main class="container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card survey-card">
            <div class="survey-header">
                <h3>Bagaimana Perasaan Anda Hari Ini?</h3>
                <p>Masukan Anda membantu kami meningkatkan layanan perpustakaan.</p>
            </div>

            <form id="form-survei">
                <div class="emoji-selector">
                    <label class="emoji-item">
                        <input type="radio" name="rating" value="1">
                        <div class="emoji-content">
                            <span class="emoji-icon">😡</span>
                            <span class="emoji-label">Sangat Buruk</span>
                        </div>
                    </label>
                    <label class="emoji-item">
                        <input type="radio" name="rating" value="2">
                        <div class="emoji-content">
                            <span class="emoji-icon">☹️</span>
                            <span class="emoji-label">Buruk</span>
                        </div>
                    </label>
                    <label class="emoji-item">
                        <input type="radio" name="rating" value="3">
                        <div class="emoji-content">
                            <span class="emoji-icon">😐</span>
                            <span class="emoji-label">Cukup</span>
                        </div>
                    </label>
                    <label class="emoji-item">
                        <input type="radio" name="rating" value="4">
                        <div class="emoji-content">
                            <span class="emoji-icon">🙂</span>
                            <span class="emoji-label">Puas</span>
                        </div>
                    </label>
                    <label class="emoji-item">
                        <input type="radio" name="rating" value="5">
                        <div class="emoji-content">
                            <span class="emoji-icon">😍</span>
                            <span class="emoji-label">Sangat Puas</span>
                        </div>
                    </label>
                </div>

                <div id="alasan-container" style="display: none;">
                    <label style="font-weight: 600; color: #ef4444;">Apa yang membuat Anda kurang puas?</label>
                    <textarea id="alasan" class="form-control" placeholder="Tuliskan keluhan atau saran Anda di sini..." rows="4"></textarea>
                </div>

                <div class="survey-footer" style="margin-top: 30px;">
                    <button type="button" class="btn btn-primary btn-large" id="btn-simpan">Kirim Feedback</button>
                </div>
            </form>

            <div id="pesan-terkirim" class="success-message" style="display: none;">
                <div class="success-icon">🎉</div>
                <h4>Terima Kasih Banyak!</h4>
                <p>Data survei Anda telah kami terima dengan baik.</p>
                <p style="color: #64748b; font-size: 14px; margin-top: 10px;">Halaman akan kembali otomatis dalam beberapa detik...</p>
            </div>
        </div>
    </main>

    <script>
        const btnSimpan = document.getElementById('btn-simpan');
        const formSurvei = document.getElementById('form-survei');
        const pesan = document.getElementById('pesan-terkirim');
        const alasanContainer = document.getElementById('alasan-container');
        const inputAlasan = document.getElementById('alasan');
        const radioRatings = document.querySelectorAll('input[name="rating"]');

        // Logika menampilkan input alasan jika rating 1 atau 2
        radioRatings.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value == "1" || this.value == "2") {
                    alasanContainer.style.display = 'block';
                } else {
                    alasanContainer.style.display = 'none';
                    inputAlasan.value = ""; 
                }
            });
        });

        btnSimpan.addEventListener('click', function() {
            const terpilih = document.querySelector('input[name="rating"]:checked');
            
            if (!terpilih) {
                alert("Silakan pilih salah satu emoji!");
                return;
            }

            const formData = new FormData();
            formData.append('rating', terpilih.value);
            formData.append('alasan', inputAlasan.value);

            fetch('proses_survei.php', { method: 'POST', body: formData })
            .then(res => res.text())
            .then(data => {
                if(data.trim() === "success") {
                    // 1. Sembunyikan Form
                    formSurvei.style.display = 'none';
                    // 2. Tampilkan Pesan Sukses
                    pesan.style.display = 'block';

                    // 3. FUNGSI AUTO-RELOAD (3 Detik)
                    setTimeout(function() {
                        window.location.href = 'survei.php';
                    }, 3000); 

                } else {
                    alert("Gagal mengirim data. Silakan coba lagi.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan koneksi.");
            });
        });
    </script>
</body>
</html>