<?php

class Database{
     function create ($nama, $deskripsi, $harga, $jenis){
         global $conn;
         $sql = "INSERT INTO bahan (nama, deskripsi, harga, jenis) VALUES('$nama','$deskripsi','$harga','$jenis')";
         $conn->exec($sql);
     }
     function tampilBahan(){
         global $conn;
         $sql = $conn->query("SELECT * FROM bahan");
         return $sql->fetchAll(PDO::FETCH_ASSOC);
     }
     function tampilBahanId ($id){
         global $conn;
         if(!$id){
             header('Location: /');
             exit();
         }
         else{
             $sql = $conn->prepare("SELECT * FROM bahan WHERE id = :id");
             $sql->bindParam(':id', $id, PDO::PARAM_INT);
             $sql->execute();
 
         }
         return $sql->fetchAll(PDO::FETCH_ASSOC);
     }
     function delete($d){
         global $conn;
         $sql = "DELETE FROM bahan WHERE id = ". $d;
         $conn->exec($sql);
     }
     
     function updateBahan($id, $nama, $deskripsi, $harga, $jenis){
         global $conn;
         if (empty($deskripsi) || empty($nama) || empty($harga) || empty($jenis)) {
             header('Location: /'); 
             exit();
         }
        $sql = $conn->prepare("UPDATE bahan SET nama = :nama, deskripsi = :deskripsi, harga = :harga, jenis = :jenis WHERE id = :id");
	    $sql->bindParam(':nama', $nama);
        $sql->bindParam(':deskripsi', $deskripsi);
	    $sql->bindParam(':harga', $harga, PDO::PARAM_INT);
        $sql->bindParam(':jenis', $jenis);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        return $sql->execute();
     }
 }

 $db = new Database();
