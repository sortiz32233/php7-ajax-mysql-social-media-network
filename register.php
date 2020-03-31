<?php
    include("connect.php");

    if (isset($_POST['register'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $ip = $_SERVER['REMOTE_ADDR'];
        // $phone = $_POST['phone'];
        // $phoneNumber = preg_replace("/[^0-9]/", '', $phone);
        $password = $_POST['password'];
        $sql = "SELECT COUNT(email) AS num 
        FROM tbl_users WHERE email = :email";
        $statement = $connect->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row['num'] > 0) {
            exit('userExists');
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_users
        (`name`, `email`, `profile`, `cover`, `hero_pic`, `password`, `ip`, `created_on`)
        VALUES
        (:name, :email, 'default_avatar.png', 'default_cover.jpg', 'default_hero.png', :password, :ip, NOW())
        ";
        $statement = $connect->prepare($sql);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':ip', $ip);
        $statement->bindValue(':password', $passwordHash);
        $result = $statement->execute();
        if ($result){
            exit('success');
        } else {
            exit('error');
        }
    }
    

