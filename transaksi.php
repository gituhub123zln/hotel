<?php
// Memuat file dummy.php yang berisi data produk kamar hotel
require 'dummy.php';

// Mendapatkan ID produk dari URL (jika ada), jika tidak ID default adalah 0
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Memeriksa apakah ID valid dan ada dalam data produk, jika tidak, tampilkan pesan error
if (!isset($datapaket[$id])) {
    echo "Produk tidak ditemukan!";
    exit;
}

// Mengambil data produk berdasarkan ID yang diberikan
$produk = $datapaket[$id];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan</title>
    <style>
        /* Styling umum untuk body halaman */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        /* Styling container form pemesanan */
        .container {
            width: 50%;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Styling untuk judul form pemesanan */
        h2 {
            text-align: center;
            background-color: #4682B4;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        /* Styling untuk label input */
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        /* Styling untuk input dan select */
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .radio-group {
            display: flex;
            gap: 10px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        button {
            width: 30%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .btn-primary { background: #4682B4; }
        .btn-secondary { background: gray; }
        .btn-cancel { background: red; }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Pemesanan</h2>
    <form action="invoice.php" method="post" onsubmit="return validateForm()">
        <label>Nama Pemesan:</label>
        <input type="text" name="nama_pemesan" required>

        <label>Jenis Kelamin:</label>
        <div class="radio-group">
            <input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki
            <input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan
        </div>

        <label>Nomor Identitas (16 digit):</label>
        <input type="text" name="nomor_identitas" id="nomor_identitas" required>
        <div id="error-message" class="error"></div>

        <!-- Dropdown untuk memilih tipe kamar -->
        <label>Tipe Kamar:</label>
        <select name="tipe_kamar" id="tipe_kamar" onchange="updateHarga()" required>
            <option value="STANDARD" data-harga="500000">STANDARD</option>
            <option value="DELUXE" data-harga="600000">DELUXE</option>
            <option value="EXECUTIF" data-harga="700000">EXECUTIF</option>
        </select>

        <label>Harga:</label>
        <input type="text" id="harga" name="harga" value="500000" readonly>

        <label>Tanggal Pesan:</label>
        <input type="date" name="tanggal_pesan" required>

        <label>Durasi Menginap (hari):</label>
        <input type="number" name="durasi" id="durasi" value="1" min="1" required>

        <label>Termasuk Breakfast:</label>
        <input type="checkbox" name="breakfast" id="breakfast" value="Ya">

        <label>Total Bayar:</label>
        <input type="text" id="total_bayar" name="total_bayar" readonly>

        <div class="btn-container">
            <button type="button" class="btn-primary" onclick="hitungTotal()">Hitung Total Bayar</button>
            <button type="submit" class="btn-secondary">Simpan</button>
            <button type="reset" class="btn-cancel">Cancel</button>
        </div>
    </form>
</div>

<script>
    let hargaInput = document.getElementById("harga");
    let durasiInput = document.getElementById("durasi");
    let breakfastInput = document.getElementById("breakfast");
    let totalBayarInput = document.getElementById("total_bayar");

    // Fungsi untuk mengupdate harga ketika tipe kamar dipilih
    function updateHarga() {
        let tipeKamar = document.getElementById("tipe_kamar");
        let hargaKamar = tipeKamar.options[tipeKamar.selectedIndex].getAttribute("data-harga");
        hargaInput.value = hargaKamar; // Update harga
        hitungTotal(); // Update total bayar
    }

    // Fungsi untuk menghitung total bayar
    function hitungTotal() {
        let hargaKamar = parseInt(hargaInput.value.replace(/[^0-9]/g, '')); // Mengambil nilai harga dan memastikan angka
        let durasi = parseInt(durasiInput.value); // Durasi menginap
        let includeBreakfast = breakfastInput.checked; // Apakah termasuk breakfast
        let hargaBreakfast = includeBreakfast ? 80000 : 0; // Menentukan harga breakfast

        // Menghitung total bayar
        let totalBayar = (hargaKamar * durasi) + hargaBreakfast;

        // Memberikan diskon 10% jika durasi lebih dari 3 hari
        if (durasi > 3) {
            totalBayar *= 0.9; // Diskon 10%
        }

        // Menampilkan total bayar di input yang sudah dibaca
        totalBayarInput.value = totalBayar.toFixed(0);
    }

    // Menambahkan event listener untuk menghitung total bayar saat durasi atau breakfast berubah
    durasiInput.addEventListener("input", hitungTotal);
    breakfastInput.addEventListener("change", hitungTotal);

    // Memanggil fungsi hitungTotal saat halaman pertama kali dimuat
    window.onload = function() {
        hitungTotal();
        updateHarga(); // Memastikan harga pertama kali ditampilkan
    };

    // Validasi form untuk nomor identitas (harus 16 digit)
    function validateForm() {
        const nomorIdentitas = document.getElementById('nomor_identitas').value;
        const errorMessage = document.getElementById('error-message');

        if (!/^\d{16}$/.test(nomorIdentitas)) {
            errorMessage.textContent = "Isian salah... data harus 16 digit.";
            return false;
        }

        errorMessage.textContent = "";
        return true;
    }
</script>

</body>
</html>
