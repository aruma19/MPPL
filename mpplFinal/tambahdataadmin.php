<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Tambah Data Siswa</title>
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
        <h1 class="text-2xl font-bold mb-8">
            Tambah Data Siswa
        </h1>
        <form action="proses_tambahdata.php" method="POST">
            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Nama Lengkap
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="nama" placeholder="Nama Lengkap"
                    type="text" required />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Email
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="email" placeholder="Email" type="email"
                    required />
            </div>
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Username
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="username" placeholder="Username"
                    type="text" required />
            </div>

            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Password
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="password" placeholder="Password"
                    type="password" required />
            </div>
            <!-- Nomor Induk -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Nomor Induk
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="nomer_induk" placeholder="Nomor Induk"
                    type="text" required />
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Jenis Kelamin
                </label>
                <select class="w-full p-2 border border-gray-300 rounded" name="jenis_kelamin" required>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <!-- Tahun Masuk -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Tahun Masuk
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="tahun_masuk" placeholder="Tahun Masuk"
                    type="number" min="1900" max="2100" required />
            </div>

            <!-- Tahun Lulus -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Tahun Lulus
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="tahun_lulus" placeholder="Tahun Lulus"
                    type="number" min="1900" max="2100" required />
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Status
                </label>
                <select class="w-full p-2 border border-gray-300 rounded" name="status" required>
                    <option value="Kuliah">Kuliah</option>
                    <option value="Bekerja">Bekerja</option>
                    <option value="Menganggur">Menganggur</option>
                    <option value="Pegawai Negeri Sipil (PNS)">Pegawai Negeri Sipil (PNS)</option>
                    <option value="Polisi">Polisi</option>
                    <option value="TNI (Tentara Nasional Indonesia)">TNI (Tentara Nasional Indonesia)</option>
                    <option value="Wirausahawan">Wirausahawan</option>
                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                    <option value="Pegawai BUMN/BUMD">Pegawai BUMN/BUMD</option>
                    <option value="Freelancer">Freelancer</option>
                    <option value="Tenaga Pengajar (Guru/Dosen)">Tenaga Pengajar (Guru/Dosen)</option>
                    <option value="Peneliti">Peneliti</option>
                    <option value="Profesional (Dokter, Pengacara, Akuntan, dll.)">Profesional (Dokter, Pengacara,
                        Akuntan, dll.)</option>
                    <option value="Pekerja di Luar Negeri">Pekerja di Luar Negeri</option>
                    <option value="Seniman/Desainer/Artis">Seniman/Desainer/Artis</option>
                    <option value="Konsultan">Konsultan</option>
                    <option value="Pekerja di Industri Kreatif">Pekerja di Industri Kreatif</option>
                    <option value="Aktivis/Relawan Sosial">Aktivis/Relawan Sosial</option>
                    <option value="Tidak Bekerja (Lanjut Studi, Mengurus Rumah Tangga, dll.)">Tidak Bekerja (Lanjut
                        Studi, Mengurus Rumah Tangga, dll.)</option>
                    <option value="Meninggal Dunia">Meninggal Dunia</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <!-- Instansi -->
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">
                    Nama Instansi
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" name="instansi" placeholder="Nama Instansi"
                    type="text" required />
            </div>

            <div class="flex justify-end">
                <!-- Tombol Kembali -->
                <button class="bg-red-500 text-white py-2 px-12 rounded mr-2" type="button"
                    onclick="window.history.back()">
                    Back
                </button>

                <!-- Tombol Submit -->
                <button class="bg-blue-500 text-white py-2 px-12 rounded" type="submit">
                    Add
                </button>
            </div>
        </form>

    </div>
</body>

</html>