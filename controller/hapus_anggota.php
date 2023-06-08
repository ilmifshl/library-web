<?php
include("../connect.php");

if (isset($_GET["kode_anggota"])) {
  $kode_anggota = $_GET["kode_anggota"];
  $sql = "DELETE FROM anggota WHERE kode_anggota = $kode_anggota";
  $query = pg_query($db, $sql);

  if ($query) {
    header("Location: ../anggota.php");
  } else {
    die("Gagal menghapus...");
  }
} else {
  die("Akses dilarang...");
}