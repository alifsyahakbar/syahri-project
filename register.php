<?php

include 'functional.php';

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>
        alert('Registrasi Berhasil');
        document.location.href='login.php';
        </script>";
    } else {
        "<script>
        alert('Registrasi Gagal');
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>


    <br>
    <form action="" method="post">
        <ul>
            <li><label for="username">Username</label></li>
            <input type="hidden" name="role_id" id="role_id" value="2">
            <input type="text" name="username" id="username">
            <br>
            <li><label for="password">Password</label></li>
            <input type="password" name="password" id="password">
            <br>
            <li><label for="password2">Confirmasi Password</label></li>
            <input type="password" name="password2" id="password2">
            <br>
            <br>
            <button type="submit" name="register">Daftar Sekarang</button>

        </ul>

    </form>

</body>

</html>