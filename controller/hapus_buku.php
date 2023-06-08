<?php
include("../connect.php");

if (isset($_GET["kode_buku"])) {
  $kode_buku = $_GET["kode_buku"];
  $sql = "DELETE FROM buku WHERE kode_buku = $kode_buku";
  $query = pg_query($db, $sql);

  if ($query) {
    header("Location: ../buku.php");
  } else {
    die("Gagal menghapus...");
  }
} else {
  die("Akses dilarang...");
}