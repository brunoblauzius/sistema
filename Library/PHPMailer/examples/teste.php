<?php
/**
 * This example shows making an SMTP connection without using authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require_once '../PHPMailerAutoload.php';


class MailPHPMailer{
    
    public $MAIL = null;
    
    public $emailRemetente = 'noreply@criarsites.cc';
    
    public $nomeRemetente  =  'Sistema';
    
    
    
    public function __construct() {
        //Create a new PHPMailer instance
        $this->MAIL = new PHPMailer();
        //Tell PHPMailer to use SMTP
        $this->MAIL->isSMTP();
        //setando que minha saida é html
        $this->MAIL->isHTML(true); 
        //setando minha linguagem de erro
        $this->MAIL->setLanguage("br", "../language/");
        
        $this->MAIL->CharSet = 'UTF-8';
            
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->MAIL->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $this->MAIL->Debugoutput = 'html';
        //Set the hostname of the mail server
        $this->MAIL->Host = "mail.criarsites.cc";
        //Set the SMTP port number - likely to be 25, 465 or 587
        $this->MAIL->Port = 587;
        //Whether to use SMTP authentication
        $this->MAIL->SMTPAuth = true;
        //Username to use for SMTP authentication
        $this->MAIL->Username = "noreply@criarsites.cc";
        //Password to use for SMTP authentication
        $this->MAIL->Password = "asx1998";
    }
    
    public function setRemetente( $email = null, $nome = null) {
        if( !empty($email) && !empty($nome)){
            $this->emailRemetente = $email;
            $this->nomeRemetente  = $nome;
        }
        $this->MAIL->setFrom( $this->emailRemetente, $this->nomeRemetente );
    }
    
    
    public function setDestinatario($email, $nome ) {
        $this->MAIL->addAddress($email, $nome);
    }
    
    public function setReplayTo($email, $nome ) {
        $this->MAIL->addReplyTo($email, $nome);
    }
    
    public function setAssunto($assunto) {
        $this->MAIL->Subject = $assunto;
    }
    
    public function setBody($corpo) {
        $this->MAIL->Body = $corpo;
    }
    
    public function sendMail() {
        if (!$this->MAIL->send()) {
            echo "Mailer Error: " . $this->MAIL->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
    
}

$objeto = new MailPHPMailer();
$objeto->setAssunto('É o teste OOP');
$objeto->setRemetente();
$objeto->setDestinatario('bruno_newstudio@hotmail.com', 'Bruno Blauzius');
$objeto->setBody('<b>Ok foi o e-mail é um sucesso</b>');
$objeto->sendMail();