<?php 

include("connect.php");

  $id = $_SESSION['id'];
  $sql = "SELECT * FROM tbl_users WHERE id = :id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(":id", $id);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  $returningUser = $row['returning_user'];

  echo $returningUser;

?>

