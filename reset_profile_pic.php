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
?>