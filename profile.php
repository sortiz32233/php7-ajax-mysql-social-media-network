<?php 
  include("connect.php");
  include("modals.php");

  if ($_SESSION["online"] != true) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}

$url_id = $_GET['id'];
$sql = "SELECT id, privacy FROM tbl_users WHERE id='$url_id'";
$statement = $connect->prepare($sql);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$rows = $statement->rowCount();

if($rows > 0 && $row['privacy'] == 1){
  // profile request is valid
}else{
  if ($_SESSION["online"] != true) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
} else {
  echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
}
}

  $ip = $_SERVER['REMOTE_ADDR']; 
  $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json")); 
  $city = $details->city;

  $sessionId = $_SESSION['id'];
  $query = "SELECT * FROM tbl_users WHERE id = :id";
  $statement = $connect->prepare($query);
  $statement->bindValue(':id', $sessionId);
  $statement->execute();
  $data      = $statement->fetch(PDO::FETCH_ASSOC);


  if (isset($_GET['id'])){
  $id = $_GET['id'];
  $sql = "SELECT * FROM tbl_users WHERE id = :id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $row      = $statement->fetch(PDO::FETCH_ASSOC);
  $profile  = $row['profile'];
  $name = $row['name'];
  $cover = $row['cover'];
  $location = $row['location'];
  $bio = $row['bio'];
} else {
  header("location: index.php");
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
    <title><?php echo $name; ?></title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-160782029-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-160782029-1');
</script>

  </head>


  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a href="dashboard.php"><i class="fas fa-lg fa-arrow-left text-white"></i></a>
    <ul class="navbar-nav ml-auto d-flex flex-row">


      <!-- PROFILE DROPDOWN -->
<small class="all_unseen_messages"></small>

    <div class="btn-group">    
  <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <img id="avatar" class="profile-rounded-sm pic<?php echo $data['id']; ?>'" src="profile_pics/<?php echo $data['profile']; ?>">
</a>
<div class="dropdown-menu position-absolute dropdown-menu-right">
<h6 class="dropdown-header text-uppercase"><?php echo $data['name']; ?></h6>
<div class="dropdown-divider"></div>


<a class="dropdown-item" href="dashboard.php"><i class="fas fa-home"></i>&ensp;Home</a>
<span class="hide-on-desktop">
<a class="dropdown-item" href="message_center.php"><i class="fas fa-envelope"></i>&ensp;Messages</a>
</span>
    <a class="dropdown-item" href="setup.php"><i class="fas fa-cog"></i>&ensp;Settings</a>
    <button class="dropdown-item" id="logout" type="button"><i class="fas fa-sign-out-alt"></i>&ensp;Logout</button>
  </div>
</div>
    </ul>
  </nav>





  <body>

  <!-- COVER -->
  <div class="cover-wrapper">
  <div class="cover<?php echo $row['id'];?> cover" style=" 
  
  background: linear-gradient(
   to bottom,
   rgba(0, 0, 0, 0.1) 0%,
   rgba(255, 255, 255, 1) 100%
  ),
  url(covers/<?php echo $cover; ?>);
  ">
  

  
<div class="cover-text">
<h4><a class="text-white" href="profile.php?id=<?php echo $id;?>"><?php echo $name; ?></a></h4>
<h5 class="font-weight-light"><?php echo $location; ?></h5>
<h6 class="font-weight-light"><?php echo $bio; ?></h6>
<h6 class="small">Joined <?php echo date("F Y", strtotime($row['created_on'])); ?></h6>
</div>
  <div class='profile-photo-container'>
   <img class='profile-photo shadow-lg pic<?php echo $row['id']; ?>' src='profile_pics/<?php echo $row['profile']; ?>'>
      </div>
      </div>
</div>

      <form class="d-none" id="cover_upload_form" method="POST" enctype="multipart/form-data" action="upload.php">
          <div class="custom-file mt-3">
            <input type="hidden" name="size" value="1000000000">
            <input type="file" class="custom-file-input" name="cover" id="cover">
          </div>
          <input class="btn btn-primary my-3" type="submit" name="cover" id="upload-cover" value="Upload Cover Picture">
        </form>
          

          <form class="d-none" id="profile_upload_form" method="POST" enctype="multipart/form-data" action="upload.php">
          <div class="custom-file mt-3">
            <input type="hidden" name="size" value="1000000000">
            <input type="file" class="form-control" name="profile" id="profile">
          </div>
          <input class="btn btn-primary my-3" type="submit" name="profile" id="upload-profile-picture" value="Upload Profile Picture">
        </form>
        

<!-- END COVER -->
<main>
<div class="row" style="margin-top:-5rem !important">


<!-- USERS COLUMN -->
    
        <!-- <div class="alert alert-secondary shadow text-primary font-weight-light">
        <div class="btn-group">
  <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <i class="fas fa-user-lock"></i>&ensp;Profile Privacy</a>
  <div class="dropdown-menu">
    <button class="dropdown-item" type="button"><i class="fas fa-user"></i>&ensp;Private </button>
    <button class="dropdown-item" type="button"><i class="fas fa-globe"></i>&ensp;Public </button>

  </div>
</div>
</div> -->

<!-- COLUMN 1 -->
<div class="col-md-3 pl-4 pt-3 hide-on-mobile">

<section id="about_section" class="jumbotron p-2 shadow-lg">
<h6 class="text-muted border-bottom text-uppercase small font-weight-bold pb-2">About <?php echo strtok($name, " ");?></h6>

<div id="about_div" class="small font-weight-light">
<?php if ($row['about'] != '' || $row['about'] != null){
  echo $row['about']; 
} else {
  echo strtok($name, " ") . "'s bio is private.";
}
 ?> 
  </div>
</section>


<section id="personal_information_section" class="jumbotron p-2 shadow-lg">
<h6 class="text-muted border-bottom text-uppercase small font-weight-bold pb-2"><?php echo strtok($name, " ");?>'s Personal Information</h6>
<div class="font-weight-light small">
<?php 

  $id = $_GET['id'];
  $sql = "SELECT * FROM tbl_users WHERE id = :id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(":id", $id);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  if (isset($_GET['id'])){
  foreach($result as $row){
  if ($row['relationship_status'] != '' || $row['relationship_status'] != null) {
    $output .= '<div class="d-flex flex-rows relationship-status">
  <i class="fas fa-heart text-danger" style="margin-top: .35rem"></i>
      &emsp;<div id="relationship_status">'.$row["relationship_status"].'</div>
  </div>';
  }

  if ($row['occupation'] != '' || $row['occupation'] != null) {
    $output .= '<div class="d-flex flex-rows occupation">
    <i style="color:saddlebrown" class="fas fa-briefcase mt-2"></i>&ensp;<div id="occupation" contenteditable="false" class="editable-div">'.$row['occupation'].'</div>
    </div>';
  }

  
  if ($row['hometown'] != '' || $row['hometown'] != null) {
  $output .= '
  <div class="d-flex flex-rows hometown">
  <i class="fas fa-home text-dark mt-2"></i>&ensp;<div contenteditable="false" id="hometown" class="editable-div">'.$row['hometown'].'</div>
  </div>';
  }

  if ($row['alma_mater'] != '' || $row['alma_mater'] != null) {
  $output .= '
  <div class="d-flex flex-rows alma-mater">
<i style="color:darkblue" class="fas fa-graduation-cap mt-2"></i>&ensp;<div id="almaMater" contenteditable="false" class="editable-div">'.$row['alma_mater'].'</div>
</div>';
  }
  }
}

