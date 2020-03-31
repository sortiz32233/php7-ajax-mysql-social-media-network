<?php

include("connect.php");


if (isset($_POST['post'])){
$ip = $_SERVER['REMOTE_ADDR'];
$post_content = htmlspecialchars($_POST["dashboard_post_content"]);
$initialExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
$finalExtension = 'img' . round(microtime(false)) . mt_rand() . '.' . $initialExtension;
$target  = "images/" . $finalExtension;
$image = $_FILES['image']['name'];

if ($_POST["dashboard_post_content"] != '' || $image){
if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
 $query = "
 INSERT INTO tbl_posts
 (parent_post_id, post, image, post_creator_id, ip)
 VALUES (:parent_post_id, :post, :image, :post_creator_id, :ip)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_post_id' => $_POST["post_id"],
   ':post' => $post_content,
   ':image' => $finalExtension,
   ':post_creator_id' => $_SESSION['id'],
   ':ip' => $ip
    )
 );
} else {
   $query = "
 INSERT INTO tbl_posts
 (parent_post_id, post, image, post_creator_id, ip)
 VALUES (:parent_post_id, :post, :image, :post_creator_id, :ip)
 ";
 $statement = $connect->prepare($query);
 $data = $statement->execute(
  array(
   ':parent_post_id' => $_POST["post_id"],
   ':post' => $post_content,
   ':image' => null,
   ':post_creator_id' => $_SESSION['id'],
   ':ip' => $ip
    )
 );
}
}

echo json_encode($data);

}

?>

