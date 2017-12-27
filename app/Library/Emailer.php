<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/26
 * Time: 下午5:14
 */

namespace App\Library;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Phalcon\Di AS PhalconDi;

class Emailer
{
    protected $email;

    public function __construct()
    {
        $config = PhalconDi::getDefault()->get('commonConfig')->aliyun_mail;
        $this->email = new PHPMailer(true);
        $this->email->SMTPDebug = 2;                                 // Enable verbose debug output
        $this->email->isSMTP();
        $this->email->Host = $config->host;
        $this->email->SMTPAuth = false;
        $this->email->Username = $config->username;
        $this->email->Password = $config->password;
        //$this->email->SMTPSecure = 'ssl';
        $this->email->Port = $config->port;
    }

    public static function sendSinge()
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {

            //Recipients
            $mail->setFrom('phalcon@email.fastgoo.net', 'Mailer');
            $mail->addAddress('15600087538@163.com', 'Joe User');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            var_dump($mail->send());
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public function sendBatch()
    {

    }

}