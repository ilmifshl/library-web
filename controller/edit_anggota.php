<?php
require_once '../connect.php';

if(isset($_POST["edit_anggota"])) {
    $kode_anggota = $_GET["kode_anggota"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
    
    $sql = "UPDATE anggota SET nama='$nama', email='$email', no_hp='$no_hp' WHERE kode_anggota = '$kode_anggota'";
    
    $query = pg_query($db, $sql);
    
    if ($query) {
      header("Location: ../anggota.php");
    } else {
      header("Gagal menyimpan perubahan...");
    }
}
?>
