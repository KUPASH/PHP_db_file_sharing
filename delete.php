<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['login'])) {
    if (isset($_GET['del'])) {
        $num_string = $_GET['del'];
        $conn = mysqli_connect(
            'localhost',
            'root',
            '',
            'localhost_table'
        );
        $sql = 'SELECT * FROM files WHERE user_id="' . $_SESSION['id'] . '"AND id=' . $num_string;
        $file = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $fileway = $file['way'];

        $conn = mysqli_connect(
            'localhost',
            'root',
            '',
            'localhost_table'
        );
        $sql = 'DELETE FROM files WHERE user_id="' . $_SESSION['id'] . '"AND id=' . $num_string;
        mysqli_query($conn, $sql);

        $conn = mysqli_connect(
            'localhost',
            'root',
            '',
            'localhost_table'
        );
        $sql = 'SELECT * FROM files WHERE user_id="' . $_SESSION['id'] . '"AND id=' . $num_string;
        $file = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        if (empty($file)) {
            unlink($fileway);
        }

    }
}
header('Location: filesharing.php');