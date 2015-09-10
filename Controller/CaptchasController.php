<?php



class CaptchasController{

    public function __construct() {}

    /**
     * Exibe Captcha
     */
    public function displayAction() {
        
        // - Cria, gera randomico
        $captcha = new Captcha();
        $valor_captcha = $captcha->getRandCaptcha();

        // - Guarda na sessao
        //session_start();
        $_SESSION["captcha"] = $valor_captcha;
        session_write_close();

        // - Cria a imagem
        $captcha->createImage();
    }

    /**
     * Executar/Tocar o Audio do Captcha
     */
    public function audioPlayAction() {

        // - Header para abrir audio
        header('Content-type: audio/x-wav');

        // - Busca o valor do captcha da session
        $valor_captcha = $this->getValue();
        
        // - Verifica se existe o valor do captcha
        if (!empty($valor_captcha)) {

            $arr_captcha = array();

            // - Loop transformar a string do captcha em array
            for ($i = 0; $i < strlen($valor_captcha); $i++) {
                $arr_captcha[] = $valor_captcha[$i];
            }

            // - Gera o *.wav
            $captcha = new Captcha();
            echo $captcha->generateWAV($arr_captcha);
        }
    }

    /**
     * Retorna valor do Captcha
     * @return String
     */
    public function getValue() {
        
        //session_start();
        $valor_captcha = $_SESSION["captcha"];
        session_write_close();
        
        return $valor_captcha;
    }
    
	/**
     * Destroi a sess�o do Captcha
     */
    public function destroy(){
        //session_start();
        $_SESSION["captcha"] = null;
        session_write_close();
    }

}


