<?php

include("connect.php");

$id = $_SESSION['id'];

if (isset($_POST['updatePersonalInfo'])) {
  $relationshipStatus = $_POST['relationship_status'];
  $occupation = trim($_POST['occupation']);
  $hometown = trim($_POST['hometown']);
  $almaMater = trim($_POST['alma_mater']);
  $sql = "UPDATE tbl_users SET 
  relationship_status = :relationship_status,
  occupation = :occupation,
  hometown = :hometown,
  alma_mater = :alma_mater
  WHERE id=:id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->bindValue(':relationship_status', $relationshipStatus);
  $statement->bindValue(':occupation', $occupation);
  $statement->bindValue(':hometown', $hometown);
  $statement->bindValue(':alma_mater', $almaMater);
  if ($statement->execute()){
    exit('success');
  } else {
    exit('error');
  }
}

if (isset($_POST['updateAbout'])) {
  $about = trim($_POST['about']);
  $sql = "UPDATE tbl_users SET 
  about = :about
  WHERE id=:id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->bindValue(':about', $about);
  if ($statement->execute()){
    exit('success');
  } else {
    exit('error');
  }
}

if (isset($_POST['updateHero'])) {
  $hero = trim($_POST['hero']);
  $heroQuote = trim($_POST['hero_quote']);

  $sql = "UPDATE tbl_users SET 
  hero = :hero,
  hero_quote = :hero_quote
  WHERE id=:id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->bindValue(':hero', $hero);
  $statement->bindValue(':hero_quote', $heroQuote);
  if ($statement->execute()){
    exit('success');
  } else {
    exit('error');
  }
}


if (isset($_POST['privacyUpdate'])){
  $id = $_SESSION['id'];
  $privacy = $_POST['privacy'];
  $sql = "UPDATE tbl_users SET `privacy` = :privacy WHERE `id` = :id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':privacy', $privacy);
  $statement->bindValue(':id', $id);
  if ($statement->execute()){
    exit('success');
  } else {
    exit('error');
  }
};


if (isset($_POST['updatePassword'])) {
  $newPassword = $_POST['new_password']; 
  $currentPassword = $_POST['current_password']; 

  $sql             = "SELECT * FROM tbl_users WHERE id = :id";
  $statement       = $connect->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $row      = $statement->fetch(PDO::FETCH_ASSOC);
  $dbPassword = $row['password'];
  if (password_verify($currentPassword, $dbPassword)) {
  $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
  $sql = "UPDATE tbl_users SET password = :password WHERE id = :id";
  $statement = $connect->prepare($sql);
  $statement->bindValue(':password', $passwordHash);
  $statement->bindValue(':id', $id);
  if ($statement->execute()) {
    exit('success');
  } else {
    exit('error');
  }
  }
}



if (isset($_POST['update'])){
  $location = $_POST['location'];
  $bio = $_POST['bio'];
  $about = $_POST['about'];
  $phone = $_POST['phone'];
  $carrier = $_POST['carrier'];
  $relationshipStatus = $_POST['relationship_status'];
  $occupation = $_POST['occupation'];
  $hometown = $_POST['hometown'];
  $almaMater = $_POST['alma_mater'];
  $hero = $_POST['hero'];
  $heroQuote = $_POST['hero_quote'];
  $returningUser = $_POST['returning_user'];


  $data = [
    'id' => $id,
    'location' => $location,
    'bio' => $bio,
    'about' => $about,
    'phone' => $phone,
    'carrier' => $carrier,
    'relationship_status' => $relationshipStatus,
    'occupation' => $occupation,
    'hometown' => $hometown,
    'alma_mater' => $almaMater,
    'hero' => $hero,
    'hero_quote' => $heroQuote,
    'returning_user' => $returningUser
];


$sql = "UPDATE tbl_users SET 
location = :location,
bio = :bio,
about = :about,
phone = :phone,
carrier = :carrier,
relationship_status = :relationship_status,
occupation = :occupation,
hometown = :hometown,
alma_mater = :alma_mater,
hero = :hero,
hero_quote = :hero_quote,
returning_user = :returning_user
WHERE id=:id";

$statement= $connect->prepare($sql);
if ($statement->execute($data)){
  exit('success');
} else {
  exit('error');
}
// }
}

?>

