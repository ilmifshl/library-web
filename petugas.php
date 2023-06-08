<?php
// Assuming the connection is already established
require_once 'connect.php'; // Include the connect.php file to establish the database connection

// Execute a SELECT query
$query = pg_query($db, "SELECT * FROM petugas");
$librarians = pg_fetch_all($query);



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
                    <a href="./" class="flex items-center p-2 text-[#90a5b0] rounded-lg  hover:text-slate-300 ">
                        <i class='bx bxs-dashboard text-2xl'></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./petugas.php" class="flex items-center p-2 text-white rounded-lg hover:text-slate-50">
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
            <p class="text-2xl font-bold">Data Petugas</p>

            <!-- Modal toggle -->
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class=" text-white bg-[#2f4859] bg-[#2f4859] hover:bg-[#20394a] focus:ring focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-200" type="button">
                Tambah Petugas
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
                            <h3 class="mb-4 text-xl text-centers font-medium text-gray-900 ">Tambah Data Petugas</h3>
                            <form class="space-y-3" action="./controller/petugas.php" method="POST">
                                <div class="relative">
                                    <input type="text" id="nama" name="nama" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required/>
                                    <label for="nama" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama</label>
                                </div>
                                <div class="relative">
                                    <input type="email" id="email" name="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required/>
                                    <label for="email" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                                </div>
                                <div class="relative">
                                    <input type="text" id="no_hp" name="no_hp" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required/>
                                    <label for="no_hp" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">No HP</label>
                                </div>

                                <button type="submit" name="tambah_petugas" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah Petugas</button>
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
                            Kode Petugas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No Hp
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($librarians as $librarian) : ?>
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap ">
                                <?= $librarian['kode_petugas'] ?>
                            </th>
                            <td class="px-6 py-4">
                                <?= $librarian['nama'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $librarian['email'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $librarian['no_hp'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center">
                                    <button data-modal-target="authentication-modal-<?= $librarian['kode_petugas'] ?>" data-modal-toggle="authentication-modal-<?= $librarian['kode_petugas'] ?>" class="text-blue-500 hover:text-white hover:bg-blue-500 flex items-center justify-center p-1.5 mx-1 text-lg rounded-lg transition duration-300" type="button">
                                        <i class='bx bxs-edit-alt'></i>
                                    </button>

                                    <button data-modal-target="popup-modal-<?= $librarian['kode_petugas'] ?>" data-modal-toggle="popup-modal-<?= $librarian['kode_petugas'] ?>" class="text-red-500 hover:text-white hover:bg-red-500 flex items-center justify-center p-1.5 mx-1 text-lg rounded-lg transition duration-300" type="button">
                                        <i class='bx bxs-trash-alt'></i>
                                    </button>

                                    <div id="popup-modal-<?= $librarian['kode_petugas'] ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow ">
                                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="popup-modal-<?= $librarian['kode_petugas'] ?>">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-6 text-center">
                                                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah Anda yakin ingin menghapus petugas #<?= $librarian['kode_petugas'] ?>?</h3>
                                                    <a href="./controller/hapus_petugas.php?kode_petugas=<?= $librarian['kode_petugas'] ?>" data-modal-hide="popup-modal-<?= $librarian['kode_petugas'] ?>" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        Ya, Saya yakin.
                                                    </a>
                                                    <button data-modal-hide="popup-modal-<?= $librarian['kode_petugas'] ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <!-- Main modal -->
                        <div id="authentication-modal-<?= $librarian['kode_petugas'] ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="authentication-modal-<?= $librarian['kode_petugas'] ?>">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="px-6 py-6 lg:px-8">
                                        <h3 class="mb-4 text-xl font-medium text-gray-900 ">Edit petugas #<?= $librarian['kode_petugas'] ?></h3>
                                        <form class="space-y-6" action="./controller/edit_petugas.php?kode_petugas=<?= $librarian['kode_petugas'] ?>" method="POST">
                                            <div class="relative mb-4">
                                                <input type="text" id="nama" name="nama" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer " placeholder=" " value="<?= $librarian['nama'] ?>" />
                                                <label for="nama" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nama Petugas</label>
                                            </div>
                                            <div class="relative mb-4">
                                                <input type="text" id="email" name="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer " placeholder=" " value="<?= $librarian['email'] ?>" />
                                                <label for="email" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                                            </div>
                                            <div class="relative mb-4">
                                                <input type="text" id="no_hp" name="no_hp" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="<?= $librarian['no_hp'] ?>" />
                                                <label for="no_hp" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">No HP</label>
                                            </div>
                                            <button type="submit" name="edit_petugas" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Edit</button>
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