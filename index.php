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
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-160782029-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-160782029-1');
</script>

  </head>

  <body>

  <!-- COVER -->
  <div class="index-wrapper">
  <div class="login-cover">
  
<div class="login-cover-text" style="text-shadow: none;">
  <h1 class="font-weight-lighter">social network</h1>
  <h4 class='font-weight-lighter'><a class="get-started" href='signup.php'><span style="text-shadow: 2px 2px 10px #fff;">new user?</span> click here to get started</a></h4>
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
      <h3 class="font-weight-lighter">sign in</h3>
     </div>
     <div class="card-body">
     <form id="login_form" method="POST" action="login.php">
       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
        <input type="text" class="form-control" id="login_email" placeholder="email" />
       </div>
       <div class="input-group form-group">
        <div class="input-group-prepend">
         <span class="input-group-text"><i class="fas fa-key"></i></span>
        </div>
        <input type="password" class="form-control" id="login_password" placeholder="password" />
       </div>
       <div class="form-group">
         
        <button type="submit" class="btn float-right btn-outline-light" />login</button>
        <h6 id="login_message" class="position-absolute"></h6>

       </div>
      </form>
     </div>
     <div class="card-footer">
      <div class="d-flex justify-content-center text-white">
       Don't have an account?&nbsp;<a href="signup.php">Sign Up</a>
      </div>
      <div class="d-flex justify-content-center">
       <!-- <a href="#">Forgot your password?</a> -->
</div>
</div>
    </main>


    <footer class="fixed-bottom text-center py-3">
<small>&copy; <?php echo date('Y');?> Anthony Umbriac</small>
</footer>

    <!-- 2FA -->
    <div class="modal fade" id="twoFactorModal" tabindex="-1" role="dialog" aria-labelledby="Create New Post" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center pb-3">
    <div class="container">
    <div class="modal-body">
    <h4 class="mb-3 text-white">Enter 6-digit code</h4>
      <input class="two-factor-input" maxlength="1" pattern="[\d]*" tabindex="1" placeholder="·" autocomplete="off" name="chars[1]">
      <input class="two-factor-input" maxlength="1" pattern="[\d]*" tabindex="2" placeholder="·" autocomplete="off" name="chars[2]">
      <input class="two-factor-input" maxlength="1" pattern="[\d]*" tabindex="3" placeholder="·" autocomplete="off" name="chars[3]">
      <input class="two-factor-input" maxlength="1" pattern="[\d]*" tabindex="4" placeholder="·" autocomplete="off" name="chars[4]">
      <input class="two-factor-input" maxlength="1" pattern="[\d]*" tabindex="5" placeholder="·" autocomplete="off" name="chars[5]">
      <input class="two-factor-input" maxlength="1" pattern="[\d]*" tabindex="6" placeholder="·" autocomplete="off" name="chars[6]">
    </div>
    <form id="two-factor-form" method="POST" action="secure.php">
    <input type="hidden" id="two-factor-token">
    <button id="two-factor-verify" class="text-primary text-center btn" type="submit">Verify</button><br>
    <small style="cursor:pointer;color:#fff" id="resend">Didn't receive a code? Click here to resend</small>
  </form>
</div>
    </div>

    <!-- 2FA -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/77115c99a1.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script>
    $(function(){
      $("#login_email").focus();
    })
    </script>
  </body>
</html>