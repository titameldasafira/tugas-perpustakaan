<?php
/*
Nama  : Tita Melda Safira
NIM   : 250102095
Kelas : TI-2C
*/

session_start();

// Ambil data flash dari session jika ada
$valid  = false;
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old']    ?? [];

$no_anggota    = $old['no_anggota']    ?? "";
$nama_lengkap  = $old['nama_lengkap']  ?? "";
$email         = $old['email']         ?? "";
$no_hp         = $old['no_hp']         ?? "";
$jenis_anggota = $old['jenis_anggota'] ?? "";
$alamat        = $old['alamat']        ?? "";

// Jika proses_anggota.php berhasil menyimpan data
if (isset($_SESSION['sukses_data'])) {
    $valid         = true;
    $data          = $_SESSION['sukses_data'];
    $no_anggota    = $data['no_anggota'];
    $nama_lengkap  = $data['nama_lengkap'];
    $email         = $data['email'];
    $no_hp         = $data['no_hp'];
    $jenis_anggota = $data['jenis_anggota'];
    $alamat        = $data['alamat'];
}

// Hapus session setelah dibaca agar bersih saat halaman di-refresh
unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['sukses_data']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Anggota Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        h1 {
            color: #1f3864;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        input[type="text"],
        select,
        textarea {
            width: 320px;
            padding: 6px;
        }
        button {
            margin-top: 16px;
            padding: 8px 20px;
        }
        .error {
            display: block;
            color: #c0392b;
            font-size: 14px;
            margin-top: 4px;
        }
        .sukses {
            background: #e6f4ea;
            border-left: 5px solid #2e7d32;
            padding: 10px;
            width: 320px;
        }
        table {
            border-collapse: collapse;
            margin-top: 12px;
        }
        th,
        td {
            border: 1px solid #999;
            padding: 8px 14px;
            text-align: left;
        }
        th {
            background: #e9eef8;
        }
    </style>
</head>
<body>
    <h1>Pendaftaran Anggota Perpustakaan</h1>

    <!-- Error database jika gagal INSERT -->
    <?php if (!empty($errors['db'])) { ?>
        <p class="error"><?php echo htmlspecialchars($errors['db']); ?></p>
    <?php } ?>

    <!-- Jika valid & tersimpan, tampilkan notifikasi sukses + tabel ringkasan -->
    <?php if ($valid) { ?>
        <p class="sukses">Data berhasil divalidasi dan disimpan.</p>
        <table>
            <tr>
                <th>Nomor Anggota</th>
                <td><?php echo htmlspecialchars($no_anggota); ?></td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td><?php echo htmlspecialchars($nama_lengkap); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <th>Nomor HP</th>
                <td><?php echo htmlspecialchars($no_hp); ?></td>
            </tr>
            <tr>
                <th>Jenis Anggota</th>
                <td><?php echo htmlspecialchars($jenis_anggota); ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo htmlspecialchars($alamat); ?></td>
            </tr>
        </table>
        <p><a href="form_anggota.php">Isi form lagi</a></p>

    <?php } else { ?>
        <form action="proses_anggota.php" method="post">
            <!-- Nomor Anggota -->
            <label for="no_anggota">Nomor Anggota</label>
            <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($no_anggota); ?>">
            <span class="error"><?php echo htmlspecialchars($errors['no_anggota'] ?? ""); ?></span>

            <!-- Nama Lengkap -->
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($nama_lengkap); ?>">
            <span class="error"><?php echo htmlspecialchars($errors['nama_lengkap'] ?? ""); ?></span>

            <!-- Email -->
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo htmlspecialchars($errors['email'] ?? ""); ?></span>

            <!-- Nomor HP -->
            <label for="no_hp">Nomor HP</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($no_hp); ?>">
            <span class="error"><?php echo htmlspecialchars($errors['no_hp'] ?? ""); ?></span>

            <!-- Jenis Anggota -->
            <label for="jenis_anggota">Jenis Anggota</label>
            <select id="jenis_anggota" name="jenis_anggota">
                <option value="">-- Pilih Jenis Anggota --</option>
                <option value="Mahasiswa" <?php if ($jenis_anggota == "Mahasiswa") echo "selected"; ?>>Mahasiswa</option>
                <option value="Dosen" <?php if ($jenis_anggota == "Dosen") echo "selected"; ?>>Dosen</option>
                <option value="Tenaga Kependidikan" <?php if ($jenis_anggota == "Tenaga Kependidikan") echo "selected"; ?>>Tenaga Kependidikan</option>
            </select>
            <span class="error"><?php echo htmlspecialchars($errors['jenis_anggota'] ?? ""); ?></span>

            <!-- Alamat -->
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="4"><?php echo htmlspecialchars($alamat); ?></textarea>
            <span class="error"><?php echo htmlspecialchars($errors['alamat'] ?? ""); ?></span>

            <button type="submit">Simpan</button>
        </form>
    <?php } ?>
</body>
</html>