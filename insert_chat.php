<?php

//insert_chat.php

include('connect.php');
$ip = $_SERVER['REMOTE_ADDR']; 

$data = array(
	':to_user_id'		=>	$_POST['to_user_id'],
	':from_user_id'		=>	$_SESSION['id'],
	':chat_message'		=>	$_POST['chat_message'],
	':ip'				=> 	$ip,
	':status'			=>	'1'
);

$query = "
INSERT INTO chat_message 
(to_user_id, from_user_id, chat_message, ip, status) 
VALUES (:to_user_id, :from_user_id, :chat_message, :ip, :status)
";

$statement = $connect->prepare($query);

if($statement->execute($data)){
	echo fetch_user_chat_history($_SESSION['id'], $_POST['to_user_id'], $connect);
}

?>