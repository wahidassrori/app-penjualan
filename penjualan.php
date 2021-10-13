<?php require 'header.php'; ?>

<div class="content">
    <div class="body-content">
        <div class="halaman-penjualan">
            <h3 class="title-customer">Data Customer</h3>
            <div class="search-customer">
                <input class="cari-pelanggan" type="text" name="cari_pelanggan" placeholder="Pelanggan">
                <button class="button-blue button-tambah-customer">Tambah</button>
            </div>
            <div class="add-customer">
                <form id="add-customer">
                    <p id="pesan-pelanggan"></p>
                    <div class="input-group">
                        <label>Nama Customer</label>
                        <input type="text" name="nama" placeholder="Nama Customer">
                    </div>
                    <div class="input-group">
                        <label>No Telp</label>
                        <input type="text" name="no_telp" placeholder="Telp Customer">
                    </div>
                    <button class="button-green button-simpan-customer" id="submit-add-customer">Simpan</button>
                </form>
            </div>
            <div class="form-transaksi">
                <h3>Transaksi</h3>
                <?php

                if (isset($_GET['pesan'])) {
                    if ($_GET['pesan'] == 'simpan') {
                        echo '<p class="pesan-transaksi-simpan">Simpan data transaksi berhasil!</p>';
                    } else {
                        $pesan = explode('-', $_GET['pesan']);
                        echo "
                                <script>
                                    window.open('invoice_pdf.php?id={$pesan[1]}', '_blank');
                                </script>
                            ";
                    }
                }

                ?>
                <!-- <form id="form-transaksi" action="core/proses_transaksi.php" method="POST"> -->
                <form action="core/proses_transaksi.php" method="POST" target="_SELF">
                    <div class="form-top">
                        <div class="form-transaksi-left">
                            <div class="input-group">
                                <label>Kasir</label>
                                <?php
                                $query = mysqli_query($mysqli, "SELECT iduser, username FROM user WHERE iduser={$_SESSION['iduser']}");
                                $row = mysqli_fetch_assoc($query);
                                ?>
                                <input type="text" value="<?= $row['username']; ?>" disabled>
                                <input id="kasir" type="text" name="kasir" value="<?= $row['iduser']; ?>" hidden>
                            </div>
                            <div class="input-group">
                                <label>Customer</label>
                                <input id="nama-customer" type="text" disabled>
                                <input id="customer-id" name="customer" type="text" hidden>
                            </div>
                        </div>
                        <div class="form-transaksi-right">
                            <div class="input-group">
                                <label>No. Nota</label>
                                <input id="no-nota" type="text" disabled>
                                <input id="no-nota-form" name="no_nota" type="text" hidden>
                            </div>
                            <div class="input-group">
                                <label>Tanggal</label>
                                <input type="text" value="<?= date('d-m-Y'); ?>" disabled>
                                <input id="tanggal" type="text" name="tanggal" value="<?= date('Y-m-d'); ?>" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <div class="input-transaksi">
                            <input class="t-produk" type="text">
                            <input class="t-harga" type="text" placeholder="Harga" disabled>
                            <input class="t-qty" type="number" name="qty[]" placeholder="Qty">
                            <input class="t-sub-total" type="text" placeholder="Sub Total" disabled>
                            <input class="kode-produk" type="text" name="produk[]" hidden>
                            <input type="text" name="harga[]" hidden>
                            <input type="text" name="sub_total[]" hidden>
                            <button type="button" class="button-blue t-btn" id="create-element-produk">+</button>
                        </div>
                        <div class="end-transaction"></div>
                    </div>
                    <div class="tampilan-detail-transaksi">
                        <div class="grup-item">
                            <label>Jumlah Item</label>
                            <input type="text" class="jumlah-item" disabled>
                            <input type="text" name="jumlah_item" class="jumlah-item" hidden>
                        </div>
                        <div class="grup-item">
                            <label>Total Bayar</label>
                            <input type="text" class="total-bayar" disabled>
                            <input type="text" name="total_bayar" class="total-bayar" hidden>
                        </div>
                        <div class="grup-item">
                            <label>Bayar</label>
                            <input type="text" id="bayar">
                        </div>
                        <div class="grup-item">
                            <label>Kembali</label>
                            <input type="text" id="kembali" disabled>
                        </div>
                        <div class="grup-item">

                            <button class="button-green print-nota" type="submit" name="submit_transaksi" value="cetak">Cetak Invoice</button>
                            <button class="button-blue simpan-transaksi" type="submit" name="submit_transaksi" value="simpan">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>