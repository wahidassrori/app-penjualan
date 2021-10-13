<?php

require 'core.php';

$result = json_decode(file_get_contents('php://input'), true);

if (isset($result['proses'])) {
    if ($result['proses'] === 'login') {
        $query = mysqli_query(
            $mysqli,
            "SELECT iduser, username, password,idusergrup FROM user WHERE username='{$result['username']}' AND password='{$result['password']}' AND status='Active'"
        );
        $rows = mysqli_fetch_assoc($query);
        if (mysqli_num_rows($query) > 0) {
            $_SESSION['iduser'] = $rows['iduser'];
            $pesan = ['pesan' => 'sukses'];
        } else {
            $pesan = ['pesan' => 'error'];
        }
        echo json_encode($pesan);
    }
    if ($result['proses'] === 'hak_akses_menu') {
        $query_user = mysqli_query(
            $mysqli,
            "SELECT idusergrup FROM user WHERE iduser='{$_SESSION['iduser']}'"
        );
        $rows = mysqli_fetch_assoc($query_user);
        $query = mysqli_query(
            $mysqli,
            "SELECT akses FROM usergrup WHERE idusergrup='{$rows['idusergrup']}'"
        );
        echo json_encode(mysqli_fetch_assoc($query));
    }
    if ($result['proses'] === 'update_user') {
        $query = mysqli_query($mysqli, "SELECT username, password FROM user WHERE iduser='{$result['iduser']}' ");
        echo json_encode(mysqli_fetch_assoc($query));
    }
    if ($result['proses'] === 'simpan_update_user') {
        $query_cekduplikat = mysqli_query($mysqli, "SELECT username, password FROM user WHERE username='{$result['username']}' AND password='{$result['password']}' ");
        if (mysqli_num_rows($query_cekduplikat) > 0) {
            $pesan = ['error' => 'Data gagal diupdate'];
        } else {
            $query = mysqli_query($mysqli, "UPDATE user SET username='{$result['username']}', password='{$result['password']}' WHERE iduser={$result['iduser']}");
            if ($query) {
                mysqli_query($mysqli, "INSERT INTO user_log (iduser, status, event) VALUES ('{$_SESSION['iduser']}', 'Update', 'Update username/password') ");
                $pesan = ['sukses' => 'Data berhasil diupdate'];
            } else {
                $pesan = ['error' => 'Data gagal diupdate'];
            }
        }
        echo json_encode($pesan);
    }
    if ($result['proses'] === 'update_user_usergrup') {
        $query = mysqli_query($mysqli, "UPDATE user SET idusergrup='{$result['idusergrup']}' WHERE iduser='{$result['iduser']}'");
        if ($query) {
            mysqli_query($mysqli, "INSERT INTO user_log (iduser, status, event) VALUES ('{$_SESSION['iduser']}', 'Update', 'Update username/password') ");
            $pesan = ['sukses' => 'Data berhasil diupdate'];
        } else {
            $pesan = ['error' => 'Data Gagal diupdate'];
        }
        echo json_encode($pesan);
    }
    if ($result['proses'] === 'tambah_user') {
        $username = input_validation($result['username']);
        $password = input_validation($result['password']);
        $idusergrup = input_validation($result['id_usergrup']);
        $query = mysqli_query($mysqli, "INSERT INTO user (username, password, idusergrup) VALUES ('$username', '$password', $idusergrup)");
        if ($query) {
            mysqli_query($mysqli, "INSERT INTO user_log (iduser, status, event) VALUES ('{$_SESSION['iduser']}', 'Insert', 'Insert data') ");
            $pesan = ['sukses' => 'Data berhasil disimpan'];
        } else {
            $pesan = ['error' => 'Data gagal disimpan'];
        }
        echo json_encode($pesan);
    }
    if ($result['proses'] == 'data_user') {
        $query = mysqli_query($mysqli, 'SELECT * FROM user LIMIT 5');
        $nomor = 0;
        while ($rows = mysqli_fetch_assoc($query)) {
            $nomor++;
            echo '<tr>';
            echo '<td>' . $nomor . '</td>';
            echo '<td>' . $rows['username'] . '</td>';
            echo '<td>' . $rows['password'] . '</td>';
            echo '<td><select name="' . $rows['iduser'] . '" id="usergrup">';
            $query_usergrup = mysqli_query($mysqli, 'SELECT idusergrup, usergrup FROM usergrup');
            while ($rows_usergrup = mysqli_fetch_assoc($query_usergrup)) {
                $selected = '';
                if ($rows['idusergrup'] == $rows_usergrup['idusergrup']) {
                    $selected = 'selected';
                }
                echo '<option value="' . $rows_usergrup['idusergrup'] . $selected . '>' . $rows_usergrup['usergrup'] . '</option>';
            }
            echo '</select></td>';
            echo '<td><select name="' . $rows['iduser'] . '" class="status-user">';
            if ($rows['status'] === 'Active') {
                echo '<option value="Active" Selected>Active</option>';
                echo '<option value="Inactive">Inactive</option>';
            }
            if ($rows['status'] === 'Inactive') {
                echo '<option value="Active">Active</option>';
                echo '<option value="Inactive"  Selected>Inactive</option>';
            }
            echo '</select></td>';
            //echo '<td>' . $rows['status'] . '</td>';
            echo '<td><button class="button-edit-user button-orange" value="' . $rows['iduser'] . '">Update</button></td>';
            echo '</tr>';
        }
    }
    if ($result['proses'] == 'data_user_baru') {

        if ($result['page'] !== null) {
            $hasil['page'] = $result['page'];
        } else {
            $hasil['page'] = 0;
        }

        if ($result['kondisi'] !== null) {

            $query = mysqli_query($mysqli, "SELECT iduser, username, password, idusergrup, status FROM user WHERE username LIKE '%{$result['kondisi']}%' OR status LIKE '%{$result['kondisi']}%' LIMIT {$result['limit']}");
            $hasil['jumlah_data'] = mysqli_num_rows($query);
        } elseif ($result['offset'] != null) {

            $offset = $result['offset'];

            $query = mysqli_query($mysqli, "SELECT iduser, username, password, idusergrup, status FROM user WHERE username LIKE '%{$result['kondisi']}%' OR status LIKE '%{$result['kondisi']}%' LIMIT {$result['limit']} OFFSET {$offset}");

            $jumlah_semua_record = mysqli_query($mysqli, 'SELECT iduser FROM user');

            $hasil['jumlah_data'] = mysqli_num_rows($jumlah_semua_record);
        } elseif ($result['offset'] == null) {
            $query = mysqli_query($mysqli, "SELECT iduser, username, password, idusergrup, status FROM user LIMIT {$result['limit']}");
            $jumlah_semua_record = mysqli_query($mysqli, 'SELECT iduser FROM user');
            $hasil['jumlah_data'] = mysqli_num_rows($jumlah_semua_record);
        }

        $jumlah_tampil = $result['limit'];
        $hasil['jumlah_halaman'] = ceil($hasil['jumlah_data'] / $jumlah_tampil);

        if (mysqli_num_rows($query) > 0) {

            while ($rows = mysqli_fetch_assoc($query)) {
                $hasil['data'][] = $rows;
            }

            $query_usergrup = mysqli_query($mysqli, 'SELECT idusergrup, usergrup FROM usergrup');
            while ($rows_usergrup = mysqli_fetch_assoc($query_usergrup)) {
                $hasil['usergrup'][] = $rows_usergrup;
            }
        } else {
            $hasil = ['pesan' => 'kosong'];
        }

        echo json_encode($hasil);
    }
    if ($result['proses'] == 'delete_user') {
        $iduser = $result['iduser'];
        $query = mysqli_query($mysqli, "DELETE FROM user WHERE iduser=$iduser");
        if ($query) {
            $pesan = ['sukses' => 'Data berhasil dihapus'];
        } else {
            $pesan = ['error' => 'Error : ' . mysqli_error($mysqli)];
        }
        echo json_encode($pesan);
    }
    if ($result['proses'] == 'update_status_user') {
        $query = mysqli_query($mysqli, "UPDATE user SET status='{$result['status']}' WHERE iduser='{$result['iduser']}'");
        if ($query) {
            mysqli_query($mysqli, "INSERT INTO user_log (iduser, status, event) VALUES ('{$_SESSION['iduser']}', 'Update', 'Update username/password') ");
            $pesan = ['pesan' => 'Data berhasil diupdate'];
        } else {
            $pesan = ['pesan' => 'Error'];
        }
        echo json_encode($pesan);
    }
}

