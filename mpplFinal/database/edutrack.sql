-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 04:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edutrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`) VALUES
(123, 'jeslyn@gmail.com', 'adminjeslyn', 'mpplkecintaankita'),
(124, 'resti123@gmail.com', 'restidani', 'resti123'),
(125, 'awangsinawang@gmail.com', 'awangsn', '123wes');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nomer_induk` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `status` enum('Kuliah','Bekerja','Menganggur','Pegawai Negeri Sipil (PNS)','Polisi','TNI (Tentara Nasional Indonesia)','Wirausahawan','Karyawan Swasta','Pegawai BUMN/BUMD','Freelancer','Tenaga Pengajar (Guru/Dosen)','Peneliti','Profesional (Dokter, Pengacara, Akuntan, dll.)','Pekerja di Luar Negeri','Seniman/Desainer/Artis','Konsultan','Pekerja di Industri Kreatif','Aktivis/Relawan Sosial','Tidak Bekerja (Lanjut Studi, Mengurus Rumah Tangga, dll.)','Meninggal Dunia','Lainnya') NOT NULL DEFAULT 'Lainnya',
  `instansi` varchar(255) DEFAULT NULL,
  `terakhir_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `email`, `nama`, `nomer_induk`, `jenis_kelamin`, `tahun_masuk`, `tahun_lulus`, `status`, `instansi`, `terakhir_update`) VALUES
(2, 'jane.miller@test.org', 'Jane Miller', '202302', 'P', '2018', '2022', 'Karyawan Swasta', 'Deloitte', '2024-12-20 15:36:02'),
(3, 'hank.brown@test.org', 'Hank Brown', '202303', 'L', '2017', '2021', 'Wirausahawan', 'Brown Ventures', '2024-12-20 07:45:29'),
(4, 'alice.moore@mail.com', 'Alice Moore', '202304', 'P', '2020', '2024', 'Kuliah', 'Universitas Gamping Mengidul', '2024-12-22 02:43:59'),
(5, 'john.taylor@school.edu', 'John Taylor', '202305', 'L', '2016', '2020', 'Konsultan', 'Polres Jakarta', '2024-12-22 14:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id` int(5) NOT NULL,
  `judul_informasi` varchar(100) NOT NULL,
  `isi_informasi` varchar(1000) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id`, `judul_informasi`, `isi_informasi`, `foto`, `tanggal_dibuat`) VALUES
(4, 'Perayaan Dies Natalis SMP 1 Ngadirejo', 'Dalam rangka memperingati Dies Natalis ke-50 SMP Negeri 1 Ngadirejo, kami mengundang seluruh siswa, guru, staf, alumni, dan orang tua siswa untuk menghadiri acara perayaan yang akan diselenggarakan pada:\r\n\r\nHari/Tanggal: Sabtu, 10 Februari 2024\r\nWaktu: Pukul 08.00 WIB s/d selesai\r\nTempat: Aula SMP Negeri 1 Ngadirejo\r\n\r\nRangkaian acara:\r\n\r\nGelar Karya Projek Penguatan Profil Pelajar Pancasila (P5)\r\nPentas Seni dan Budaya\r\nSambutan dari Alumni dan Guru\r\nBazaar Kewirausahaan\r\nHiburan Musik\r\nUntuk informasi lebih lanjut, dapat menghubungi panitia melalui nomor berikut:\r\n0812-3456-7890 (Ibu Siti) atau 0856-1234-5678 (Bapak Andi)\r\n\r\nMari bersama-sama meriahkan momen istimewa ini dan pererat tali silaturahmi!\r\n\r\nDemikian pengumuman ini disampaikan. Atas perhatian dan partisipasinya, kami ucapkan terima kasih.\r\n\r\nPanitia Dies Natalis ke-50 SMP Negeri 1 Ngadirejo', 'uploads/1_6X7xKNffMMWEFCyrqC1vDg.jpeg', '2024-12-22 13:46:01'),
(5, 'Kerja Bakti', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'uploads/encoded_image.png', '2024-12-22 14:17:44'),
(6, 'Galangan Dana', 'Judul: Bantuan Pendidikan Anak Yatim di Desa Harapan\r\nDeskripsi:\r\nKami menggalang dana untuk membantu 50 anak yatim di Desa Harapan mendapatkan pendidikan yang layak. Donasi yang terkumpul akan digunakan untuk membeli perlengkapan sekolah, buku, seragam, dan membayar biaya pendidikan mereka.\r\nSetiap kontribusi Anda, sekecil apa pun, akan memberikan dampak besar bagi masa depan mereka.\r\n\r\nTarget Dana: Rp50.000.000\r\nDurasi Penggalangan: 22 Desember 2024 - 22 Januari 2025\r\nDana Terkumpul Saat Ini: Rp15.000.000', 'uploads/1734877575_bgreal.jpg', '2024-12-22 14:26:15'),
(7, 'Pagelaran Acara Terbesar SMPN 1 Ngadirejo ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'uploads/1734879417_iio.jpg', '2024-12-22 14:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul_pengumuman` varchar(255) NOT NULL,
  `isi_pengumuman` text NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul_pengumuman`, `isi_pengumuman`, `tanggal_dibuat`) VALUES
(4, 'Workshop', 'PENGUMUMAN\r\n\r\nDiberitahukan kepada seluruh siswa kelas XII bahwa:\r\n\r\nHari: Senin\r\nTanggal: 15 Januari 2024\r\nWaktu: 08.00 - 12.00 WIB\r\nTempat: Aula Sekolah\r\n\r\nAkan dilaksanakan Workshop Persiapan Ujian Nasional. Semua siswa diharapkan hadir tepat waktu dan membawa perlengkapan tulis.\r\n\r\nDemikian pengumuman ini disampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.\r\n\r\nHormat kami,\r\nPanitia Pelaksana', '2024-12-22 13:12:47'),
(5, 'Update Data', 'Kepada seluruh Alumni SMP N 1 Ngadirejo dimohon untuk mengisi Update data Tahunan pada:\r\nTanggal : 20 Juni 2022', '2024-12-22 13:30:33'),
(6, 'Update Data Tahap 2', 'Dimohon kepada seluruh alumni untuk melakukan update data', '2024-12-22 14:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`) VALUES
(1, 'restiramadhani101@smadaprima.sch.id', 'restirama', 'smadaprima2019'),
(3, 'maudiayunda99@smadaprima.sch.id', 'maudiayunda', 'smadaprima2019'),
(4, 'john.wilson@mail.com', 'john13', 'cH89XvDrF8gc'),
(5, 'jane.miller@test.org', 'jane83', 'mcXN6K3WzYQG'),
(6, 'hank.brown@test.org', 'hank30', '22t0WLMGrLUJ'),
(7, 'alice.moore@mail.com', 'alice71', 'YhP2uitRNLLr'),
(8, 'john.taylor@school.edu', 'john30', 'rzBOEmUXeEBc'),
(11, 'almasfaros@gmail.com', 'almsfaros', 'faros12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomer_induk` (`nomer_induk`),
  ADD KEY `fk_email` (`email`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `fk_email` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
