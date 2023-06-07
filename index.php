<?php
session_start();
// Assuming the connection is already established
require_once 'connect.php'; // Include the connect.php file to establish the database connection

// Execute a SELECT query
$query = pg_query($db, "SELECT * FROM anggota");
$members = pg_fetch_all($query);

$lib_query = pg_query($db, "SELECT * FROM petugas");
$librarians = pg_fetch_all($lib_query);

$transaksi_query = pg_query($db, "SELECT t.*, t.kode_transaksi AS peminjaman, a.nama AS peminjam, p.nama AS petugas FROM transaksi t 
                            JOIN anggota a ON t.kode_anggota = a.kode_anggota
                            JOIN petugas p ON t.kode_petugas = p.kode_petugas");
$borrows = pg_fetch_all($transaksi_query);

$book_query = pg_query($db, "SELECT * FROM buku JOIN kategori ON buku.kode_kategori = kategori.kode_kategori
                                WHERE buku.jumlah > 0");
$books = pg_fetch_all($book_query);
// Check if the query was successful
if (!$members) {
    die("Query failed: " . pg_last_error());
}

date_default_timezone_set('Asia/Jakarta');

// Mendapatkan tanggal hari ini
$tanggal = date('d F Y');

// Mendapatkan nama hari pada tanggal hari ini
$hari = date('l', strtotime($tanggal));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
</head>

<body>

    <?php if (isset($_SESSION["message"])) : ?>
        <div id="toast-danger" class="fixed top-3 right-3 flex items-center w-full max-w-xs p-4 mb-4 text-gray-800 bg-white rounded-lg shadow-lg border " role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg ">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ml-3 text-sm font-normal">Maksimal meminjam 3 buku.</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 transition duration-200" data-dismiss-target="#toast-danger" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    <?php endif ?>
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-[#2f4859]">
            <a href="./" class="flex items-center pl-2.5 mb-5 text-white">
                <i class="lni lni-library text-2xl mr-2 bg-[#596d76] rounded-full pt-1 pl-2 w-10 h-10"></i>
                <span class="self-center text-2xl font-semibold whitespace-nowrap">Library</span>
            </a>
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="./" class="flex items-center p-2 text-white rounded-lg hover:text-slate-50 ">
                        <i class='bx bxs-dashboard text-2xl'></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./petugas.php" class="flex items-center p-2 text-[#90a5b0] rounded-lg  hover:text-slate-300 ">
                        <i class='bx bxs-book text-2xl'></i>
                        <span class="ml-3">Petugas</span>
                    </a>
                </li>
                <li>
                    <a href="./anggota.php" class="flex items-center p-2 text-[#90a5b0] rounded-lg  hover:text-slate-300 ">
                        <i class='bx bxs-book text-2xl'></i>
                        <span class="ml-3">Anggota</span>
                    </a>
                </li>
                <li>
                    <a href="./buku.php" class="flex items-center p-2 text-[#90a5b0] rounded-lg  hover:text-slate-300 ">
                        <i class='bx bxs-book text-2xl'></i>
                        <span class="ml-3">Buku</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>

    <div class="px-4 sm:ml-64">
        <div class="flex justify-between items-center mb-6 my-4">
            <p class="text-2xl font-bold">Dashboard</p>

            <!-- Modal toggle -->
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class=" text-white bg-[#2f4859] bg-[#2f4859] hover:bg-[#20394a] focus:ring focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-200" type="button">
                Peminjaman
            </button>

            <!-- Main modal -->
            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow ">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="authentication-modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8">
                            <h3 class="mb-4 text-xl text-centers font-medium text-gray-900 ">Peminjaman</h3>
                            <form class="space-y-3" action="./controller/peminjaman.php" method="POST">
                                <div>
                                    <label for="peminjam" class="block text-sm font-medium text-gray-900 mb-2">Peminjam</label>
                                    <select id="peminjam" name="peminjam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option value="" selected>Peminjam</option>
                                        <?php foreach ($members as $member) : ?>
                                            <option value="<?= $member['kode_anggota'] ?>"><?= $member['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="petugas" class="block text-sm font-medium text-gray-900 mb-2">Petugas</label>
                                    <select id="petugas" name="petugas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option value="" selected>Petugas</option>
                                        <?php foreach ($librarians as $librarian) : ?>
                                            <option value="<?= $librarian['kode_petugas'] ?>"> <?= $librarian['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="jumlah_buku" class="block text-sm font-medium text-gray-900 mb-2">Jumlah Buku yang Dipinjam</label>
                                    <input id="jumlah_buku" name="jumlah_buku" type="number" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jumlah Buku" required>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label for="buku" class="block text-sm font-medium text-gray-900 mb-2">Buku yang dipinjam (Maksimal 3 buku)</label>
                                        <button type="button" id="tambah_buku" class="text-blue-500 hover:bg-blue-600 hover:text-white text-md font-medium rounded-lg ml-6 w-6 h-6 transition duration-300"><i class='bx bx-plus'></i></button>
                                    </div>

                                    <select id="buku" name="buku[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option value="" selected>Pilih Buku</option>
                                        <?php foreach ($books as $book) : ?>
                                            <option value="<?= $book['kode_buku'] ?>"> <?= $book['judul_buku'] ?> (<?= $book['penulis'] ?>)</option>
                                        <?php endforeach ?>
                                    </select>

                                    <div id="daftar_buku" class="mt-4"></div>
                                </div>


                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input datepicker datepicker-autohide type="text" id="start" name="start" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Tanggal Pinjam" autocomplete="off">
                                </div>


                                <button type="submit" name="pinjam" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg px-4 py-2 mt-4">Pinjam</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="px-2">

            <div class="grid grid-cols-4 gap-5 ">
                <div class="flex justify-between items-center bg-[#f2e1f7] rounded-lg py-6 px-4">
                    <i class='bx bx-book-open text-2xl bg-[#cea9d9] px-2 pt-1 text-[#66237a] rounded-lg mr-3 w-10 h-10'></i>
                    <div>
                        <p class="text-slate-500">Buku yang dipinjam</p>
                        <p class="font-bold text-xl">8</p>
                    </div>
                </div>
                <div class="flex justify-between items-center bg-[#daf1f4] rounded-lg py-6 px-4">
                    <i class='bx bx-time-five text-2xl bg-[#aedce0] px-2 pt-1 text-[#257d81] rounded-lg mr-3 w-10 h-10'></i>
                    <div>
                        <p class="text-slate-500">Telat pengembalian</p>
                        <p class="font-bold text-xl">8</p>
                    </div>
                </div>
                <div class="flex justify-between items-center bg-[#fff4e6] rounded-lg px-4">
                    <svg class='text-2xl bg-[#f9e1c3] px-2 pt-1 text-[#d09a41] rounded-lg mr-3 w-10 h-10' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>

                    <div class="pr-6">
                        <p class="text-slate-500">Jumlah anggota</p>
                        <p class="font-bold text-xl">8</p>
                    </div>
                </div>
                <div class="flex justify-center items-center bg-[#fffbe6] rounded-lg">
                    <div class="flex justify-center items-center bg-[#f6efc6] p-2 rounded-lg shadow text-3xl w-12 h-12">
                        <i class='bx bx-calendar text-[#d1c355]'></i>
                    </div>
                    <div class="mt-2 ml-4 mr-4">
                        <p class="font-semibold text-sm text-slate-500"><?= $hari ?>,</p>
                        <p class="font-bold text-lg "><?= $tanggal ?></p>
                    </div>
                </div>
            </div>
            <div class="w-full mt-4 relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Kode Pinjam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Peminjam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal pinjam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal kembali
                            </th>
                            <th scope="col" class="px-6 py-3 text-center" colspan="2">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($borrows as $borrow) : ?>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                                    <?= $borrow['peminjaman'] ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?= $borrow['peminjam'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $borrow['tanggal_pinjam'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($borrow['tanggal_kembali'] == null) : ?>
                                        -
                                    <?php elseif ($borrow['tanggal_kembali'] !== null) : ?>
                                        <?= $borrow['tanggal_kembali'] ?>
                                    <?php endif ?>
                                </td>
                                <td class="px-6 py-4" colspan="2">
                                    <?php if ($borrow['tanggal_kembali'] == null) : ?>
                                        <div class="bg-red-200 text-red-700 rounded-lg p-1.5 text-center border border-red-600 text-xs">
                                            <p>Belum Kembali</p>
                                        </div>
                                    <?php elseif ($borrow['tanggal_kembali'] !== null && $borrow['denda'] > 0) : ?>

                                        <button data-tooltip-target="tooltip-default-<?= $borrow['peminjaman'] ?>" type="button" class="bg-yellow-200 text-yellow-700 rounded-lg p-1.5 text-center border border-yellow-600 text-xs w-full">Terlambat</button>
                                        <div id="tooltip-default-<?= $borrow['peminjaman'] ?>" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            Denda: Rp<?= $borrow['denda'] ?>
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                    <?php elseif ($borrow['tanggal_kembali'] !== null) : ?>
                                        <div class="bg-green-200 text-green-700 rounded-lg p-1.5 text-center border border-green-600 text-xs">
                                            <p>Sudah Kembali</p>
                                        </div>
                                    <?php endif ?>
                                </td>
                                <td class="px-6 py-4 flex justify-center ietms-center">

                                    <div class="flex">
                                        <button data-modal-target="popup-modal-<?= $borrow['peminjaman'] ?>" data-modal-toggle="popup-modal-<?= $borrow['peminjaman'] ?>" class="text-blue-600" type="button">
                                            Kembali
                                        </button>
                                        <p class="mx-2 text-blue-600">|</p>
                                        <button data-modal-target="authentication-modal-<?= $borrow['peminjaman']?>" data-modal-toggle="authentication-modal-<?= $borrow['peminjaman']?>" class="text-blue-600" type="button">
                                            Detail
                                        </button>
                                    </div>

                                    <div id="authentication-modal-<?= $borrow['peminjaman']?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-md max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow d">
                                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-hide="authentication-modal-<?= $borrow['peminjaman']?>">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="px-6 py-6 lg:px-8">
                                                    <h3 class="mb-4 text-xl font-medium text-gray-900">Detail Peminjaman #<?= $borrow['peminjaman']?></h3>
                                                    <form class="space-y-6" action="#">
                                                        <div>
                                                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Your email</label>
                                                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="name@company.com" required>
                                                        </div>
                                                        <div>
                                                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Your password</label>
                                                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " required>
                                                        </div>
                                                        <div class="flex justify-between">
                                                            <div class="flex items-start">
                                                                <div class="flex items-center h-5">
                                                                    <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 " required>
                                                                </div>
                                                                <label for="remember" class="ml-2 text-sm font-medium text-gray-900 ">Remember me</label>
                                                            </div>
                                                            <a href="#" class="text-sm text-blue-700 hover:underline ">Lost Password?</a>
                                                        </div>
                                                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Login to your account</button>
                                                        <div class="text-sm font-medium text-gray-500 ">
                                                            Not registered? <a href="#" class="text-blue-700 hover:underline ">Create account</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="popup-modal-<?= $borrow['peminjaman'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow ">
                                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center transition duration-200" data-modal-hide="popup-modal-<?= $borrow['peminjaman'] ?>">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-6 text-center">
                                                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah <?= $borrow['peminjam'] ?> sudah mengembalikan buku?</h3>
                                                    <button data-modal-hide="popup-modal-<?= $borrow['peminjaman'] ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 transition duration-300">Durung</button>
                                                    <a href="./controller/pengembalian.php?kode_transaksi=<?= $borrow['peminjaman'] ?>" data-modal-hide="popup-modal-<?= $borrow['peminjaman'] ?>" class="text-white bg-[#2f4859] hover:bg-[#162a38] focus:ring-4 focus:outline-none focus:ring-[#2f4859] font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 transition duration-300">
                                                        Uwes
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script>
    <script>
        const tambahBukuBtn = document.getElementById('tambah_buku');
        const daftarBukuContainer = document.getElementById('daftar_buku');

        tambahBukuBtn.addEventListener('click', function() {
            const bukuInput = document.createElement('div');
            bukuInput.innerHTML = `
            <select id="buku" name="buku[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option value="" selected>Pilih Buku</option>
                                        <?php foreach ($books as $book) : ?>
                                            <option value="<?= $book['kode_buku'] ?>"> <?= $book['judul_buku'] ?> (<?= $book['penulis'] ?>)</option>
                                        <?php endforeach ?>
                                    </select>
            <button type="button" class="hapus_buku text-red-500 hover:text-red-700 text-sm">Hapus</button>
        `;
            daftarBukuContainer.appendChild(bukuInput);
        });

        daftarBukuContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('hapus_buku')) {
                event.target.parentElement.remove();
            }
        });

        const dateRangePicker = new DateRangePicker('#start', '#end', {
            format: 'yyyy-mm-dd',
            separator: ' - ',
            autoApply: true,
            showDropdowns: true,
            minDate: new Date()
        });
    </script>

</body>

</html>

<?php
unset($_SESSION["message"]);
?>