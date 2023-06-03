<?php
require_once '../connect.php';

if (isset($_POST["tambah_petugas"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
  
    $sql = "INSERT INTO petugas (kode_petugas, nama, email, no_hp) VALUES (nextval('kode_petugas'), '$nama', '$email', '$no_hp')";
    $query = pg_query($db, $sql);
    if ($query) {
        header("Location: ../petugas.php");
        exit();
    } else {
        die("Gagal menyimpan perubahan...");
    }
} else {
    die("Akses dilarang...");
}
?>
