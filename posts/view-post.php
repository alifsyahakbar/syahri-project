<?php
include '../functional.php';

$id = $_GET['slug'];

$post = mysqli_query($conn, "SELECT *, posts.created_at, tags.name, categorys.name_categ FROM (( posts INNER JOIN Tags ON posts.tag_id = tags.id) INNER JOIN Categorys ON posts.category_id = categorys.id) WHERE slug = '$id'");

$mama = mysqli_fetch_array($post);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Post</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>

<body>
    <div class="container">
        <div class="my-4">
            <h3>Detail Post <span style="color: gray;">- </span><?php echo $mama['judul']; ?> </h3>
        </div>
        <a href="/syahri-project/posts/index.php" class="btn btn-dark mb-4">Kembali</a>
        <div class="row ">
            <div class="col-md-6">
                <div class="card">
                    <img src="/syahri-project/posts/img/<?php echo $mama['gambar']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap">
                            <p>Tag : <?php echo $mama['name_categ']; ?>, Category : <?php echo $mama['name']; ?></p>
                            <p><?php echo $mama['create_by']; ?> - <?php echo (date("d F Y H:i A", strtotime($mama['created_at']))); ?></p>
                        </div>
                        <h5 class="card-title"><?= $mama['judul']; ?></h5>
                        <p class="card-text"><?php echo $mama['text']; ?>.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>