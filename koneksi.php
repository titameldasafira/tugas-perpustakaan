<?php
/*
Nama  : Tita Melda Safira
NIM   : 250102095
Kelas : TI-2C
*/
// koneksi.php - Menghubungkan PHP dengan database MySQL (MySQLi procedural)

// PHP 8.1+ secara bawaan melempar exception bila koneksi gagal.
// Baris ini mematikannya agar kesalahan dapat diperiksa dengan if.
mysqli_report(MYSQLI_REPORT_ERROR);

// Parameter koneksi
$host = "localhost";
$username = "root";
$password = "";
$database = "db_perpustakaan";

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . htmlspecialchars(mysqli_connect_error()));
} else {
    echo "Koneksi berhasil";
}

// Mengatur karakter agar huruf dan simbol tersimpan dengan benar
mysqli_set_charset($koneksi,"utf8mb4");