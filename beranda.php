<?php
// Memasukkan file dummy.php yang berisi data produk kamar hotel
require 'dummy.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kamar Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            color: white;
        }

        .navbar {
            background-color: #000;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #fff !important;
        }

        .card {
            background-color: #fff;
            border: 1px solid #000;
            color: black;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card-title {
            color: black;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #fff;
        }

        .card-text {
            color: black;
        }

        .btn-primary {
            background-color: #000;
            border-color: #000;
            color: white;
        }

        .btn-primary:hover {
            background-color: #333;
        }

        img {
            border-radius: 10px;
        }

        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }

        .text-left {
            text-align: left;
        }

        .card-img-top {
            object-fit: cover;
            height: 200px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .row>.col {
            display: flex;
        }

        .row {
            gap: 1rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark shadow">
        <div class="container-fluid">
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex">
                    <a class="nav-link mx-3 fs-5 py-2 px-3" href="#">Home</a>
                    <a class="nav-link mx-3 fs-5 py-2 px-3" href="transaksi.php">Transaksi</a>
                </div>
                <a class="nav-link mx-3 fs-5 py-2 px-3" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="mb-4 p-0">
        <div class="container-fluid p-0">
            <img src="img/banner.jpg" class="img-fluid w-100" alt="" style="height: 550px; object-fit: cover; border-radius: 10px;">
        </div>
    </div>

    <div class="container-fluid mt-5">
        <h2 class="text-left mb-4">Daftar Paket Kamar Hotel</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
            <?php foreach ($datapaket as $index => $paket) : ?>
                <div class="col mb-4">
                    <div class="card">
                        <img src="img/<?= $paket[3] ?>" class="card-img-top" alt="<?= $paket[0] ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= ucfirst($paket[0]) ?></h5>
                            <p class="card-text"><strong>Alamat</strong>: <?= $paket[1] ?></p>
                            <p class="card-text"><strong>Harga</strong>: Rp <?= number_format($paket[2], 0, ',', '.') ?></p>
                            <p class="card-text"><strong>No. Telp</strong>: <?= $paket[4] ?></p>
                            <p class="card-text"><strong>Email</strong>: <a href="mailto:<?= $paket[5] ?>"><?= $paket[5] ?></a></p>
                            <a href="transaksi.php?id=<?= $index ?>" class="btn btn-primary w-100 mt-auto py-2">Pilih Produk</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>