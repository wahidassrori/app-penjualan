<?php

require 'core.php';

if (isset($_POST['submit_transaksi'])) {
    $kasir          = input_validation($_POST['kasir']);
    $customer       = input_validation($_POST['customer']);
    $no_nota        = input_validation($_POST['no_nota']);
    $tanggal        = input_validation($_POST['tanggal']);
    $jumlah_item    = input_validation($_POST['jumlah_item']);
    $total_bayar    = input_validation($_POST['total_bayar']);

    $makeid = mysqli_query($mysqli, "SELECT * FROM detail_transaksi") or die(mysqli_error($mysqli));

    // $id_transaksi = mysqli_num_rows($makeid) + 1;

    $jumlah_produk = count($_POST['qty']);

    for ($i = 0; $i < $jumlah_produk; $i++) {
        $array_produk[] = "('{$_POST['produk'][$i]}', {$_POST['harga'][$i]}, {$_POST['qty'][$i]}, {$_POST['sub_total'][$i]}, '{$no_nota}')";
    }

    $query = implode(',', $array_produk);

    $result = mysqli_query($mysqli, "INSERT INTO transaksi (kode_produk, harga, qty, sub_total, no_nota) VALUES $query") or die(mysqli_error($mysqli));

    $result_detail_transaksi = mysqli_query($mysqli, "INSERT INTO detail_transaksi (kasir, customer, tanggal, total, no_nota) VALUES ('{$kasir}', '{$customer}', '{$tanggal}', {$total_bayar}, '{$no_nota}')") or die(mysqli_error($mysqli));


    if ($_POST['submit_transaksi'] == 'simpan' && $result == true && $result_detail_transaksi == true) {
        header('location: ../penjualan.php?pesan=simpan');
    }

    if ($_POST['submit_transaksi'] == 'cetak'  && $result == true) {

        $query = mysqli_query($mysqli, "SELECT id_detail_transaksi FROM detail_transaksi WHERE no_nota='{$no_nota}'") or die(mysqli_error($mysqli));

        $result = mysqli_fetch_assoc($query);

        header("location: ../penjualan.php?pesan=cetak-{$result['id_detail_transaksi']}");
    }
}
