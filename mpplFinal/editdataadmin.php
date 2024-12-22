<?php
include 'config.php'; // Koneksi ke database

// Mendapatkan parameter nama dari URL
$nama = isset($_GET['nama']) ? urldecode($_GET['nama']) : '';

// Query untuk mengambil data alumni berdasarkan nama
$sql = "SELECT * FROM alumni WHERE nama = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $nama);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Menambahkan efek hover dan border-radius pada tombol */
        .rounded-btn {
            background-color: #5573B9; /* Warna tombol default */
            color: white;
            padding: 12px 24px;
            border-radius: 50px; /* Membuat tombol melengkung */
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 350px; /* Batas maksimal lebar tombol */
            transition: background-color 0.3s, transform 0.2s; /* Animasi perubahan warna */
            text-decoration: none; /* Menghapus garis bawah pada link */
        }

        /* Efek hover */
        .rounded-btn:hover {
            background-color: #5573B9; /* Warna tombol saat hover */
            transform: scale(1.05); /* Efek pembesaran sedikit saat hover */
        }

        /* Efek tombol yang aktif (dihighlight dengan warna biru) */
        .rounded-btn.active {
            background-color: #5573B9; /* Warna tombol aktif */
        }

        /* Efek tombol non-aktif (warna abu-abu) */
        .rounded-btn:not(.active) {
            background-color: #D1D1D1; /* Warna tombol non-aktif */
            color: #1C5FEF;
        }

        .rounded-btn i {
            margin-right: 8px; /* Memberikan jarak antara ikon dan teks */
        }

    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-1/4 p-4 flex flex-col items-center fixed top-0 left-0 h-full bg-blue-200" style="background-color: #89A9ED;">
            <div class="d-flex align-items-center" style="display: flex; align-items: center; padding-bottom:30px; font-family:Typography; font-size:20px;">
                <a class="logowisuda">
                    <img src="assets/wisudalur.png" alt="Logo Wisuda" height="30px" width="20px">
                </a>
                <a class="navbar-brand" href="#" style="color: black; margin-left: 10px;">EduTrack</a>
            </div>
            <div class="flex items-center justify-center mb-6">
                <img src="assets/profil.png" alt="EduTrack logo" class="mr-2 w-[60%] h-auto">
            </div>
            <div class="text-center mb-6" style="color:white;">
                <p class="text-lg">Halo, Admin</p>
            </div>
            <div class="text-center mb-6" style="color:white;">
                <p class="text-lg">SMPN 1 Ngadirejo</p>
            </div>

            <!-- Link ke halaman Data Alumni -->
            <a href="alldataadmin.php" id="linkDataAlumni" class="rounded-btn mb-4 w-full">
                <i class="fas fa-users"></i>Lihat Data Alumni
            </a>

            <!-- Link ke halaman Tambah Data -->
            <a href="tambahdataadmin.php" id="linkTambahData" class="rounded-btn mb-4 w-full  active">
                <i class="fas fa-users"></i>Tambah Data
            </a>

            <!-- Link ke halaman Buat Pengumuman -->
            <a href="buat_pengumuman.php" id="linkBuatPengumuman" class="rounded-btn mb-4 w-full">
                <i class="fas fa-bullhorn"></i>Pengumuman/Informasi
            </a>

            <!-- Link ke halaman Logout -->
            <a href="logout.php" id="linkLogout" class="rounded-btn w-full" style="background-color: #E8AA24; color:white">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </div>

    <script>
        // Menambahkan event listener pada setiap tombol untuk mengubah warnanya
        const links = document.querySelectorAll('.bg-gray-400');

        links.forEach(link => {
            link.addEventListener('click', function () {
                // Mengatur warna tombol menjadi biru untuk tombol yang diklik
                links.forEach(btn => btn.classList.remove('bg-blue-600'));
                link.classList.add('bg-blue-600');

                // Mengatur tombol yang tidak diklik menjadi abu-abu
                links.forEach(btn => {
                    if (btn !== link) {
                        btn.classList.remove('bg-blue-600');
                        btn.classList.add('bg-gray-400');
                    }
                });
            });
        });
    </script>

    <!-- Main Content -->
    <div class="flex-grow w-3/4 p-8 ml-[25%]">
        <h2 class="text-2xl font-bold mb-6">Edit Data</h2>
        <form action="proses_editdata.php" method="POST">
            <!-- Hidden Input for ID -->
            <input type="hidden" name="id" value="<?= $data['id']; ?>" />

            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Nama Lengkap</label>
                <input class="w-full p-2 border border-gray-300 rounded bg-gray-100" name="nama" type="text"
                    value="<?= htmlspecialchars($data['nama']); ?>" readonly />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Email</label>
                <input class="w-full p-2 border border-gray-300 rounded bg-gray-100" name="email" type="email"
                    value="<?= htmlspecialchars($data['email']); ?>" readonly />
            </div>

            <!-- Nomor Induk -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Nomor Induk</label>
                <input class="w-full p-2 border border-gray-300 rounded bg-gray-100" name="nomer_induk" type="text"
                    value="<?= htmlspecialchars($data['nomer_induk']); ?>" readonly />
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Jenis Kelamin</label>
                <select class="w-full p-2 border border-gray-300 rounded bg-gray-100" name="jenis_kelamin" disabled>
                    <option value="L" <?= $data['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-Laki</option>
                    <option value="P" <?= $data['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <!-- Tahun Masuk -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Tahun Masuk</label>
                <input class="w-full p-2 border border-gray-300 rounded bg-gray-100" name="tahun_masuk" type="number"
                    value="<?= htmlspecialchars($data['tahun_masuk']); ?>" readonly />
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Status</label>
                <select class="w-full p-2 border border-gray-300 rounded" name="status" required>
                    <option value="Kuliah" <?= $data['status'] == 'Kuliah' ? 'selected' : ''; ?>>Kuliah</option>
                    <option value="Bekerja" <?= $data['status'] == 'Bekerja' ? 'selected' : ''; ?>>Bekerja</option>
                    <option value="Menganggur" <?= $data['status'] == 'Menganggur' ? 'selected' : ''; ?>>Menganggur
                    </option>
                    <option value="Pegawai Negeri Sipil (PNS)" <?= $data['status'] == 'Pegawai Negeri Sipil (PNS)' ? 'selected' : ''; ?>>Pegawai Negeri Sipil (PNS)</option>
                    <option value="Polisi" <?= $data['status'] == 'Polisi' ? 'selected' : ''; ?>>Polisi</option>
                    <option value="TNI (Tentara Nasional Indonesia)" <?= $data['status'] == 'TNI (Tentara Nasional Indonesia)' ? 'selected' : ''; ?>>TNI (Tentara Nasional Indonesia)</option>
                    <option value="Wirausahawan" <?= $data['status'] == 'Wirausahawan' ? 'selected' : ''; ?>>Wirausahawan
                    </option>
                    <option value="Karyawan Swasta" <?= $data['status'] == 'Karyawan Swasta' ? 'selected' : ''; ?>>Karyawan
                        Swasta</option>
                    <option value="Pegawai BUMN/BUMD" <?= $data['status'] == 'Pegawai BUMN/BUMD' ? 'selected' : ''; ?>>
                        Pegawai BUMN/BUMD</option>
                    <option value="Freelancer" <?= $data['status'] == 'Freelancer' ? 'selected' : ''; ?>>Freelancer
                    </option>
                    <option value="Tenaga Pengajar (Guru/Dosen)" <?= $data['status'] == 'Tenaga Pengajar (Guru/Dosen)' ? 'selected' : ''; ?>>Tenaga Pengajar (Guru/Dosen)</option>
                    <option value="Peneliti" <?= $data['status'] == 'Peneliti' ? 'selected' : ''; ?>>Peneliti</option>
                    <option value="Profesional (Dokter, Pengacara, Akuntan, dll.)" <?= $data['status'] == 'Profesional (Dokter, Pengacara, Akuntan, dll.)' ? 'selected' : ''; ?>>Profesional (Dokter, Pengacara,
                        Akuntan, dll.)</option>
                    <option value="Pekerja di Luar Negeri" <?= $data['status'] == 'Pekerja di Luar Negeri' ? 'selected' : ''; ?>>Pekerja di Luar Negeri</option>
                    <option value="Seniman/Desainer/Artis" <?= $data['status'] == 'Seniman/Desainer/Artis' ? 'selected' : ''; ?>>Seniman/Desainer/Artis</option>
                    <option value="Konsultan" <?= $data['status'] == 'Konsultan' ? 'selected' : ''; ?>>Konsultan</option>
                    <option value="Pekerja di Industri Kreatif" <?= $data['status'] == 'Pekerja di Industri Kreatif' ? 'selected' : ''; ?>>Pekerja di Industri Kreatif</option>
                    <option value="Aktivis/Relawan Sosial" <?= $data['status'] == 'Aktivis/Relawan Sosial' ? 'selected' : ''; ?>>Aktivis/Relawan Sosial</option>
                    <option value="Tidak Bekerja (Lanjut Studi, Mengurus Rumah Tangga, dll.)" <?= $data['status'] == 'Tidak Bekerja (Lanjut Studi, Mengurus Rumah Tangga, dll.)' ? 'selected' : ''; ?>>Tidak Bekerja (Lanjut
                        Studi, Mengurus Rumah Tangga, dll.)</option>
                    <option value="Meninggal Dunia" <?= $data['status'] == 'Meninggal Dunia' ? 'selected' : ''; ?>>
                        Meninggal Dunia</option>
                    <option value="Lainnya" <?= $data['status'] == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                </select>

            </div>

            <!-- Instansi -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Instansi</label>
                <input class="w-full p-2 border border-gray-300 rounded" name="instansi" type="text"
                    placeholder="Instansi (opsional)" value="<?= htmlspecialchars($data['instansi'] ?? ''); ?>" />
            </div>

            <!-- Tombol -->
            <div class="flex justify-end">
                <button class="bg-red-500 text-white py-2 px-12 rounded mr-2" type="button"
                    onclick="window.history.back()">Back</button>
                <button class="bg-blue-500 text-white py-2 px-12 rounded" type="submit">Edit</button>
            </div>
        </form>
    </div>
</body>

</html>