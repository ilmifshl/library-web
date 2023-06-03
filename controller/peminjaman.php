<?php
require_once '../connect.php';

if (isset($_POST["pinjam"])) {
    $peminjam = $_POST["peminjam"];
    $petugas = $_POST["petugas"];
    $start = $_POST["start"];
    $end = $_POST["end"];

    $start = date("Y-m-d", strtotime($start));
    $end = date("Y-m-d", strtotime($end));

    $sql = "INSERT INTO transaksi (kode_transaksi, kode_anggota, kode_petugas, tanggal_pinjam, tanggal_kembali) VALUES (nextval('kode_transaksi'), '$peminjam', '$petugas', '$start', '$end')";
    $query = pg_query($db, $sql);
    if ($query) {
        header("Location: ../");
        exit();
    } else {
        die("Gagal menyimpan perubahan...");
    }
} else {
    die("Akses dilarang...");
}
