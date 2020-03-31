<?php

//fetch_user.php

include('connect.php');

$id = $_SESSION['id'];

$query = "
SELECT to_user_id FROM chat_message 
WHERE to_user_id = :id
AND status = '1'
";
$statement = $connect->prepare($query);
$statement->bindValue(':id', $id);
$statement->execute();
$output='';
$count = $statement->rowCount();
if($count > 0)
{
    $output = '<sup class="badge badge-pill badge-danger mr-2">'.$count.'</sup>';
}
echo $output;


?>