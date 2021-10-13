<?php

require 'core.php';

$query = mysqli_query($mysqli, "SELECT * FROM pelanggan") or die(mysqli_error($mysqli));

while ($row = mysqli_fetch_assoc($query)) {
    $pesan['data'][] = [
        'nama' => $row['nama'],
        'no_telp' => $row['no_telp']
    ];
}

echo json_encode($pesan);
