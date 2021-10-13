<?php

session_start();

$mysqli = mysqli_connect('localhost', 'root', '', 'project');

if (!$mysqli) {
    die('Database error : ' . mysqli_connect_error());
}

function input_validation($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function imageValidation($fileIndex)
{
    $fileName = strtolower($_FILES["$fileIndex"]["name"]);
    $fileType = strtolower($_FILES["$fileIndex"]["type"]);
    $fileTemp = $_FILES["$fileIndex"]["tmp_name"];
    $fileError = $_FILES["$fileIndex"]["error"];
    $fileSize = $_FILES["$fileIndex"]["size"];
    // return $fileError;
    // validation image upload
    if ($fileError === 0) {
        $strToArray = explode('.', $fileName);
        $resultName = end($strToArray);
        if ($resultName === 'png' || $resultName === 'jpg' || $resultName === 'jpeg') {
            // validation image size
            if ($fileSize <= 1000000) {
                //cek move upload file
                $moveUploadFile = rand() . '.' . $resultName;
                if (move_uploaded_file($fileTemp, '../assets/img/' . $moveUploadFile)) {
                    // $result = move_uploaded_file($fileTemp, 'assets/img/' . $moveUploadFile);
                    $result = ['sukses' => $moveUploadFile];
                } else {
                    $result = ['gagal' => 'Upload file error'];
                }
            } else {
                $result = ['gagal' => 'Ukuran gambar terlalu besar, max 1 mb!'];
            }
        } else {
            $result = ['gagal' => 'Format gambar harus jpg, jpeg, png!'];
        }
    } else {
        $result = ['gagal' => 'Upload error, image not empty!'];
    }

    return $result;
}

function updateImage($fileIndex, $kode_produk)
{
    $fileName = strtolower($_FILES["$fileIndex"]["name"]);
    $fileType = strtolower($_FILES["$fileIndex"]["type"]);
    $fileTemp = $_FILES["$fileIndex"]["tmp_name"];
    $fileError = $_FILES["$fileIndex"]["error"];
    $fileSize = $_FILES["$fileIndex"]["size"];
    global $mysqli;
    // update image
    if (empty($fileName)) {
        $query = mysqli_query($mysqli, "SELECT gambar FROM produk WHERE kode_produk='$kode_produk'") or die(mysqli_error($mysqli));
        $result = mysqli_fetch_assoc($query);
        // $result = $row;
    } else {
        // return $fileError;
        // validation image upload
        $strToArray = explode('.', $fileName);
        $resultName = end($strToArray);
        if ($resultName === 'png' || $resultName === 'jpg' || $resultName === 'jpeg') {
            // validation image size
            if ($fileSize <= 1000000) {
                //cek move upload file
                $moveUploadFile = rand() . '.' . $resultName;
                if (move_uploaded_file($fileTemp, '../assets/img/' . $moveUploadFile)) {
                    // $result = move_uploaded_file($fileTemp, 'assets/img/' . $moveUploadFile);
                    $query = mysqli_query($mysqli, "SELECT gambar FROM produk WHERE kode_produk='$kode_produk'") or die(mysqli_error($mysqli));
                    $row = mysqli_fetch_assoc($query);
                    unlink('../assets/img/' . $row['gambar']);
                    $result = ['sukses' => $moveUploadFile];
                } else {
                    $result = ['gagal' => 'Upload file error'];
                }
            } else {
                $result = ['gagal' => 'Ukuran gambar terlalu besar, max 1 mb!'];
            }
        } else {
            $result = ['gagal' => 'Format gambar harus jpg, jpeg, png!'];
        }
    }

    return $result;
}

function akses_validation($mysqli)
{
    if (!isset($_SESSION['iduser']) && !isset($_SESSION['username-login']) && !isset($_SESSION['idusergrup'])) {
        header('location:login.php');
    }
    $query_user = mysqli_query($mysqli, "SELECT idusergrup FROM user WHERE iduser='{$_SESSION['iduser']}'");
    $rows = mysqli_fetch_assoc($query_user);
    $query = mysqli_query($mysqli, "SELECT akses FROM usergrup WHERE idusergrup='{$rows['idusergrup']}'");
    $result = mysqli_fetch_assoc($query);
    $array_akses = explode('-', $result['akses']);
    $halaman = explode('/', $_SERVER['PHP_SELF']);
    $halaman = end($halaman);
    foreach ($array_akses as $value) {
        $halaman_akses[] = $value . '.php';
    }
    $halaman_akses[] = 'index.php';
    if (!in_array($halaman, $halaman_akses)) {
        die("Can't access this page!!!");
    }
}
