<?php
include_once("connect.php");

$id = $_SESSION['id'];

$initialExtension = strtolower(pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION));
$finalExtension = 'img' . round(microtime(false)) . mt_rand() . '.' . $initialExtension;
$target  = "profile_pics/" . $finalExtension;



if (move_uploaded_file($_FILES['profile']['tmp_name'], $target)) {
    
$query = "
UPDATE tbl_users SET `profile` = :profile WHERE id = '$id'
";
$statement = $connect->prepare($query);
$statement->bindValue(':profile', $finalExtension);
$statement->execute();
};



?>