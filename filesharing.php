<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
session_start();
?>
    <html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <?
        if(isset($_SESSION['id']) && isset($_SESSION['login'])) { ?>
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="userFile">
                <button type="submit">Submit</button>
            </form>
            <a href="logout.php">Logout</a> </br>

            <?
            function generateKey() {
                $imageKey = '';
                $keyLength = 8;
                for($i=0; $i<$keyLength; $i++) {
                    $imageKey .= chr(mt_rand(33,126));
                }
                return $imageKey;
            }
            $allowed_ext = ['jpg', 'jpeg'];

            echo '<pre>';
            print_r($_FILES);
            echo '</pre>';

            if (isset($_FILES['userFile']) && $_FILES['userFile']['error'] == 0) {
                $realName = $_FILES['userFile']['name'];
                $filename = md5(time() . rand(1, 9999) . $realName);

                $ext = explode('.', $_FILES['userFile']['name']);
                $ext = $ext[count($ext) - 1];

                if (!in_array($ext, $allowed_ext)) {
                    echo '<div style="color: red">ERROR: Invalid file extension; valid jpg, jpeg</div>';
                } else {

                    $subdirname1 = $filename[0];
                    $subdirname2 = $filename[1];

                    if (!file_exists('./uploads/' .
                        $subdirname1 . '/' .
                        $subdirname2)
                    ) {
                        mkdir('./uploads/' .
                            $subdirname1 . '/' .
                            $subdirname2, 0777, true);
                    }

                    move_uploaded_file($_FILES['userFile']['tmp_name'],
                        './uploads/' .
                        $subdirname1 . '/' .
                        $subdirname2 . '/' .
                        $filename . '.' . $ext);

                    if (file_exists('./uploads/' .
                        $subdirname1 . '/' .
                        $subdirname2 . '/' .
                        $filename . '.' . $ext)) {

                        $imageKey = generateKey();
                        $filename = $filename . '.' . $ext;
//                        $fileway = './uploads/' .
//                            $subdirname1 . '/' .
//                            $subdirname2 . '/' .
//                            $filename . '.' . $ext;
                        $conn = mysqli_connect(
                            'localhost',
                            'root',
                            '',
                            'localhost_table'
                        );
                        $sql = 'INSERT INTO files (real_name, hash_name, image_key, user_id) VALUES ("' . $realName . '", "' . $filename . '", "' . $imageKey . '",' . $_SESSION['id'] . ')';
                        mysqli_query($conn, $sql);

                    }

                }
            } else {
                echo 'Please Select file to Upload';
            }
            $sql = 'SELECT * FROM files WHERE user_id='.$_SESSION['id'];
            $conn = mysqli_connect(
                'localhost',
                'root',
                '',
                'localhost_table'
            );
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<br/><img src="./uploads/' . $row['hash_name'][0] . '/' . $row['hash_name'][1] . '/' . $row['hash_name'] . '" width="100"/> <br/>
                    <a href="delete.php?del='.$row['id'].'">Delete picture</a> 
                    <a href="download.php?name=' . $row['image_key'] . '">Link</a>
                    <input value="localhost/download.php?name=' . $row['image_key'] . '"> <br/>';
            }
        } else {
            echo 'Что-то пошло не так!';
        }
        ?>
    </body>
    </html>
