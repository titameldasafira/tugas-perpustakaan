<?php
/*
Nama  : Tita Melda Safira
NIM   : 250102095
Kelas : TI-2C
*/

require_once "koneksi.php";

// Mengambil id dari URL
$id = isset($_GET["id"]) ? trim($_GET["id"]) : "";

if (empty($id) || !ctype_digit($id)) {
    die("ID anggota tidak valid.");
}

// Mengambil data anggota berdasarkan id
$query = "SELECT * FROM anggota WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Memeriksa apakah data ditemukan
if (mysqli_num_rows($result) == 0) {
    die("Data anggota tidak ditemukan.");
}

$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota Perpustakaan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #1f3864; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input[type="text"], select, textarea { width: 320px; padding: 6px; }
        button { margin-top: 16px; padding: 8px 20px; }
        .sukses {
            background: #e6f4ea;
            border-left: 5px solid #2e7d32;
            padding: 10px;
            width: 320px;
        }
    </style>
</head>
<body>
    <h2>Edit Data Anggota</h2>

    <form action="proses_update.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <label>Nomor Anggota</label><br>
        <input type="text" name="no_anggota"
            value="<?= htmlspecialchars($data['no_anggota']); ?>"
            maxlength="15" required>
        <br><br>

        <label>Nama Lengkap</label><br>
        <input type="text" name="nama_lengkap"
            value="<?= htmlspecialchars($data['nama_lengkap']); ?>"
            maxlength="100" required>
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email"
            value="<?= htmlspecialchars($data['email']); ?>"
            maxlength="100" required>
        <br><br>

        <label>Nomor HP</label><br>
        <input type="text" name="no_hp"
            value="<?= htmlspecialchars($data['no_hp']); ?>"
            maxlength="15" required>
        <br><br>

        <label>Jenis Anggota</label><br>
        <select name="jenis_anggota" required>

            <option value="Mahasiswa"
                <?= $data['jenis_anggota'] == "Mahasiswa" ? "selected" : ""; ?>>
                Mahasiswa
            </option>

            <option value="Dosen"
                <?= $data['jenis_anggota'] == "Dosen" ? "selected" : ""; ?>>
                Dosen
            </option>

            <option value="Tenaga Kependidikan"
                <?= $data['jenis_anggota'] == "Tenaga Kependidikan" ? "selected" : ""; ?>>
                Tenaga Kependidikan
            </option>
        </select>
        <br><br>

        <label>Alamat</label><br>
        <textarea name="alamat" rows="4" cols="40"
            required><?= htmlspecialchars($data['alamat']); ?></textarea>
        <br><br>

        <button type="submit" name="update">Update Data</button>
        <a href="data.php">Kembali</a>
    </form>
</body>
</html>