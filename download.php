<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['login'])) {
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        $conn = mysqli_connect(
            'localhost',
            'root',
            '',
            'localhost_table'
        );
        $sql = 'SELECT * FROM files WHERE user_id="' . $_SESSION['id'] . '"AND image_key="' . $name . '"';
        $file = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $realName = $file['real_name'];
        $fileway = './uploads/' . $file['hash_name'][0] . '/' . $file['hash_name'][1] . '/' . $file['hash_name'];

        if (file_exists($fileway)) {
            header('Content-Description: File Transfer');
            header('Content-Type: octet-stream');
            header('Content-Disposition: attachment; filename="' . $realName . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileway));
            readfile($fileway);
        }
    }
}
header('Location: index.html');