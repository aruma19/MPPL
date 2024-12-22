<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginsiswa.php?pesan=belum_login");
    exit();
}

// Fetch user data from the database
$username = $_SESSION['username'];
$query = mysqli_query($connection, "
    SELECT u.username, u.email, a.nama, a.nomer_induk, a.jenis_kelamin, 
           a.tahun_masuk, a.tahun_lulus, a.status, a.instansi, a.terakhir_update
    FROM users u
    JOIN alumni a ON u.email = a.email
    WHERE u.username = '$username'
");

$userData = mysqli_fetch_assoc($query);

if (!$userData) {
    // Handle case where user data is not found
    header("Location: loginsiswa.php?pesan=gagal");
    exit();
}

// Extract user data
$userId = $userData['username'];
$userEmail = $userData['email'];
$userName = $userData['nama'];
$userNomerInduk = $userData['nomer_induk'];
$userJenisKelamin = $userData['jenis_kelamin'];
$userTahunMasuk = $userData['tahun_masuk'];
$userTahunLulus = $userData['tahun_lulus'];
$userStatus = $userData['status'];
$userInstansi = $userData['instansi'];
$lastUpdate = $userData['terakhir_update'];

// Query untuk mengambil data pengumuman
$pengumumanQuery = mysqli_query($connection, "SELECT * FROM pengumuman ORDER BY tanggal_dibuat DESC");

$pengumumanList = [];
if ($pengumumanQuery) {
    while ($row = mysqli_fetch_assoc($pengumumanQuery)) {
        $pengumumanList[] = $row;
    }
} else {
    $errorPengumuman = "Gagal mengambil data pengumuman.";
}

// Query untuk mengambil data informasi
$informasiQuery = mysqli_query($connection, "SELECT id, judul_informasi, tanggal_dibuat FROM informasi ORDER BY tanggal_dibuat DESC");

$informasiList = [];
if ($informasiQuery) {
    while ($row = mysqli_fetch_assoc($informasiQuery)) {
        $informasiList[] = $row;
    }
} else {
    $errorInformasi = "Gagal mengambil data informasi.";
}

// Query untuk menghitung jumlah alumni per tahun
$statistikQuery = mysqli_query($connection, "
    SELECT tahun_lulus, COUNT(*) as jumlah_alumni
    FROM alumni
    GROUP BY tahun_lulus
    ORDER BY tahun_lulus ASC
");

$statistikData = [];
if ($statistikQuery) {
    while ($row = mysqli_fetch_assoc($statistikQuery)) {
        $statistikData[] = $row;
    }
} else {
    $errorStatistik = "Gagal mengambil data statistik.";
}

// Query untuk mengambil data informasi
$informasiQuery = mysqli_query($connection, "
    SELECT id, judul_informasi, isi_informasi, foto, tanggal_dibuat 
    FROM informasi 
    ORDER BY tanggal_dibuat DESC
");

$informasiList = [];
if ($informasiQuery) {
    while ($row = mysqli_fetch_assoc($informasiQuery)) {
        $informasiList[] = $row;
    }
} else {
    $errorInformasi = "Gagal mengambil data informasi.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>EduTrack Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #89A9ED;
        }

        /* Menambahkan efek hover dan border-radius pada tombol */
        .rounded-btn {
            background-color: #5573B9;
            /* Warna tombol default */
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            /* Membuat tombol melengkung */
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 350px;
            /* Batas maksimal lebar tombol */
            transition: background-color 0.3s, transform 0.2s;
            /* Animasi perubahan warna */
            text-decoration: none;
            /* Menghapus garis bawah pada link */
        }

        /* Efek hover */
        .rounded-btn:hover {
            background-color: #5573B9;
            /* Warna tombol saat hover */
            transform: scale(1.05);
            /* Efek pembesaran sedikit saat hover */
        }

        /* Efek tombol yang aktif (dihighlight dengan warna biru) */
        .rounded-btn.active {
            background-color: #5573B9;
            /* Warna tombol aktif */
        }

        /* Efek tombol non-aktif (warna abu-abu) */
        .rounded-btn:not(.active) {
            background-color: #D1D1D1;
            /* Warna tombol non-aktif */
            color: #1C5FEF;
        }

        .rounded-btn i {
            margin-right: 8px;
            /* Memberikan jarak antara ikon dan teks */
        }
    </style>
</head>

<body>
    <div class="flex flex-row min-h-screen p-6">
        <!-- Sidebar -->
        <div class="bg-white rounded-xl p-4 w-full fixed lg:w-1/4 flex flex-col items-center shadow-lg">
            <div class="d-flex align-items-center"style="display: flex; align-items: center; padding-bottom:5px; font-family:Typography; font-size:20px;">
                <a class="logowisuda">
                    <img src="assets/wisudalur.png" alt="Logo Wisuda" height="30px" width="20px">
                </a>
                <a class="navbar-brand" href="#" style="color: black; margin-left: 10px;">EduTrack</a>
            </div>
            <div class="text-center mb-6">
                <div class="flex items-center justify-center">
                    <img src="assets/profil.png" alt="EduTrack logo" class="mr-2 w-[50%] h-auto">
                </div>
                <p class="text-sm">ID : <?php echo htmlspecialchars($userId); ?></p>
                <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($userName); ?></h2>
                <p class="text-sm"><?php echo htmlspecialchars($userEmail); ?></p>
            </div>
            <div class="space-y-2 text-left w-full" style="padding-left:50px;">
                <p class="flex items-center"><i class="fas fa-id-card mr-2"></i>Nomor Induk:
                    <?php echo htmlspecialchars($userNomerInduk); ?>
                </p>
                <p class="flex items-center"><i class="fas fa-venus-mars mr-2"></i>Jenis Kelamin:
                    <?php echo htmlspecialchars($userJenisKelamin); ?>
                </p>
                <p class="flex items-center"><i class="fas fa-calendar-alt mr-2"></i>Tahun Masuk:
                    <?php echo htmlspecialchars($userTahunMasuk); ?>
                </p>
                <p class="flex items-center"><i class="fas fa-calendar-check mr-2"></i>Tahun Lulus:
                    <?php echo htmlspecialchars($userTahunLulus); ?>
                </p>
                <p class="flex items-center"><i class="fas fa-user-graduate mr-2"></i>Status:
                    <?php echo htmlspecialchars($userStatus); ?>
                </p>
                <p class="flex items-center"><i class="fas fa-building mr-2"></i>Instansi:
                    <?php echo htmlspecialchars($userInstansi); ?>
                </p>
                <p class="flex items-center"><i class="fas fa-clock mr-2"></i>Terakhir Update:
                    <?php echo htmlspecialchars($lastUpdate); ?>
                </p>
            </div>

            <a href="updatedata.php" id="linkUpdateData" class="rounded-btn mb-4 w-full">
                <i class="fas fa-bullhorn"></i> Update
            </a>
            <a href="logout.php" id="linkLogout" class="rounded-btn w-full"
                style="background-color: #E8AA24; color:white;">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-6 space-y-6 ml-auto lg:pl-[27%]" style="padding-top:4px;padding-right:2px;">
            <div class="bg-white rounded-xl p-6 shadow-lg">

                <!-- Search Bar -->
                <div class="flex justify-end" style="padding-bottom:20px;">
                    <a href="premiumalumni.php"
                        class=" text-black py-2 px-4 rounded-l inline-block text-center 
                    <?php echo basename($_SERVER['PHP_SELF']) == 'premiumalumni.php' ? 'bg-blue-500 text-white' : ''; ?>"
                        style="background-color:#D9D9D9; border-radius: 50px; padding: 8px 50px;">
                        PREMIUM
                    </a>
                </div>
                <div class="flex flex-wrap gap-4 items-start">
                    <!-- Statistik Data Alumni -->
                    <div class="flex-1 bg-gradient-to-r from-green-100 to-green-100 rounded-xl p-6 shadow-lg mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-2xl font-bold text-green-700">Statistik Data Alumni</h3>
                            <p class="text-sm text-gray-600 italic">Data terbaru tahun <?php echo date('Y'); ?></p>
                        </div>
                        <div class="overflow-x-auto">
                            <table
                                class="table-auto border-collapse border border-green-400 w-full text-sm text-left bg-white shadow-md rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-green-300 text-green-900 text-sm uppercase tracking-wider">
                                        <th class="border border-green-400 px-4 py-2">Tahun Lulus</th>
                                        <th class="border border-green-400 px-4 py-2">Jumlah Alumni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($statistikData)) { ?>
                                        <?php foreach ($statistikData as $statistik) { ?>
                                            <tr class="odd:bg-green-100 even:bg-white hover:bg-green-200">
                                                <td class="border border-green-400 px-4 py-3 font-medium text-green-800">
                                                    <?php echo htmlspecialchars($statistik['tahun_lulus']); ?>
                                                </td>
                                                <td class="border border-green-400 px-4 py-3 font-medium text-green-800">
                                                    <?php echo htmlspecialchars($statistik['jumlah_alumni']); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="2" class="border border-green-400 px-4 py-4 text-center text-gray-600">Belum ada data
                                                alumni.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                        <div class="bg-orange-100 rounded-xl p-6 col-span-1 lg:col-span-2 shadow-lg hover:shadow-xl transition">
                            <h3 class="text-xl font-semibold mb-4 flex items-center"><i class="fas fa-bell mr-2"></i>Notifikasi</h3>
                            <!-- Daftar Pengumuman -->
                            <div>
                                <h4 class="font-semibold mb-2">Pengumuman Terbaru</h4>
                                <div class="space-y-2">
                                    <?php if (!empty($pengumumanList)) { ?>
                                        <?php foreach ($pengumumanList as $pengumuman) { ?>
                                            <div class="bg-white rounded-lg p-4 shadow-md">
                                                <h4 class="text-lg font-bold mb-2">
                                                    <?php echo htmlspecialchars($pengumuman['judul_pengumuman']); ?>
                                                </h4>
                                                <p class="mb-2">
                                                    <?php echo nl2br(htmlspecialchars($pengumuman['isi_pengumuman'])); ?>
                                                </p>
                                                <p class="text-sm text-gray-500">Tanggal:
                                                    <?php echo htmlspecialchars($pengumuman['tanggal_dibuat']); ?>
                                                </p>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <p class="text-center">Belum ada pengumuman terbaru.</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Information -->
                        <div class="rounded-xl p-6 shadow-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold">Informasi</h3>
                                <a href="informasisekolah.php" class="text-blue-500 text-sm hover:underline">See More</a>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <?php if (!empty($informasiList)) { ?>
                                    <?php foreach ($informasiList as $informasi) { ?>
                                        <div class="bg-white rounded-lg p-4 shadow-md">
                                            <h4 class="text-lg font-bold mb-2">
                                                <?php echo htmlspecialchars($informasi['judul_informasi']); ?>
                                            </h4>
                                            <img alt="Foto Informasi" class="rounded-lg mb-4 w-full h-48 object-cover"
                                                src="<?php echo htmlspecialchars($informasi['foto']); ?>" />
                                            <p class="mb-2">
                                                <?php echo nl2br(htmlspecialchars($informasi['isi_informasi'])); ?>
                                            </p>
                                            <p class="text-sm text-gray-500">Tanggal:
                                                <?php echo htmlspecialchars($informasi['tanggal_dibuat']); ?>
                                            </p>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p class="text-center col-span-1 lg:col-span-2">Belum ada Informasi.</p>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</body>

</html>