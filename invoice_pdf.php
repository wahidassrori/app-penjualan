<?php

require('core/core.php');
require('core/fpdf/fpdf.php');

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$id_transaksi = $_GET['id'];

$table_detail_transaksi = mysqli_query($mysqli, "SELECT * FROM detail_transaksi WHERE id_detail_transaksi={$id_transaksi}") or die(mysqli_error($mysqli));

$row_detail_transaksi = mysqli_fetch_assoc($table_detail_transaksi);

$table_transaksi = mysqli_query($mysqli, "SELECT * FROM transaksi WHERE no_nota='{$row_detail_transaksi['no_nota']}'") or die(mysqli_error($mysqli));

$row_transaksi = mysqli_fetch_assoc($table_transaksi);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(140, 7, 'PT. Wahid Assrori, Tbk', 0, 0);
$pdf->Cell(50, 7, 'INVOICE', 0, 1);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(140, 5, 'Jl. Pajajaran No. 200 Surabaya', 0, 0);
$pdf->Cell(50, 5, "{$row_transaksi['no_nota']}", 0, 1);

// Membuat cell kosong untuk jarak
$pdf->Cell(140, 15, '', 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 7, 'Customer :', 0, 1);

$customer = mysqli_query($mysqli, "SELECT * FROM pelanggan WHERE no_telp='{$row_detail_transaksi['customer']}'");
$row_customer = mysqli_fetch_assoc($customer);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 5, 'Nama', 0, 0);
$pdf->Cell(90, 5, ": {$row_customer['nama']}", 0, 0);
$pdf->Cell(25, 5, 'Tanggal', 0, 0);
$pdf->Cell(30, 5, ": {$row_detail_transaksi['tanggal']}", 0, 1);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 5, 'No Telp', 0, 0);
$pdf->Cell(90, 5, ': ' . $row_customer['no_telp'], 0, 1);

// Membuat cell kosong untuk jarak
$pdf->Cell(140, 10, '', 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 7, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(30, 7, 'Harga', 1, 0, 'C');
$pdf->Cell(20, 7, 'Qty', 1, 0, 'C');
$pdf->Cell(35, 7, 'Sub Total', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$sql_barang = mysqli_query($mysqli, "SELECT * FROM transaksi WHERE no_nota='{$row_detail_transaksi['no_nota']}'");
while ($row_barang = mysqli_fetch_assoc($sql_barang)) {

    $sql_produk = mysqli_query($mysqli, "SELECT produk FROM produk WHERE kode_produk='{$row_barang['kode_produk']}'");

    $res_produk = mysqli_fetch_assoc($sql_produk);
    $pdf->Cell(100, 7, "{$res_produk['produk']}", 1, 0);
    $pdf->Cell(30, 7, 'Rp. ' . number_format($row_barang['harga'], 0, '.', '.'), 1, 0);
    $pdf->Cell(20, 7, "{$row_barang['qty']}", 1, 0, 'C');
    $pdf->Cell(35, 7, 'Rp. ' . number_format($row_barang['sub_total'], 0, '.', '.'), 1, 1);
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100, 7, '', 0, 0);
$pdf->Cell(50, 7, 'Grand Total', 1, 0);
$pdf->Cell(35, 7, 'Rp. ' . number_format($row_detail_transaksi['total'], 0, '.', '.'), 1, 1);

// Membuat cell kosong untuk jarak
$pdf->Cell(100, 20, '', 0, 1);

$pdf->Cell(130, 7, '', 0, 0);
$pdf->Cell(55, 7, 'PT. Wahid Assrori, Tbk', 0, 1);

// Membuat cell kosong untuk jarak
$pdf->Cell(100, 15, '', 0, 1);

$pdf->Cell(130, 7, '', 0, 0);
$pdf->Cell(55, 7, '( Manager Penjualan )', 0, 1);

$pdf->Output();
