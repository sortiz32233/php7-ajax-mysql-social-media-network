<?php
include_once("connect.php");

$id = $_SESSION['id'];


if (isset($_POST['setHeroProfile'])){

$initialExtension = strtolower(pathinfo($_FILES['hero']['name'], PATHINFO_EXTENSION));
$finalExtension = 'img' . round(microtime(false)) . mt_rand() . '.' . $initialExtension;
$target  = "heros/" . $finalExtension;



if (move_uploaded_file($_FILES['hero']['tmp_name'], $target)) {
    
$query = "
UPDATE tbl_users SET hero_pic = :hero_pic WHERE id = :id
";
$statement = $connect->prepare($query);
$statement->bindValue(':hero_pic', $finalExtension);
$statement->bindValue(':id', $id);

$statement->execute();
}
}


if (isset($_POST['updateHeroInfo'])){
    $heroName = trim($_POST['hero_name']);
    $heroQuote = trim($_POST['hero_quote']);
    $sql = "UPDATE tbl_users SET hero = :hero, hero_quote = :hero_quote WHERE id = :id";
    $statement = $connect->prepare($sql);
    $statement->bindValue(":hero", $heroName);
    $statement->bindValue(":hero_quote", $heroQuote);
    $statement->bindValue(':id', $id);
    $result = $statement->execute();
if ($result){
    exit('success');
} else {
    exit('error');
}
} else {

$initialExtension = strtolower(pathinfo($_FILES['hero']['name'], PATHINFO_EXTENSION));
$finalExtension = 'img' . round(microtime(false)) . mt_rand() . '.' . $initialExtension;
$target  = "heros/" . $finalExtension;



if (move_uploaded_file($_FILES['hero']['tmp_name'], $target)) {
    
$query = "
UPDATE tbl_users SET hero_pic = :hero_pic WHERE id = :id
";
$statement = $connect->prepare($query);
$statement->bindValue(':hero_pic', $finalExtension);
$statement->bindValue(':id', $id);

$statement->execute();
}
}

?>