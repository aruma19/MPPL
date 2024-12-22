<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginsiswa.php?pesan=belum_login");
    exit();
}

// Fetch user data from 'users' and 'alumni' tables using a JOIN
$username = $_SESSION['username'];
$query = mysqli_query($connection, "
    SELECT u.email, u.username, a.nama, a.nomer_induk, a.jenis_kelamin, a.tahun_masuk, a.tahun_lulus, a.status, a.instansi
    FROM users u
    JOIN alumni a ON u.email = a.email
    WHERE u.username = '$username'
");
$userData = mysqli_fetch_assoc($query);

if (!$userData) {
    header("Location: loginsiswa.php?pesan=gagal");
    exit();
}

// Handle form submission for updating 'status' and 'instansi'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $instansi = mysqli_real_escape_string($connection, $_POST['instansi']);

    // Update query
    $updateQuery = "UPDATE alumni SET status='$status', instansi='$instansi' WHERE email='{$userData['email']}'";

    if (mysqli_query($connection, $updateQuery)) {
        $successMessage = "Data berhasil diperbarui.";
        // Refresh user data after update
        $query = mysqli_query($connection, "
            SELECT u.email, u.username, a.nama, a.nomer_induk, a.jenis_kelamin, a.tahun_masuk, a.tahun_lulus, a.status, a.instansi
            FROM users u
            JOIN alumni a ON u.email = a.email
            WHERE u.username = '$username'
        ");
        $userData = mysqli_fetch_assoc($query);
    } else {
        $errorMessage = "Terjadi kesalahan saat memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <div class="bg-white rounded-xl p-6 w-full fixed lg:w-1/4 flex flex-col items-center shadow-lg"
            style="padding-bottom:180px;">
            <div class="">
                <div class="flex items-center justify-center" style="font-family: Typography; font-size: 20px; padding-bottom:50px;">
                    <a class="logowisuda">
                        <img src="assets/wisudalur.png" alt="Logo Wisuda" height="30px" width="20px">
                    </a>
                    <c<a class="navbar-brand" href="#" style="color: black; margin-left: 10px;">EduTrack</a>
                </div>
                <div class="flex items-center justify-center" style="padding-bottom:20px;">
                    <img src="assets/profil.png" alt="EduTrack logo" class="mr-2 w-[50%] h-auto">
                </div>
                <div class="keterangan">
                    <p class="text-center font-semibold">Username:
                        <?php echo htmlspecialchars($userData['username']); ?></p>
                    <p class="text-center font-semibold mb-4">Nama: <?php echo htmlspecialchars($userData['nama']); ?>
                    </p>
                    <br>
                    <a href="mainpageSiswa.php" id="kembali" class="rounded-btn mb-4 w-full" style="margin-top:30px;">
                        <i class="fas fa-bullhorn"></i> Kembali
                    </a>
                    <a href="logout.php" id="linkLogout" class="rounded-btn w-full"
                        style="background-color: #E8AA24; color:white;">
                        <i class="fas fa-bullhorn"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 space-y-6 ml-auto lg:pl-[27%]" style="padding-top:4px;">
            <div class="bg-white p-6 rounded-lg  shadow-lg">
                <h1 class="text-center text-2xl font-semibold mb-6 mt-6">Update Data</h1>

                <?php if (isset($successMessage)) { ?>
                    <p class="text-green-500 text-center mb-4"><?php echo $successMessage; ?></p>
                <?php } elseif (isset($errorMessage)) { ?>
                    <p class="text-red-500 text-center mb-4"><?php echo $errorMessage; ?></p>
                <?php } ?>

                <form method="POST" action="">
                    <!-- Email (Read-only) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="email">Email</label>
                        <input class="w-full p-2 border rounded bg-gray-200" id="email" name="email" type="email"
                            value="<?php echo htmlspecialchars($userData['email']); ?>" readonly />
                    </div>

                    <!-- Nama (Read-only) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="nama">Nama</label>
                        <input class="w-full p-2 border rounded bg-gray-200" id="nama" name="nama" type="text"
                            value="<?php echo htmlspecialchars($userData['nama']); ?>" readonly />
                    </div>

                    <!-- Nomer Induk (Read-only) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="nomer_induk">Nomer Induk</label>
                        <input class="w-full p-2 border rounded bg-gray-200" id="nomer_induk" name="nomer_induk"
                            type="text" value="<?php echo htmlspecialchars($userData['nomer_induk']); ?>" readonly />
                    </div>

                    <!-- Jenis Kelamin (Read-only) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="jenis_kelamin">Jenis Kelamin</label>
                        <input class="w-full p-2 border rounded bg-gray-200" id="jenis_kelamin" name="jenis_kelamin"
                            type="text" value="<?php echo htmlspecialchars($userData['jenis_kelamin']); ?>" readonly />
                    </div>

                    <!-- Tahun Masuk (Read-only) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="tahun_masuk">Tahun Masuk</label>
                        <input class="w-full p-2 border rounded bg-gray-200" id="tahun_masuk" name="tahun_masuk"
                            type="text" value="<?php echo htmlspecialchars($userData['tahun_masuk']); ?>" readonly />
                    </div>

                    <!-- Tahun Lulus (Read-only) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="tahun_lulus">Tahun Lulus</label>
                        <input class="w-full p-2 border rounded bg-gray-200" id="tahun_lulus" name="tahun_lulus"
                            type="text" value="<?php echo htmlspecialchars($userData['tahun_lulus']); ?>" readonly />
                    </div>

                    <!-- Status (Editable) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="status">Status</label>
                        <?php
                        $statusValue = isset($userData['status']) ? htmlspecialchars($userData['status']) : '';
                        ?>

                        <select class="w-full p-2 border border-gray-300 rounded" name="status" required>
                            <option value="Kuliah" <?= $statusValue == 'Kuliah' ? 'selected' : ''; ?>>Kuliah</option>
                            <option value="Bekerja" <?= $statusValue == 'Bekerja' ? 'selected' : ''; ?>>Bekerja</option>
                            <option value="Menganggur" <?= $statusValue == 'Menganggur' ? 'selected' : ''; ?>>Menganggur
                            </option>
                            <option value="Pegawai Negeri Sipil (PNS)" <?= $statusValue == 'Pegawai Negeri Sipil (PNS)' ? 'selected' : ''; ?>>Pegawai Negeri Sipil (PNS)</option>
                            <option value="Polisi" <?= $statusValue == 'Polisi' ? 'selected' : ''; ?>>Polisi</option>
                            <option value="TNI (Tentara Nasional Indonesia)" <?= $statusValue == 'TNI (Tentara Nasional Indonesia)' ? 'selected' : ''; ?>>TNI (Tentara Nasional Indonesia)</option>
                            <option value="Wirausahawan" <?= $statusValue == 'Wirausahawan' ? 'selected' : ''; ?>>
                                Wirausahawan</option>
                            <option value="Karyawan Swasta" <?= $statusValue == 'Karyawan Swasta' ? 'selected' : ''; ?>>
                                Karyawan Swasta</option>
                            <option value="Pegawai BUMN/BUMD" <?= $statusValue == 'Pegawai BUMN/BUMD' ? 'selected' : ''; ?>>Pegawai BUMN/BUMD</option>
                            <option value="Freelancer" <?= $statusValue == 'Freelancer' ? 'selected' : ''; ?>>Freelancer
                            </option>
                            <option value="Tenaga Pengajar (Guru/Dosen)" <?= $statusValue == 'Tenaga Pengajar (Guru/Dosen)' ? 'selected' : ''; ?>>Tenaga Pengajar (Guru/Dosen)</option>
                            <option value="Peneliti" <?= $statusValue == 'Peneliti' ? 'selected' : ''; ?>>Peneliti</option>
                            <option value="Profesional (Dokter, Pengacara, Akuntan, dll.)" <?= $statusValue == 'Profesional (Dokter, Pengacara, Akuntan, dll.)' ? 'selected' : ''; ?>>Profesional (Dokter,
                                Pengacara, Akuntan, dll.)</option>
                            <option value="Pekerja di Luar Negeri" <?= $statusValue == 'Pekerja di Luar Negeri' ? 'selected' : ''; ?>>Pekerja di Luar Negeri</option>
                            <option value="Seniman/Desainer/Artis" <?= $statusValue == 'Seniman/Desainer/Artis' ? 'selected' : ''; ?>>Seniman/Desainer/Artis</option>
                            <option value="Konsultan" <?= $statusValue == 'Konsultan' ? 'selected' : ''; ?>>Konsultan
                            </option>
                            <option value="Pekerja di Industri Kreatif" <?= $statusValue == 'Pekerja di Industri Kreatif' ? 'selected' : ''; ?>>Pekerja di Industri Kreatif</option>
                            <option value="Aktivis/Relawan Sosial" <?= $statusValue == 'Aktivis/Relawan Sosial' ? 'selected' : ''; ?>>Aktivis/Relawan Sosial</option>
                            <option value="Tidak Bekerja (Lanjut Studi, Mengurus Rumah Tangga, dll.)"
                                <?= $statusValue == 'Tidak Bekerja (Lanjut Studi, Mengurus Rumah Tangga, dll.)' ? 'selected' : ''; ?>>Tidak Bekerja (Lanjut Studi, Mengurus Rumah Tangga, dll.)</option>
                            <option value="Meninggal Dunia" <?= $statusValue == 'Meninggal Dunia' ? 'selected' : ''; ?>>
                                Meninggal Dunia</option>
                            <option value="Lainnya" <?= $statusValue == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>

                    </div>

                    <!-- Instansi (Editable) -->
                    <div class="mb-4">
                        <label class="block text-gray-700" for="instansi">Instansi</label>
                        <input class="w-full p-2 border rounded" id="instansi" name="instansi" type="text"
                            value="<?php echo htmlspecialchars($userData['instansi']); ?>" required />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button class="bg-blue-500 text-white py-2 px-4 rounded" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>