<?php
// Include file konfigurasi database
include 'config.php';

// Periksa apakah data dikirim melalui metode GET dengan parameter nama
if (isset($_GET['nama'])) {
    // Ambil nama dari parameter GET
    $nama = urldecode($_GET['nama']);

    // Validasi nama
    if (empty($nama)) {
        echo "Nama tidak valid!";
        exit;
    }

    // Mulai transaksi
    $connection->begin_transaction();

    try {
        // Query untuk mendapatkan email berdasarkan nama
        $sql_email = "SELECT email FROM alumni WHERE nama = ?";
        $stmt_email = $connection->prepare($sql_email);

        if (!$stmt_email) {
            throw new Exception("Gagal menyiapkan query (ambil email): " . $connection->error);
        }

        $stmt_email->bind_param("s", $nama);
        $stmt_email->execute();
        $result = $stmt_email->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Hapus dari tabel alumni
            $sql_delete_alumni = "DELETE FROM alumni WHERE nama = ?";
            $stmt_delete_alumni = $connection->prepare($sql_delete_alumni);
            if (!$stmt_delete_alumni) {
                throw new Exception("Gagal menyiapkan query (hapus alumni): " . $connection->error);
            }
            $stmt_delete_alumni->bind_param("s", $nama);
            if (!$stmt_delete_alumni->execute()) {
                throw new Exception("Gagal menghapus data dari tabel alumni: " . $stmt_delete_alumni->error);
            }

            // Hapus dari tabel users menggunakan email yang terkait
            $sql_delete_users = "DELETE FROM users WHERE email = ?";
            $stmt_delete_users = $connection->prepare($sql_delete_users);
            if (!$stmt_delete_users) {
                throw new Exception("Gagal menyiapkan query (hapus users): " . $connection->error);
            }
            $stmt_delete_users->bind_param("s", $email);
            if (!$stmt_delete_users->execute()) {
                throw new Exception("Gagal menghapus data dari tabel users: " . $stmt_delete_users->error);
            }

            // Commit transaksi jika semua berhasil
            $connection->commit();
            echo "Data berhasil dihapus!";
            // Redirect ke halaman data alumni (sesuaikan dengan kebutuhan)
            header("Location: alldataadmin.php");
            exit;

        } else {
            throw new Exception("Data tidak ditemukan di tabel alumni.");
        }
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $connection->rollback();
        echo "Gagal menghapus data: " . $e->getMessage();
    }

    // Tutup statement
    $stmt_email->close();
    if (isset($stmt_delete_alumni)) $stmt_delete_alumni->close();
    if (isset($stmt_delete_users)) $stmt_delete_users->close();

} else {
    echo "Nama tidak ditemukan!";
    exit;
}

// Tutup koneksi
$connection->close();
?>
