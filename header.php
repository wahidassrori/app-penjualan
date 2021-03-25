<?php require 'core/core.php';
akses_validation($mysqli); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="assets/fontawesome/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <title>Document</title>
</head>

<body>
    <div class="grid-container">
        <div class="header">
            <div class="brand">
                <span class="hamburger-menu"><i class="fas fa-hamburger"></i></span>
                <h2>Dashboard</h2>
            </div>
            <div class="profil">
                <img src="assets/img/profil.png" alt="profil">
                <h3>Hai Admin</h3>
            </div>
        </div>
        <div class="sidebar">
            <div class="sidebar-profil">
                <div class="profil-img"><img src="assets/img/profil.png" alt="profil image"></div>
                <div class="nama-profil">
                    <h3>Wahid Assrori</h3>
                </div>
                <div class="divisi-profil">Accounting</div>
            </div>
            <div class="menu-item user"><a href="user.php"><i class="fas fa-users"></i><span class="menu-large">User</span></a></div>
            <div class="menu-item gudang"><a href="gudang.php"><i class="fas fa-building"></i><span class="menu-large">Gudang</span></a></div>
            <div class="menu-item produk"><a href="produk.php"><i class="fas fa-shopping-basket"></i><span class="menu-large">Produk</span></a></div>
            <div class="menu-item penjualan"><a href="penjualan.php"><i class="fas fa-comments-dollar"></i><span class="menu-large">Penjualan</span></a></div>
            <div class="menu-item pembelian"><a href="pembelian.php"><i class="fas fa-money-check-alt"></i><span class="menu-large">Pembelian</span></a></div>
            <div class="menu-item laporan"><a href="laporan.php"><i class="fas fa-book"></i><span class="menu-large">Laporan</span></a></div>
        </div>