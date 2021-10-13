<?php
require 'core/core.php';
akses_validation($mysqli);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="assets/fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/DataTables/css/dataTables.dataTables.min.css" />
    <!--load all styles -->
    <title>Document</title>
</head>

<body>
    <div class="grid-container">
        <div class="header"></div>
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
            </div>
            <div class="menu-item user"><a href="user.php"><i class="fas fa-users"></i><span class="menu-large">Users</span></a></div>
            <!-- <div class="menu-item gudang"><a href="gudang.php"><i class="fas fa-building"></i><span class="menu-large">Gudang</span></a></div> -->
            <div class="menu-item customer"><a href="customer.php"><i class="fas fa-building"></i><span class="menu-large">Customers</span></a></div>
            <div class="menu-item produk"><a href="produk.php"><i class="fas fa-shopping-basket"></i><span class="menu-large">Produk</span></a></div>
            <div class="menu-item penjualan"><a href="penjualan.php"><i class="fas fa-comments-dollar"></i><span class="menu-large">Penjualan</span></a></div>
            <div class="menu-item pembelian"><a href="pembelian.php"><i class="fas fa-money-check-alt"></i><span class="menu-large">Pembelian</span></a></div>
            <div class="menu-item laporan"><a href="laporan.php"><i class="fas fa-book"></i><span class="menu-large">Laporan</span></a></div>
        </div>