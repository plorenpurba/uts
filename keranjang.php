<?php
session_start();
$keranjang = $_SESSION['keranjang'] ?? [];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['hapus'])) {

        unset($_SESSION['keranjang'][$_GET['hapus']]);
        header("Location: keranjang.php");
        exit;

    }
    //tambah
    if (isset($_GET['tambah'])) {
        $_SESSION['keranjang'][$_GET['tambah']]['porsi'] += 1;
        header("Location: keranjang.php");
        exit;

    }
    //kurang
    if (isset($_GET['kurang'])) {
        $kurang = $_GET['kurang'];
        if ($_SESSION['keranjang'][$kurang]['porsi'] > 1) {
            $_SESSION['keranjang'][$kurang]['porsi'] -= 1;

        } else {
            unset($_SESSION['keranjang'][$kurang]);
        }
        header("Location: keranjang.php");
        exit;
    }
    //bayar
    if (isset($_GET['bayar'])) {
        session_destroy();
        
        header("Location: keranjang.php");
        exit;

    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjangmu</title>
    <link rel="stylesheet" href="keranjang.css">
</head>
<body>

<h2 class="judul-halaman">Keranjangmu</h2>

<div class="keranjang-container">
<?php if (!empty($keranjang)): ?>
    <?php 
    $total = 0;
    foreach ($keranjang as $idx => $barang): 
        $subtotal = $barang['harga'] * $barang['porsi'];
        $total += $subtotal;
    ?>
    <div class="item-keranjang">
        <div class="detail-barang">
            <div class="info-barang">
                <h3 class="nama-barang"><?= htmlspecialchars($barang['nama']) ?></h3>
                <p class="harga-barang">Harga: Rp<?= $barang['harga'] ?></p>
                <p class="jumlah-barang">Porsi: <?= $barang['porsi'] ?></p>
                <p class="subtotal-barang">Subtotal: Rp.<?= $subtotal ?></p>
            </div>
        </div>
        <div class="aksi-barang">
            <a class="tombol tambah" href="?tambah=<?= $idx ?>">+</a>
            <a class="tombol kurang" href="?kurang=<?= $idx ?>">−</a>
            <a class="tombol hapus" href="?hapus=<?= $idx ?>">Hapus</a>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="total-keranjang">
        <strong>Total Bayar: Rp.<?= $total ?></strong>
    </div>

    <div class="aksi-pembayaran">
        <a class="tombol-bayar" href="?bayar=1" onclick="return confirm('Bayar Jamu?')">Bayar Sekarang</a>
    </div>
<?php else: ?>
    <p class="keranjang-kosong">Keranjang kamu masih kosong.</p>
<?php endif; ?>
</div>

<div class="navigasi-bawah">
    <a class="tombol-kembali" href="index.php">Tambah Komposisi</a>
</div>

</body>
</html>