if ($row['relationship_status'] != null && $row['relationship_status'] != '' && 
$row['occupation'] != null && $row['occupation'] != '' && $row['hometown'] != null && $row['hometown'] != '' 
&& $row['occupation'] != null && $row['occupation'] != ''){
echo $output;
} else {
  echo strtok($name, " ") . "'s personal information is private.";
}
?>
</div>
</section>



<section id="hero_section" class="jumbotron p-2 shadow-lg">
<h6 class="text-muted border-bottom text-uppercase small font-weight-bold pb-2"><?php echo strtok($name, " ")."'s Hero</h6>";?>
<div class="hero-container font-weight-light small">
  <div class="text-center">
  <?php 
  if ($row['hero_pic'] == '' || 
  $row['hero_pic'] == null || 
  $row['hero_pic'] == 'default_hero.png' and 
  $row['hero_quote'] == null || 
  $row['hero_quote'] == '' and 
  $row['hero'] == null || 
  $row['hero'] == ''){
  echo "<div class='text-left'>".strtok($row['name'], " ")."'s hero section is private.</div>";
}
?>



<?php if ($row['hero_pic'] != '' && $row['hero_pic'] != null && $row['hero_pic'] != 'default_hero.png'){
  echo '
  <figure class="position-relative" id="hero-image-container">
<img class="img-fluid" id="hero-image" src="heros/'.$row['hero_pic'].'">
<div id="uploadHeroBtn"><i class="fas fa-camera"></i></div>
  </figure>
</div>
  <form class="" id="hero_pic_upload_form" method="POST" enctype="multipart/form-data" action="upload_hero.php">
          <div class="custom-file mt-3">
            <input type="hidden" name="size" value="1000000000">
            <input type="file" class="form-control" name="hero" id="hero">
          </div>
          <input class="btn btn-primary my-3" type="submit" name="uploadHeroPic" id="upload-hero-picture">
        </form>
        ';
      };
      
      ?>


