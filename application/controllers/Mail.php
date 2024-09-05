<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/Exception.php");

require 'vendor/autoload.php';

class Mail extends Main {
	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function index()
	{
        echo "hello";
    }

     public function send()
    {
        $sender         = 'noreply@myrentalstay.com';
        $senderName     = 'MyRentalStay';
        // $recipient = 'nitin.deep2008@gmail.com';
        $recipient      = $_POST['to'];
        $usernameSmtp   = 'AKIASG7JWSISKXOFH3UR';
        $passwordSmtp   = 'BG3DaHwWx2x+EEIcn8tBlemXIezT1gFF8K+xqv1+acvC';
        $host           = 'email-smtp.us-east-1.amazonaws.com';
        $port           = 587;
        $subject        = $_POST['subject'];
        $bodyText       = $_POST['bodyText'];
        $bodyHtml       = $_POST['bodyHtml'];
        $mail           = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->setFrom($sender, $senderName);
            $mail->Username   = $usernameSmtp;
            $mail->Password   = $passwordSmtp;
            $mail->Host       = $host;
            $mail->Port       = $port;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';
            $mail->addAddress($recipient);
            $mail->isHTML(true);
            $mail->Subject    = $subject;
            $mail->Body       = $bodyHtml;
            $mail->AltBody    = $bodyText;
            $mail->Send();
            echo "Email sent!" , PHP_EOL;
        } catch (phpmailerException $e) {
            echo "An error occurred. {$e->errorMessage()}", PHP_EOL; 
        } catch (Exception $e) {
            echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; 
        }
    }
    
    public function sendmail()
    {

        $sender = 'noreply@myrentalstay.com';
        $senderName = 'MyRentalStay';

        // Replace recipient@example.com with a "To" address. If your account
        // is still in the sandbox, this address must be verified.
        // $recipient = 'nitin.deep2008@gmail.com';
        $recipient = 'ankitv4087@gmail.com';

        // Replace smtp_username with your Amazon SES SMTP user name.
        $usernameSmtp = 'AKIASG7JWSISKXOFH3UR';

        // Replace smtp_password with your Amazon SES SMTP password.
        $passwordSmtp = 'BG3DaHwWx2x+EEIcn8tBlemXIezT1gFF8K+xqv1+acvC';

        // Specify a configuration set. If you do not want to use a configuration
        // set, comment or remove the next line.
        //$configurationSet = 'ConfigSet';

        // If you're using Amazon SES in a region other than US West (Oregon),
        // replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
        // endpoint in the appropriate region.
        $host = 'email-smtp.us-east-1.amazonaws.com';
        $port = 587;

        // The subject line of the email
        $subject = 'Amazon SES test (SMTP interface accessed using PHP)';

        // The plain-text body of the email
        $bodyText =  "Email Test\r\nThis email was sent through the
            Amazon SES SMTP interface using the PHPMailer class.";

        // The HTML-formatted body of the email
        $bodyHtml = '<h1>Email Test</h1>
            <p>This email was sent through the
            <a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
            interface using the <a href="https://github.com/PHPMailer/PHPMailer">
            PHPMailer</a> class.</p>';

        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        

        try {
            // Specify the SMTP settings.
            $mail->isSMTP();
            $mail->setFrom($sender, $senderName);
            $mail->Username   = $usernameSmtp;
            $mail->Password   = $passwordSmtp;
            $mail->Host       = $host;
            $mail->Port       = $port;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';
            //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

            // Specify the message recipients.
            $mail->addAddress($recipient);
            // You can also add CC, BCC, and additional To recipients here.

            // Specify the content of the message.
            $mail->isHTML(true);
            $mail->Subject    = $subject;
            $mail->Body       = $bodyHtml;
            $mail->AltBody    = $bodyText;
            $mail->Send();
            echo "Email sent!" , PHP_EOL;
        } catch (phpmailerException $e) {
            echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
        } catch (Exception $e) {
            echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
        }

    }
}
?>
