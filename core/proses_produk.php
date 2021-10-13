<?php

require 'core.php';

if (isset($_POST)) {
    if ($_POST['proses_produk'] === 'add_produk') {

        $kode_produk = strtoupper($_POST['kode_produk']);
        $produk = ucfirst($_POST['produk']);
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $image = imageValidation('file_foto');

        // validasi kode produk & nama produk
        $query_kode_produk = mysqli_query($mysqli, "SELECT * FROM produk WHERE kode_produk='$kode_produk'");
        $query_produk = mysqli_query($mysqli, "SELECT * FROM produk WHERE produk='$produk'");
        if (mysqli_num_rows($query_kode_produk) > 0) {
            $pesan = ['duplikasi_kode_produk' => 'Kode produk sudah ada'];
        } elseif (mysqli_num_rows($query_produk)) {
            $pesan = ['duplikasi_nama_produk' => 'Produk sudah ada'];
        } elseif (!array_key_exists('sukses', $image)) {
            $pesan = $image;
        } else {
            $query = mysqli_query($mysqli, "INSERT INTO produk (kode_produk, produk, harga, stok, gambar) VALUES ('{$kode_produk}', '{$produk}', {$harga}, {$stok}, '{$image['sukses']}')");
            if ($query) {
                $pesan = ['sukses' => 'Data berhasil ditambahkan'];
            } else {
                $pesan = ['error' => 'Gagal : ' . mysqli_error($mysqli)];
            }
        }
        echo json_encode($pesan);
    } elseif ($_POST['proses_produk'] === 'edit_produk') {

        $kode_produk = strtoupper($_POST['up_kode_produk']);
        $produk = ucfirst($_POST['update_produk']);
        $harga = $_POST['update_harga'];
        $stok = $_POST['update_stok'];
        $image = updateImage('up_file_foto', $kode_produk);

        if (array_key_exists('gambar', $image)) {
            $resultImage = $image['gambar'];
        }

        if (array_key_exists('sukses', $image)) {
            $resultImage = $image['sukses'];
        }

        if (array_key_exists('gagal', $image)) {
            $pesan = $image;
        } else {
            $query_produk = mysqli_query($mysqli, "SELECT produk FROM produk WHERE produk='$produk'");
            if (mysqli_num_rows($query_produk) > 0) {
                $pesan = ['duplikasi_nama_produk' => 'Produk sudah ada'];
            } else {
                $query = mysqli_query($mysqli, "UPDATE produk SET produk='$produk', harga=$harga, stok=$stok, gambar='{$resultImage}' WHERE kode_produk='$kode_produk'");
                if ($query) {
                    $pesan = ['sukses' => 'Data berhasil diupdate'];
                } else {
                    $pesan = ['gagal' => 'Error : ' . mysqli_error($mysqli)];
                }
            }
        }

        echo json_encode($pesan);
    } 
}
