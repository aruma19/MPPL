<?php
session_start();

// Hapus semua sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login dengan pesan logout
header("Location: landingpage.php?pesan=logout");
exit();
