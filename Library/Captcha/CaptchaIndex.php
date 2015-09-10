<?php

/*
	Exemplo simples de uso
*/

//include_once "controller/CaptchaController.php";


class CaptchaIndex{
    
    public $captcha;
    
    public function __construct() {
        $this->captcha = new CaptchaController();
    }
    
    public function displayAction (){
        return  $this->captcha->displayAction();
    }
    
    public function getValue(){
        return $this->captcha->getValue();
    }
    
    
}
?>