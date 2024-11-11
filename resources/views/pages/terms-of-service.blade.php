<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat dan Ketentuan - DDST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
        }
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 12px;
        }
        .card-body {
            padding: 2rem;
        }
        h1 {
            color: #2d3748;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        h2 {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .text-muted {
            color: #6c757d;
        }
        section {
            margin-bottom: 2rem;
        }
        p {
            margin-bottom: 1rem;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        @media print {
            .container {
                margin: 0;
                max-width: 100%;
            }
            .card {
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1>Syarat dan Ketentuan DDST</h1>
                <p class="text-muted">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <section>
                    <h2>1. Penerimaan Ketentuan</h2>
                    <p>Dengan mengakses atau menggunakan DDST, Anda setuju untuk terikat oleh syarat dan ketentuan ini.</p>
                </section>

                <section>
                    <h2>2. Deskripsi Layanan</h2>
                    <p>DDST menyediakan platform untuk [deskripsi layanan Anda]. Kami berhak untuk memodifikasi atau 
                    menghentikan layanan kapan saja.</p>
                </section>

                <section>
                    <h2>3. Akun Pengguna</h2>
                    <h3>3.1 Pendaftaran</h3>
                    <ul>
                        <li>Anda harus memberikan informasi yang akurat dan lengkap</li>
                        <li>Anda bertanggung jawab menjaga kerahasiaan akun</li>
                        <li>Anda harus berusia minimal 13 tahun</li>
                    </ul>

                    <h3>3.2 Keamanan Akun</h3>
                    <ul>
                        <li>Anda bertanggung jawab atas semua aktivitas akun</li>
                        <li>Wajib memberitahu kami jika ada penggunaan tidak sah</li>
                    </ul>
                </section>

                <section>
                    <h2>4. Penggunaan yang Dilarang</h2>
                    <p>Anda dilarang:</p>
                    <ul>
                        <li>Melanggar hukum atau peraturan</li>
                        <li>Mengunggah konten berbahaya</li>
                        <li>Menyalahgunakan layanan</li>
                        <li>Menggangu pengguna lain</li>
                    </ul>
                </section>

                <section>
                    <h2>5. Hak Kekayaan Intelektual</h2>
                    <ul>
                        <li>Semua konten adalah milik DDST</li>
                        <li>Pengguna mempertahankan hak atas konten mereka</li>
                        <li>Lisensi terbatas diberikan untuk penggunaan layanan</li>
                    </ul>
                </section>

                <section>
                    <h2>6. Batasan Tanggung Jawab</h2>
                    <ul>
                        <li>Layanan disediakan "sebagaimana adanya"</li>
                        <li>Kami tidak bertanggung jawab atas kerugian tidak langsung</li>
                        <li>Batasan sesuai hukum yang berlaku</li>
                    </ul>
                </section>

                <section>
                    <h2>7. Perubahan Ketentuan</h2>
                    <p>Kami berhak mengubah ketentuan ini kapan saja. Perubahan akan diumumkan melalui aplikasi.</p>
                </section>

                <section>
                    <h2>8. Penghentian</h2>
                    <p>Kami dapat menghentikan akses pengguna yang melanggar ketentuan ini.</p>
                </section>

                <section>
                    <h2>9. Hukum yang Berlaku</h2>
                    <p>Ketentuan ini tunduk pada hukum Republik Indonesia.</p>
                </section>

                <section>
                    <h2>10. Kontak</h2>
                    <p>Untuk pertanyaan tentang ketentuan ini, hubungi: 
                    <a href="mailto:your@email.com">your@email.com</a></p>
                </section>

                <div class="no-print">
                    <a href="{{ url()->previous() }}" class="back-link">← Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>