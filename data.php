<?php
/*
Nama  : Tita Melda Safira
NIM   : 250102095
Kelas : TI-2C
*/

require_once 'koneksi.php';

$sql    = "SELECT * FROM anggota";
$hasil  = mysqli_query($koneksi, $sql);
$jumlah = mysqli_num_rows($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th {
            padding: 12px;
            text-align: center;
            border: 1px solid black;
        }

        tr,
        td {
            padding: 12px;
            border: 1px solid black;
            text-align: left;
        }

        .inline {
            display: inline;
        }
    </style>
</head>
<body>
    <h1>Data Anggota Perpustakaan</h1>
    <table>
        <tr>
            <th>No</th>
            <th>Nomor Anggota</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Nomor HP</th>
            <th>Jenis Anggota</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($baris = mysqli_fetch_assoc($hasil)) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($baris['no_anggota']); ?></td>
            <td><?php echo htmlspecialchars($baris['nama_lengkap']); ?></td>
            <td><?php echo htmlspecialchars($baris['email']); ?></td>
            <td><?php echo htmlspecialchars($baris['no_hp']); ?></td>
            <td><?php echo htmlspecialchars($baris['jenis_anggota']); ?></td>
            <td><?php echo htmlspecialchars($baris['alamat']); ?></td>
            <td>
                <a href="detail.php?id=<?php echo (int) $baris['id']; ?>">Detail</a>
                <form action="hapus.php" class="inline" method="post" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                    <input type="hidden" name="id" value="<?php echo (int) $baris['id']; ?>">
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php
    mysqli_free_result($hasil);
    mysqli_close($koneksi);
    ?>
</body>
</html>