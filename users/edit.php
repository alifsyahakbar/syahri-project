<?php
require '../functional.php';

$id = $_GET['id'];

$user = query("SELECT * FROM user WHERE id = $id")[0]; //query itu adalah function


if (isset($_POST["submit"])) {
    if (edituser($_POST) >= 0) {
        echo "<script>
        alert('Data User Berhasil di Edit.');
        document.location.href='../users/index.php';
        </script>";
    } else {
        echo "<script>
        alert('Data User Gagal di Edit.');
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
    <title>Edit user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2 class="my-3">Edit user - <small><?php echo ucfirst($user['username']); ?></small></h2>
        <a href="/syahri-project/users/index.php" class="btn btn-dark btn-sm">Kembali</a>
        <form action="" method="post" class="mt-4">
            <input type="hidden" name="id" value="<?= $user['id']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input class="form-control" type="text" name="username" id="username" value="<?= $user['username']; ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password </label>
                <span style="color: red;"> *</span><small style="font-style: italic;">Kosongkan bila tidak ada perubahan Password</small>
                <input class="form-control" type="hidden" name="passwordLama" id="passwordLama" value="<?php echo $user['password']; ?>">
                <input class="form-control" type="password" name="password" id="password">
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select name="role_id" id="role_id" class="form-select">
                    <?php foreach ($roles as $u) : ?>
                        <option value="<?= $u['id']; ?>" <?= ($user['role_id'] == $u['id'] ? 'selected' : ''); ?>><?php echo $u["name"]; ?></option>
                        <!-- ambil id pada table roles lalu diluar value jika $user"id" cocok dengan table roles maka tambilkan data true, jika false atau salah maka jalankan selected dengan tanda "-" -->
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="aktif" <?= ($user['status'] == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="tidak aktif" <?= ($user['status'] == 'tidak aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
                </select>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-dark">Simpan</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>