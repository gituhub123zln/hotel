<?php
// Memasukkan file 'dummy.php' yang berisi data yang dibutuhkan untuk aplikasi (misalnya data produk kamar)
require 'dummy.php';
?>

<?php
// Memeriksa apakah form disubmit menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form yang disubmit
    $nama_pemesan = $_POST['nama_pemesan'];
    $nomor_identitas = $_POST['nomor_identitas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $durasi = $_POST['durasi'];
    $harga = $_POST['harga'];
    $breakfast = isset($_POST['breakfast']) ? "Ya" : "Tidak"; // Memeriksa apakah pemesan memilih breakfast

    // Menghitung total harga sebelum diskon
    $total_bayar = $harga * $durasi;
    $diskon = 0;

    // Jika durasi lebih dari atau sama dengan 3 hari, beri diskon 10%
    if ($durasi >= 3) {
        $diskon = 0.10 * $total_bayar;
    }

    // Menghitung total setelah diskon
    $total_setelah_diskon = $total_bayar - $diskon;

    // Menentukan gambar kamar berdasarkan tipe kamar yang dipilih
    $gambar_kamar = '';
    switch (strtolower($tipe_kamar)) {
        case 'standar':
            $gambar_kamar = 'img/standar.jpg'; // Gambar untuk tipe kamar standar
            break;
        case 'deluxe':
            $gambar_kamar = 'img/deluxe.jpg'; // Gambar untuk tipe kamar deluxe
            break;
        case 'executif':
            $gambar_kamar = 'img/executive.jpg'; // Gambar untuk tipe kamar executive
            break;
        default:
            $gambar_kamar = 'img/default.jpg'; // Gambar default jika tipe kamar tidak ditemukan
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Pengaturan karakter encoding dan tampilan untuk halaman -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pemesanan</title>
    <style>
        /* Styling untuk body halaman */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        /* Styling untuk container yang berisi invoice */
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Styling untuk judul invoice */
        h2 {
            text-align: center;
            background-color: #4682B4;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        /* Styling untuk konten invoice */
        .invoice {
            padding: 20px;
            font-size: 18px;
            color: #333;
        }
        /* Styling untuk paragraf dalam invoice */
        .invoice p {
            margin: 5px 0;
        }
        /* Styling untuk gambar kamar */
        .invoice img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 20px;
        }
        /* Styling untuk tombol */
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            display: inline-block;
        }
        .btn-primary { background: #4682B4; }
        .btn-secondary { background: gray; }
    </style>
</head>
<body>

<!-- Container utama untuk menampilkan invoice -->
<div class="container">
    <h2>Invoice Pemesanan</h2>
    <div class="invoice">
        <!-- Menampilkan data pemesan dan detail pemesanan -->
        <p><strong>N2ama Pemesan</strong> : <?php echo $nama_pemesan; ?></p>
        <p><strong>Nomor Identitas</strong> : <?php echo $nomor_identitas; ?></p>
        <p><strong>Jenis Kelamin</strong> : <?php echo $jenis_kelamin; ?></p>
        <p><strong>Tipe Kamar</strong> : <?php echo ucfirst(strtolower($tipe_kamar)); ?></p>
        <p><strong>Durasi Penginapan</strong> : <?php echo $durasi; ?> Hari</p>
        <!-- Menampilkan diskon jika ada -->
        <p><strong>Discount</strong> : <?php echo $diskon > 0 ? "10%" : "0%"; ?></p>
        <!-- Menampilkan total bayar setelah diskon -->
        <p><strong>Total Bayar</strong> : Rp <?php echo number_format($total_setelah_diskon, 0, ',', '.'); ?></p>
        
        <!-- Menampilkan gambar kamar berdasarkan tipe yang dipilih -->
        <img src="<?php echo $gambar_kamar; ?>" alt="Gambar Kamar">
    </div>

    <!-- Tombol untuk kembali ke halaman utama -->
    <div class="btn-container">
        <a href="beranda.php" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
