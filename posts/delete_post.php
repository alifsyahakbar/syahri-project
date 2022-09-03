<?php

require '../functional.php';

$id = $_GET['id'];

if (delete_post($id) > 0) {
    echo "<script>
        alert('Data Behasil dihapus.');
        document.location.href= 'index.php';
        </script>";
} else {
    echo "<script>
    alert('Data Gagal dihapus.');
    document.location.href= 'index.php';
    </script>";
}
