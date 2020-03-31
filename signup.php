<?php
include("connect.php");
if (isset($_SESSION["online"])) {
  echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
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
  <div class="registration-wrapper">
  <div class="registration-cover">
  
<div class="login-cover-text" style="text-shadow: none;">
  <h1 class="font-weight-lighter">social network</h1>
  <h4 class='font-weight-lighter'><a class="get-started" href='index.php'>click here to login</a></h4>
</div>
  <div class='logo-photo-container'>
   <img class='logo-photo shadow-lg' src="images/world3.jpg" style="border-radius: 50%;">
      </div>
</div>

<!-- END COVER -->
<main>




<div class="container">
        <div class="card login-form-container shadow-lg">
     <div class="card-header border-0">
      <h3 class="font-weight-lighter">sign up</h3>
     </div>
     <div class="card-body">
     <form id="register_form" method="POST" action="register.php">
     <div class="input-group form-group">
     <div class="input-group-prepend">
     <span class="input-group-text"><i class="fas fa-user"></i></span>
     </div>
     <input name="name" type="text" id="name" class="form-control" placeholder="first and last name" autocomplete="off">
  </div>


       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
        <input type="email" class="form-control" id="email" placeholder="email" />
       </div>


       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-key"></i></span>
        </div>
        <input type="password" class="form-control" id="password" placeholder="password" />
       </div>


       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-key"></i></span>
        </div>
        <input type="password" class="form-control" id="confirm_password" placeholder="confirm password" />
       </div>
       <div class="form-group">
       <button id="register_button" type="submit" class="btn btn-outline-light float-right">register</button>

        <div id="register_message" class="position-absolute text-white"><sup><i class="fas fa-lock"></i></sup> password must include 1 uppercase character, 1 lowercase character, 1 number, 1 special character, and be 7 characters long</div>

       </div>
      </form>
     </div>
     <div class="card-footer pb-4 mt-4">
      <div class="d-flex justify-content-center text-white">
       Already have an account?&nbsp;<a href="index.php">Login</a>
      </div>

</div>
    </main>
    <footer class="fixed-bottom text-center py-3">
<small>&copy; <?php echo date('Y');?> Anthony Umbriac</small>
</footer>

    <!-- 2FA -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/77115c99a1.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
  </body>
</html>