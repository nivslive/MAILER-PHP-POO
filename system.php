<?php

require "Mailer.php";
use PHPMailer\PHPMailer\PHPMailer as Mailer;


class Mensagem{
    
    private $for = null;
    private $subject = null;
    private $msg = null;
    public $status = array('status_code' => null, 'status_description' => null);




    public function __get($attr){
            return $this->$attr;
    }


    public function __set($attr, $value) {
        $this->$attr = $value;

    }

    public function validateMsg(){
        if (empty($this->for) || empty($this->subject) || empty($this->msg)){
            return false;
        }
        return true;
    }
}



$msg = new Mensagem();

$msg->__set('for', $_POST['for']);
$msg->__set('subject', $_POST['subject']);
$msg->__set('msg', $_POST['for']);
$data = $msg->__get();





if(!$msg->validateMsg()) {
        echo "Mensagem invalida.";
        header('Location: index.php');
        die();
    }
    else
    {
    try{    $mail  = new Mail();
  //Server settings
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'user@example.com';                     //SMTP username
  $mail->Password   = 'secret';                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
  $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  //Recipients
  $mail->setFrom('nivsoficial@gmail.com', 'Mailer');
  $mail->addAddress($data('for'), 'Joe User');     //Add a recipient
  $mail->addAddress('ellen@example.com');               //Name is optional
  $mail->addReplyTo('nivsoficial@gmail.com', 'Information');
  //$mail->addCC('cc@example.com');
  //$mail->addBCC('bcc@example.com');

  //Attachments
  //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
  //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = $data('subject');
  $mail->Body    = $data('msg');
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  $mail->send();
  $msg->status['status_code'] = 1;
  $msg->status['status_description'] = "Email enviado com sucesso!";
  echo 'Email enviado com sucesso';
} 
    catch (Exception $e) {
        $msg->status['status_code'] = 2;
        $msg->status['status_description'] = "Email falhou ao ser enviado!";
  echo $mail->ErrorInfo;
}
        
    }

    ?>

    <html>
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>



    
    <body>

    <div class="container">  

    <div class="py-3 text-center">
        <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
        <h2>Send Mail</h2>
        <p class="lead">Seu app de envio de e-mails particular!</p>
    </div>
<div class="row">

<div class="col-md-12">



<?php if($msg->status['status_code'] == 1 ) {
    ?>

<div class="container">
    <h1 class="display-4 text-success"> Sucesso! </h1>
    <p> <?php $msg->status['status_description']?> </p> 
 
 
    <?php } ?>



    <?php if($msg->status['status_code'] == 2 ) {
    ?>

<div class="container">
    <h1 class="display-4 text-success"> Sucesso! </h1>
    <p> <?php $msg->status['status_description']?> </p> 
 
 
    <?php } ?>

</div>
</div>
    </body>

    </html>