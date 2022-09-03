<?php

require '../functional.php';

$id = $_GET["id"];

if (hapususer($id) > 0) {
    echo "<script>
    alert('Data Berhasil dihapus');
    document.location.href= '/syahri-project/users/index.php';
    </script>";
} else {
    echo "<script>
    alert('Data Gagal dihapus');
    document.location.href= '/syahri-project/users/index.php';
    </script>";
}
