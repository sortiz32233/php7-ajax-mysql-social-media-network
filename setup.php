<?php
include('connect.php');

if ($_SESSION["online"] != true) {
  echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}

$id = $_SESSION['id'];
$sql = "SELECT * FROM tbl_users WHERE id = :id";
$statement = $connect->prepare($sql);
$statement->bindValue(":id", $id);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$name = $row['name'];
$carrier = $row['carrier'];
$two_factor_auth = $row['two_factor_auth'];
$privacy = $row['privacy'];

if ($two_factor_auth == 1) {
$checked = "checked";
} else {
$checked = "";
}

if ($privacy == 1) {
  $privacyCheck = "checked";
  } else {
  $privacyCheck = "";
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
    <title>Social Network</title>
  </head>

  <body>

  <!-- COVER -->
  <div class="setup-wrapper">
  <div class="login-cover" style="background: linear-gradient(
   to bottom,
   rgba(0, 0, 0, 0.1) 0%,
   rgba(255, 255, 255, 1) 100%
  ),
  url(images/mcwayfalls.jpg);">
  

  <div class='logo-photo-container'>
   <img class='logo-photo shadow-lg' src="images/world3.jpg" style="border-radius: 50%;">
      </div>
</div>

<!-- END COVER -->
<main>

<div class="form-container shadow-lg text-white">
  <!-- Tab navigation -->
  <div class="d-none">
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="final-tab" data-toggle="tab" href="#final" role="tab" aria-controls="final" aria-selected="false">Final</a>
  </li>
</ul>
  </div>
<!-- Tab content -->
<div class="tab-content">


<!-- PAGE 1 -->

  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <div class="card-header border-0 pb-0 mb-0">
      <h3 class="font-weight-lighter text-primary pb-0 mb-0">
      <?php 
      
      if ($row['returning_user'] == 1){
      echo strtolower(strtok($row['name'], " ")) . "'s profile";
      } else {
        echo "<span class='text-white'>let's set up your profile</span>";
      }
      
      ?></h3>
      <small class="font-weight-lighter">all information is optional</small>
     </div>
  <div class="card-body pt-1">
     <h5 class="font-weight-lighter text-primary"><a class="settings_profile_upload_button">click to upload profile photo&ensp;<i class="fas fa-camera-retro text-white"></a></i></h5>
     <form id="profile_post_form" action="upload.php" method="POST" enctype="multipart/form-data">
          <input name="profile" type="file" class="custom-file-input d-none" id="settings-profile-input" accept="image/*">
          <label class="custom-file-label d-none" for="image">Upload image</label>
          <input type="hidden" name="size" value="1000000000">
          
        <a class="settings_profile_upload_button"><img id='profile-preview' class="shadow-lg img-fluid" src='profile_pics/<?php echo $row['profile'];?>'></a><br>
      
        <span class="text-white font-weight-lighter">your current profile pic · <a style="color:red;cursor:pointer" id="reset_profile_pic">reset to default</a></span>
</form>


     <h5 class="font-weight-lighter text-primary mt-2">general information</h5>

     <form class="settings_form" method="POST" action="update_info.php">
       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
        </div>
        <input type="text" class="form-control" id="updateLocation" placeholder="location" value="<?php echo $row['location'];?>" />
       </div>
       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fab fa-line"></i></span>
        </div>
        <input type="text" class="form-control" id="updateBio" placeholder="tagline" value="<?php echo $row['bio'];?>" />
       </div>

       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-book"></i></span>
        </div>
        <textarea type="text" class="form-control" id="updateAbout" placeholder="about" style="resize: none" /><?php echo $row['about'];?></textarea>
       </div>
      </form>     
    </div>
  </div>
<!-- END PAGE 1 -->

