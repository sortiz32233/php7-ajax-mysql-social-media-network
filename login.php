<?php

include("connect.php");

use PHPMailer\PHPMailer\PHPMailer;
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/Exception.php";

if (isset($_POST['login'])) {
    $email           = $_POST['email'];
    $passwordAttempt = $_POST['password'];
    $sql             = "SELECT * FROM tbl_users WHERE email = :email";
    $statement       = $connect->prepare($sql);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row      = $statement->fetch(PDO::FETCH_ASSOC);
    $password = $row['password'];
    $_SESSION['email'] = $row['email'];
    $two_factor_auth = $row['two_factor_auth'];
    $_SESSION['two_factor_auth'] = $row['two_factor_auth'];
    
    if (password_verify($passwordAttempt, $password) && $two_factor_auth == 1) { //2FA On

    $phone    = $row['phone'];
    $carrier  = $row['carrier'];
    $token = str_shuffle("0123456789");
    $token = substr($token, 0, 6);
    $encryptedToken = password_hash($token, PASSWORD_DEFAULT);
    $sql = "UPDATE tbl_users
    SET `two_factor_token` = :token
    WHERE email = :email
    ";
    $statement = $connect->prepare($sql);
    $statement->bindValue(":token", $encryptedToken);
    $statement->bindValue(':email', $email);
    $statement->execute();

        // Conditional switch statement to determine which mail server to use
        switch ($carrier) {
            case att:
                $carrierEmailExtension = "@txt.att.net";
                break;
            case verizon:
                $carrierEmailExtension = "@vtext.com";
                break;
            case sprint:
                $carrierEmailExtension = "@messaging.sprintpcs.com";
                break;
            case tmobile:
                $carrierEmailExtension = "tmomail.net";
                break;
            }
        $sms             = new PHPMailer;
        $sms->Host       = 'mail.example.com;mail.example.com';
        $sms->SMTPAuth   = true;
        $sms->Username   = '';
        $sms->Password   = '';
        $sms->SMTPSecure = 'TLS';
        $sms->Port       = 587;
        $sms->setFrom("donotreply@example.com", "example.com");
        $sms->addAddress($phone . $carrierEmailExtension);
        $sms->isHTML(true);
        $sms->Body = " Your authorization code is " . $token;
        $sms->send();
        exit('success');
    } else if (password_verify($passwordAttempt, $password) && $two_factor_auth == 0) { // 2FA off
        $sub_query = "
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$row['id']."')
        ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['online'] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['login_details_id'] = $connect->lastInsertId();
        exit('successExpress');
    } else {
        exit('error'); // Bad credentials
    }
};
;

if (isset($_POST['resend'])){
    $email = $_SESSION['email'];
    $sql             = "SELECT * FROM tbl_users WHERE email = :email";
    $statement       = $connect->prepare($sql);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row      = $statement->fetch(PDO::FETCH_ASSOC);
    $password = $row['password'];
    $phone    = $row['phone'];
    $carrier  = $row['carrier'];
    $token = str_shuffle("0123456789");
    $token = substr($token, 0, 6);
    $encryptedToken = password_hash($token, PASSWORD_DEFAULT);
    $sql = "UPDATE tbl_users
    SET `two_factor_token` = :token
    WHERE email = :email
    ";
    $statement = $connect->prepare($sql);
    $statement->bindValue(":token", $encryptedToken);
    $statement->bindValue(':email', $email);
    $statement->execute();

        // Conditional switch statement to determine which mail server to use
        switch ($carrier) {
            case att:
                $carrierEmailExtension = "@txt.att.net";
                break;
            case verizon:
                $carrierEmailExtension = "@vtext.com";
                break;
            case sprint:
                $carrierEmailExtension = "@messaging.sprintpcs.com";
                break;
            case tmobile:
                $carrierEmailExtension = "tmomail.net";
                break;
            }
        $sms             = new PHPMailer;
        $sms->Host       = 'mail.example.com;mail.example.com';
        $sms->SMTPAuth   = true;
        $sms->Username   = 'example@example.com';
        $sms->Password   = '';
        $sms->SMTPSecure = 'TLS';
        $sms->Port       = 587;
        $sms->setFrom("donotreply@example.com", " Robot Anthony");
        $sms->addAddress($phone . $carrierEmailExtension);
        $sms->isHTML(false);
        $sms->Body = " Your authorization code is " . $token;
        $sms->send();
        exit('success');
    } else {
        exit('error');
    }