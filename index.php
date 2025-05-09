<?php
session_start();
include "koneksi.php";

// pake session untuk keranjang
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// form untuk menambah bahan lewat sesiion
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $bahanTerpilih = isset($_POST['bahan']) ? $_POST['bahan'] : [];
    // untuk porsi nilai defaultnya 1 
    $porsi = isset($_POST['porsi']) ? $_POST['porsi'] : 1;
    foreach ($bahanTerpilih as $id) {
        $bahan = $db->tampilBahanId($id); 
        // cek kalo bahan itu ada ?
        if ($bahan) {
            // ambil harga dan nama dari id nya
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
<h2>Daftar dan pesan jamu</h2>
<form method="post" action="">
    <label>Jumlah Porsi: <input type="number" name="porsi" value="1" min="1" required></label>
    <ul>
        <?php foreach ($listBahan as $t): ?>
            <li>
                <input type="checkbox" name="bahan[]"value="<?= $t['id']; ?>">
                <p style="display:inline" >Nama : <?= $t['nama'] ?></p>
                <p>Jenis : <?= $t['jenis'] ?></p>
                <p>Deskripsi : <?= $t['deskripsi'] ?></p>
                <p>Harga : Rp.<?= $t['harga'] ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">Tambahkan ke Keranjang</button>
</form>

<a href="keranjang.php">Lihat Keranjang</a>
