<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - DDST</title>
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
                <h1>Kebijakan Privasi DDST</h1>
                <p class="text-muted">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <section>
                    <h2>1. Pendahuluan</h2>
                    <p>DDST ("kami", "kita", atau "aplikasi") berkomitmen untuk melindungi privasi pengguna ("Anda"). 
                    Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda.</p>
                </section>

                <section>
                    <h2>2. Informasi yang Kami Kumpulkan</h2>
                    <p>Kami mengumpulkan informasi berikut:</p>
                    <ul>
                        <li>Informasi pribadi (nama, alamat email)</li>
                        <li>Data profil pengguna</li>
                        <li>Informasi penggunaan aplikasi</li>
                        <li>Data perangkat dan log sistem</li>
                    </ul>
                </section>

                <section>
                    <h2>3. Penggunaan Informasi</h2>
                    <p>Kami menggunakan informasi Anda untuk:</p>
                    <ul>
                        <li>Menyediakan dan mengelola layanan</li>
                        <li>Meningkatkan pengalaman pengguna</li>
                        <li>Berkomunikasi dengan pengguna</li>
                        <li>Keamanan dan pencegahan penipuan</li>
                    </ul>
                </section>

                <section>
                    <h2>4. Penyimpanan dan Keamanan Data</h2>
                    <ul>
                        <li>Data disimpan secara aman menggunakan enkripsi standar industri</li>
                        <li>Akses ke data dibatasi hanya untuk personel yang berwenang</li>
                        <li>Data disimpan selama diperlukan untuk layanan atau sesuai ketentuan hukum</li>
                    </ul>
                </section>

                <section>
                    <h2>5. Hak Pengguna</h2>
                    <p>Anda memiliki hak untuk:</p>
                    <ul>
                        <li>Mengakses data pribadi Anda</li>
                        <li>Meminta koreksi data yang tidak akurat</li>
                        <li>Meminta penghapusan data</li>
                        <li>Menarik persetujuan penggunaan data</li>
                    </ul>
                </section>

                <section>
                    <h2>6. Kontak</h2>
                    <p>Untuk pertanyaan tentang kebijakan privasi ini, hubungi kami di: 
                    <a href="mailto:your@email.com">kevinlimyeeming@gmail.com</a></p>
                </section>

                <div class="no-print">
                    <a href="{{ url()->previous() }}" class="back-link">← Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>