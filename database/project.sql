-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2021 at 06:54 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `kasir` varchar(50) NOT NULL,
  `customer` char(13) NOT NULL,
  `tanggal` date NOT NULL,
  `total` int(11) NOT NULL,
  `id_detail_transaksi` int(11) NOT NULL,
  `no_nota` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`kasir`, `customer`, `tanggal`, `total`, `id_detail_transaksi`, `no_nota`) VALUES
('15', '098765432123', '2021-06-26', 175000, 56, 'INV260620211'),
('15', '098765432123', '2021-06-26', 175000, 57, 'INV260620211'),
('15', '0777', '2021-06-26', 175000, 58, 'INV260620213'),
('15', '0999999', '2021-10-13', 210000, 59, 'INV131020214');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `idgudang` char(5) NOT NULL,
  `nama_gudang` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`idgudang`, `nama_gudang`, `alamat`) VALUES
('G-BDG', 'Gudang Bandung', 'Jl. Bandung No. 21'),
('G-BWI', 'Gudang Banyuwangi', 'Jl. Banyuwangi No. 21'),
('G-JGY', 'Gudang Jogja Selatan 2', 'Jl. Jogja Selatan No. 21'),
('G-MDN', 'Gudang Madiun', 'Jl. Madiun No. 21'),
('G-MJK', 'Gudang Mojokerto', 'Jl. Mojokerto No. 21');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `no_telp` char(13) NOT NULL,
  `nama` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`no_telp`, `nama`) VALUES
('0777', 'antonio'),
('081234567890', 'wahid'),
('0888', 'dummy'),
('098765432123', 'assrori'),
('0999', 'junaidi'),
('0999999', 'subakur'),
('123456', 'dian');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `kode_produk` varchar(30) NOT NULL,
  `produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kode_produk`, `produk`, `harga`, `stok`, `gambar`) VALUES
('O-LP-CB', 'Combed 30s Lengan Pendek O-Neck Caribbean Blue', 35000, 24, '185495545.png'),
('O-LP-FA', 'Combed 30s Lengan Pendek O-Neck Fanta', 35000, 24, '696956224.png'),
('O-LP-HA', 'Combed 30s Lengan Pendek O-Neck Hijau Army', 35000, 24, '1388554185.png'),
('O-LP-HB', 'Combed 30s Lengan Pendek O-Neck Hijau Botol', 35000, 24, '230593744.png'),
('O-LP-HF', 'Combed 30s Lengan Pendek O-Neck Hijau Fuji', 35000, 24, '1010184442.png'),
('O-LP-HI', 'Combed 30s Lengan Pendek O-Neck Hitam', 35000, 24, '490774942.png'),
('O-LP-HP', 'Combed 30s Lengan Pendek O-Neck Hijau Pucuk', 35000, 34, '1619751545.png'),
('O-LP-RED', 'Combed 30s Lengan Pendek O-Neck Merah', 35000, 24, '976250099.png'),
('O-N-BIRU', 'Combed 30s Lengan Pendek O-Neck Biru Dongker', 35000, 32, '548034209.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `kode_produk` varchar(30) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `no_nota` char(50) NOT NULL,
  `id_transaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`kode_produk`, `harga`, `qty`, `sub_total`, `no_nota`, `id_transaksi`) VALUES
('O-LP-HA', 35000, 2, 70000, 'INV260620211', 1),
('O-LP-HB', 35000, 3, 105000, 'INV260620211', 2),
('O-LP-HA', 35000, 2, 70000, 'INV260620211', 3),
('O-LP-HB', 35000, 3, 105000, 'INV260620211', 4),
('O-LP-FA', 35000, 2, 70000, 'INV260620213', 5),
('O-LP-CB', 35000, 3, 105000, 'INV260620213', 6),
('O-LP-CB', 35000, 2, 70000, 'INV131020214', 7),
('O-LP-FA', 35000, 4, 140000, 'INV131020214', 8);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `idusergrup` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `username`, `password`, `idusergrup`, `status`) VALUES
(15, 'admin', 'admin', 2, 'Active'),
(78, 'tono', '1234', 3, 'Inactive'),
(81, 'doraemon', '1234', 3, 'Active'),
(90, 'rafaela', '123jaya', 2, 'Active'),
(92, 'Dodik', 'setuju23', 3, 'Inactive'),
(93, 'kuwait', 'kollllol', 2, 'Active'),
(95, 'nanda', 'kominu345', 3, 'Active'),
(96, 'jokowo', 'pres123', 3, 'Active'),
(98, 'jona', 'komokisuta', 3, 'Inactive'),
(99, 'dorayaki', 'makansiang123', 3, 'Active'),
(102, 'anas', '1234', 3, 'Active'),
(103, 'krisna', 'lpopsd123', 3, 'Active'),
(104, 'rido', 'kiol123', 3, 'Active'),
(105, 'sandi', '123', 3, 'Active'),
(109, 'jojo', 'madagaskar21', 3, 'Active'),
(110, 'yoga', 'jiraya123', 3, 'Active'),
(111, 'koi', '789', 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `usergrup`
--

CREATE TABLE `usergrup` (
  `idusergrup` int(11) NOT NULL,
  `usergrup` char(15) NOT NULL,
  `akses` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usergrup`
--

INSERT INTO `usergrup` (`idusergrup`, `usergrup`, `akses`) VALUES
(2, 'superadmin', 'user-customer-produk-penjualan-laporan'),
(3, 'purchasing', 'penjualan'),
(47, 'Gudang', 'produk');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `iduser_log` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `event` varchar(100) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`iduser_log`, `iduser`, `status`, `event`, `tanggal`) VALUES
(4, 15, 'Update', 'Update username/password', '2021-01-14 12:12:12'),
(5, 15, 'Update', 'Update username/password', '2021-02-23 12:12:12'),
(6, 15, 'Update', 'Update username/password', '2021-03-23 12:12:12'),
(7, 15, 'Insert', 'Insert data', '2021-04-23 12:12:12'),
(10, 15, 'Update', 'Update username/password', '2021-05-23 12:12:12'),
(11, 15, 'Update', 'Update username/password', '2021-06-23 12:12:12'),
(12, 15, 'Update', 'Update username/password', '2021-03-04 23:50:09'),
(13, 15, 'Update', 'Update username/password', '2021-03-08 15:24:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`idgudang`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`no_telp`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode_produk`),
  ADD UNIQUE KEY `produk` (`produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `idusergrup` (`idusergrup`);

--
-- Indexes for table `usergrup`
--
ALTER TABLE `usergrup`
  ADD PRIMARY KEY (`idusergrup`),
  ADD UNIQUE KEY `usergrup` (`usergrup`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`iduser_log`),
  ADD KEY `iduser` (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `usergrup`
--
ALTER TABLE `usergrup`
  MODIFY `idusergrup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `iduser_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user` FOREIGN KEY (`idusergrup`) REFERENCES `usergrup` (`idusergrup`) ON UPDATE CASCADE;

--
-- Constraints for table `user_log`
--
ALTER TABLE `user_log`
  ADD CONSTRAINT `user_log_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
