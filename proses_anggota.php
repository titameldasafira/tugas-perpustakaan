<?php
/*
Nama  : Tita Melda Safira
NIM   : 250102095
Kelas : TI-2C
*/

session_start();

// Halaman ini hanya boleh dibuka melalui pengiriman form (POST)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form_anggota.php");
    exit;
}

// 1. Ambil data dan bersihkan spasi di awal/akhir
$no_anggota    = isset($_POST["no_anggota"])    ? trim($_POST["no_anggota"])    : "";
$nama_lengkap  = isset($_POST["nama_lengkap"])  ? trim($_POST["nama_lengkap"])  : "";
$email         = isset($_POST["email"])         ? trim($_POST["email"])         : "";
$no_hp         = isset($_POST["no_hp"])         ? trim($_POST["no_hp"])         : "";
$jenis_anggota = isset($_POST["jenis_anggota"]) ? trim($_POST["jenis_anggota"]) : "";
$alamat        = isset($_POST["alamat"])        ? trim($_POST["alamat"])        : "";

// 2. Validasi di sisi server (Associative array agar muncul di bawah tiap kolom)
$daftar_jenis = ["Mahasiswa", "Dosen", "Tenaga Kependidikan"];
$errors       = [];

// Nomor Anggota: wajib diisi, hanya angka, maksimal 15 digit
if (empty($no_anggota)) {
    $errors['no_anggota'] = "Nomor anggota tidak boleh kosong.";
} elseif (!ctype_digit($no_anggota)) {
    $errors['no_anggota'] = "Nomor anggota hanya boleh berisi angka.";
} elseif (strlen($no_anggota) > 15) {
    $errors['no_anggota'] = "Nomor anggota maksimal 15 digit.";
}

// Nama Lengkap: wajib diisi, maksimal 100 karakter
if (empty($nama_lengkap)) {
    $errors['nama_lengkap'] = "Nama lengkap tidak boleh kosong.";
} elseif (strlen($nama_lengkap) > 100) {
    $errors['nama_lengkap'] = "Nama lengkap maksimal 100 karakter.";
}

// Email: wajib diisi, format email valid, maksimal 100 karakter
if (empty($email)) {
    $errors['email'] = "Email tidak boleh kosong.";
} elseif (strlen($email) > 100) {
    $errors['email'] = "Email maksimal 100 karakter.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Format email tidak valid.";
}

// Nomor HP: wajib diisi, hanya angka, 10 sampai 13 digit
if (empty($no_hp)) {
    $errors['no_hp'] = "Nomor HP tidak boleh kosong.";
} elseif (!ctype_digit($no_hp)) {
    $errors['no_hp'] = "Nomor HP hanya boleh berisi angka.";
} elseif (strlen($no_hp) < 10 || strlen($no_hp) > 13) {
    $errors['no_hp'] = "Nomor HP harus terdiri dari 10 sampai 13 digit.";
}

// Jenis Anggota: wajib dipilih sesuai daftar
if (empty($jenis_anggota)) {
    $errors['jenis_anggota'] = "Jenis anggota wajib dipilih.";
} elseif (!in_array($jenis_anggota, $daftar_jenis, true)) {
    $errors['jenis_anggota'] = "Jenis anggota tidak valid.";
}

// Alamat: wajib diisi
if (empty($alamat)) {
    $errors['alamat'] = "Alamat tidak boleh kosong.";
}

// 3. Bila semua data valid, hubungkan ke database dan simpan data (INSERT)
if (empty($errors)) {
    require_once "koneksi.php";

    $sql  = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "ssssss",
            $no_anggota,
            $nama_lengkap,
            $email,
            $no_hp,
            $jenis_anggota,
            $alamat
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['sukses_data'] = compact(
                'no_anggota',
                'nama_lengkap',
                'email',
                'no_hp',
                'jenis_anggota',
                'alamat'
            );
        } else {
            $_SESSION['errors'] = ['db' => "Gagal menyimpan ke database: " . mysqli_stmt_error($stmt)];
            $_SESSION['old']    = compact('no_anggota', 'nama_lengkap', 'email', 'no_hp', 'jenis_anggota', 'alamat');
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['errors'] = ['db' => "Terjadi kesalahan pada query database: " . mysqli_error($koneksi)];
        $_SESSION['old']    = compact('no_anggota', 'nama_lengkap', 'email', 'no_hp', 'jenis_anggota', 'alamat');
    }

    mysqli_close($koneksi);
} else {
    // Titipkan pesan error & isian lama ke session agar muncul kembali di form
    $_SESSION['errors'] = $errors;
    $_SESSION['old']    = compact('no_anggota', 'nama_lengkap', 'email', 'no_hp', 'jenis_anggota', 'alamat');
}

// Kembali ke halaman form
header("Location: form_anggota.php");
exit;