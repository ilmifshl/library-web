<?php
// Assuming the connection is already established
require_once 'connect.php'; // Include the connect.php file to establish the database connection

// Execute a SELECT query
$query = pg_query($db, "SELECT * FROM buku 
                        JOIN kategori ON buku.kode_kategori = kategori.kode_kategori 
                        ORDER BY buku.judul_buku");
$books = pg_fetch_all($query);

$cat_query = pg_query($db, "SELECT * FROM kategori");
$categories = pg_fetch_all($cat_query);



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
                    <a href="./index.php" class="flex items-center p-2 text-[#90a5b0] rounded-lg  hover:text-slate-300 ">
                        <i class='bx bxs-dashboard text-2xl'></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./petugas.php" class="flex items-center p-2  text-[#90a5b0] rounded-lg  hover:text-slate-300 ">
                        <i class='bx bxs-user text-2xl'></i>
                        <span class="ml-3">Petugas</span>
                    </a>
                </li>
                <li>
                    <a href="./anggota.php" class="flex items-center p-2 text-[#90a5b0] rounded-lg  hover:text-slate-300 ">
                        <i class='bx bxs-user text-2xl'></i>
                        <span class="ml-3">Anggota</span>
                    </a>
                </li>
                <li>
                    <a href="./buku.php" class="flex items-center p-2 text-white rounded-lg hover:text-slate-50">
                        <i class='bx bxs-book text-2xl'></i>
                        <span class="ml-3">Buku</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>

    <div class="px-4 sm:ml-64">
        <div class="flex justify-between items-center mb-6 my-4">
            <p class="text-2xl font-bold">Data Buku</p>

            <!-- Modal toggle -->
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class=" text-white bg-[#2f4859] bg-[#2f4859] hover:bg-[#20394a] focus:ring focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-200" type="button">
                Tambah Buku
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
                            <h3 class="mb-4 text-xl text-centers font-medium text-gray-900 ">Tambah Buku</h3>
                            <form class="space-y-3" action="./controller/buku.php" method="POST">
                                <div class="relative">
                                    <input type="text" id="nama" name="nama" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required/>
                                    <label for="nama" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Judul Buku</label>
                                </div>
                                <div>
                                    <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                    <select id="kategori" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                        <option selected>Kategori</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['kode_kategori'] ?>"><?= $category['kategori_buku'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="relative">
                                    <input type="text" id="penulis" name="penulis" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required/>
                                    <label for="penulis" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Penulis</label>
                                </div>

                                <button type="submit" name="tambah_buku" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah Buku</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="bg-red-200 relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Kode Buku
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Judul Buku
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Penulis
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book) : ?>
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap ">
                                <?= $book['kode_buku'] ?>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap ">
                                <?= $book['judul_buku'] ?>
                            </th>
                            <td class="px-6 py-4">
                                <?= $book['kategori_buku'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $book['penulis'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $book['jumlah'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <!-- Modal toggle -->
                                <div class="flex justify-center items-center">
                                    <button data-modal-target="authentication-modal-<?= $book['kode_buku'] ?>" data-modal-toggle="authentication-modal-<?= $book['kode_buku'] ?>" class="text-blue-500 hover:text-white hover:bg-blue-500 flex items-center justify-center p-1.5 mx-1 text-lg rounded-lg transition duration-300" type="button">
                                        <i class='bx bxs-edit-alt'></i>
                                    </button>

                                    <button data-modal-target="popup-modal-<?= $book['kode_buku']?>" data-modal-toggle="popup-modal-<?= $book['kode_buku']?>" class="text-red-500 hover:text-white hover:bg-red-500 flex items-center justify-center p-1.5 mx-1 text-lg rounded-lg transition duration-300" type="button">
                                    <i class='bx bxs-trash-alt' ></i>
                                    </button>

                                    <div id="popup-modal-<?= $book['kode_buku']?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow ">
                                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="popup-modal-<?= $book['kode_buku']?>">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-6 text-center">
                                                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah Anda yakin ingin menghapus anggota #<?= $book['kode_buku']?>?</h3>
                                                    <a href="./controller/hapus_buku.php?kode_buku=<?= $book['kode_buku']?>" data-modal-hide="popup-modal-<?= $book['kode_buku']?>"  class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        Ya, Saya yakin.
                                                    </a>
                                                    <button data-modal-hide="popup-modal-<?= $book['kode_buku']?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <!-- Main modal -->
                        <div id="authentication-modal-<?= $book['kode_buku'] ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="authentication-modal-<?= $book['kode_buku'] ?>">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="px-6 py-6 lg:px-8">
                                        <h3 class="mb-4 text-xl font-medium text-gray-900 ">Edit buku #<?= $book['kode_buku'] ?></h3>
                                        <form class="space-y-6" action="./controller/edit_buku.php?kode_buku=<?= $book['kode_buku'] ?>" method="POST">
                                            <div class="relative mb-4">
                                                <input type="text" id="judul" name="judul" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer " placeholder=" " value="<?= $book['judul_buku'] ?>" />
                                                <label for="judul" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Judul Buku</label>
                                            </div>
                                            <div class="mb-4">
                                                <label for="kategori" class="block  text-sm font-medium text-gray-900"></label>
                                                <select id="kategori" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                    <option value="<?= $book['kode_kategori'] ?>" selected>Kategori</option>
                                                    <?php foreach ($categories as $category) : ?>
                                                        <option value="<?= $category['kode_kategori'] ?>"><?= $category['kategori_buku'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="relative mb-4">
                                                <input type="text" id="penulis" name="penulis" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="<?= $book['penulis'] ?>" />
                                                <label for="penulis" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Penulis</label>
                                            </div>
                                            <button type="submit" name="edit_buku" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script>


</body>

</html>