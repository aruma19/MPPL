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

?>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EduTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body{
            background-color:#89A9ED;
        }
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
<body >
    <div class="flex flex-row min-h-screen p-6">
        <!-- Sidebar -->
        <div class="bg-white rounded-xl p-6 w-full fixed lg:w-1/4 flex flex-col items-center shadow-lg">
            <div class="d-flex align-items-center" style="display: flex; align-items: center; padding-bottom:20px; font-family:Typography; font-size:20px;">
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
                <p class="flex items-center"><i class="fas fa-id-card mr-2"></i>Nomor Induk: <?php echo htmlspecialchars($userNomerInduk); ?></p>
                <p class="flex items-center"><i class="fas fa-venus-mars mr-2"></i>Jenis Kelamin: <?php echo htmlspecialchars($userJenisKelamin); ?></p>
                <p class="flex items-center"><i class="fas fa-calendar-alt mr-2"></i>Tahun Masuk: <?php echo htmlspecialchars($userTahunMasuk); ?></p>
                <p class="flex items-center"><i class="fas fa-calendar-check mr-2"></i>Tahun Lulus: <?php echo htmlspecialchars($userTahunLulus); ?></p>
                <p class="flex items-center"><i class="fas fa-user-graduate mr-2"></i>Status: <?php echo htmlspecialchars($userStatus); ?></p>
                <p class="flex items-center"><i class="fas fa-building mr-2"></i>Instansi: <?php echo htmlspecialchars($userInstansi); ?></p>
                <p class="flex items-center"><i class="fas fa-clock mr-2"></i>Terakhir Update: <?php echo htmlspecialchars($lastUpdate); ?></p>
            </div>
            
            <a href="updatedata.php" id="linkUpdateData" class="rounded-btn mb-4 w-full">
                <i class="fas fa-bullhorn"></i> Update
            </a>
            <a href="logout.php" id="linkLogout" class="rounded-btn w-full" style="background-color: #E8AA24; color:white;">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-6 space-y-6 ml-auto lg:pl-[27%]"style="padding-top:4px; ">
            <div class="bg-white p-4 rounded-lg shadow-lg" style="padding-bottom: 250px;">
                <div class="flex items-center space-x-2">
                    <a href="mainpageSiswa.php">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div class="tombol" style="padding-left:20px;">
                        <a href="statistikalumni.php"
                            class="bg-blue-200 text-black py-2 px-4 rounded-r inline-block text-center 
                                <?php echo basename($_SERVER['PHP_SELF']) == 'statistikalumni.php' ? 'bg-blue-500 text-white' : ''; ?>">
                            STATISTIK DATA
                        </a>
                        <a href="alldataalumni.php"
                            class="bg-grey-200 text-black py-2 px-4 rounded-l inline-block text-center 
                                <?php echo basename($_SERVER['PHP_SELF']) == 'alldataalumni.php' ? 'bg-blue-500 text-white' : ''; ?>">
                            DATA ALUMNI
                        </a>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <img alt="Pie chart showing alumni statistics" class="w-64 h-64 mb-4" height="300" src="https://storage.googleapis.com/a1aa/image/olcI54GRJ8puGNb1HwTQTkDoYQHTYY3FBbTOCR7a3VfuYk7JA.jpg" width="300"/>
                    <div class="flex justify-center space-x-4 mb-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-yellow-400"></div>
                            <span>2020</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-blue-300"></div>
                            <span>2021</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-red-400"></div>
                            <span>2022</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-red-500"></div>
                            <span>2023</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-blue-500"></div>
                            <span>2024</span>
                        </div>
                    </div>
                    <div class="flex justify-around w-full">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                            <span class="font-bold">TOTAL</span>
                            <span>19,500 ALUMNI</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-2xl"></i>
                            <span class="font-bold">AVERAGE</span>
                            <span>1500 ALUMNI</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>