<?php
include"koneksi.php";

// Yang nanganin
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    
}
if ($_SERVER['REQUEST_METHOD'] == "GET"){
    $hapus = isset($_GET['hapus']) ? $_GET['hapus'] : false;
    if ($hapus !== false){
        $db->delete($hapus);
        header('Location: '. $_SERVER['SCRIPT_NAME']);
        exit;
    }
}

$listBahan = $db->tampilBahan();
?>

<?php if(!empty($listBahan)): ?>
    <h2>Daftar Bahan Jamu </h2>
    <ul>
    <?php foreach($listBahan as $t): ?>
        <li>Nama : <?= $t['nama']; ?> </li>
        <li>Jenis : <?= $t['jenis']; ?> </li>
        <li>Deskrpisi : <?= $t['deskripsi']; ?> </li>
        <li>Harga : Rp.<?= $t['harga']; ?> </li>
        <a href="?hapus=<?= $t['id']; ?>">Hapus</a> 
        | <a href="update.php?ubah=<?= $t['id'] ?>">Ubah</a> 
        | <a href="tampil.php?tampil=<?= $t['id'] ?>">Lihat</a></li>
        <hr>
    <?php endforeach; ?>

    </ul>
    <?php endif; ?>

