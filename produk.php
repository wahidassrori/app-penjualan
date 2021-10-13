<?php require 'header.php'; ?>

<div class="content">
    <div class="body-content">
        <div class="halaman-produk">
            <!-- <div class="head-menu">Produk</div> -->
            <div class="header-content">
                <div class="header-content-menu menu-daftar-produk">Daftar Produk</div>
                <div class="header-content-menu menu-tambah-produk">Tambah Produk</div>
            </div>
            <div class="content-daftar-produk">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="table-produk"></tbody>
                </table>
            </div>
            <div class="content-tambah-produk">
                <form id="form-tambah-produk" enctype="multipart/form-data">
                    <p class="pesan"></p>
                    <label class="label-ve">Kode Produk</label>
                    <input type="text" name="kode_produk" id="kode-produk" placeholder="Kode Produk" required>
                    <label class="label-ve">Produk</label>
                    <input type="text" name="produk" id="produk" placeholder="Nama Produk" required>
                    <label class="label-ve">Harga</label>
                    <input type="text" name="harga" id="harga" placeholder="Harga" required>
                    <label class="label-ve">Stok</label>
                    <input type="text" name="stok" id="stok" placeholder="Stok" required>
                    <label class="label-ve">Gambar</label>
                    <input type="file" name="file_foto">
                    <button type="submit" class="button-small button-green button-tambah-produk">Simpan</button>
                </form>
            </div>
            <div class="content-update-produk">
                <button class="back-daftar-produk button-blue">
                    << Kembali ke daftar produk</button>
                        <form id="form-update-produk" enctype="multipart/form-data">
                            <p class="pesan"></p>
                            <label class="label-ve">Kode Produk</label>
                            <input type="hidden" name="up_kode_produk" id="up-kode-produk">
                            <input type="text" name="update_kode_produk" id="update-kode-produk" disabled required>
                            <label class="label-ve">Produk</label>
                            <input type="text" name="update_produk" id="update-produk" placeholder="Nama Produk" required>
                            <label class="label-ve">Harga</label>
                            <input type="text" name="update_harga" id="update-harga" placeholder="Harga" required>
                            <label class="label-ve">Stok</label>
                            <input type="text" name="update_stok" id="update-stok" placeholder="Stok" required>
                            <label class="label-ve">Gambar</label>
                            <img id="update-file-foto" src="" class="img-produk">
                            <input type="file" name="up_file_foto" id="edit-file-foto">
                            <button type="submit" class="button-small button-green button-update-produk">Simpan</button>
                        </form>
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>