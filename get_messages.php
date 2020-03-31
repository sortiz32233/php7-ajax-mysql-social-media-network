<?php

include_once("connect.php");
date_default_timezone_set('America/Los_Angeles');

$email = $_SESSION['email'];
$sql = "SELECT * FROM tbl_users WHERE email = :email";
$statement = $connect->prepare($sql);
$statement->bindValue(':email', $email);
$statement->execute();
$data      = $statement->fetch(PDO::FETCH_ASSOC);
$profile  = $data['profile'];


$query = "
SELECT * FROM tbl_messages
INNER JOIN tbl_users ON
tbl_messages.message_creator_id = tbl_users.id
WHERE parent_message_id = '0'
ORDER BY message_id ASC";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$output = '';
foreach ($result as $row) {
  $cover = $row['cover'];
  $profile = $row['profile'];
  $message = $row['message'];
  $id = $row['message_creator_id'];
  if ($id === $_SESSION['id']) {
    $messageIcon = '<i class="fas fa-trash-alt text-danger message-top-icons remove-message"></i>';
  } else {
    $messageIcon = '';
  }

  $output .= '
  <div class="">
  <img src="profile_pics/'.$profile.'" class="profile-circle-sm float-right">
  <div class="p-2 mt-2 mr-2 rounded float-right w-50" style="background: lightyellow;">
  '.$message.'
  </div>
  </div>
  <div class="clearfix"></div>

 ';
  $message_id = $row['message_id'];
  $output .= get_reply_message($connect, $message_id);

}


echo $output;


function get_reply_message($connect, $parent_id = 0) {
  $query = "
 SELECT * FROM tbl_messages
 INNER JOIN tbl_users ON
 tbl_messages.message_creator_id = tbl_users.id
 WHERE parent_message_id = '$parent_id'
 ";
  $output = '';
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $count = $statement->rowCount();

  if ($count > 0) {
    foreach ($result as $row) {
      $id = $row['id'];
      $message_id = $row['message_id'];
      $parent_message_id = $row['parent_message_id'];
      $message_creator_id = $row['message_creator_id'];

      // Timestamps
      $now = new DateTime("now");
      // echo $now->format('m/d/Y h:i:s')."<br>";
      $then = new DateTime($row['date']);
      // echo $then->format('m/d/Y h:i:s')."<br>";
      $interval = $now->diff($then);
      if ($interval->format('%i') < 3 && $interval->format('%h') < 1 && $interval->format('%a') < 1) {
        $elapsed = "Just now";
      } else if ($interval->format('%i') >= 3 && $interval->format('%h') < 1 && $interval->format('%a') < 1) {
        $elapsed = $interval->format('%im');
      } else if ($interval->format('%a') < 1 && $interval->format('%h') >= 1){
      $elapsed = $interval->format('%hh');
    } else if ($interval->format('%a') > 0) {
      $elapsed = $interval->format('%ad');
    }


      
      if ($id === $_SESSION['id']) {
        $deleteComment = '· <a style="cursor: pointer;" class="text-danger remove-message small">Delete Comment</a>';
      } else {
        $deleteComment = '· <a style="cursor:pointer;" data-toggle="modal" data-target="#messageModal" class="text-primary small text-weight-light reply" id="'
        . $row["parent_message_id"] . '">Reply</a>';
      }
      $output .= '
      <div class="container">
      <img src="profile_pics/'.$profile.'" class="profile-circle-sm float-right">

      <div class="p-2 mt-2 bg-aliceblue rounded float-left w-50">
      '.$message.'
      </div>
      </div>
      <div class="clearfix"></div>
   ';
      $output .= get_reply_message($connect, $row["message_id"]);
    } // END foreach loop
  }

  return $output;
};



?>

<script>

// TO DO: Get very last activity in the system!!!!!!!!


    
$(".remove-message").click(function() {
    var id = $(this).parents("section").attr("id");
    $("#deleteModal").modal("show");
    $(".remove").click(function(){
    
      $.ajax({
        url: 'delete_message.php',
        type: 'GET',
        data: {
          id: id
        },
        error: function() {
          alert('Error: ' + error);
        },
        success: function(data) {
          $("#" + id).remove();
          $("#deleteModal").modal('hide');
          load_messages();
        }
      });
    })
  });


</script>