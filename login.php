<?php
session_start();
require  'functional.php';

// cekk cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    // bikin variabel
    $id  = $_COOKIE['id'];
    $key  = $_COOKIE['key'];

    // ambil username sesuai id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");

    // ambil setiap baris dari table
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) { //jika key nya sama dengan hash maka jalankan session dibawah
        $_SESSION['login'] = true;
    }
}

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>
        alert('Registrasi Berhasil, Terimakasih udah Menjadi Anggota SyahriProject😊.');
        document.location.href='login.php';
        </script>";
    } else {
        "<script>
        alert('Registrasi Gagal');
        </script>";
    }
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // cek username
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $user = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        $use = mysqli_fetch_assoc($user);
        //jika function verify dijalankan lalu cocokan password diinputan dengan password database
        if (password_verify($password, $row["password"])) {

            // set session
            // jdi sessiion itu ambil dari function mysli_fetch_assoc lalu dia juga ambil dari function query 
            // didalam query dicari yaitu "tampilkan data table user dimana? yaitu di varibel $_post / 
            // diambil dari imputan.
            $_SESSION["login"] = $username;
            $_SESSION["role_id"] = $use["role_id"];

            // cek dulu apakah remember me nya diklik 
            if (isset($_POST['remember'])) {
                // lalu jalankan set cookie   
                setcookie('id', $row['id'], time() + 60 * 60 * 24 * 15);
                setcookie('key', hash('sha256', $row['username']), time() + 60 * 60 * 24 * 15);
            }

            header("Location: dashboard.php");
            exit;
        }
    }

    // jika terjadi error maka jalankan varibel error..
    $error = true;
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | SyahriProject </title>

    <!-- Bootstrap -->
    <link href="/syahri-project/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/syahri-project/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/syahri-project/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="/syahri-project/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/syahri-project/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <div>
                        <a href="/syahri-project/index.php">
                            <h2 style="padding-bottom: 10px;"> SyahriProject <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-incognito" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="m4.736 1.968-.892 3.269-.014.058C2.113 5.568 1 6.006 1 6.5 1 7.328 4.134 8 8 8s7-.672 7-1.5c0-.494-1.113-.932-2.83-1.205a1.032 1.032 0 0 0-.014-.058l-.892-3.27c-.146-.533-.698-.849-1.239-.734C9.411 1.363 8.62 1.5 8 1.5c-.62 0-1.411-.136-2.025-.267-.541-.115-1.093.2-1.239.735Zm.015 3.867a.25.25 0 0 1 .274-.224c.9.092 1.91.143 2.975.143a29.58 29.58 0 0 0 2.975-.143.25.25 0 0 1 .05.498c-.918.093-1.944.145-3.025.145s-2.107-.052-3.025-.145a.25.25 0 0 1-.224-.274ZM3.5 10h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Zm-1.5.5c0-.175.03-.344.085-.5H2a.5.5 0 0 1 0-1h3.5a1.5 1.5 0 0 1 1.488 1.312 3.5 3.5 0 0 1 2.024 0A1.5 1.5 0 0 1 10.5 9H14a.5.5 0 0 1 0 1h-.085c.055.156.085.325.085.5v1a2.5 2.5 0 0 1-5 0v-.14l-.21-.07a2.5 2.5 0 0 0-1.58 0l-.21.07v.14a2.5 2.5 0 0 1-5 0v-1Zm8.5-.5h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Z" />
                                </svg> </h2>
                        </a>
                        <?php if (isset($error)) : ?>
                            <img src="/syahri-project/img/error.png" alt="" height="auto" width="50%">
                            <p style="color: red;font-style:italic;">Username / Password Anda salah.</p>
                        <?php endif; ?>
                    </div>
                    <form action="" method="post">
                        <h1>Login</h1>
                        <div>
                            <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" required="" autofocus />
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required="" />
                        </div>
                        <div style="text-align: left;">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <div>
                            <button class="btn btn-dark submit" name="login" type="submit">Log in</button>
                        </div>
                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">New Akun?
                                <a href="#signup" class="to_register"><strong>Create Account </strong> </a>
                            </p>
                            <div class="clearfix"></div>
                            <br />
                            <div>

                                <p>©2022 Alif Syah Akbar. SyahriProject! . Privacy and Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <div>
                        <h2 style="padding-bottom: 10px;">JOIN TEAM SyahriProject <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-incognito" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="m4.736 1.968-.892 3.269-.014.058C2.113 5.568 1 6.006 1 6.5 1 7.328 4.134 8 8 8s7-.672 7-1.5c0-.494-1.113-.932-2.83-1.205a1.032 1.032 0 0 0-.014-.058l-.892-3.27c-.146-.533-.698-.849-1.239-.734C9.411 1.363 8.62 1.5 8 1.5c-.62 0-1.411-.136-2.025-.267-.541-.115-1.093.2-1.239.735Zm.015 3.867a.25.25 0 0 1 .274-.224c.9.092 1.91.143 2.975.143a29.58 29.58 0 0 0 2.975-.143.25.25 0 0 1 .05.498c-.918.093-1.944.145-3.025.145s-2.107-.052-3.025-.145a.25.25 0 0 1-.224-.274ZM3.5 10h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Zm-1.5.5c0-.175.03-.344.085-.5H2a.5.5 0 0 1 0-1h3.5a1.5 1.5 0 0 1 1.488 1.312 3.5 3.5 0 0 1 2.024 0A1.5 1.5 0 0 1 10.5 9H14a.5.5 0 0 1 0 1h-.085c.055.156.085.325.085.5v1a2.5 2.5 0 0 1-5 0v-.14l-.21-.07a2.5 2.5 0 0 0-1.58 0l-.21.07v.14a2.5 2.5 0 0 1-5 0v-1Zm8.5-.5h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Z" />
                            </svg> </h2>

                    </div>
                    <form action="" method="post">
                        <h1>Create Account</h1>
                        <div>
                            <input type="hidden" name="role_id" value="1" />
                            <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username" required="" autofocus />
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password" required="" />
                        </div>
                        <div>
                            <input type="password" name="password2" class="form-control" autocomplete="off" placeholder="Confirm Password" required="" />
                        </div>
                        <div style="margin:10px">
                            <button class="btn btn-dark submit" name="register" type="submit">Submit</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already a Member ?
                                <a href="#signin" class="to_register"> Log in </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>

                                <p>©2022 Alif Syah Akbar. SyahriProject! . Privacy and Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>

</html>