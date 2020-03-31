<?php

include("connect.php");

if (isset($_POST['secure'])){
$token = $_POST['two_factor_token'];
$email = $_SESSION['email'];
$sql = "SELECT * FROM tbl_users WHERE email = :email";
$statement = $connect->prepare($sql);
$statement->bindValue(':email', $email);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$encryptedToken = $row['two_factor_token'];
if (password_verify($token, $encryptedToken)){
  $sub_query = "
  INSERT INTO login_details 
  (user_id) 
  VALUES ('".$row['id']."')
  ";
  $statement = $connect->prepare($sub_query);
  $statement->execute();
  $_SESSION['online'] = true;
  $_SESSION['id'] = $row['id'];
  $_SESSION['name'] = $row['name'];
  $_SESSION['email'] = $row['email'];
  $_SESSION['login_details_id'] = $connect->lastInsertId();
  exit('success');
} else {
  exit('badPassword');
}};