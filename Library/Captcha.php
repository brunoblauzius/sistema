<?php

class Captcha {

    private $width = 300;
    private $height = 100;
    private $minCaracteres = 6;
    private $maxCaracteres = 6;
    private $randCaptcha;
    private $backgroundColor = array(255, 255, 255); // cor branca
    private $colors = array(array(27, 78, 181), array(22, 163, 35), array(83, 134, 139), array(47, 79, 47), array(0, 0, 0));
    private $shadowColor = null;
    private $lineWidth = 0;
    private $fonts = array('Antykwa' => array('spacing' => 3, 'minSize' => 27, 'maxSize' => 30, 'font' => 'AntykwaBold.ttf'),
        'DingDong' => array('spacing' => 2, 'minSize' => 24, 'maxSize' => 30, 'font' => 'Ding-DongDaddyO.ttf'),
        'Duality' => array('spacing' => 2, 'minSize' => 30, 'maxSize' => 38, 'font' => 'Duality.ttf'),
        'Jura' => array('spacing' => 2, 'minSize' => 28, 'maxSize' => 32, 'font' => 'Jura.ttf'),
        'Times' => array('spacing' => 2, 'minSize' => 28, 'maxSize' => 34, 'font' => 'TimesNewRomanBold.ttf'),
        'VeraSans' => array('spacing' => 1, 'minSize' => 20, 'maxSize' => 28, 'font' => 'VeraSansBold.ttf'),
        'Metamorphous-Regular' => array('spacing' => 1, 'minSize' => 20, 'maxSize' => 28, 'font' => 'Metamorphous-Regular.ttf'),
        'TitanOne-Regular' => array('spacing' => 1, 'minSize' => 20, 'maxSize' => 28, 'font' => 'TitanOne-Regular.ttf')
    );
    private $Yperiod = 10;
    private $Yamplitude = 10;
    private $Xperiod = 11;
    private $Xamplitude = 6;
    private $maxRotation = 3;
    private $scale = 3;
    private $blur = true;
    private $debug = false; // modo debug mostra o caractere gerado no captcha junto com a font usada.
    private $imageFormat = 'jpeg';
    private $im;
    private $audio_path = null;

    /*
     * Verifica se esta vazio ou nulo, caso esteja seta valor.
     * apos setar valor ele define o header da pagina como image e gera o captcha.
     */
    
    public function __construct() {
        $this->audio_path = '/home/criar/public_html/jopacs/View/webroot/audio/';
    }

    public function createImage() {

        $ini = microtime(true);

        $this->imageAllocate();

        $text = $this->randCaptcha;

        if (is_null($text) || empty($text)) {
            $text = $this->getRandCaptcha();
        }

        $fontcfg = $this->fonts[array_rand($this->fonts)];

        $this->writeText($text, $fontcfg);

        $this->randCaptcha = $text;

        if (!empty($this->lineWidth)) {

            $this->WriteLine();
        }

        $this->waveImage();

        if ($this->blur && function_exists('imagefilter')) {

            imagefilter($this->im, IMG_FILTER_GAUSSIAN_BLUR);
        }

        $this->reduceImage();

        if ($this->debug) {

            imagestring($this->im, 1, 1, $this->height - 8, "$text {$fontcfg['font']} " . round((microtime(true) - $ini) * 500) . "ms", $this->GdFgColor);
        }

        $this->writeImage();

        $this->cleanup();
    }

    /**
     * se n�o estiver vazia ela � destroida .
     * seta as cores do background.
     * seta as cores das letras.
     */
    protected function imageAllocate() {

        if (!empty($this->im)) {

            imagedestroy($this->im);
        }

        $this->im = imagecreatetruecolor($this->width * $this->scale, $this->height * $this->scale);


        $this->GdBgColor = imagecolorallocate($this->im, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]
        );

        imagefilledrectangle($this->im, 0, 0, $this->width * $this->scale, $this->height * $this->scale, $this->GdBgColor);


