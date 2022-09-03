<?php
session_start();

require '../functional.php';

$result = mysqli_query($conn, "SELECT * FROM tags");
$categ = mysqli_query($conn, "SELECT * FROM categorys");

if (isset($_POST["submit"])) {
    if (add_post($_POST) > 0) {
        echo "<script>
        alert('Post Berhasil ditambahkan');
        document.location.href= '../posts/index.php';
        </script>";
    } else {
        echo "<script>
        alert('Post Gagal ditambahkan');
        </script>";
    }

    $error = true;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new post | SyahriProject</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
        <h2>Create New Post</h2>
        <hr>
        <div style="margin: 10px;">
            <a href="../posts/index.php" class="btn btn-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                </svg> Kembali</a>
        </div>
        <br>
        <p class="text-muted" style="font-style: italic;"><small class="text-danger">* </small>Jika tag dan category tidak ada mohon input terlebih dahulu.</p>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" autocomplete="off" required autofocus>
                <input type="hidden" name="create_by" id="create_by" value="<?= $_SESSION["login"]; ?>">
            </div>
            <div class="mb-4">
                <label for="summernote">Text / Artikel</label>
                <textarea class="form-control" name="text" id="summernote"></textarea>
            </div>
            <div class="mb-4">
                <label for="gambar">Gambar</label>
                <input type="file" class="form-control" name="gambar" id="gambar">
            </div>
            <div class="mb-4">
                <label class="title" for="tag_id">Tags</label>
                <small class="text-muted" style="font-style: italic;"><small class="text-danger">*</small> Untuk saat ini tags hanya 1 tag saja.</small>
                <select class=" form-control" name="tag_id" id="tag_id">
                    <?php foreach ($result as $tag) : ?>
                        <option value="<?= $tag['id']; ?>"><?= $tag['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="title" for="category_id">Categorys</label>
                <select class="form-control" name="category_id" id="category_id">
                    <?php foreach ($categ as $cat) : ?>
                        <option value="<?= $cat['id']; ?>"><?= $cat['name_categ']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mv-3">
                <label class="title" for="status">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="publish">Publish</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <br>
            <br>
            <button class="btn btn-dark" style="padding: 10px;" type="submit" name="submit">Kirim</button>
        </form>
        <div style="height: 300px;">
        </div>
    </div>

    <script>
        $('#summernote').summernote({
            placeholder: 'Your Artikel',
            tabsize: 2,
            height: 400
        });
    </script>


</body>

</html>