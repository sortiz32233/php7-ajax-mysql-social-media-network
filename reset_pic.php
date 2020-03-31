<?php
   include("connect.php");
   
if (isset($_POST['resetProfile'])) {
$id = $_SESSION['id'];
$query = "
UPDATE tbl_users SET `profile` = 'default_avatar.png' WHERE id = :id
";
$statement = $connect->prepare($query);
$statement->bindValue(':id', $id);
if ($statement->execute()){
	exit('success');
} else {
	exit('error');
}
}

if (isset($_POST['resetCover'])) {
	$id = $_SESSION['id'];
	$query = "
	UPDATE tbl_users SET `cover` = 'default_cover.jpg' WHERE id = :id
	";
	$statement = $connect->prepare($query);
	$statement->bindValue(':id', $id);
	if ($statement->execute()){
		exit('success');
	} else {
		exit('error');
	}
	}

	if (isset($_POST['resetHero'])) {
		$id = $_SESSION['id'];
		$query = "
		UPDATE tbl_users SET `hero_pic` = 'default_hero.png' WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->bindValue(':id', $id);
		if ($statement->execute()){
			exit('success');
		} else {
			exit('error');
		}
		}
?>