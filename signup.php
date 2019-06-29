<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);

require_once 'config.php';
if ( !empty($_POST['login']) && !empty($_POST['pass']) ) {
    $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'localhost_table'
    );
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $sql = 'SELECT * FROM users WHERE login="'.$login.'"';
    $user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    if (empty($user)) {
        $saltedPassword = md5($password.$salt);
        $sql = 'INSERT INTO `users` (`login`, `password`) VALUES ("'.$login.'","'.$saltedPassword.'")';
        mysqli_query($conn, $sql);
    } else {
        exit ('This login is already taken!');
    }
} else {
    exit ('Fields cannot be empty');
}
if (!empty($_POST['login']) && !empty($_POST['pass']) ) {
    $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'localhost_table'
    );
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $sql = 'SELECT * FROM users WHERE login="'.$login.'"';
    $user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    mysqli_close($conn);
    if (!empty($user)) {
        $salt = 'idk6lviqLPnB4gR';
        $saltedPassword = md5($password . $salt);
        if ($user['password'] == $saltedPassword) {
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            header('location: filesharing.php');
        }
    }
}