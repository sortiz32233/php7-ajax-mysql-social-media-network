<?php

include("connect.php");

if (isset($_GET['id'])){
$query = "
DELETE FROM tbl_posts 
WHERE parent_post_id=".$_GET['id']." 
OR post_id=".$_GET['id']
;
$statement = $connect->prepare($query);
$statement->execute();
}

?>