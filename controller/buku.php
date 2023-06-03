<?php
require_once '../connect.php';

if (isset($_POST["tambah_buku"])) {
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $penulis = $_POST["penulis"];
  
    $sql = "INSERT INTO buku (kode_buku, judul_buku, kode_kategori, penulis) VALUES (nextval('kode_buku'), '$nama', '$kategori', '$penulis')";
    $query = pg_query($db, $sql);
    if ($query) {
        header("Location: ../buku.php");
        exit();
    } else {
        die("Gagal menyimpan perubahan...");
    }
} else {
    die("Akses dilarang...");
}
?>
