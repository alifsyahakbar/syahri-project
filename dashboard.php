<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: index.php");
} elseif ($_SESSION["role_id"] == 2) {
    header("location: index.php");
    exit;
}

require  'functional.php';

$roles = mysqli_query($conn, "SELECT * FROM roles");

$users = mysqli_query($conn, "SELECT user.id, user.username, user.role_id, roles.name, user.status FROM user INNER JOIN roles ON user.role_id = roles.id");

$user = mysqli_fetch_assoc($users);

if (isset($_POST["submit"])) {
    if (AddUser($_POST) > 0) {
        echo "<script>
        alert('User berhasil ditambahkan');
        document.location.href='dashboard.php';
        </script>";
    } else {
        echo "<script>
        alert('User Gagal ditambahkan');
        document.location.href='dashboard.php';
        </script>";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | SyahriProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oregano&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">SyahriProject <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-incognito" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="m4.736 1.968-.892 3.269-.014.058C2.113 5.568 1 6.006 1 6.5 1 7.328 4.134 8 8 8s7-.672 7-1.5c0-.494-1.113-.932-2.83-1.205a1.032 1.032 0 0 0-.014-.058l-.892-3.27c-.146-.533-.698-.849-1.239-.734C9.411 1.363 8.62 1.5 8 1.5c-.62 0-1.411-.136-2.025-.267-.541-.115-1.093.2-1.239.735Zm.015 3.867a.25.25 0 0 1 .274-.224c.9.092 1.91.143 2.975.143a29.58 29.58 0 0 0 2.975-.143.25.25 0 0 1 .05.498c-.918.093-1.944.145-3.025.145s-2.107-.052-3.025-.145a.25.25 0 0 1-.224-.274ZM3.5 10h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Zm-1.5.5c0-.175.03-.344.085-.5H2a.5.5 0 0 1 0-1h3.5a1.5 1.5 0 0 1 1.488 1.312 3.5 3.5 0 0 1 2.024 0A1.5 1.5 0 0 1 10.5 9H14a.5.5 0 0 1 0 1h-.085c.055.156.085.325.085.5v1a2.5 2.5 0 0 1-5 0v-.14l-.21-.07a2.5 2.5 0 0 0-1.58 0l-.21.07v.14a2.5 2.5 0 0 1-5 0v-1Zm8.5-.5h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Z" />
                </svg></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/syahri-project/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/syahri-project/posts/index.php">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/syahri-project/users/index.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/syahri-project/categorys/index.php">Categorys</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/syahri-project/tags/index.php">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/syahri-project/events/index.php">Events</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="logout.php" onclick="return confirm('Anda yakin ingin Logout??')" style="color:red; text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                            <path d="M7.5 1v7h1V1h-1z" />
                            <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
                        </svg> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">

        <head>
            <h1 class="mt-2">Selamat Datang
                <small class="text-muted">
                    <?php echo ucfirst($_SESSION["login"]); ?>
                </small>
            </h1>
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="20000">
                        <img src="/syahri-project/img/admin3.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="10000">
                        <img src="/syahri-project/img/soryy2.png" class="d-block w-100" alt="...">
                    </div>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div>
                <a href="https://api.whatsapp.com/send?phone=6285792314401&text=Hallo%20Selamat%20Datang" target="_blank"><img style="position: fixed; right:15px; top: 85%; width:50px; height:50px;" src="/syahri-project/img/wa.png" alt=""></a>
            </div>
        </head>

    </div>


    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>