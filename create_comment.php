<?php

include_once("connect.php");

$post_content = strip_tags($_POST["comment_post_content"]);
$ip = $_SERVER['REMOTE_ADDR'];

 $query = "
 INSERT INTO tbl_posts
 (parent_post_id, post, post_creator_id, ip)
 VALUES (:parent_post_id, :post, :post_creator_id, :ip)
 ";
 $statement = $connect->prepare($query);
 $data = $statement->execute(
  array(
   ':parent_post_id' => $_POST["post_id"],
   ':post' => $post_content,
   ':post_creator_id' => $_SESSION['id'],
   ':ip' => $ip
    )
 );
  
  echo json_encode($data);
  
  ?>