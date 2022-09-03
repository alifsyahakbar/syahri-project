<?php
session_start();

require '../functional.php';

$id = $_GET['slug'];

$post = query("SELECT * FROM posts WHERE slug = '$id'")[0];

$tags = query("SELECT * FROM tags");

$categs = query("SELECT * FROM categorys");

if (isset($_POST["submit"])) {
    if (edit_post($_POST) >= 0) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil</strong> Data berhasil diedit.
            </div>';
        echo '<meta http-equiv="refresh" content="1;url=../posts/index.php">';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal</strong> Data gagal diedit.
        </div>';
        echo '<meta http-equiv="refresh" content="1;url=../posts/index.php">';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <!-- summernote -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
</head>

<body>
    <style>
        body {
            padding: 10px;
        }

        .container {
            padding: 10px;
        }

        label {
            display: flex;
            flex-direction: row;
        }

        input {
            margin-bottom: 10px;
        }
    </style>
    <div class="container">
        <h2>Edit Post -
            <small><?php echo $post['judul']; ?></small>
        </h2>
        <br>
        <a class="btn btn-dark mb-4" href="../posts/index.php">Kembali</a>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="create_by" id="create_by" value="<?= $_SESSION['login']; ?>">
            <input type="hidden" name="id" id="id" value="<?= $post['id']; ?>">
            <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $post['gambar']; ?>">
            <label for="judul">Judul </label>
            <input class="form-control" type="text" name="judul" id="judul" value="<?= $post['judul']; ?>" required autofocus>
            <div class="mb-4">
                <label class="title" for="tag_id">Tags</label>
                <small class="text-muted" style="font-style: italic;"><small class="text-danger">*</small> Untuk saat ini tags hanya 1 tag saja.</small>
                <select class=" form-control" name="tag_id" id="tag_id">
                    <?php foreach ($tags as $tag) : ?>
                        <option value="<?= $tag['id']; ?>" <?= $post['tag_id'] == $tag['id'] ? 'selected' : '' ?>><?= $tag['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="title" for="category_id">Categorys</label>
                <select class="form-control" name="category_id" id="category_id">
                    <?php foreach ($categs as $categ) : ?>
                        <option value="<?= $categ['id']; ?>" <?= $post['category_id'] == $categ['id'] ? 'selected' : '' ?>><?= $categ['name_categ']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label for="summernote">Text</label>
            <textarea class="form-control" name="text" id="summernote"><?= $post["text"]; ?></textarea>
            <br>
            <br>
            <label class="title" for="gambar">Gambar Lama </label>
            <img src="img/<?= $post['gambar']; ?>" alt="" style="width: 50%; height: auto">
            <br>
            <label class="title mt-4" for="gambar">Gambar Baru </label>
            <input class="form-control mt-2" type="file" name="gambar" id="gambar">
            <br>
            <div class="mv-3">
                <label class="title" for="status">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="draft" <?= $post['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="publish" <?= $post['status'] == 'publish' ? 'selected' : '' ?>>Publish</option>
                </select>
            </div>
            <br>
            <br>
            <button class="btn btn-dark" type="submit" name="submit">Kirim</button>
        </form>
    </div>

    <script>
        $(' #summernote').summernote({
            tabsize: 2,
            height: 350,
        })
    </script>

</body>

</html>