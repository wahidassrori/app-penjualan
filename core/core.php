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
