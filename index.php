<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];

}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $bahanTerpilih = $_POST['bahan'] ?? [];
    $porsi = $_POST['porsi'] ?? 1;

    foreach ($bahanTerpilih as $id) {
        $bahan = $db->tampilBahanId($id);
        if ($bahan) {
            
            if (isset($_SESSION['keranjang'][$id])) {
                $_SESSION['keranjang'][$id]['porsi'] += $porsi;
            } else {
                $_SESSION['keranjang'][$id] = [
                    'nama' => $bahan['nama'],
                    'harga' => $bahan['harga'],
                    'porsi' => $porsi
                ];
            }
        }
    }
    header("Location: keranjang.php");
    exit;

}

$listBahan = $db->tampilBahan();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pesan Jamu</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<h2 class="judul-halaman">Pesan Jamu</h2>

<form method="post" action="">
    <div class="input-porsi">
        <label for="porsi">Jumlah Porsi:</label>
        <input type="number" name="porsi" id="porsi" value="1" min="1" required>
    </div>

    <div class="kartu-container">
        <?php foreach ($listBahan as $b): ?>
        <div class="kartu-bahan">
            <label class="konten-kartu">
                <input type="checkbox" name="bahan[]" value="<?= $b['id']; ?>">
                <h3 class="nama-bahan"><?= htmlspecialchars($b['nama']) ?></h3>
                <p class="jenis-bahan"><strong>Jenis:</strong> <?= $b['jenis'] ?></p>
                <p class="deskripsi-bahan"><?= $b['deskripsi'] ?></p>
                <p class="harga-bahan">Harga: Rp.<?= $b['harga'] ?></p>
            </label>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="aksi-form">
        <button type="submit" class="tombol-submit">Tambahkan ke Keranjang</button>
    </div>
</form>

<div class="navigasi-bawah">
    <a href="keranjang.php" class="tombol-keranjang">Lihat Keranjang</a>
</div>

</body>
</html>

