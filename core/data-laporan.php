<?php

require 'core.php';

$query = mysqli_query($mysqli, "SELECT detail_transaksi.id_detail_transaksi, pelanggan.nama, detail_transaksi.no_nota, user.username, detail_transaksi.tanggal, detail_transaksi.total FROM detail_transaksi JOIN pelanggan ON detail_transaksi.customer=pelanggan.no_telp JOIN user ON detail_transaksi.kasir=user.iduser") or die(mysqli_error($mysqli));

$nomor = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $pesan['data'][] = [
        'no' => $nomor++,
        'no_nota' => $row['no_nota'],
        'kasir' => $row['username'],
        'customer' => $row['nama'],
        'tanggal' => $row['tanggal'],
        'total' => $row['total'],
        'keterangan' => ["<button class='button-blue' value='{$row['id_detail_transaksi']}'>Detail</button>"]
    ];
}

echo json_encode($pesan);
