<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
</head>
<body>
<form style="display: inline-block" method="post" action="login.php">
    <input name="login" placeholder="Enter login"></br>
    <input name="pass" placeholder="Enter password"></br>
    <button type="submit">Login</button>
</form>
<form style="display: inline-block; padding-left: 150px" method="post" action="signup.php">
    <input name="login" placeholder="Enter login"></br>
    <input name="pass" placeholder="Enter password"></br>
    <button type="submit">Sign up</button>
</form>
</body>
</html>