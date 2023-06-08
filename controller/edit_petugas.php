<?php
require_once '../connect.php';

if(isset($_POST["edit_petugas"])) {
    $kode_petugas = $_GET["kode_petugas"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
    
    $sql = "UPDATE petugas SET nama='$nama', email='$email', no_hp='$no_hp' WHERE kode_petugas = '$kode_petugas'";
    
    $query = pg_query($db, $sql);
    
    if ($query) {
      header("Location: ../petugas.php");
    } else {
      header("Gagal menyimpan perubahan...");
    }
}
?>