<!-- PAGE 2 -->
<div class="tab-pane fade" id="cover" role="tabpanel" aria-labelledby="cover-tab">
  <div class="card-body pt-0 mt-0">

     <h5 class="font-weight-lighter text-primary mt-2">personal information</h5>

     <form class="settings_form" method="POST" action="update_info.php">
     <div class="input-group">
  <div style="height:2.5rem !important" class="input-group-prepend">
    <button class="input-group-text" type="button"><i class="fas fa-heart"></i></button>
  </div>
     <select style="height:2.5rem !important" id="updateRelationshipStatus" name="relationship_status" class="form-control mb-3" placeholder="Relationship Status">
          <option value="" selected>relationship status</option>
          <option <?php if ($row['relationship_status'] == 'Single'){echo "selected";}?> value="Single">Single</option>
          <option <?php if ($row['relationship_status'] == 'In A Relationship'){echo "selected";}?> value="In A Relationship">In A Relationship</option>
          <option <?php if ($row['relationship_status'] == 'Married'){echo "selected";}?> value="Married">Married</option>
          </select>
          </div>

       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
        </div>
        <input type="text" class="form-control" id="updateOccupation" placeholder="occupation" value="<?php echo $row['occupation'];?>"/>
       </div>


       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-home"></i></span>
        </div>
        <input type="text" class="form-control" id="updateHometown" placeholder="hometown" value="<?php echo $row['hometown'];?>"/>
       </div>


       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
        </div>
        <input type="text" class="form-control" id="updateAlmaMater" placeholder="alma mater" value="<?php echo $row['alma_mater'];?>"/>
       </div>



       
      </form>     

      <h5 class="font-weight-lighter text-primary"><a style="cursor:pointer" id="cover_upload_button">click to upload cover photo&ensp;<i class="fas fa-camera-retro text-white"></i></a></h5>
     <form id="cover_post_form" action="upload.php" method="POST" enctype="multipart/form-data">
          <input name="cover" type="file" class="custom-file-input d-none" id="cover-input" accept="image/*">
          <label class="custom-file-label d-none" for="image">Upload image</label>
          <input type="hidden" name="size" value="1000000000">

        <img id='cover-preview' class="shadow-lg img-fluid" style="max-height: 10rem; width:100%; object-fit:cover;" src='covers/<?php echo $row['cover'];?>'><br>

        <span class="text-white font-weight-lighter">your current cover · <a style="color:red;cursor:pointer" id="reset_cover">reset to default</a></span> 
</form>
    </div>
  </div>
  <!-- END TAB 2 -->

  <div class="tab-pane fade" id="final" role="tabpanel" aria-labelledby="contact-tab">
  <div class="card-body pt-0 mt-0">
  <h5 class="text-primary font-weight-lighter">account security</h5>

  <div class="custom-control custom-switch font-weight-lighter">
<input type="checkbox" class="custom-control-input" id="privacy" <?php echo $privacyCheck; ?>>
<label id="privacy-label" class="custom-control-label mb-2 text-<?php if ($privacyCheck){echo "primary";}else{echo "muted";}?>" for="privacy">
<?php echo $privacy ? 'your profile is now public&ensp;<i class="fas fa-globe"></i>' : 'your profile is currently set to private' ?></label> <sup>
</div>

<div class="custom-control custom-switch font-weight-lighter">
<input type="checkbox" class="custom-control-input" id="two-factor" <?php echo $checked; ?>>
<label id="two-factor-label" class="custom-control-label mb-2 text-<?php if ($checked){echo "primary";}else{echo "muted";}?>" for="two-factor">
two factor authentication</label> <sup>
<i class="fas fa-question-circle text-light" data-toggle="tooltip" data-placement="top" title="Toggle to enable two factor authentication. Each time you sign in, you will receive a text message with a security token that is required to access the account."></i></sup>
</div>

<?php if ($two_factor_auth == 1) {
$display = 'd-block';
} else {
$display = 'd-none';
}
?>

