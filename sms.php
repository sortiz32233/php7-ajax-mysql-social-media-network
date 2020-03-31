<?php

// Include connect.php for database connection
include_once("connect.php");

// Include required dependencies
use PHPMailer\PHPMailer\PHPMailer;
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/Exception.php";

// When the variable 'sms' from the Ajax call has a value (isset), the below code block is executed
if (isset($_POST['sms'])) {
  // !empty ensures that no information gets sent to the server with no value
  // trim() strips whitespace/other characters from the beginning and end of strings
  // The below ternary operator checks if any of the fields are empty
  $name = !empty($_POST['name']) ? trim($_POST['name']) : null;
  $recipientNumber = !empty($_POST['recipient_number']) ? trim($_POST['recipient_number']) : null;
  $senderNumber = !empty($_POST['sender_number']) ? trim($_POST['sender_number']) : null;
  $carrier = !empty($_POST['carrier']) ? $_POST['carrier'] : null;
  $message = !empty($_POST['message']) ? trim($_POST['message']) : null;
  $ip = $_SERVER['REMOTE_ADDR']; // Get the IP of the user
  // Conditional switch statement to determine which mail server to use
  switch($carrier){
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
  };
  # IMPORTANT: PHPMailer will not work on a local server
  $sms = new PHPMailer; // Creates a new mailer object from the PHPMailer libary
  $sms->Host = 'mail.example.com;mail.example.com'; // Specifies the main and backup SMTP email servers
  $sms->SMTPAuth = true; // Enables SMTP authentication
  $sms->Username = ''; // Your SMTP username
  $sms->Password = ''; // Your SMTP password
  $sms->SMTPSecure = 'TLS'; // Enables TLS/SSL encryption; TLS is preferred
  $sms->Port = 587; // Connects to the default TCP port - when used with TLS encryption, it meets IETF (Internet Engineering Task Force) standards for security
  $sms->setFrom($senderNumber.$carrierEmailExtension, $name); // Sender phone number concatenated with the appropriate email carrier extension and name
  // Concatenate each $recipientNumber variable with all major cellular providers
  $sms->addAddress($recipientNumber."@txt.att.net");
  $sms->addAddress($recipientNumber."@vtext.com");
  $sms->addAddress($recipientNumber."@messaging.sprintpcs.com");
  $sms->addAddress($recipientNumber."@tmomail.net");
  $sms->isHTML(false); // Prevents HTML
  $sms->Body = $message; // The body of the SMS equals the input from the $message variable above
  $sms->send(); // Send the SMS

  // The $sql variable holds the SQL statement to prepare for entry into the database
  // IMPORTANT: Ensure that the column names match the columns in your database (name, number, etc)
  // On the contrary, (:name, :number, etc) are placeholders - they don't mean anything until bindValue() binds them to variables (see below)
  $sql = 
  "INSERT INTO sms 
  (name, recipient_number, sender_number, carrier, message, ip) 
  VALUES 
  (:name, :recipient_number, :sender_number, :carrier, :message, :ip)";
  // Connect to the database and prepare the SQL statement for execution 
  $statement = $connect->prepare($sql);
  // Bind each variable to their respective placeholder
  $statement->bindValue(':name', $name);
  $statement->bindValue(':recipient_number', $recipientNumber);
  $statement->bindValue(':sender_number', $senderNumber);
  $statement->bindValue(':carrier', $carrier);
  $statement->bindValue(':message', $message);
  $statement->bindValue(':ip', $ip);

  // Execute the prepared SQL statement and store the data in the database
  if ($statement->execute()) {
    exit('success'); // Success response from server returned to Ajax
  } else {
    exit('error'); // Error response from server returned to Ajax
  }
}

?>