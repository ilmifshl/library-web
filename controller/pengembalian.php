<?php
session_start();
require_once '../connect.php';

$kode_transaksi = $_GET["kode_transaksi"];
$tanggal_kembali = date("Y-m-d"); // Mendapatkan tanggal saat ini

// Lakukan query untuk mendapatkan tanggal_pinjam dari tabel Transaksi
$sql_tanggal_pinjam = "SELECT tanggal_pinjam FROM transaksi WHERE kode_transaksi = '$kode_transaksi'";
$query_tanggal_pinjam = pg_query($db, $sql_tanggal_pinjam);
$tanggal_pinjam = pg_fetch_result($query_tanggal_pinjam, 0, 'tanggal_pinjam');

// Menghitung selisih hari antara tanggal_kembali dan tanggal_pinjam
$selisih_hari = (strtotime($tanggal_kembali) - strtotime($tanggal_pinjam)) / (60 * 60 * 24);

// Jika selisih hari lebih dari 7 hari (1 minggu)
if ($selisih_hari > 7) {
    $denda = 10000 * ($selisih_hari - 7); // Menghitung denda
    
    // Update tanggal_kembali dan denda pada tabel Transaksi
    $sql_update = "UPDATE transaksi SET tanggal_kembali = '$tanggal_kembali', denda = '$denda' WHERE kode_transaksi = '$kode_transaksi'";
    $query_update = pg_query($db, $sql_update);
    
    if ($query_update) {
        // Peminjaman berhasil dilakukan dengan denda
        // Tambahkan kode lainnya sesuai kebutuhan Anda

        // Mengembalikan buku dan menambahkan jumlah buku pada tabel Buku
        $sql_buku = "SELECT kode_buku FROM detail_transaksi WHERE kode_transaksi = '$kode_transaksi'";
        $query_buku = pg_query($db, $sql_buku);
        
        while ($row = pg_fetch_assoc($query_buku)) {
            $kode_buku = $row['kode_buku'];
            
            // Menambahkan jumlah buku pada tabel Buku
            $sql_update_buku = "UPDATE buku SET jumlah = jumlah + 1 WHERE kode_buku = '$kode_buku'";
            pg_query($db, $sql_update_buku);
        }
        
        header("Location: ../index.php");
        exit();
    } else {
        die("Gagal menyimpan perubahan...");
    }
} else {
    // Update tanggal_kembali tanpa denda pada tabel Transaksi
    $sql_update = "UPDATE transaksi SET tanggal_kembali = '$tanggal_kembali' WHERE kode_transaksi = '$kode_transaksi'";
    $query_update = pg_query($db, $sql_update);
    
    if ($query_update) {
        // Peminjaman berhasil dilakukan tanpa denda
        // Tambahkan kode lainnya sesuai kebutuhan Anda

        // Mengembalikan buku dan menambahkan jumlah buku pada tabel Buku
        $sql_buku = "SELECT kode_buku FROM detail_transaksi WHERE kode_transaksi = '$kode_transaksi'";
        $query_buku = pg_query($db, $sql_buku);
        
        while ($row = pg_fetch_assoc($query_buku)) {
            $kode_buku = $row['kode_buku'];
            
            // Menambahkan jumlah buku pada tabel Buku
            $sql_update_buku = "UPDATE buku SET jumlah = jumlah + 1 WHERE kode_buku = '$kode_buku'";
            pg_query($db, $sql_update_buku);
        }
        
        header("Location: ../index.php");
        exit();
    } else {
        die("Gagal menyimpan perubahan...");
    }
}
?>