        $color = $this->colors[mt_rand(0, sizeof($this->colors) - 1)];

        $this->GdFgColor = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);

        if (!empty($this->shadowColor) && is_array($this->shadowColor) && sizeof($this->shadowColor) >= 5) {

            $this->GdShadowColor = imagecolorallocate($this->im, $this->shadowColor[0], $this->shadowColor[1], $this->shadowColor[2]
            );
        }
    }

    /**
     * obtem valor do captcha.
     * @return string
     */
    public function getRandCaptcha() {

        $this->randCaptcha = $this->geradorCaptcha();
        return $this->randCaptcha;
    }

    /**
     * Gera o captcha random , podendo ser indicado por parametro a quantidade de caracteres.
     * caso nao for indicado a quantidade o default � 6 caracteres.
     * @param type $length null
     * @return string
     */
    public function geradorCaptcha($length = null) {

        if (empty($length)) {

            $length = rand($this->minCaracteres, $this->maxCaracteres);
        }

        $words = "abcdefghijlmnpqrstvwyz123456789";

        $vocals = "123456789";

        $text = "";

        $vocal = rand(0, 1);

        for ($i = 0; $i < $length; $i++) {

            if ($vocal) {

                $text .= substr($vocals, mt_rand(0, 8), 1);
            } else {

                $text .= substr($words, mt_rand(0, 30), 1);
            }

            $vocal = !$vocal;
        }

        return $text;
    }

    /**
     * L� o texto e adiciona as fontes de modo random.
     * caso esteja sem configura��o de fonte definida ( Vazio ) � setado a nova fonte.
     * setado rota��o.
     * setado cor das letras.
     * setado escala.
     * setado tamanho das letras min e max.
     * seta angulo x e y.
     * 
     * @param type $text string
     * @param type $fontcfg string
     */
    protected function writeText($text, $fontcfg = array()) {

        if (empty($fontcfg)) {

            $fontcfg = $this->fonts[array_rand($this->fonts)];
        }

        $fontfile = '/home/criar/public_html/jopacs/View/webroot/fonts/' . $fontcfg['font'];


        $lettersMissing = $this->maxCaracteres - strlen($text);

        $fontSizefactor = 1 + ($lettersMissing * 0.09);


        $x = 40 * $this->scale;

        $y = round(($this->height * 20 / 30) * $this->scale);

        $length = strlen($text);

        for ($i = 0; $i < $length; $i++) {

            $degree = rand($this->maxRotation * -1, $this->maxRotation);

            $fontsize = rand($fontcfg['minSize'], $fontcfg['maxSize']) * $this->scale * $fontSizefactor;

            $letter = substr($text, $i, 1);



            if ($this->shadowColor) {

                $coords = imagettftext($this->im, $fontsize, $degree, $x + $this->scale, $y + $this->scale, $this->GdShadowColor, $fontfile, $letter);
            }

            $coords = imagettftext($this->im, $fontsize, $degree, $x, $y, $this->GdFgColor, $fontfile, $letter);

            $x += ($coords[2] - $x) + ($fontcfg['spacing'] * $this->scale);
        }

        $this->textFinalX = $x;
    }

    /**
     * seta x e y de cada letra e copia a imagem.
     * 
     */
    protected function waveImage() {


        $xp = $this->scale * $this->Xperiod * rand(1, 3);

        $k = rand(0, 100);

        for ($i = 0; $i < ($this->width * $this->scale); $i++) {

            imagecopy($this->im, $this->im, $i - 1, sin($k + $i / $xp) * ($this->scale * $this->Xamplitude), $i, 0, 1, $this->height * $this->scale);
        }

        $k = rand(0, 100);

        $yp = $this->scale * $this->Yperiod * rand(1, 2);

        for ($i = 0; $i < ($this->height * $this->scale); $i++) {

            imagecopy($this->im, $this->im, sin($k + $i / $yp) * ($this->scale * $this->Yamplitude), $i - 1, 0, $i, $this->width * $this->scale, 1);
        }
    }

    /**
     * redimensiona a imagem.
     */
    protected function reduceImage() {

        $imResampled = imagecreatetruecolor($this->width, $this->height);

        imagecopyresampled($imResampled, $this->im, 0, 0, 0, 0, $this->width, $this->height, $this->width * $this->scale, $this->height * $this->scale);

        imagedestroy($this->im);

        $this->im = $imResampled;
    }

    /**
     * Identifica se a imagem � png , caso nao seja � definido como jpg;
     * seta header conforme o formato identificado.
     */
    protected function writeImage() {

        if ($this->imageFormat == 'png' && function_exists('imagepng')) {

            header("Content-type: image/png");

            imagepng($this->im);
        } else {

            header("Content-type: image/jpeg");

            imagejpeg($this->im, null, 100);
        }
    }

    /**
     * Destroy a imagem criada.
     */
    protected function cleanup() {

        imagedestroy($this->im);
    }

    /**
     * esta fun��o exige parametro $letters como Array<String>.
     * get caminho do audio em $this->filename.
     * abre o arquivo , conforme indicado no param $letters em array .
     * uni os arquivos encontrados .
     * defini o cabe�alho como audio/wave , para for�ar o download do arquivo ou executar no browser.
     * 
     * @param type $letters string
     * @return audio
     */
    public function generateWAV($letters) {
        $first = true;
        $data_len = 0;
        $files = array();
        $out_data = '';

        foreach ($letters as $letter) {
            $filename = $this->audio_path . strtoupper($letter) . '.wav';

            $fp = fopen($filename, 'rb');

            $file = array();

            $data = fread($fp, filesize($filename)); // read file in

            $header = substr($data, 0, 36);
            $body = substr($data, 44);


            $data = unpack('NChunkID/VChunkSize/NFormat/NSubChunk1ID/VSubChunk1Size/vAudioFormat/vNumChannels/VSampleRate/VByteRate/vBlockAlign/vBitsPerSample', $header);

            $file['sub_chunk1_id'] = $data['SubChunk1ID'];
            $file['bits_per_sample'] = $data['BitsPerSample'];
            $file['channels'] = $data['NumChannels'];
            $file['format'] = $data['AudioFormat'];
            $file['sample_rate'] = $data['SampleRate'];
            $file['size'] = $data['ChunkSize'] + 8;
            $file['data'] = $body;

            if (($p = strpos($file['data'], 'LIST')) !== false) {
                // If the LIST data is not at the end of the file, this will probably break your sound file
                $info = substr($file['data'], $p + 4, 8);
                $data = unpack('Vlength/Vjunk', $info);
                $file['data'] = substr($file['data'], 0, $p);
                $file['size'] = $file['size'] - (strlen($file['data']) - $p);
            }

            $files[] = $file;
            $data = null;
            $header = null;
            $body = null;

            $data_len += strlen($file['data']);

            fclose($fp);
        }

        $out_data = '';
        for ($i = 0; $i < sizeof($files); ++$i) {
            if ($i == 0) { // output header
                $out_data .= pack('C4VC8', ord('R'), ord('I'), ord('F'), ord('F'), $data_len + 36, ord('W'), ord('A'), ord('V'), ord('E'), ord('f'), ord('m'), ord('t'), ord(' '));

                $out_data .= pack('VvvVVvv', 16, $files[$i]['format'], $files[$i]['channels'], $files[$i]['sample_rate'], $files[$i]['sample_rate'] * (($files[$i]['bits_per_sample'] * $files[$i]['channels']) / 8), ($files[$i]['bits_per_sample'] * $files[$i]['channels']) / 8, $files[$i]['bits_per_sample']);

                $out_data .= pack('C4', ord('d'), ord('a'), ord('t'), ord('a'));

                $out_data .= pack('V', $data_len);
            }

            $out_data .= $files[$i]['data'];
        }

        return $out_data;
    }

}
