<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../../login.php");
    exit;
}

include '../../../config/database.php';

$id = (int)$_POST['id'];

$query = "DELETE FROM inventaris WHERE id = $id";

if (mysqli_query($conn, $query)) {
    header("Location: ../index.php?success=2");
} else {
    header("Location: ../index.php?error=" . urlencode(mysqli_error($conn)));
}
exit;
?>