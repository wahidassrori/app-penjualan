<?php

require('core.php');

if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 'add_customer') {
        $nama = input_validation($_POST['nama']);
        $no_telp = input_validation($_POST['no_telp']);

        $cek_id_pelanggan = mysqli_query($mysqli, "SELECT * FROM pelanggan WHERE no_telp='{$no_telp}'") or die(mysqli_error($mysqli));
        $num_pelanggan = mysqli_num_rows($cek_id_pelanggan);
        if ($num_pelanggan > 0) {
            $pesan = [
                'duplikat' => 'No telp sudah terdaftar!'
            ];
        } else {
            $insert_pelanggan = mysqli_query($mysqli, "INSERT INTO pelanggan (nama, no_telp) VALUES ('{$nama}', '{$no_telp}')") or die(mysqli_error($mysqli));
            $pesan = [
                'sukses' => 'Data pelanggan berhasil ditambahkan!'
            ];
        }
        echo json_encode($pesan);
    }
}
