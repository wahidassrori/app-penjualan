<?php

require 'core.php';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = mysqli_query($mysqli, "SELECT kode_produk, produk, harga FROM produk WHERE produk LIKE '%" . $search . "%' ") or die(mysqli_error($mysqli));

    if (mysqli_num_rows($query) > 0) {

        while ($rows = mysqli_fetch_assoc($query)) {
            $pesan[] = array(
                "value" => $rows['harga'],
                "kode_produk" => $rows['kode_produk'],
                "label" => $rows['produk']
            );
        }
    }
    echo json_encode($pesan);
}
