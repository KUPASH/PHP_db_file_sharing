<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['login'])) {
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        if (file_exists($name)) {
            header('Content-Description: File Transfer');
            header('Content-Type: octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($name));
            readfile($name);
        }
    }
}
header('Location: index.html');