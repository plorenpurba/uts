<?php
session_start();
// Ambil isi keranjang
$keranjang = $_SESSION['keranjang'];

if ($_SERVER['REQUEST_METHOD'] == "GET"){
    if (isset($_GET['hapus'])) {
        $hapus = $_GET['hapus'];
        if (isset($_SESSION['keranjang'][$hapus])) {
            unset($_SESSION['keranjang'][$hapus]);
        }
        header("Location: keranjang.php");
        exit;
    }
    
    //tamabh
    if (isset($_GET['tambah'])) {
        $tambah = $_GET['tambah'];
        if (isset($_SESSION['keranjang'][$tambah])) {
            $_SESSION['keranjang'][$tambah]['porsi'] += 1;
        }
        header("Location: keranjang.php");
        exit;
    }
    //kurang
    if (isset($_GET['kurang'])) {
        $kurang = $_GET['kurang'];
        if (isset($_SESSION['keranjang'][$kurang])) {
            if ($_SESSION['keranjang'][$kurang]['porsi'] > 1) {
                $_SESSION['keranjang'][$kurang]['porsi'] -= 1;
            } else {
                unset($_SESSION['keranjang'][$kurang]);
            }
        }
        header("Location: keranjang.php");
        exit;
    }

    
}
?>

<h2>Keranjang Jamu</h2>

<?php if (!empty($keranjang)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga Satuan</th>
                <th>Porsi</th>
                <th>Subtotal</th>
                <th colspan="3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($keranjang as $idx => $barang): 
                $subtotal = $barang['harga'] * $barang['porsi'];
                $total = $total + $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($barang['nama']) ?></td>
                <td>Rp<?= $barang['harga']?></td>
                <td><?= $barang['porsi'] ?></td>
                <td>Rp<?= $subtotal ?></td>
                <td><a href="?tambah=<?= $idx ?>">Tambah</a></td>
                <td><a href="?kurang=<?= $idx ?>">Kurang</a></td>
                <td><a href="?hapus=<?= $idx ?>">Hapus</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="4"><strong>Rp<?= $total ?></strong></td>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <p>Keranjang kosong.</p>
<?php endif; ?>

<br>
<a href="index.php">Tambah komposisi</a>
