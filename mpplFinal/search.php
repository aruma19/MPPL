<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <div class="w-1/4 p-4 flex flex-col items-center fixed top-0 left-0 h-full" style="background-color: #89A9ED;">
        <div class="flex items-center mb-6" style="font-family: 'kadwa'; padding-bottom:50px;">
            <span class="text-xl">EduTrack</span>
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
            <i class="fas fa-bullhorn"></i>Pengumuman/Informasi
        </a>

        <!-- Link ke halaman Logout -->
        <a href="logout.php" id="linkLogout" class="rounded-btn w-full" style="background-color: #E8AA24; color:white">
            <i class="fas fa-sign-out-alt"></i>Logout
        </a>
    </div>
        <!-- Main Content -->
        <div class="w-3/4 p-8 ml-[25%]">
            <?php
            // Koneksi ke database
            $conn = new mysqli("localhost", "root", "", "edutrack");

            // Periksa koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Ambil query pencarian
            $nama = isset($_GET['nama']) ? $_GET['nama'] : '';

            // Cek apakah input tidak kosong
            if ($nama) {
                // Query pencarian
                $sql = "SELECT * FROM alumni WHERE nama LIKE ?";
                $stmt = $conn->prepare($sql);
                $search = "%" . $nama . "%";
                $stmt->bind_param("s", $search);
                $stmt->execute();
                $result = $stmt->get_result();

                // Tampilkan hasil pencarian
                echo "<h1 class='text-xl font-bold mb-4 text-center'>Hasil Pencarian untuk: '$nama'</h1>";

                if ($result->num_rows > 0) {
                    // Tampilkan tabel hasil pencarian
                    echo "<table class='table-auto w-full border-collapse border border-gray-300'>";
                    echo "<thead>
                            <tr class='bg-gray-200'>
                                <th class='border border-gray-300 py-2 px-4'>No</th>
                                <th class='border border-gray-300 py-2 px-4'>Nama</th>
                                <th class='border border-gray-300 py-2 px-4'>Nomor Induk</th>
                                <th class='border border-gray-300 py-2 px-4'>Jenis Kelamin</th>
                                <th class='border border-gray-300 py-2 px-4'>Angkatan</th>
                                <th class='border border-gray-300 py-2 px-4'>Status</th>
                                <th class='border border-gray-300 py-2 px-4'>Instansi</th>
                                <th class='border border-gray-300 py-2 px-4'>Terakhir Update</th>
                                <th class='border border-gray-300 py-2 px-4'>Ubah</th>
                            </tr>
                        </thead><tbody>";

                    $no = 1; // Nomor urut
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border border-gray-300 py-2 px-4 text-center'>" . $no++ . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4'>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4'>" . htmlspecialchars($row['nomer_induk']) . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4 text-center'>" . ($row['jenis_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan') . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4 text-center'>" . htmlspecialchars($row['tahun_masuk']) . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4 text-center'>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4'>" . htmlspecialchars($row['instansi']) . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4 text-center'>" . htmlspecialchars($row['terakhir_update']) . "</td>";
                        echo "<td class='border border-gray-300 py-2 px-4 text-center'>
                            <div class='flex justify-start space-x-2'>
                                <a href='editdataadmin.php?nama=" . htmlspecialchars($row['nama']) . "' class='bg-blue-500 text-white py-1 px-2 rounded mr-2'>Edit</a>
                                <a href='deletedata.php?nama=" . htmlspecialchars($row['nama']) . "' class='bg-red-500 text-white py-1 px-2 rounded' onclick='return confirm(\"Are you sure you want to delete this item?\")'>Delete</a>
                            </div>
                            </td>";
                        echo "</tr><br>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p class='text-center mt-4'>Tidak ada hasil ditemukan.</p>";
                }

                $stmt->close();
            } else {
                echo "<p class='text-center mt-4'>Masukkan nama untuk mencari.</p>";
            }

            $conn->close();
            ?><br>
            <div class="flex justify-end">
                <!-- Tombol Kembali -->
                 <br>
                <button class="bg-red-500 text-white py-2 px-12 rounded mr-3" type="button"
                    onclick="window.history.back()">
                    Back
                </button>
            </div>
        </div>
    </div>
</body>

</html>