<?php require 'header.php'; ?>

<div class="content">
    <!-- <div class="header-content">
        <div class="header-content-menu">Gudang</div>
    </div> -->
    <div class="body-content">
        <div class="halaman-gudang">
            <div class="head-menu">Gudang</div>
            <button class="button-blue button-small button-form-tambah-gudang">Tambah Gudang</button>
            <form id="form-tambah-gudang" class="form-tambah-gudang">
                <label class="label-ve">Kode Gudang</label>
                <input class="input-small" type="text" name="idgudang" id="idgudang" required>
                <label class="label-ve">Gudang</label>
                <input class="input-small" type="text" name="nama_gudang" id="nama_gudang" required>
                <label class="label-ve">Alamat</label>
                <textarea class="input-small" id="alamat-gudang"></textarea>
                <button type="submit" class="button-green button-small submit-tambah-gudang">Simpan</button>
            </form>
            <form id="form-update-gudang" class="form-update-gudang">
                <label class="label-ve">Kode Gudang</label>
                <input class="input-small" type="text" name="update_idgudang" id="update-idgudang" disabled>
                <label class="label-ve">Gudang</label>
                <input class="input-small" type="text" name="update_nama_gudang" id="update-nama-gudang" required>
                <label class="label-ve">Alamat</label>
                <textarea class="input-small" name=update_alamat_gudang id="update-alamat-gudang"></textarea>
                <button type="submit" class="button-green submit-update-gudang button-small">Update</button>
            </form>
            <table>
                <thead>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Gudang</th>
                    <th>Alamat</th>
                    <th>Pilihan</th>
                </thead>
                <tbody class="table-data-gudang"></tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>