<?php 
if ($row['hero_quote'] != NULL || $row['hero_quote'] != ''){
echo '<blockquote>
<span id="hero_blockquote">'.$row['hero_quote'].'</span>
      ';
}
?>
<?php 

if ($row['hero'] != NULL || $row['hero'] != ''){
  echo '<cite><span id="hero_cite">'.$row['hero'].'</span></cite>';
} else 
{
    echo '<div><cite><span id="hero_cite">'.$row['hero'].'</span></cite></div>';
}

?>

    <?php 
if ($row['hero_quote'] != NULL || $row['hero_quote'] != ''){
echo '
</blockquote>';
}
?>
</div>


</form>

  </section>







<div class="jumbotron p-2 shadow-lg">
<h6 class="text-muted border-bottom text-uppercase small font-weight-bold pb-2"><i class="fas fa-images"></i>&ensp;Posted Images
</h6>
<?php
$id = $_GET['id'];
$name = $row['name'];
$sql = "SELECT * FROM tbl_posts INNER JOIN tbl_users ON tbl_users.id = tbl_posts.post_creator_id WHERE tbl_posts.post_creator_id = :id AND tbl_posts.image != '' OR null";
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
    echo "<div class='small text-muted mr-auto'>".strtok($name, " ")." has not posted any images yet</small></div>";
  }
$output .= "</div>";

echo $output;

?>
</div>
</div>

<!-- END COLUMN 1 -->

<!-- COLUMN 2 -->

        <div class="col-md-5 col2">
<?php if ($row['id'] == $data['id']){
$placeholder = "What's up?";
echo '
<div class="post-container shadow-lg pb-1">

<form id="dashboard_post_form" action="create_post.php" method="POST" enctype="multipart/form-data">
<div class="container d-flex flex-row pr-0">
<a href="profile.php?id='.$data["id"].'"><img class="profile-pic position-relative pic'.$data["id"].'" src="profile_pics/'.$data['profile'].'"></a>

<textarea type="text" id="dashboard_post_content" name="dashboard_post_content" class="form-control flex-fill mt-1 mr-3" style="resize:none;" placeholder="'.$placeholder.'" maxlength="255" autocomplete="off"></textarea>
<a class="float-right text-primary py-3 px-1 image_upload_button"><i class="fas fa-image"></i></a>&ensp;
</div>
<input type="hidden" name="post_id" id="post_id" value="0">
  <input name="image" type="file" onchange="readURL(this);" class="custom-file-input d-none" id="file-input" accept="image/*">
  <label class="custom-file-label d-none" for="image">Upload image</label>
  <input type="hidden" name="size" value="1000000000">
  <div class="image-preview-container jumbotron bg-light shadow-lg">
  <button class="close" style="color: white; opacity: 1 !important; z-index:2; right: 0;" type="button" data-dismiss="modal" aria-label="Close">
  <i class="text-dark fas fa-times remove-image-preview"></i>
  </button>
  <img class="img-fluid" id="image-preview" src="">
</div>
<button type="submit" href="#" class="btn btn-primary mt-2 mr-4 float-right"><span>post</span></button>
  <div class="text-danger small" id="dashboard_post_message"></div>
  </div>
</form>
';

}
?>



