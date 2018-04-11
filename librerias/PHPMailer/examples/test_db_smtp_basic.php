<html>
<head>
<title>PHPMailer - MySQL Database - SMTP basic test with authentication</title>
</head>
<body>
<h1>asvdhjavsdjhs</h1>
<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

require_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail                = new PHPMailer();

$body = "akjsbdjabsjkdbkjasd";

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host          = "smtp.gmail.com";
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtp.gmail.com"; // sets the SMTP server
$mail->Port          = 465;                    // set the SMTP port for the GMAIL server
$mail->Username      = "rl.juan666@gmail.com"; // SMTP account username
$mail->Password      = "nagaikishitehanei";        // SMTP account password
$mail->SetFrom('rl.juan666@gmail.com', 'List manager');
$mail->AddReplyTo('lrl.juan666@gmail.com', 'List manager');

$mail->Subject       = "PHPMailer Test Subject via smtp, basic with authentication";



  $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
  $mail->MsgHTML($body);
  $mail->AddAddress('rl.juan666@gmail.com');

  if(!$mail->Send()) {
    echo "Mailer Error (". $mail->ErrorInfo . '<br />';
  } else {
    echo "Message sent to :JUAN";
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();

?>

</body>
</html>
