<?php
    $connect = new PDO("mysql:host=localhost;dbname=secure_login", "root", "",
    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION) // IMPORTANT: Enables strict debugging
);
    session_start();

    date_default_timezone_set('America/Los_Angeles');

    
function fetch_user_last_activity($user_id, $connect) {
	$query = "
	SELECT * FROM login_details 
	WHERE user_id = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row){
		return $row['last_activity'];
	}
}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect){
    $email = $_SESSION['email'];
    $sql = "
    SELECT * FROM tbl_users WHERE email = :email";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $data = $statement->fetch(PDO::FETCH_ASSOC);
    $name = $data['name'];
    
	$query = "
	SELECT * FROM chat_message 
	WHERE (from_user_id = '".$from_user_id."' 
	AND to_user_id = '".$to_user_id."') 
	OR (from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."') 
	ORDER BY timestamp ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<div class="list-unstyled">';
	foreach($result as $row){
		$user_name = '';
        $dynamic_background = '';
        $profile_pic_position = '';
		$chat_message = '';
		if($row["from_user_id"] == $from_user_id){
		$chat_message = $row['chat_message'];
        $user_name = '<b>'.$name.'</b>';
		$profile_pic_position = 'float: right';
		$dynamic_background = 'background-color:aliceblue; float: right;';
	} else {
		$chat_message = $row["chat_message"];
		$user_name = '<b>'.get_user_name($row['from_user_id'], $connect).'</b>';
        $dynamic_background = 'background-color:lightyellow; float:left';
        $profile_pic_position = 'float: left';
	}
        $output .= '
        <img style="'.$profile_pic_position.'" src="profile_pics/'.get_profile_pic($row['from_user_id'], $connect).'" class="profile-circle-sm">

		<div style="padding:.5rem .5rem 0 .5rem; margin: .25rem; border-radius: 1rem; width: 60%;'.$dynamic_background.'">
			<p>'.$user_name.' '.$chat_message.'
				<div align="right">
				</div>
            </p>
		</div>
        <div class="clearfix"></div>
		';
	}
	$output .= '</div>';
	$query = "
	UPDATE chat_message 
	SET status = '0' 
	WHERE from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."' 
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $output;
}

function get_user_name($user_id, $connect)
{
	$query = "SELECT name FROM tbl_users WHERE id = '$user_id'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['name'];
	}
}

function get_profile_pic($user_id, $connect)
{
	$query = "SELECT profile FROM tbl_users WHERE id = '$user_id'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['profile'];
	}
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
	$query = "
	SELECT * FROM chat_message 
	WHERE from_user_id = '$from_user_id' 
	AND to_user_id = '$to_user_id' 
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	if($count > 0)
	{
		$output = '<sup class="badge badge-pill badge-danger">'.$count.'</sup>';
	}
	return $output;
}

function fetch_is_type_status($user_id, $connect)
{
	$query = "
	SELECT is_type FROM login_details 
	WHERE user_id = '".$user_id."' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		if($row["is_type"] == 'yes')
		{
			$output = 'typing...';
		}
	}
	return $output;
}



?>