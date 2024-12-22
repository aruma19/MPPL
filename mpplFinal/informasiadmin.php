<?php
include 'config.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_informasi = $_POST['judul_informasi'];
    $isi_informasi = $_POST['isi_informasi'];

    if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_name = time() . "_" . $_FILES['foto']['name']; // Beri nama unik
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($file_name);

        if (move_uploaded_file($file_tmp, $upload_file)) {
            $sql = "INSERT INTO informasi (judul_informasi, isi_informasi, foto) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sss", $judul_informasi, $isi_informasi, $upload_file);

            if ($stmt->execute()) {
                header("Location: informasiadmin.php?success=true");
                exit;
            } else {
                echo "Gagal menyimpan informasi: " . $stmt->error;
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        echo "Error dalam file upload: " . $_FILES['foto']['error'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Buat Informasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

        .hidden {
            display: none;
        }

        .notification-error {
            background-color: #e3342f;
            /* Warna merah untuk notifikasi error */
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-1/4 p-4 flex flex-col items-center fixed top-0 left-0 h-full bg-blue-200"
            style="background-color: #89A9ED;">
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
            <a href="alldataadmin.php" id="linkDataAlumni" class="rounded-btn mb-4 w-full">
                <i class="fas fa-users"></i>Lihat Data Alumni
            </a>

            <!-- Link ke halaman Tambah Data -->
            <a href="tambahdataadmin.php" id="linkTambahData" class="rounded-btn mb-4 w-full">
                <i class="fas fa-users"></i>Tambah Data
            </a>

            <!-- Link ke halaman Buat Pengumuman -->
            <a href="buat_pengumuman.php" id="linkBuatPengumuman" class="rounded-btn mb-4 w-full  active">
                <i class="fas fa-bullhorn"></i>Pengumuman/Informasi
            </a>

            <!-- Link ke halaman Logout -->
            <a href="logout.php" id="linkLogout" class="rounded-btn w-full"
                style="background-color: #E8AA24; color:white;">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="w-3/4 p-8 ml-[25%]">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <a href="buat_pengumuman.php"
                        class="bg-gray-200 text-black py-2 px-4 rounded-l inline-block text-center 
                            <?php echo basename($_SERVER['PHP_SELF']) == 'buat_pengumuman.php' ? 'bg-blue-500 text-white' : ''; ?>">
                        PENGUMUMAN
                    </a>
                    <a href="informasiadmin.php"
                        class="bg-blue-200 text-black py-2 px-4 rounded-r inline-block text-center 
                            <?php echo basename($_SERVER['PHP_SELF']) == 'informasiadmin.php' ? 'bg-blue-500 text-white' : ''; ?>">
                        INFORMASI
                    </a>
                </div>
            </div>

            <div class="flex-grow  p-8">
                <center>
                    <h2 class="text-2xl font-bold mb-6">Informasi</h2>
                </center>
                <form action="informasiadmin.php" method="POST" enctype="multipart/form-data">
                    <!-- Judul Pengumuman -->
                    <div class="mb-4">
                        <label class="block text-lg font-semibold mb-2">Judul</label>
                        <input class="w-full p-2 border border-gray-300 rounded bg-gray-100" name="judul_informasi"
                            type="text" required />
                    </div>

                    <!-- Isi Pengumuman -->
                    <div class="mb-4">
                        <label class="block text-lg font-semibold mb-2">Isi</label>
                        <textarea class="w-full p-2 border border-gray-300 rounded bg-gray-100" name="isi_informasi"
                            rows="5" required></textarea>
                    </div>

                    <!-- Foto Pengumuman -->
                    <div class="mb-4">
                        <label class="block text-lg font-semibold mb-2">Foto </label>
                        <input class="w-full p-2 border border-gray-300 rounded bg-gray-100" type="file" name="foto"
                            required />
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end">
                        <button class="bg-red-500 text-white py-2 px-4 rounded mr-2" type="button"
                            onclick="window.history.back()">Back</button>
                        <button class="bg-blue-500 text-white py-2 px-4 rounded" type="submit">Buat Informasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="notification" class="hidden fixed top-4 right-4 bg-green-500 text-white p-4 rounded shadow-lg">
        <span id="notification-message">Informasi berhasil dibuat!</span>
        <button onclick="hideNotification()" class="ml-4 text-white font-bold">×</button>
    </div>
    <script>
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            const results = regex.exec(location.search);
            return results === null ? null : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        function showNotification() {
            const notification = document.getElementById('notification');
            notification.classList.remove('hidden');

            setTimeout(() => {
                hideNotification();
            }, 5000); // Sembunyikan setelah 5 detik
        }

        function hideNotification() {
            const notification = document.getElementById('notification');
            notification.classList.add('hidden');
        }

        document.addEventListener("DOMContentLoaded", () => {
            const success = getUrlParameter('success');
            if (success === 'true') {
                showNotification();
            }
        });
    </script>

</body>

</html>