<?php
/*
Nama  : Tita Melda Safira
NIM   : 250102095
Kelas : TI-2C
*/

require_once "koneksi.php";

// Cegah akses langsung tanpa menekan tombol Hapus (POST)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: data.php");
    exit;
}

// Mengambil ID anggota
$id = isset($_POST["id"]) ? trim($_POST["id"]) : "";

// Memeriksa ID
// if (!isset($id) || !ctype_digit((string) $id)) {
//     die("ID anggota tidak valid.");
// }

// Membuat query DELETE
$query = "DELETE FROM anggota WHERE id = ?";

// Menyiapkan prepared statement
$stmt = mysqli_prepare($koneksi, $query);

// Mengikat parameter
mysqli_stmt_bind_param($stmt, "i", $id);

// Menjalankan query DELETE
if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
    header("Location: data.php?status=terhapus");
    exit;
} else {
    $pesan_db = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
    die("Gagal menghapus data: " . htmlspecialchars($pesan_db));
}
?>