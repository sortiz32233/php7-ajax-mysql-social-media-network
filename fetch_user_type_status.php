<?php

//fetch_user.php

include('connect.php');

$id = $_SESSION['id'];
$sql = "SELECT * FROM tbl_users WHERE id != :id ORDER BY id DESC";
$statement = $connect->prepare($sql);
$statement->bindValue(':id', $id);
$statement->execute();

$result = $statement->fetchAll();

$output = '';

foreach($result as $row)
{	
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['id'], $connect);
	if($user_last_activity > $current_timestamp) {
$output .= fetch_is_type_status($row['id'], $connect);
    }
}

echo $output;

?>