<div class="two-factor-container <?php echo $display; ?>">

      <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-address-card"></i></span>
        </div>
        <input type="text" class="form-control" id="updatePhone" placeholder="phone number" value="<?php echo $row['phone']; ?>"/>
       </div>

      <div class="input-group">
  <div style="height:2.5rem !important" class="input-group-prepend">
    <button class="input-group-text" type="button"><i class="fas fa-phone"></i></button>
  </div>
      <select style="height:2.5rem !important" id="updateCarrier" name="carrier" class="form-control mb-3" placeholder="Select your carrier">
          <option value="" disabled selected>Select your carrier</option>
          <option <?php if ($row['carrier'] == 'att'){echo "selected";}?> value="att">AT&T (US)</option>
          <option <?php if ($row['carrier'] == 'verizon'){echo "selected";}?> value="verizon">Verizon (US)</option>
          <option <?php if ($row['carrier'] == 'tmobile'){echo "selected";}?> value="tmobile">T-Mobile (US)</option>
          <option <?php if ($row['carrier'] == 'sprint'){echo "selected";}?> value="sprint">Sprint (US)</option>
          </select>
</div>
</div>




<a class="text-decoration-none" data-toggle="collapse" href="#passwordForm">
<h5 class="btn btn-outline-light font-weight-lighter" onclick="this.classList.toggle('border-bottom')"">change password</h5>
</a>
<div class="collapse" id="passwordForm">
<div class="mb-2">

<div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-key"></i></span>
        </div>
        <input type="password" class="form-control" id="currentPassword" placeholder="current password" />
       </div>

       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
        </div>
        <input type="password" class="form-control" id="newPassword" placeholder="new password" />
       </div>
       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
        </div>
        <input type="password" class="form-control" id="newPasswordConfirm" placeholder="confirm new password" />
       </div>
      
      <a id="updatePasswordBtn" class="btn btn-outline-light font-weight-lighter">update password</a>
      <small class="d-block position-absolute" id="update_password_message"></small>
</div>
</div>

      

    </div>

  </div>
  <!-- TAB 3 -->
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  <div class="card-body pt-0 mt-0">
     <h5 class="font-weight-lighter text-primary"><a id="hero_upload_button">click to upload hero photo&ensp;<i class="fas fa-camera-retro text-white"></i></a></h5>
     <form id="hero_post_form" action="upload.php" method="POST" enctype="multipart/form-data">
          <input name="hero" type="file" class="custom-file-input d-none" id="hero-input" accept="image/*">
          <label class="custom-file-label d-none" for="image">Upload image</label>
          <input type="hidden" name="size" value="1000000000">

        <img id='hero-preview' class="shadow-lg img-fluid" src='heros/<?php echo $row['hero_pic'];?>'><br>

        <span class="text-white font-weight-lighter">your current hero · <a style="color:red;cursor:pointer" id="reset_hero">remove</a></span>
</form>


     <h5 class="font-weight-lighter text-primary mt-2">hero information</h5>

     <form class="settings_form" method="POST" action="update_info.php">
       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-mask"></i></span>
        </div>
        <input type="text" class="form-control" id="updateHero" placeholder="hero name" value="<?php echo $row['hero'];?>" />
       </div>
       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-quote-left"></i></span>
        </div>
        <textarea type="text" class="form-control" style="resize:none;" id="updateHeroQuote" placeholder="hero quote"><?php echo $row['hero_quote'];?></textarea>

       </div>
        
      
    </div>

  </div>

  <!-- END TAB 3 -->


    <!-- TAB 4 -->


  <!-- END TAB 4 -->

<!-- Tab carousel -->
<div class="card-footer text-right">
<?php if ($row['returning_user'] == 1) { echo '<a href="dashboard.php" class="btn btn-outline-danger">cancel</a>'; } ?>

<a class="prevtab btn btn-outline-light d-none">previous</a>
<a class="nexttab btn btn-outline-light">continue</a>
<button type="submit" id="final_submit" class="btn float-right btn-outline-light ml-1" />done</button>
</form>   
</div>
</div>
</div>


     
    </main>


</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/77115c99a1.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <!-- <script>
$(document).on("keydown", function(event){
  if (event.keyCode === 27){
    setTimeout(() => {
      window.location = "dashboard.php";
    },500)
  }
})
</script> -->

</html>