<?php

include("connect.php");
date_default_timezone_set('America/Los_Angeles');

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_users WHERE id = :id";
$statement = $connect->prepare($sql);
$statement->bindValue(':id', $id);
$statement->execute();
$data      = $statement->fetch(PDO::FETCH_ASSOC);
$profile  = $data['profile'];
$ip = $_SERVER['REMOTE_ADDR']; 
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json")); 
$city = $details->city;
if ($city){
  $city = $city;
} else {
  $city = "Unkown Location";
}

$query = "SELECT * FROM tbl_posts 
INNER JOIN tbl_users ON tbl_users.id = tbl_posts.post_creator_id 
WHERE tbl_posts.post_creator_id = :id AND parent_post_id = '0' ORDER BY post_id DESC";
$statement = $connect->prepare($query);
$statement->bindValue(':id', $id);
$statement->execute();
$result = $statement->fetchAll();
$count = $statement->rowCount();

$output = '';
foreach ($result as $row) {

  if ($id === $_SESSION['id']) {
    $postIcon = '<i class="fas fa-trash-alt text-danger post-top-icons remove-post"></i>';
  } else {
    $postIcon = '';
  }

  $cover = $row['cover'];

  $image = $row['image'];
  if ($image == NULL) {
   $imagePost = "";
  } else {
   $imagePost = "<img class='img-fluid post-image mb-2' src='images/".$row['image']."'></a>";
  }

  $output .= '
 <section class="shadow post mt-5" id="' . $row["post_id"] . '">
 <div class="card-header cover'.$row['id'].' p-3" style=" 
  
 background: linear-gradient(
  to bottom,
  rgba(255, 255, 255, 0.1) 0%,
  rgba(255, 255, 255, 1) 100%
 ),
 url(covers/'.$cover.');
 background-position: 0; ">
 <a href="profile.php?id='.$row['id'].'"><img class="post-pic pic'.$row['id'].'" src="profile_pics/'.$row["profile"].'"></a>
 <div class="post-text-container">
 <b><a class="text-white" href="profile.php?id='.$id.'">' . $row['name'] . '</a></b><br><span class="small text-white">'
    . date("m/d/Y", strtotime($row["date"])) . " " . ltrim(date("h:i:s A", strtotime($row["date"])), '0') . '</span>
' . $postIcon . '
</div>
 </div>
 <div class="card-body post-body">
  <p class="post-text">' . strip_tags($row["post"]) . '</p>
  '.$imagePost.'
<div class="small font-weight-light"><i class="fas fa-map-marker-alt text-danger"></i> '.$city.'</div>
<div class="small text-dark font-weight-light"><i class="far fa-clock text-muted"></i> Posted ' . date("m/d/Y", strtotime($row["date"])) . " at " . ltrim(date("h:i:s A", strtotime($row["date"])), '0') . '</div>
</div>
</div>
<div class="card-footer">
<form class="d-flex flex-row dashboard_comment_form" action="create_comment.php" method="POST">
<a href="profile.php?id='.$data['id'].'"><img class="profile-pic position-relative pic'.$data['id'].'" src="profile_pics/'.$profile.'"></a>
<input autocomplete="off" type="text" name="comment_post_content" class="form-control flex-fill mr-1 mt-2">
<input type="hidden" name="post_id" value="'.$row['post_id'].'">

<button type="submit" name="submit" class="btn commentBtn mt-2 ml-2"><i class="far fa-comment"></i></button>
<div class="text-danger small position-absolute mt-5" style="margin-left: 4.2rem;" id="dashboard_post_message"></div>

</form>

</div>

 </section>
 ';
  $post_id = $row['post_id'];
  $output .= get_reply_post($connect, $post_id);

}


echo $output;


function get_reply_post($connect, $parent_id = 0) {
  $query = "
 SELECT * FROM tbl_posts
 INNER JOIN tbl_users ON
 tbl_posts.post_creator_id = tbl_users.id
 WHERE parent_post_id = '$parent_id'
 ";
  $output = '';
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $count = $statement->rowCount();

  if ($count > 0) {
    if ($count === 1) {
      $output .= "<div class='ml-3 mb-3 text-weight-light'>" . $count . " Total Comment</div>";
    } else {
      $output .= "<div class='ml-3 mb-3 text-weight-light'>" . $count . " Total Comments</div>";
    }
    foreach ($result as $row) {
      $id = $row['id'];
      $post_id = $row['post_id'];
      $parent_post_id = $row['parent_post_id'];
      

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
        $deleteComment = '· <a style="cursor:pointer;" data-toggle="modal" data-target="#postModal" class="text-primary small text-weight-light reply" id="'
        . $row["parent_post_id"] . '">Add Comment</a> · <a style="cursor: pointer;" class="text-danger remove-post small">Delete Comment</a>';
      } else {
        $deleteComment = '· <a style="cursor:pointer;" data-toggle="modal" data-target="#postModal" class="text-primary small text-weight-light reply" id="'
        . $row["parent_post_id"] . '">Reply</a>';
      }
      $output .= '
      
      <section class="container-fluid d-flex comment-container" id="' . $row["post_id"] . '">
      <a href="profile.php?id='.$row['id'].'"><img class="profile-pic pic'.$row['id'].'" src="profile_pics/'.$row["profile"].'"></a>

      <div class="comment">
   <div class="bubble">
    
   <b><a class="text-dark text-decoration-none" href="profile.php?id='.$row['id'].'">' . $row["name"] . '</a></b>&ensp;<h6 class="d-inline comment-text">'.htmlspecialchars($row["post"]).'</h6></div>
   <span class="small text-muted">' . $elapsed . '</span>
   ' . $deleteComment  . '
   

   </div>
   </div>
   </section>
   ';
      $output .= get_reply_post($connect, $row["post_id"]);
    } // END foreach loop

  }

  return $output;
};

if (!$output){
  echo "<div style='text-shadow: black 0px 0px 10px !important;' class='font-weight-light text-white mt-2 text-center'>".strtok($data['name'], " ")." has not posted anything.</div>";
}

?>

<script>
     //Ajax => create_comment.php
 $('.dashboard_comment_form').on('submit', function(event) {
  event.preventDefault();
  var input = $(this).children("input");
  if (input.val() == ''){
    input.css("border", "1px solid red");
        setTimeout(() => {
            input.css("border", "1px solid lightgrey");
        }, 1900);
        $(this).children('div')
        .html("Please post a status or image")
        .show()
        .delay(1000)
        .fadeOut(1000);
  } else {
  var form_data = $(this).serialize();
  $.ajax({
   url: 'create_comment.php',
   method: 'POST',
   data: form_data,
   dataType: 'JSON',
   success: function() {
    load_profile_posts()
     // scroll here
    },
    error: function(){
      alert("Server error.")
    },
    complete: function(){
      $(this)
     .children('input')
     .val('');
    }
  });
}
});

$(".remove-post").click(function() {
    var id = $(this).parents("section").attr("id");
    $("#deleteModal").modal("show");
    $(".remove").click(function(){
    
      $.ajax({
        url: 'delete_post.php',
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
          load_profile_posts();
        }
      });
    })
  });

  


</script>