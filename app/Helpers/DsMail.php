<?php

namespace App\Helpers;

use App\Models\Mailings;
use Ds\Foundations\Config\Env;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class DsMail
{
    private PHPMailer $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        //Server settings
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
    }

    public function sendMail($email, $recipent, $subject, $content, $cc = null, $attachment = null)
    {
        $mailData = [
            'recipent' => $email,
            'subject' => $subject,
            'cc' => $cc,
            'attachment' => $attachment,
            'message' => $content,
        ];
        if (Env::get('STATUS') == 'development') {
            echo $content;
            $mailData['is_sent'] = 1;
            Mailings::save($mailData);
            return;
        }
        try {
            $this->mail->Host = 'mail.velanim.com'; //Set the SMTP server to send through
            $this->mail->SMTPAuth = true; //Enable SMTP authentication
            $this->mail->Username = 'cs@velanim.com'; //SMTP username
            $this->mail->Password = 'Influencery@123'; //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
            $this->mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $this->mail->setFrom('cd@velanim.com', 'Influencery Admin');
            $this->mail->addAddress($email, $recipent);

            //Content
            $this->mail->isHTML(true); //Set email format to HTML
            $this->mail->Subject = $subject; //'Register Influencery Account Successfully';
            $this->mail->Body = $content;

            $this->mail->send();
            $mailData['is_sent'] = 1;
            Mailings::save($mailData);
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            Mailings::save($mailData);
            return false;
        }
    }
}
