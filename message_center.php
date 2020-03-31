<?php 
  include("connect.php");
  include("modals.php");
  if ($_SESSION["online"] != true) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}

//GETCITY
  // $ip = $_SERVER['REMOTE_ADDR']; $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json")); 
  // $city = $details->city;



  $sql = "SELECT * FROM tbl_users ORDER BY id DESC";
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $id = $_SESSION['id'];
  foreach($result as $row){
    $output .= '
    <aside class="rounded text-white shadow" style="padding: .25rem; margin-top: 1rem; background: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,.5)), url(covers/'.$row['cover'].') no-repeat;">
      <div class="float-left"><img class="profile-rounded-sm pic'.$row['id'].'" id="'.$row['id'].'" src="profile_pics/'.$row['profile'].'" /></div>
      <a class="text-white" href="profile.php?id='.$row['id'].'">'.$row['name'].'</a>
      <br><small>'.$row['location'].'</small>
      <div style="position:absolute; right: 20px; transform:translate(-.75rem, -2.5rem);"><i class="fas fa-user-plus"></i></div>
    </aside>
    '
    ;
  }

  if (isset($_POST['two_factor'])){
    $email = $_SESSION['email'];
    $two_factor_auth = $_POST['two_factor_auth'];
    $sql = "UPDATE tbl_users SET `two_factor_auth` = :two_factor_auth WHERE `email` = :email";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':two_factor_auth', $two_factor_auth);
    $statement->bindValue(':email', $email);
    if ($statement->execute()){
      exit('success');
    } else {
      exit('error');
    }
  };

  if ($_SESSION['two_factor_auth'] == 1) {
    $checked = "checked";
  } else {
    $checked = "";
  }


  $email = $_SESSION['email'];
  $sql = "SELECT * FROM tbl_users WHERE email = :email";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $row      = $statement->fetch(PDO::FETCH_ASSOC);
  $profile  = $row['profile'];
  $name = $row['name'];
  $cover = $row['cover'];
  $location = $row['location'];
  $bio = $row['bio'];
  


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
  </head>


  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a href="dashboard.php"><i class="fas fa-lg fa-arrow-left text-white"></i></a>
    <ul class="navbar-nav ml-auto d-flex flex-row">

      <!-- PROFILE DROPDOWN -->
      <small class="all_unseen_messages"></small>

    <div class="btn-group">    
  <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <img id="avatar" class="profile-rounded-sm pic<?php echo $row['id']; ?>'" src="profile_pics/<?php echo $profile; ?>">
</a>
<div class="dropdown-menu position-absolute dropdown-menu-right">
<h6 class="dropdown-header text-uppercase"><?php echo $name; ?></h6>
<div class="dropdown-divider"></div>

<a class="dropdown-item" href="dashboard.php"><i class="fas fa-home"></i>&ensp;Home</a>

<a class="dropdown-item" href="setup.php"><i class="fas fa-cog"></i>&ensp;Settings</a>
    <button class="dropdown-item" id="logout" type="button"><i class="fas fa-sign-out-alt"></i>&ensp;Logout</button>
  </div>
</div>
    </ul>
  </nav>





  <body style="height: 100vh !important;">

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
  

  
</div>
<div class="cover-text">
<h4><a class="text-white" href="profile.php?id=<?php echo $id;?>"><?php echo $name; ?></a></h4>
<h5 class="font-weight-light"><?php echo $location; ?></h5>
<h6 class="font-weight-light"><?php echo $bio; ?></h6>
</div>
  <div class='profile-photo-container'>
 <img class='profile-photo shadow-lg pic<?php echo $row['id']; ?>' src='profile_pics/<?php echo $row['profile']; ?>'>
</div>
</div>






<!-- END COLUMN 2 -->

<!-- COLUMN 3 -->

        <div class="container" style="transform: translateY(-8rem)">
        <div class="alert alert-light p-3 shadow text-primary font-weight-bold text-uppercase">
        <i class="fas fa-envelope"></i>&ensp;Message Center
</div>

<div class="form-group has-search">
    <span class="fa fa-search form-control-feedback"></span>
    <input type="text" class="form-control" id="search" placeholder="Search users">
  </div>
  </div>
  <div class="container" style="margin-top:-8rem;">
        <div id="user_details"></div>
          <div id="user_model_details"></div>

</div>

<!-- END COLUMN 3 -->

    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/77115c99a1.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/get.js"></script>

  </body>
</html>