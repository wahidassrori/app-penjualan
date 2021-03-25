<?php

require 'core.php';

if (isset($_POST)) {
    if ($_POST['proses_produk'] === 'add_produk') {
        print_r($_POST);
        print_r($_FILES);
    }
}
