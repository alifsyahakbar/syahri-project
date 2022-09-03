<?php

$conn = mysqli_connect("localhost", "root", "", "belajarphp");

$user = mysqli_query($conn, "SELECT * FROM user WHERE username = 'username'");

$roles = mysqli_query($conn, "SELECT * FROM roles");

function register($data)
{
    global $conn;

    $role_id = $data["role_id"];
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    //cek konfirmasi usernamse apakah sudah ada didatabase
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username sudah ada.');
        </script>";
        return false;
    }

    // cek apakah konfirmasi password sesuai
    if ($password !== $password2) {
        echo "<script>
        alert('Konfirmasi Password Tidak sesuai.');
        </script>";
        return false;
    }

    //enksripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $result = "INSERT INTO user (username, password, role_id) VALUES ('$username', '$password', '$role_id')";
    // Koneksikan ke database
    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function addTags($tag)
{
    global $conn;
    $name = $tag['name'];

    $result = mysqli_query($conn, "SELECT * FROM tags WHERE name = '$name'");
    if (mysqli_fetch_array($result)) {
        echo "<script>
        alert('Nama Tags sudah udah.')
        </script>";
    }

    $query = "INSERT INTO tags(name) values ('$name')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function addCategory($categ)
{
    global $conn;
    $name = $categ['name'];

    $result = mysqli_query($conn, "SELECT * FROM categorys WHERE name = '$name'");
    if (mysqli_fetch_array($result)) {
        echo "<script>
        alert('Nama Category sudah udah.')
        </script>";
    }

    $query = "INSERT INTO categorys(name) values ('$name')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function AddUser($user)
{
    global $conn;
    $username = strtolower(stripslashes($user["username"]));
    $password = mysqli_real_escape_string($conn, $user["password"]);
    $password2 = mysqli_real_escape_string($conn, $user["password2"]);
    $role = $user["role_id"];
    $status = $user["status"];

    // cek apakah username susah ada
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username sudah Ada, Mohon cari yang lain.');
        </script>";
        return false;
    }
    //cek konfirmasi password apa kah sesuai
    if ($password !== $password2) {
        echo "<script>
        alert('Konfirmasi password tidak sesuai.');
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (username, password, role_id, status) VALUES ('$username', '$password','$role', '$status')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function edituser($user)
{

    global $conn;

    $id = $user['id'];
    $username = $user['username'];
    $password = $user['password'];
    $passwordLama = $user['passwordLama'];
    $role_id = $user['role_id'];
    $status = $user['status'];

    if ($password == '') {
        $password = $passwordLama;
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
    // endskripsi password



    $query = "UPDATE user SET 
                username = '$username',
                password = '$password',
                role_id = '$role_id',
                status = '$status'
                WHERE id = $id
                ";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapususer($user)
{
    global $conn;

    $result = "DELETE FROM user WHERE id = $user ";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function query($query)
{
    global $conn; //ambil koneksi diluar functions  

    $user = mysqli_query($conn, $query); //hubungkan koneksi dengan nilai dari query dan masukan ke dalam variabel

    $rows = []; //array kosong
    while ($row = mysqli_fetch_assoc($user)) { //jdi ketika membuka bungkus aray kecil buka aray besat terlebih dahulu yaitu dengan
        $rows[] = $row; //dengan masukan ke variabelrows kosong
    }
    return ($rows); //lalu kembalikan eksekusi akhir dengan varibel akhir yaitu $rows
}







// function post


function upload_post()
{
    // panggil dulu $_files sesuai filed input tambah
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpFile = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];

    // cek apakah file ada error
    if ($error === 4) { //kenapa dikasih nilai no 4 karena itu adalah code default dari $_files.
        echo "<script>
        alert('Pilih gambar terlebih dahulu')
        document.location.href= '../posts/index.php';

        </script>";
    }

    $nameFileValid = ['jpeg', 'jpg', 'png']; //format gambar
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $nameFileValid)) {
        echo "<script>
        alert('File yang anda pilih bukan gambar.')
        alert('Format harus JPG, JPEG, PNG.')
        </script>";
        exit;
    }

    if ($ukuranFile > 10000000) {
        echo "<script>
        alert('File Max 10mb.')
        </script>";
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpFile, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function slug($title, $separator = '-')
{

    // Convert all dashes/underscores into separator
    $flip = $separator === '-' ? '_' : '-';

    $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

    // Replace @ with the word 'at'
    $title = str_replace('@', $separator . 'at' . $separator, $title);

    // Remove all characters that are not the separator, letters, numbers, or whitespace.

    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

    return trim($title, $separator);
}


function waktu()
{
    $unixTime = time();
    $timeZone = new \DateTimeZone('Asia/Jakarta');


    $time = new \DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    $formattedTime = $time->format('Y-m-d H:i:s');
    return $formattedTime;
}


function add_post($post)
{
    global $conn;

    $judul = $post["judul"];
    $slug = slug($judul, "-");
    $text = $post["text"];
    $user = $post["create_by"];
    $status = $post["status"];
    $tag_id = $post["tag_id"];
    $category_id = $post["category_id"];
    $created_at = waktu();
    $gambar = upload_post();

    $result = "INSERT INTO posts (judul, slug, text, gambar, status, tag_id, category_id, create_by, created_at) VALUES ('$judul', '$slug', '$text', '$gambar', '$status', '$tag_id', '$category_id', '$user', '$created_at')";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function edit_post($data)
{
    global $conn;

    $id = $data["id"];
    $judul = $data["judul"];
    $text = $data["text"];
    $created_by = $data["create_by"];
    $tags_id = $data["tag_id"];
    $categ_id = $data["category_id"];
    $status = $data["status"];
    $slug = slug($judul, "-");
    $user = waktu();
    $gambarLama = $data["gambar_lama"];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload_post();
    }

    $query = "UPDATE posts SET judul = '$judul', text = '$text', create_by = '$created_by', tag_id = '$tags_id', category_id = '$categ_id', status = '$status', gambar = '$gambar', slug = '$slug', created_at = '$user' WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete_post($hapus)
{
    global $conn;

    $result = "DELETE FROM posts WHERE id = $hapus";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function Hours()
{
    $unixTime = time();
    $timeZone = new \DateTimeZone('Asia/Jakarta');

    $time = new \DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    $formattedTime = $time->format('d F Y H:i');

    return $formattedTime;
}

function Selamat()
{
    $unixTime = time();
    $timeZone = new \DateTimeZone('Asia/Jakarta');

    $time = new \DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    $formattedTime = $time->format('G:i:s');

    return $formattedTime;
}

function cari($keyword)
{
    $result = "SELECT * FROM posts WHERE 
    judul LIKE '%$keyword%'";

    return query($result);
}







// function commets

function komentar($data)
{
    global $conn;

    $nama = $data["nama"];
    $email = $data["email"];
    $komentar = $data["komentar"];
    $website = $data["website"];
    $post_id = $data["post_id"];
    $parent_id = $data["parent_id"];
    $balas = $data["balas"];
    $created_ts = waktu();

    $cekemail = mysqli_query($conn, "SELECT * FROM comments WHERE email = '$email'");

    // cek apakah email sudah ada
    if (mysqli_fetch_assoc($cekemail)) {
        echo "<script>
        alert('Email sudah ada')
        </script>";
    }

    $result = "INSERT INTO comments (nama, email, komentar, website, post_id, parent_id, balas, created_ts) VALUES ('$nama', '$email', '$komentar', '$website', '$post_id', '$parent_id', '$balas', '$created_ts')";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}

function balas($data)
{
    global $conn;

    $nama = $data["nama"];
    $parent_id = $data["parent_id"];
    $balas = $data["balas"];
    $created_ts = waktu();

    $result = "INSERT INTO comments (nama, parent_id, balas, created_ts) VALUES ('$nama', '$parent_id', '$balas', '$created_ts')";

    mysqli_query($conn, $result);

    return mysqli_affected_rows($conn);
}


function alert($tipe, $text)
{
    echo "<div class='alert alert-" . $tipe . " alert-dismissible fade show' role='alert'>
    <strong>Success</strong> $text
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}



// function event


function addEvent($data)

{
    global $conn;

    $judul = $data['judul'];
    $slug = slug($judul, "-");
    $deskripsi = $data['deskripsi'];
    $status = $data['status'];
    $lokasi = $data['lokasi'];
    $tanggal_mulai = $data['tanggal_mulai'];
    $tanggal_akhir = $data['tanggal_akhir'];
    $create_by = $data['create_by'];
    $gambar = upload_post();

    $query = mysqli_query($conn, "INSERT INTO events (judul, slug, gambar, deskripsi, status, lokasi, tanggal_mulai, tanggal_akhir, create_by) VALUES ('$judul', '$slug', '$gambar', '$deskripsi', '$status', '$lokasi', '$tanggal_mulai', '$tanggal_akhir', '$create_by')");

    return mysqli_affected_rows($conn);
}
