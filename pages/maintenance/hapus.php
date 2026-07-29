<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include '../../config/database.php';

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT inventaris_id
FROM maintenance
WHERE id='$id'
");

$data = mysqli_fetch_assoc($query);

mysqli_query($conn,"
UPDATE inventaris
SET status='Tersedia'
WHERE id='".$data['inventaris_id']."'
");

mysqli_query($conn,"
DELETE FROM maintenance
WHERE id='$id'
");

header("Location:index.php");
exit;