<div class="wrapper" style="transform: translateY(2rem) !important;">
<box class="shine"></box>

<div class="box">
<lines class="shine"></lines>
<lines class="shine"></lines>
<lines class="shine"></lines>
</div>

<photo class="shine"></photo>
<br>

<box class="shine"></box>
<div class="box">
<lines class="shine"></lines>
<lines class="shine"></lines>
<lines class="shine"></lines>
</div>

<photo class="shine"></photo>
</div>


<div class="mx-auto" id="display_profile_posts"></div>
</div>



<!-- END COLUMN 2 -->

<!-- COLUMN 3 -->

        <div class="col-md-4 pr-4 pt-3 hide-on-mobile">
        <div class="jumbotron p-2 shadow-lg">
        <h6 class="text-primary border-bottom text-uppercase small font-weight-bold pb-2"><i class="fas fa-envelope"></i>&ensp;Message Center
</h6>
<div class="form-group has-search">
    <span class="fa fa-search form-control-feedback"></span>
    <input type="text" class="form-control" id="search" placeholder="Search public users">
  </div>

        <div id="user_details"></div>
          <div id="user_model_details"></div>
</div>
</div>

</div>
</div>
</div>


</div>


<!-- END COLUMN 3 -->

<!-- DELETE MODAL -->

<div class="modal fade text-white" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Delete Post" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: rgba(0,0,0,.9);">
      <div class="modal-header">
        <h5 class="modal-title font-weight-lighter">confirm deletion</h5>
        <a type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <div class="modal-body">
        <h6 class="mt-3 mb-3 font-weight-light">Are you sure? This action cannot be undone.</h6>
      </div>
      <div class="modal-footer">
        <a class="btn btn-outline-secondary text-white" data-dismiss="modal">Cancel</a>
        <button class="btn btn-outline-danger remove" type="submit" id="btn-delete">Delete</button>
      </div>
    </div>
  </div>
</div>


    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/77115c99a1.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/get.js"></script>

    <script>

$('#profile_upload_form').submit(function(event) {
 event.preventDefault();
 var formData = new FormData(this);

 $.ajax({
  type: 'POST',
  url: 'upload.php',
  data: formData,
  cache: false,
  contentType: false,
  processData: false,
  success: function() {
   $.get('get_profiles.php', function(data, status) {
    $(".pic<?php echo $row['id'];?>").attr('src', 'profile_pics/' + data);
    $('#avatar').attr('src', 'profile_pics/' + data);
   });
  },
  error: function() {
   console.log('Error: ' + error);
  }
 });
});

$('#cover_upload_form').submit(function(event) {
 event.preventDefault();
 var formData = new FormData(this);

 $.ajax({
  type: 'POST',
  url: 'upload_cover.php',
  data: formData,
  cache: false,
  contentType: false,
  processData: false,
  success: function() {
   $.get('get_covers.php', function(data, status) {
    $(".cover<?php echo $row['id'];?>").css(
     'background','linear-gradient(to bottom,rgba(0, 0, 0, 0.1) 0%, rgba(255, 255, 255, 1) 100%), url(covers/' +
      data +
      ')'
    );
    $(".cover<?php echo $row['id'];?>").css('background-position', '50%');
   });
  },
  error: function() {
   console.log('Error: ' + error);
  }
 });
});

$('.change-cover').click(function() {
 $('#cover').click();
});

$('#cover').on('change', function() {
 if ($('#cover').val() !== '') {
  $('#upload-cover').click();
 } else {
  return false;
 }
});

$(document).on('click', '.reply', function() {
  var post_id = $(this).attr('id');
  $('#post_id').val(post_id);
 });

 function load_profile_posts() {
 $.ajax({
  url: "get_profile_posts.php?id=<?php echo $_GET['id']; ?>",
  method: 'GET',
  beforeSend: function() {
   $('.wrapper').show();
  },
  success: function(data) {
   $('.wrapper').hide();
   $('#display_profile_posts').html(data);
  }
 });
}

load_profile_posts();

</script>

  </body>
</html>