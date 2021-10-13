<?php

require 'core.php';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = mysqli_query($mysqli, "SELECT * FROM pelanggan WHERE nama LIKE '%" . $search . "%' OR no_telp LIKE '%" . $search . "%' ") or die(mysqli_error($mysqli));

    if (mysqli_num_rows($query) > 0) {

        while ($rows = mysqli_fetch_assoc($query)) {
            $pesan[] = array(
                "value" => $rows['no_telp'],
                "label" => $rows['nama']
            );
        }
    }

    echo json_encode($pesan);
}
