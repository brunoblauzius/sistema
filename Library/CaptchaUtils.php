<?php

require_once("Captcha/controller/CaptchaController.php");

class CaptchaUtils extends CaptchaController{

    public function __construct() {}

    /**
     * Exibe Captcha
     */
    public function displayAction() {
        try{
            return parent::displayAction();
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public function getValue() {
        try{
            return parent::getValue();
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

}


