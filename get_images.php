<?php 

include("connect.php");


  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
  $sql = "SELECT tbl_posts.image, tbl_posts.post_id FROM tbl_posts INNER JOIN tbl_users ON tbl_users.id = tbl_posts.post_creator_id WHERE tbl_posts.post_creator_id = :id AND tbl_posts.image != '' OR null";
  $statement = $connect->prepare($sql);
  $statement->bindValue(":id", $id);
  $statement->execute();
  $result = $statement->fetchAll();
  $output='<div class="img-area">';
  if ($result){
    foreach ($result as $row){
    $image = $row['image'];
    $output .= "<div class='single-img'><img style='width: 100px; height: 100px' class='img". $row["post_id"] ."' src='images/".$image."'></div>";  
  }
    } else {
      $output = "<div class='small text-muted mr-auto'>".strtok($name, " ")." has not posted any images yet</small></div>";
    }
$output .= "</div>";

echo $output;

?>

