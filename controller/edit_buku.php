<?php
require_once '../connect.php';

if(isset($_POST["edit_buku"])) {
    $kode_buku = $_GET["kode_buku"];
    $judul = $_POST["judul"];
    $kategori = $_POST["kategori"];
    $penulis = $_POST["penulis"];
    
    $sql = "UPDATE buku SET judul_buku='$judul', kode_kategori='$kategori', penulis='$penulis' WHERE kode_buku = '$kode_buku'";
    
    $query = pg_query($db, $sql);
    
    if ($query) {
      header("Location: ../buku.php");
    } else {
      header("Gagal menyimpan perubahan...");
    }
}
?>
