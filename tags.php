<?php
session_start();

require 'functional.php';
$id = $_GET['tags'];
$name = $_GET['name'];

// pagination
$jumlahDataPerhalaman = 2;
$jumlahData = count(query("SELECT * FROM posts where tag_id = '$id'"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$halaman = mysqli_query($conn, "SELECT *, posts.created_at FROM posts inner join tags on posts.tag_id = tags.id where tag_id = '$id' limit $awalData, $jumlahDataPerhalaman");
$halaman2 = mysqli_query($conn, "SELECT * FROM posts limit 4");
$categorys = mysqli_query($conn, "SELECT * FROM categorys");
$tags = mysqli_query($conn, "SELECT * FROM tags");

$array = mysqli_fetch_assoc($halaman);
// end pagination

// search
if (isset($_POST["cari"])) {
    $halaman = cari($_POST["keyword"]);
}



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ($array) ? $array['name'] . ' -' : ''; ?> SyahriProject.id</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>

    <!-- navbar -->

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/syahri-project/index.php">
                <h3 style="margin: 20px; font-family: 'Crimson Text', serif;">Syahri Project <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-incognito" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="m4.736 1.968-.892 3.269-.014.058C2.113 5.568 1 6.006 1 6.5 1 7.328 4.134 8 8 8s7-.672 7-1.5c0-.494-1.113-.932-2.83-1.205a1.032 1.032 0 0 0-.014-.058l-.892-3.27c-.146-.533-.698-.849-1.239-.734C9.411 1.363 8.62 1.5 8 1.5c-.62 0-1.411-.136-2.025-.267-.541-.115-1.093.2-1.239.735Zm.015 3.867a.25.25 0 0 1 .274-.224c.9.092 1.91.143 2.975.143a29.58 29.58 0 0 0 2.975-.143.25.25 0 0 1 .05.498c-.918.093-1.944.145-3.025.145s-2.107-.052-3.025-.145a.25.25 0 0 1-.224-.274ZM3.5 10h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Zm-1.5.5c0-.175.03-.344.085-.5H2a.5.5 0 0 1 0-1h3.5a1.5 1.5 0 0 1 1.488 1.312 3.5 3.5 0 0 1 2.024 0A1.5 1.5 0 0 1 10.5 9H14a.5.5 0 0 1 0 1h-.085c.055.156.085.325.085.5v1a2.5 2.5 0 0 1-5 0v-.14l-.21-.07a2.5 2.5 0 0 0-1.58 0l-.21.07v.14a2.5 2.5 0 0 1-5 0v-1Zm8.5-.5h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Z" />
                    </svg></h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a href="events.php" class="navbar-brand">Events</a>
                    <a href="about.php" class="navbar-brand">About Me</a>
                </ul>
                <div class="d-flex">
                    <?php if (!isset($_SESSION["login"])) : ?>
                        <a href="login.php" class="navbar-brand">Login</a>
                        <a href="login.php#signup" class="navbar-brand">Join</a>
                    <?php elseif (($_SESSION["role_id"] != 2)) : ?>
                        <a href="dashboard.php" class="navbar-brand">Dashboard</a>
                        <a href="logout.php" class="navbar-brand" onclick="return confirm('Yakin ingin logout?')">Logout</a>
                    <?php else : ?>
                        <a href="logout.php" class="navbar-brand" onclick="return confirm('Yakin ingin logout?')">Logout</a>
                    <?php endif; ?>
                    <form class="d-flex" role="search" action="" method="POST">
                        <input class="form-control me-2" name="keyword" type="text" placeholder="Search" aria-label="Search" autocomplete="off">
                        <button class="btn btn-dark" type="submit" name="cari">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- end navbar -->

    <div class="container-fluid sidebar-fixed">
        <div class="row ">
            <div class="col-md-3" id="gambar-me">
                <img src="img/me2.png" alt="" width="auto" height="100px" style="border-radius: 50%;" class="border p-1">
                <h3 style="margin-top: 15px;">Alif Syah Akbar</h3>
                <div class="sosmed">
                    <div>
                        <div class="fs-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                            </svg>
                            <small style="font-size: 18px;"> Bogor, Indonesia</small>
                        </div>
                    </div>
                    <div>
                        <div class=" fs-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                            </svg>
                            <a href="mailto: alifsyah789@gmail.com">Email</a>
                        </div>
                    </div>
                    <div>
                        <div class="fs-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                            </svg>
                            <a href="https://www.instagram.com/syaahri_/" target="_blank">Instagram</a>
                        </div>
                    </div>
                    <div>
                        <div class=" fs-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                            </svg>
                            <a href="https://www.facebook.com/alifsyah.akbar.90/" target="_blank">Facebook</a>
                        </div>
                    </div>
                    <div>
                        <div class="fs-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                            </svg>
                            <a href="https://github.com/alifsyahakbar" target="_blank">Github</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <main>
                    <div class="container">
                        <h1 class="mt-2">Tags : <?php echo $_GET['name']; ?></h1>
                        <?php if (!$array) : ?>
                            <div style="display: block; text-align: center; margin: 50px 0px; padding: 10px;">
                                <img src="/syahri-project/img/notfound.png" alt="" height="auto" width="50%" style="align-items: center;">
                            </div>
                        <?php endif; ?>
                        <hr>
                        <?php if (isset($_POST["cari"])) : ?>
                            <h5>Search Result For : <?= $_POST["keyword"]; ?></h5>
                            <hr class="col-6">
                        <?php endif; ?>
                        <?php if ($halaman) : ?>
                            <?php foreach ($halaman as $post) : ?>
                                <?php if ($post["status"] == 'publish') : ?>
                                    <div style="padding: 10px;">
                                        <h2 style="margin-bottom: 20px;"><?= $post['judul']; ?></h2>
                                        <img src="/syahri-project/posts/img/<?= $post["gambar"]; ?>" alt="" height="auto" width="100%">
                                        <p style="font-style:italic; margin:10px 0px;">Publish By : <?= ucfirst($post['create_by']); ?> - <?= (date("d F Y, H:i A", strtotime($post['created_at']))); ?></p>
                                        <p><?= substr($post['text'], 0, 200) . "..."; ?></p>
                                        <a href="/syahri-project/view-post.php?slug=<?= $post["slug"]; ?>" class="btn btn-dark">Read More</a>
                                    </div>
                                    <br>
                                    <br>
                                    <hr style="margin:30px">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div style="display: block; text-align: center; margin: 20px; padding: 10px;">
                                <img src="/syahri-project/img/notfound.png" alt="" height="auto" width="70%" style="align-items: center;">
                            </div>
                        <?php endif; ?>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php if (isset($_POST["cari"]) < $halaman) : ?>
                                <?php if ($halamanAktif > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?tags=<?php echo $_GET['tags']; ?>&&name=<?php echo $_GET['name']; ?>&&halaman=<?= $halamanAktif - 1; ?>">Previous</a>
                                    </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                                    <?php if ($i == $halamanAktif) : ?>
                                        <li class="page-item"><a style="color: red; font-wight: bold;" class="page-link" href="?tags=<?php echo $_GET['tags']; ?>&&name=<?php echo $_GET['name']; ?>&&halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a class="page-link" href="?tags=<?php echo $_GET['tags']; ?>&&name=<?php echo $_GET['name']; ?>&&halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <?php if ($halamanAktif < $jumlahHalaman) : ?>
                                    <li class="page-item ">
                                        <a class="page-link" href="?tags=<?php echo $_GET['tags']; ?>&&name=<?php echo $_GET['name']; ?>&&halaman=<?= $halamanAktif + 1; ?>">Next</a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </nav>

                </main>
            </div>
            <div class="col-md-3">
                <div class="m-4" id="kategori">
                    <h3>Kategori</h3>
                    <ul class="list-group">
                        <li class="list-group" style="margin-left: 8px ;">
                            <?php foreach ($categorys as $category) : ?>
                                <a href="/syahri-project/categorys.php?categ=<?= $category['id']; ?>&&name=<?= $category['name_categ'] ?>"><?= $category['name_categ'] ?></a>
                            <?php endforeach; ?>
                        </li>
                    </ul>
                </div>
                <div class="m-4" id="tags">
                    <h3>Tags</h3>
                    <ul class="list-group">
                        <li class="list-group" style="margin-left: 8px ;">
                            <?php foreach ($tags as $tag) : ?>
                                <a href="/syahri-project/tags.php?tags=<?= $tag['id']; ?>&&name=<?= $tag['name'] ?>"><?= $tag['name'] ?></a>
                            <?php endforeach; ?>
                        </li>
                    </ul>
                </div>
                <div class="m-4" id="recent-post">
                    <h3>Recent Posts</h3>
                    <ul class="list-group">
                        <li class="list-group" style="margin-left: 8px ;">
                        <li class="list-group" style="margin-left: 8px ;">
                            <?php foreach ($halaman2 as $as) : ?>
                                <a href="/syahri-project/view-post.php?slug=<?= $as["slug"]; ?>" class="mb-2"><?= $as['judul'] ?></a>
                            <?php endforeach; ?>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- error -->
        <?php if (isset($error)) : ?>
            <div style="display: block; text-align: center; margin: 20px; padding: 10px;">
                <img src="/syahri-project/img/notfound.png" alt="" height="auto" width="50%" style="align-items: center;">
            </div>
        <?php endif; ?>
        <!-- end error -->
    </div>
    <footer>
        <div class="footer">
            <div class="follow-me">
                <div class="fs-4 mb-3" style="font-weight: bold;">
                    FOLLOW ME :
                </div>
                <div class="fs-4 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                    </svg>
                    <a href="https://github.com/alifsyahakbar">Github</a>
                </div>
                <div class=" fs-4 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                    </svg>
                    <a href="https://www.instagram.com/syaahri_/">Instagram</a>
                </div>
                <div class=" fs-4 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                    </svg>
                    <a href="https://www.facebook.com/alifsyah.akbar.90/">Facebook</a>
                </div>
            </div>
            <div class="footer-bawah">
                <p style="color: white;">&#169; 2022 AlifSyahAkbar. Powered By Syahri Project.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>