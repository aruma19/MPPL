<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginsiswa.php?pesan=belum_login");
    exit();
}

// Query untuk mengambil data dari tabel informasi
$informasiQuery = mysqli_query($connection, "SELECT * FROM informasi ORDER BY tanggal_dibuat DESC");

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
    <title>EduTrack - Notifikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #89A9ED;
        }

        .notification-card {
            background-color: #f8f8f8;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .notification-card img {
            border-radius: 8px;
            max-height: 150px;
            max-width: 100%;
            object-fit: cover;
            margin-bottom: 12px;
        }

        .notification-card h3 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .notification-card p {
            font-size: 0.875rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .notification-date {
            font-size: 0.75rem;
            color: #888;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="flex flex-row min-h-screen p-6">
        <!-- Sidebar -->
        <div class="bg-white rounded-xl p-6 w-full fixed lg:w-1/4 flex flex-col items-center shadow-lg">
            <div class="d-flex align-items-center" style="display: flex; align-items: center; padding-bottom:20px;">
                <a class="logowisuda">
                    <img src="assets/wisudalur.png" alt="Logo Wisuda" height="30px" width="20px">
                </a>
                <a class="navbar-brand" href="#" style="color: black; margin-left: 10px;">EduTrack</a>
            </div>
            <a href="mainpageSiswa.php" class="rounded-btn mb-4 w-full">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="logout.php" id="linkLogout" class="rounded-btn w-full" style="background-color: #E8AA24; color:white;">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="bg-white w-3/4 p-6 bg-white rounded-xl shadow-lg ml-[27%]">
            <div class="flex items-center space-x-2 mb-4">
                <a href="mainpageSiswa.php">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h2 class="text-xl font-semibold">Notifikasi</h2>
            </div>
            <div class="space-y-4">
                <?php if (!empty($informasiList)) : ?>
                    <?php foreach ($informasiList as $informasi) : ?>
                        <div class="notification-card">
                            <?php if (!empty($informasi['foto'])) : ?>
                                <img src="<?php echo htmlspecialchars($informasi['foto']); ?>" alt="Informasi Image">
                            <?php else : ?>
                                <img src="https://via.placeholder.com/400x200?text=No+Image+Available" alt="Default Image">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($informasi['judul_informasi']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($informasi['isi_informasi'])); ?></p>
                            <p class="notification-date">Tanggal: <?php echo htmlspecialchars($informasi['tanggal_dibuat']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Tidak ada notifikasi tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
