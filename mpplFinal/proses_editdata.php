<?php
// Include file konfigurasi database
include 'config.php';

// Periksa apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $instansi = isset($_POST['instansi']) ? trim($_POST['instansi']) : '';

    // Validasi ID
    if ($id <= 0) {
        echo "ID tidak valid!";
        exit;
    }

    // Validasi data yang diperlukan
    if (empty($status)) {
        echo "Status wajib diisi!";
        exit;
    }

    // Query untuk mengupdate data
    $sql = "UPDATE alumni SET status = ?, instansi = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssi", $status, $instansi, $id);
        
        // Eksekusi query
        if ($stmt->execute()) {
            echo "Data berhasil diupdate!";
            // Redirect ke halaman data alumni (sesuaikan dengan kebutuhan)
            header("Location: alldataadmin.php");
            exit;
        } else {
            echo "Gagal mengupdate data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal menyiapkan query: " . $connection->error;
    }
} else {
    echo "Metode tidak diizinkan!";
    exit;
}

// Tutup koneksi
$connection->close();
?>