if (isset($result['proses_log'])) {
    if ($result['proses_log'] === 'user') {
        $query = mysqli_query($mysqli, "SELECT user.username, user_log.status, user_log.event, user_log.tanggal FROM user_log INNER JOIN user ON user_log.iduser=user.iduser WHERE month(tanggal)={$result['kondisi']} LIMIT 32");
        if ($query) {
            if (mysqli_num_rows($query) > 0) {
                while ($rows = mysqli_fetch_assoc($query)) {
                    $hasil[] = $rows;
                }
            } else {
                $hasil = ['kosong' => 'Data tidak tersedia!'];
            }
        } else {
            $hasil = ['error' => mysqli_error($mysqli)];
        }
        echo json_encode($hasil);
    }
}

if (isset($result['proses_usergrup'])) {
    if ($result['proses_usergrup'] === 'data_usergrup') {
        $query = mysqli_query($mysqli, 'SELECT idusergrup, usergrup, akses FROM usergrup');
        while ($rows = mysqli_fetch_assoc($query)) {
            $res[] = $rows;
        }
        echo json_encode($res);
    } elseif ($result['proses_usergrup'] === 'tambah_usergrup') {
        if ($result['akses'] != '') {
            $akses = str_replace(',', '-', $result['akses']);
            $query = mysqli_query($mysqli, "INSERT INTO usergrup (usergrup, akses) VALUES ('{$result['usergrup']}', '{$akses}')");
            if ($query) {
                $pesan = ['sukses' => 'Data berhasil ditambahkan'];
            } else {
                $pesan = ['error' => mysqli_error($mysqli)];
            }
        } else {
            $pesan = ['error' => 'Hak akses tidak boleh kosong'];
        }
        mysqli_close($mysqli);
        echo json_encode($pesan);
    } elseif ($result['proses_usergrup'] === 'update_usergrup') {
        $query = mysqli_query($mysqli, "SELECT * FROM usergrup WHERE idusergrup='{$result['idusergrup']}'");
        if ($query) {
            $pesan = mysqli_fetch_assoc($query);
        } else {
            $pesan = ['error' => mysqli_error($mysqli)];
        }
        echo json_encode($pesan);
    } elseif ($result['proses_usergrup'] === 'simpan_update_usergrup') {
        $akses = str_replace(',', '-', $result['akses']);
        $query = mysqli_query($mysqli, "UPDATE usergrup SET usergrup='{$result['usergrup']}', akses='{$akses}' WHERE idusergrup='{$result['simpan_idusergrup']}'");
        if ($query) {
            $pesan = ['sukses' => 'Data berhasil diupdate'];
        } else {
            $pesan = ['error' => mysqli_error($mysqli)];
        }
        mysqli_close($mysqli);
        echo json_encode($pesan);
    }
} elseif (isset($result['proses_gudang'])) {
    if ($result['proses_gudang'] === 'tambah_gudang') {
        $query = mysqli_query($mysqli, "INSERT INTO gudang (idgudang, nama_gudang, alamat) VALUES ('{$result['idgudang']}', '{$result['nama_gudang']}', '{$result['alamat']}')");
        if ($query) {
            $pesan = ['sukses' => 'Data berhasil ditambahkan'];
        } else {
            $pesan = ['error' => mysqli_error($mysqli)];
        }
        mysqli_close($mysqli);
        echo json_encode($pesan);
    } elseif ($result['proses_gudang'] === 'data_gudang') {
        $query = mysqli_query($mysqli, "SELECT * FROM gudang");
        if ($query) {
            if (mysqli_num_rows($query) > 0) {
                while ($rows = mysqli_fetch_assoc($query)) {
                    $pesan[] = $rows;
                }
            } else {
                $pesan = ['kosong' => 'Data tidak tersedia!'];
            }
        } else {
            $pesan = ['error' => mysqli_error($mysqli)];
        }
        mysqli_close($mysqli);
        echo json_encode($pesan);
    } elseif ($result['proses_gudang'] === 'update_gudang') {
        $query = mysqli_query($mysqli, "SELECT * FROM gudang WHERE idgudang='{$result['idgudang']}'");
        if ($query) {
            $pesan = mysqli_fetch_assoc($query);
        } else {
            $pesan = ['error' => mysqli_error($mysqli)];
        }
        echo json_encode($pesan);
    } elseif ($result['proses_gudang'] === 'simpan_update_gudang') {
        $query = mysqli_query($mysqli, "UPDATE gudang SET nama_gudang='{$result['update_nama_gudang']}', alamat='{$result['update_alamat_gudang']}' WHERE idgudang='{$result['idgudang']}'");
        if ($query) {
            $pesan = ['sukses' => 'Data berhasil di update'];
        } else {
            $pesan = ['error' => mysqli_error($mysqli)];
        }
        echo json_encode($pesan);
    } elseif ($result['proses_gudang'] === 'delete_gudang') {
        $query = mysqli_query($mysqli, "DELETE FROM gudang WHERE idgudang='{$result['id']}'");
        if ($query) {
            $pesan = ['sukses' => 'Data berhasil dihapus'];
        } else {
            $pesan = ['error' => 'Data gagal dihapus'];
        }
        echo json_encode($pesan);
    }
} elseif (isset($result['proses_produk']) && !empty($result['proses_produk'])) {
    if ($result['proses_produk'] === 'show_data_produk') {
        $query = mysqli_query($mysqli, "SELECT * FROM produk LIMIT 100");
        if (mysqli_num_rows($query) > 0) {
            while ($rows = mysqli_fetch_assoc($query)) {
                $data[] = $rows;
            }
        } else {
            $data = ['kosong' => 'Daftar produk kosong'];
        }
        echo json_encode($data);
    } elseif ($result['proses_produk'] === 'update_produk') {
        $query = mysqli_query($mysqli, "SELECT * FROM produk WHERE kode_produk='{$result['idproduk']}'");
        if ($query) {
            $pesan = mysqli_fetch_assoc($query);
        } else {
            $pesan = ['error' => 'Error : ' . mysqli_error($mysqli)];
        }
        echo json_encode($pesan);
    } elseif ($result['proses_produk'] === 'delete_produk') {
        $query_tampil = mysqli_query($mysqli, "SELECT gambar FROM produk WHERE kode_produk='{$result['id']}'");
        $gambar = mysqli_fetch_assoc($query_tampil);
        if (unlink('../assets/img/' . $gambar['gambar'])) {
            $query = mysqli_query($mysqli, "DELETE FROM produk WHERE kode_produk='{$result['id']}'");
            if ($query) {
                $pesan = ['sukses' => 'Data berhasil dihapus'];
            } else {
                $pesan = ['error' => 'Error : ' . mysqli_error($mysqli)];
            }
        }
        echo json_encode($pesan);
    }
}

if (isset($result['transaksi'])) {
    if ($result['transaksi'] === 'get_produk') {
        $query = mysqli_query($mysqli, "SELECT produk FROM produk LIMIT 5") or die(mysqli_error($mysqli));
        if (mysqli_num_rows($query) > 0) {
            while ($rows = mysqli_fetch_assoc($query)) {
                $pesan[] = $rows;
            }
        } else {
            $pesan = ['kosong' => 'Data tidak ditemukan'];
        }
        // var_dump($pesan);
        echo json_encode($pesan);
    }

    if ($result['transaksi'] === 'get_no_nota') {
        $query = mysqli_query($mysqli, "SELECT * FROM detail_transaksi") or die(mysqli_error($mysqli));
        $pesan = mysqli_num_rows($query);
        echo json_encode($pesan += 1);
    }
}
