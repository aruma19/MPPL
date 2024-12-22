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


// Query untuk mengambil data informasi
$informasiQuery = mysqli_query($connection, "SELECT * FROM informasi ORDER BY tanggal_dibuat DESC");

$informasiList = [];
if ($informasiQuery) {
    while ($row = mysqli_fetch_assoc($informasiQuery)) {
        $informasiList[] = $row;
    }
} else {
    $errorinformasi = "Gagal mengambil data informasi.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>EduTrack - Informasi Sekolah</title>
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
            <div class="d-flex align-items-center"style="display: flex; align-items: center; padding-bottom:52px; font-family:Typography; font-size:20px;">
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
        <div class="bg-white w-3/4 p-6 bg-white rounded-xl shadow-lg ml-[27%]">
            <div class="flex items-center space-x-2 ">
                <a href="mainpageSiswa.php">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
            </div>
            <h1 class="text-2xl font-bold mb-4" style="text-align:center;">Informasi Sekolah</h1>
            <div class="">
                <div class="space-y-2">
                    <?php if (!empty($informasiList)) { ?>
                        <?php foreach ($informasiList as $informasi) { ?>
                            <div class="bg-white rounded-lg p-4 shadow-md">
                                <h5 class="text-md font-bold mb-1">
                                    <?php echo htmlspecialchars($informasi['judul_informasi']); ?>
                                </h5>
                                <img alt="Foto Informasi" class="rounded-lg mb-2 w-full h-32 object-cover"
                                    src="<?php echo htmlspecialchars($informasi['foto']); ?>" />
                                <p class="text-sm mb-1">
                                    <?php echo nl2br(htmlspecialchars($informasi['isi_informasi'])); ?>
                                </p>
                                <p class="text-xs text-gray-500">Tanggal:
                                    <?php echo htmlspecialchars($informasi['tanggal_dibuat']); ?>
                                </p>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p class="text-center">Belum ada Informasi.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
