<?php
// Menyertakan file koneksi database
include 'config.php';

// Mendapatkan data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$username = $_POST['username']; // Parameter tambahan untuk tabel users
$password = $_POST['password']; // Parameter tambahan untuk tabel users
$nomer_induk = $_POST['nomer_induk'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tahun_masuk = $_POST['tahun_masuk'];
$tahun_lulus = $_POST['tahun_lulus'];
$status = $_POST['status'];
$instansi = $_POST['instansi']; // Parameter tambahan untuk tabel alumni

// Validasi sederhana
if (empty($nama) || empty($email) || empty($username) || empty($password) || empty($nomer_induk) || empty($jenis_kelamin) || empty($tahun_masuk) || empty($tahun_lulus) || empty($status) || empty($instansi)) {
    die("Semua field harus diisi!");
}

// SQL untuk menambahkan data ke tabel `users` jika belum ada
$sql_users = "INSERT IGNORE INTO users (email, username, password) VALUES (?, ?, ?)";
$stmt_users = $connection->prepare($sql_users);

if (!$stmt_users) {
    die("Query gagal diproses (users): " . $connection->error);
}

// Mengikat parameter dan eksekusi query untuk tabel `users`
$stmt_users->bind_param('sss', $email, $username, $password);
if (!$stmt_users->execute()) {
    die("Terjadi kesalahan saat menambahkan data ke tabel users: " . $stmt_users->error);
}

// SQL untuk menyisipkan data ke tabel `alumni`
$sql_alumni = "INSERT INTO alumni (email, nama, nomer_induk, jenis_kelamin, tahun_masuk, tahun_lulus, status, instansi) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_alumni = $connection->prepare($sql_alumni);

if (!$stmt_alumni) {
    die("Query gagal diproses (alumni): " . $connection->error);
}

// Mengikat parameter ke statement
$stmt_alumni->bind_param('ssssssss', $email, $nama, $nomer_induk, $jenis_kelamin, $tahun_masuk, $tahun_lulus, $status, $instansi);

// Menjalankan query untuk tabel alumni
if ($stmt_alumni->execute()) {
    echo "Data berhasil ditambahkan!";
    // Redirect ke halaman tertentu (misalnya halaman data alumni)
    header("Location: alldataadmin.php");
    exit();
} else {
    echo "Terjadi kesalahan: " . $stmt_alumni->error;
}

// Menutup statement dan koneksi
$stmt_users->close();
$stmt_alumni->close();
$connection->close();
?>
