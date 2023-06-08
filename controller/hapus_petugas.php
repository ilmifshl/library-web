<?php
include("../connect.php");

if (isset($_GET["kode_petugas"])) {
  $kode_petugas = $_GET["kode_petugas"];
  $sql = "DELETE FROM petugas WHERE kode_petugas = $kode_petugas";
  $query = pg_query($db, $sql);

  if ($query) {
    header("Location: ../petugas.php");
  } else {
    die("Gagal menghapus...");
  }
} else {
  die("Akses dilarang...");
}