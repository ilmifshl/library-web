<?php
require_once '../connect.php';

if (isset($_POST["tambah_buku"])) {
    $nama = $_POST["nama"];
    $kategori = $_POST["kategori"];
    $penulis = $_POST["penulis"];

    // Check if the book already exists
    $checkSql = "SELECT kode_buku, jumlah FROM buku WHERE judul_buku = '$nama' AND penulis = '$penulis'";
    $checkResult = pg_query($db, $checkSql);

    if (pg_num_rows($checkResult) > 0) {
        // Book already exists, update the quantity
        $row = pg_fetch_assoc($checkResult);
        $kodeBuku = $row['kode_buku'];
        $jumlah = $row['jumlah'] + 1;

        $updateSql = "UPDATE buku SET jumlah = $jumlah WHERE kode_buku = $kodeBuku";
        $updateQuery = pg_query($db, $updateSql);

        if ($updateQuery) {
            header("Location: ../buku.php");
            exit();
        } else {
            die("Gagal menyimpan perubahan...");
        }
    } else {
        // Book does not exist, insert a new record
        $insertSql = "INSERT INTO buku (kode_buku, judul_buku, kode_kategori, penulis, jumlah)
                      VALUES (nextval('kode_buku'), '$nama', '$kategori', '$penulis', 1)";
        $insertQuery = pg_query($db, $insertSql);

        if ($insertQuery) {
            header("Location: ../buku.php");
            exit();
        } else {
            die("Gagal menyimpan perubahan...");
        }
    }
} else {
    die("Akses dilarang...");
}
?>
