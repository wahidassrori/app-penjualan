<?php require 'header.php' ?>
<div class="content">
    <div class="body-content">
        <div class="halaman-user">
            <!-- <div class="head-menu">User</div> -->
            <div class="header-content">
                <div class="header-content-menu menu-data-user">Data User</div>
                <div class="header-content-menu menu-usergrup">Usergrup</div>
                <div class="header-content-menu menu-log-user">Log User</div>
            </div>
            <div class="content-data-user">
                <button class="button-form-tambah-user button-small button-normal">Tambah User</button>
                <div class="pesan pesan-tambah-user"></div>
                <form class="form-tambah-user">
                    <label class="label-ve">Username</label>
                    <input class="input-small" type="text" name="username" autocomplete="off" required>
                    <label class="label-ve">Password</label>
                    <input class="input-small" type="text" name="password" autocomplete="off" required>
                    <label class="label-ve">Usergrup</label>
                    <select class="input-small" name="id_usergrup" id="id-usergrup" required>
                        <option value="">Pilih Usergrup</option>
                        <?php
                        $query = mysqli_query($mysqli, "SELECT idusergrup, usergrup FROM usergrup");
                        while ($rows = mysqli_fetch_assoc($query)) {
                            echo '<option value="' . $rows['idusergrup'] . '">' . $rows['usergrup'] . '</option>';
                        }
                        ?>
                    </select>
                    <button class="button-simpan-user button-small button-green" type="submit">Simpan</button>
                </form>
                <div class="pesan"></div>
                <div class="update-user"></div>
                <div class="filter-data-user">
                    <select id="jumlah-tampil-data-user" class="jumlah-tampil-user input-small">
                        <option value="100" selected>100</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </select>
                    <input type="search" class="search-data-user input-small" placeholder="Search">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Usergrup</th>
                            <th>Status</th>
                            <th width="30px">Update</th>
                        </tr>
                    </thead>
                    <tbody class="data-user"></tbody>
                </table>
                <div class="pagination">
                    <button type=button class="prev button-small button-blue" value="">PREV</button>
                    <div class="pagination-number"></div>
                    <button type=button class="next button-small button-blue">NEXT</button>
                </div>
            </div>
            <div class="content-usergrup">
                <form id="form-tambah-usergrup">
                    <div class="pesan-usergrup"></div>
                    <label class="label-ve">Usergrup</label>
                    <input type="text" name="usergrup" id="input-usergrup" autocomplete="off" required>
                    <div class="checkbox-akses">
                        <label>
                            <input type="checkbox" name="akses" class="akses" value="user"> User
                        </label>
                        <!-- <label>
                            <input type="checkbox" name="akses" class="akses" value="gudang"> Gudang
                        </label> -->
                        <label>
                            <input type="checkbox" name="akses" class="akses" value="customer"> Customer
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses" value="produk"> Produk
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses" value="penjualan"> Penjualan
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses" value="pembelian"> Pembelian
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses" value="laporan"> Laporan
                        </label>
                    </div>
                    <input class="button-tambah-usergrup button-green" type="submit" value="Tambah Usergrup">
                </form>
                <form id="form-update-usergrup">
                    <div class="pesan-usergrup"></div>
                    <label class="label-ve">Usergrup</label>
                    <input type="text" name="usergrup" id="input-update-usergrup" autocomplete="off" required>
                    <input type="hidden" name="simpan_idusergrup" id="simpan-idusergrup">
                    <div class="checkbox-akses">
                        <label>
                            <input type="checkbox" name="akses" class="akses-usergrup" value="user"> User
                        </label>
                        <!-- <label>
                            <input type="checkbox" name="akses" class="akses-usergrup" value="gudang"> Gudang
                        </label> -->
                        <label>
                            <input type="checkbox" name="akses" class="akses-usergrup" value="customer"> Customer
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses-usergrup" value="produk"> Produk
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses-usergrup" value="penjualan"> Penjualan
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses-usergrup" value="pembelian"> Pembelian
                        </label>
                        <label>
                            <input type="checkbox" name="akses" class="akses-usergrup" value="laporan"> Laporan
                        </label>
                    </div>
                    <input class="simpan-update-usergrup button-green" type="submit" value="Simpan">
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Usergrup</th>
                            <th>Akses</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody class="data-usergrup"></tbody>
                </table>
            </div>
            <div class="content-log-user">
                <select id="search-log-user">
                    <option class="search-log-user-value" value="1">Januari</option>
                    <option class="search-log-user-value" value="2">Februari</option>
                    <option class="search-log-user-value" value="3">Maret</option>
                    <option class="search-log-user-value" value="4">April</option>
                    <option class="search-log-user-value" value="5">Mei</option>
                    <option class="search-log-user-value" value="6">Juni</option>
                    <option class="search-log-user-value" value="7">Juli</option>
                    <option class="search-log-user-value" value="8">Agustus</option>
                    <option class="search-log-user-value" value="9">September</option>
                    <option class="search-log-user-value" value="10">Oktober</option>
                    <option class="search-log-user-value" value="11">November</option>
                    <option class="search-log-user-value" value="12">Desember</option>
                </select>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="table-content-log-user"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div></div>
</div>
<?php require 'footer.php' ?>