<?php

//fetch_user.php

include('connect.php');

$id = $_SESSION['id'];
$sql = "SELECT * FROM tbl_users WHERE id != :id AND privacy = 1 ORDER BY id DESC";
$statement = $connect->prepare($sql);
$statement->bindValue(':id', $id);
$statement->execute();

$result = $statement->fetchAll();

$output = '
<div class="container">
';

foreach($result as $row)
{	
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['id'], $connect);
	if($user_last_activity > $current_timestamp)
	{
		$status = '<div class="spinner-grow bg-success online"></div>';
	}
	else
	{
		$status = '<div class="spinner-grow bg-danger offline"></div>';
	}
	$output .= '

	<div class="user-list rounded text-white shadow" style="background-size: cover !important; ;padding: .25rem; margin-top: 1rem; background: linear-gradient(to bottom right, rgba(0,0,0,.25), rgba(255,255,255,.25)), url(covers/'.$row['cover'].') no-repeat; background-position: center">
	<div class="float-left"><a href="profile.php?id='.$row['id'].'"><img style="border: 3px double white; box-shadow: none; margin-left: .25rem; margin-top:-.215rem; " class="profile-circle pic'.$row['id'].'" id="'.$row['id'].'" src="profile_pics/'.$row['profile'].'" /></div>
	<a class="text-white" href="profile.php?id='.$row['id'].'"><span style="text-shadow: black 0px 0px 10px !important;">'.$row['name'].'</span></a>
	'.count_unseen_message($row['id'], $_SESSION['id'], $connect).'
	<br><small>'.fetch_is_type_status($row['id'], $connect).'&nbsp;</small>

		<button class="start_chat btn btn-primary float-right" data-touserid="'.$row['id'].'" data-tousername="'.$row['name'].'"><i class="far fa-comments"></i></button>
		'.$status.'
		</div>
	';
}

$output .= '</div>';

echo $output;

?>