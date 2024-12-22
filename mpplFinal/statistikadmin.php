<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "edutrack";

// Membuat koneksi ke database
$connection = new mysqli($hostname, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if ($connection->connect_error) {
    die('Connection error: ' . $connection->connect_error);
}

// Query untuk mendapatkan data berdasarkan kategori
$query_gender = "SELECT jenis_kelamin, COUNT(*) as total FROM alumni GROUP BY jenis_kelamin";
$query_tahun_masuk = "SELECT tahun_masuk, COUNT(*) as total FROM alumni GROUP BY tahun_masuk";
$query_tahun_lulus = "SELECT tahun_lulus, COUNT(*) as total FROM alumni GROUP BY tahun_lulus";
$query_status = "SELECT status, COUNT(*) as total FROM alumni GROUP BY status";
$query_instansi = "SELECT instansi, COUNT(*) as total FROM alumni GROUP BY instansi";

$result_gender = $connection->query($query_gender);
$result_tahun_masuk = $connection->query($query_tahun_masuk);
$result_tahun_lulus = $connection->query($query_tahun_lulus);
$result_status = $connection->query($query_status);
$result_instansi = $connection->query($query_instansi);

// Menutup koneksi
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>EduTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
    table {
        width: 100%;
        border-collapse: collapse; /* Hilangkan jarak antara border */
        table-layout: fixed; /* Lebar kolom tetap */
    }

    th, td {
        border: 1px solid #ddd; /* Border konsisten */
        padding: 8px; /* Padding konsisten */
        text-align: left; /* Teks sejajar kiri */
        word-wrap: break-word; /* Pecah kata panjang */
    }

    th {
        background-color: #f2f2f2; /* Warna latar belakang header */
        font-weight: bold; /* Header lebih tebal */
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9; /* Warna selang-seling */
    }

    tbody tr:hover {
        background-color: #f1f1f1; /* Efek hover */
    }
</style>

</head>
<style>
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

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-1/4 p-4 flex flex-col items-center fixed top-0 left-0 h-full" style="background-color: #89A9ED;">
            <div class="d-flex align-items-center"
                style="display: flex; align-items: center; padding-bottom:30px; font-family:Typography; font-size:20px;">
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
            <a href="alldataadmin.php" id="linkDataAlumni" class="rounded-btn mb-4 w-full active">
                <i class="fas fa-users"></i>Lihat Data Alumni
            </a>

            <!-- Link ke halaman Tambah Data -->
            <a href="tambahdataadmin.php" id="linkTambahData" class="rounded-btn mb-4 w-full">
                <i class="fas fa-users"></i>Tambah Data
            </a>

            <!-- Link ke halaman Buat Pengumuman -->
            <a href="buat_pengumuman.php" id="linkBuatPengumuman" class="rounded-btn mb-4 w-full">
                <i class="fas fa-bullhorn"></i> Pengumuman/Informasi
            </a>

            <!-- Link ke halaman Logout -->
            <a href="logout.php" id="linkLogout" class="rounded-btn w-full"
                style="background-color: #E8AA24; color:white;">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </div>
        <!-- Main Content -->
        <div class="w-3/4 p-2 ml-[26%] mt-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <a href="alldataadmin.php"
                        class="bg-gray-200 text-black py-2 px-4 rounded-l inline-block text-center 
                            <?php echo basename($_SERVER['PHP_SELF']) == 'alldataadmin.php' ? 'bg-blue-500 text-white' : ''; ?>">
                        DATA ALUMNI
                    </a>
                    <a href="statistikadmin.php"
                        class="bg-primmary-200 text-black py-2 px-4 rounded-r inline-block text-center 
                            <?php echo basename($_SERVER['PHP_SELF']) == 'statistikadmin.php' ? 'bg-blue-500 text-white' : ''; ?>">
                        STATISTIK DATA
                    </a>
                </div>
            </div>
            <div class="text-center text-xl font-bold mb-4">
                Statistik Data Alumni
            </div>
            <!-- Tabel Statistik Berdasarkan Jenis Kelamin -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-2">Statistik Berdasarkan Jenis Kelamin</h2>
                <table class="min-w-full border-collapse block md:table">
                    <thead class="block md:table-header-group">
                        <tr class="border border-gray-300 block md:table-row">
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Jenis Kelamin</th>
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Total</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group">
                        <?php while ($row = $result_gender->fetch_assoc()): ?>
                            <tr class="border border-gray-300 block md:table-row">
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['jenis_kelamin']); ?>
                                </td>
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['total']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Statistik Berdasarkan Tahun Masuk -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-2">Statistik Berdasarkan Tahun Masuk</h2>
                <table class="min-w-full border-collapse block md:table">
                    <thead class="block md:table-header-group">
                        <tr class="border border-gray-300 block md:table-row">
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Tahun Masuk</th>
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Total</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group">
                        <?php while ($row = $result_tahun_masuk->fetch_assoc()): ?>
                            <tr class="border border-gray-300 block md:table-row">
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['tahun_masuk']); ?>
                                </td>
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['total']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Statistik Berdasarkan Tahun Lulus -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-2">Statistik Berdasarkan Tahun Lulus</h2>
                <table class="min-w-full border-collapse block md:table">
                    <thead class="block md:table-header-group">
                        <tr class="border border-gray-300 block md:table-row">
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Tahun Lulus</th>
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Total</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group">
                        <?php while ($row = $result_tahun_lulus->fetch_assoc()): ?>
                            <tr class="border border-gray-300 block md:table-row">
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['tahun_lulus']); ?>
                                </td>
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['total']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Statistik Berdasarkan Instansi -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-2">Statistik Berdasarkan Instansi</h2>
                <table class="min-w-full border-collapse block md:table">
                    <thead class="block md:table-header-group">
                        <tr class="border border-gray-300 block md:table-row">
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Instansi</th>
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Total</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group">
                        <?php while ($row = $result_instansi->fetch_assoc()): ?>
                            <tr class="border border-gray-300 block md:table-row">
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['instansi']); ?></td>
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['total']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Statistik Berdasarkan Status -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-2">Statistik Berdasarkan Status</h2>
                <table class="min-w-full border-collapse block md:table">
                    <thead class="block md:table-header-group">
                        <tr class="border border-gray-300 block md:table-row">
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Status</th>
                            <th class="bg-gray-200 p-2 text-left font-bold block md:table-cell">Total</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group">
                        <?php while ($row = $result_status->fetch_assoc()): ?>
                            <tr class="border border-gray-300 block md:table-row">
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['status']); ?></td>
                                <td class="p-2 block md:table-cell"><?php echo htmlspecialchars($row['total']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>

</html>