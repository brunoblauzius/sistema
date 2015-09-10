<?php

/*
	Exemplo simples de uso
*/


include_once getcwd()."/controller/CaptchaController.php";

$cc = new CaptchaController();
$cc->displayAction();

// Para escutar o captcha
// $cc->audioPlayAction();

?>