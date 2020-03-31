<?php
include_once("connect.php");

$id = $_SESSION['id'];

$initialExtension = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
$finalExtension = 'img' . round(microtime(false)) . mt_rand() . '.' . $initialExtension;
$target  = "covers/" . $finalExtension;

if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
    
$query = "
UPDATE tbl_users SET `cover` = :cover WHERE id = '$id'
";
$statement = $connect->prepare($query);
$statement->bindValue(':cover', $finalExtension);
$statement->execute();
};

?>