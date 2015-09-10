<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



class Image {
    
    /** @var String */
    public $pathBanner = 'View/webroot/img/banner/';
    /** @var String */
    public $pathNoticias = 'View/webroot/img/noticias/';
 
    /**
     * @todo Variavel para se feito a verificaÃ§Ã£o de tipo de imagem com ER
     * @var String 
     */
    public $tipoPermitido = '/(.jpeg|.jpg|.png)/';
    
    /**
     * @todo caminho das thumbs Cropadas
     * @var String 
     */
    public $imageThumb = 'img/users/thumb/'; 
    
    /**
     * @todo Caminho da imagens redimencionadas
     * @var String 
     */
    public $image      = 'img/users/'; 
    
    /**
     * @todo tamanho de envio permitido
     * @var int
     */
    public $tamanhoPermitido = 8500000;//5,5MB max
    
    
    /**
     *  @todo antigo nome da imagem
     * @var null 
     */
    public $oldName  = null;
    
    /**
     * @todo tmp da imagem em execuÃ§Ã£o
     * @var type 
     */
    public $tmp_name   = null;
    
    public $oldTamanho = null;
    
    private $newNome    = null;
    
    private $altura = null, $largura = null;
    
    public $caminhoCarro = 'img/upload/carro';


    /**
     * 
     * @param array $imagem
     * @return array
     * @throws Exception
     */
    public function moveUploadFile( array $imagem = null, $nomePasta = 'banner', $sistema = 'app' ) {
        try{
            
            $caminhoImagem = null;
            
            if( $nomePasta == 'banner') {
                $caminhoImagem = $this->pathBanner;
            } else {
                $caminhoImagem = $this->pathNoticias;
            }
            
            if( !empty($imagem)){
                $this->newNome = $sistema.'_'.md5(mt_rand()).'.jpeg';

                if( move_uploaded_file( $imagem['tmp_name'], $caminhoImagem . $this->newNome ) ) {
                    return $this->newNome;
                } else {
                    throw new Exception('Imagem não pode ser enviada ao servidor');
                }
                
            } else {
                throw new Exception('Imagem está vázia');
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    
    /**
     * @todo Description validação de tipo da
     * @param  array $fileImagem
     * @return boolean
     * @throws type
     * @throws Exception
     */
    public function validaImagem( $fileImagem = null ){
        try {
            
            if( $fileImagem['error'] == UPLOAD_ERR_INI_SIZE ) {
                throw new Exception( json_encode( array( 'imagem' => Enum::MAX_FILE_SIZE ) ) );
            } else if( $fileImagem['error'] == UPLOAD_ERR_FORM_SIZE ) {
                throw new Exception( json_encode( array( 'imagem' => Enum::LIMIT_IMAGE_MAXFILESIZE ) ) );
            } else if( $fileImagem['error'] == UPLOAD_ERR_PARTIAL ) {
                throw new Exception( json_encode( array( 'imagem' => Enum::IMAGEM_NULL ) ) );
            }else if ( !preg_match($this->tipoPermitido, $fileImagem['name']) ){
                throw new Exception( json_encode( array( 'imagem' => Enum::IMAGE_TIPO_NEGADO ) ) );
            }
            
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
    
    /**
     * @todo Description tamanho para a imagem no sistema
     * @param type array $fileImagem
     * @param type integer $tamanho
     * @return boolean 1/0
     * @throws Exception
     */
    public function tamanhoPermitido( $fileImagem = NULL ){
        try{
            if( $fileImagem['size'] > $this->tamanhoPermitido ){
                throw new Exception( json_encode( array( 'imagem' => Enum::IMAGEM_SIZE_NEGADO ) ) );
            }
            return TRUE;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    

    /**
     * @todo metodo usado para descobrir o tipo de arquivo que esta sendo enviado ja verificando se 
     * Ã© do tipo aceito ou nÃ£o
     * @return string
     */
    public function tipoImagem( $name = null ){
        try{
            if( !is_null($name)) {
                $this->oldName = $name;
            }
            
            if( preg_match($this->tipoPermitido, $this->oldName, $matches) ){
                return $matches[0];
            } else {
                throw new Exception( 'Tipo de arquivo não é aceito, formatos aceitos .jpg, .jpeg, .png' );
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        
    }
    
    /**
     * @version 1.0
     * @todo metodo aonde eu faço o calculo do tamanho da minha imagem
     */
    public function calculaNovoTamanho( $tipo, $alturaSaida, $larguraSaida ){
            
            if( $tipo === '.png') {
                $img = imagecreatefrompng($this->tmp_name);
            } else {
                $img = imagecreatefromjpeg($this->tmp_name);
            }
            
            //altura e largura originais da minha imagem
            $largura = imagesx($img);
            $altura = imagesy($img);
            
            //verifico a largura da minha imagem é maior do que eu estou solicitando
            $this->largura = ( $largura > $larguraSaida ) ? $larguraSaida : $largura ;
            //faço o calculo da porcentagem da largura
            $alturaPorcentagem = ( $larguraSaida / $largura ) * 100;
            //calculo a porcentagem da altura
            $this->altura  = round( ( $altura * $alturaPorcentagem )  / 100 );
             
            
            imagedestroy($img);
    }
    
    public function limitesPermitidoImagem( $altura, $largura, $tipo, $tmp){
        try{
            if( $tipo === '.png') {
                $img = imagecreatefrompng($tmp);
            } else {
                $img = imagecreatefromjpeg($tmp);
            }
            
            $x = imagesx($img);
            $y = imagesy($img);
            
            if( $x > $largura ) {
                throw new Exception(json_encode(array('imagem' => Enum::IMAGEM_LARGURA_NAO_PERMITIDA)));
            }
            if( $y > $altura ) {
                throw new Exception(json_encode(array('imagem' => Enum::IMAGEM_ALTURA_NAO_PERMITIDA)));
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    public function isNull( $file ){
        try{
            if( !is_array($file) || empty($file)) {
                throw new Exception(json_encode(array('imagem' => Enum::IMAGEM_NULL)));
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    /**
     * @version 1.1
     * @todo metodo aonde crio minhas pastas no sistema 
     * @param type $minhaPasta
     */
    public function createDir( $minhaPasta ) {
        if( !file_exists($this->image) ) {
            mkdir($this->image);
            mkdir($this->imageThumb);
        }
        $pathname = $this->image . $minhaPasta . DS ;
        if( !file_exists($pathname) ) {
//          mkdir($this->image);
//          mkdir($this->imageThumb);
            mkdir($pathname); 
        }
        
    }
    

    
    /**
     * @todo metodo de saida do nome da imagem para gravar no banco de dados
     * @version 1.1
     * @return string
     */
    public function getNewNome(){
        return $this->newNome;
    }
    
    public function verificaRestricao( $altura, $largura ){
        if( $altura > 200 || $largura > 200){
            return true;
        }

        return false;
        
    }

    /**
     * @todo metodo que exclui minha imagem do servidor
     * @param type $image
     * @return type
     * @throws Exception
     */
    public function delImage( $image , $pasta ){
        try{
                        
            if( !is_null($image) ) {
                if( unlink( $this->caminhoCarro . '/' . $pasta . '/' . $image )) {
                    return true;
                }
            } 
            return false;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
   
    
    /**
    * 
     * @param string $dir
    * @param string $image
    * @param string $larguraSaida
    * @param string $alturaSaida
    * @param string $pastaDestino
    * @return stream <string, mixed>
    */
    function fnRedimenssionar( $image, $larguraSaida, $alturaSaida, $destino ) { 
        try{
            $arquivo  = basename($image);
            $dir      = $destino;
            $pastaDestino = $destino;
            $extensao = 'jpeg';

            $imagem = imagecreatefromstring( file_get_contents( $image ) ); 

            $largura = imagesx( $imagem ); 
            $altura = imagesy( $imagem ); 

            if ( $altura > $larguraSaida OR $largura > $alturaSaida ) {
                $percentualLargura = ( $larguraSaida / $largura );
                $percentualAltura = ( $alturaSaida / $altura );                   
                $percentualAplicar = ( $percentualAltura < $percentualLargura ) ? $percentualAltura : $percentualLargura;
                $novaLargura = ( $largura * $percentualAplicar );
                $novaAltura = ( $altura * $percentualAplicar );
            }
            else {
                $novaLargura = $largura;
                $novaAltura = $altura;
            } 

                $nova_imagem = imagecreatetruecolor( $novaLargura, $novaAltura );  
                imagecopyresized( $nova_imagem, $imagem, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura );  
                $localNovaImagem = $pastaDestino .'/'. $arquivo; 
                if( $extensao == "jpg" || $extensao == "jpeg" || $extensao == "JPG" ) {

                    imagejpeg( $nova_imagem, $localNovaImagem );#Por default a qualidade de imagem é 75


                }
                elseif( $extensao == "png" || $extensao == "PNG" ) {
                    imagepng( $nova_imagem, $localNovaImagem );
                } 
                imagedestroy( $nova_imagem ); 
                return $arquivo;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    
    
    public function initMaxfilesize( $tamanho = '5M' ) {
        ini_set('post_max_size', $tamanho);
        ini_set('upload_max_filesize', $tamanho);
    }
    
    /**
     * @todo  metodo que gera o blob da imagem a ser enviada para o servidor
     * @param string $URL
     * @return string
     */
    public function blobImagem( $URL ){
        $blobImagem = null;
        $blobImagem = file_get_contents($URL);
        $blobImagem = addslashes( $blobImagem );
        return $blobImagem;
    }
    
    /**
     * @todo metodo que gera as pastas necessárias para o meu cadastro das imagens para o servidor
     * @param string $placa
     * @return true em caso de sucesso
     * @throws Exception quando gerar o erro de não conseguir criar a pasta
     */
    public function geraPastaCarro( $placa = NULL ){
       try{
            $pathUpload   = 'img/upload';
            if(!file_exists($this->caminhoCarro)) {
                mkdir($pathUpload,0777);
                mkdir($this->caminhoCarro,0777);
                
            }
            if( !is_null($placa)) {
                
                if(!file_exists($this->caminhoCarro.'/'.$placa)){
                    if( mkdir($this->caminhoCarro.'/'.$placa,0777) ) {
                        
                        return $this->caminhoCarro.'/'.$placa;
                    } else {
                        throw new Exception(str_replace(array('{DIR}'), $placa, Enum::CREATE_DIR_ERROR));
                    }
                }
            }
       } catch (Exception $ex) {
           throw $ex;
       }
    }
    
    /**
     * @todo metod que realiza o envio de imagens para o servidor
     * @param string $url
     * @param string $placa 
     * @return string nome da imagem 
     */
    public function imageUploadUrl( $url = NULL, $placa = NULL ){
        $nomeImagem = $placa.'_'.md5(mt_rand()).'.jpeg';
        file_put_contents($this->caminhoCarro .'/'.$placa.'/'. $nomeImagem , file_get_contents($url));
        return $nomeImagem;
    }
    
    /**
    * @todo que busca os arquivos da pasta selecionada
    * @param string $placa pasta que eu irei ler
    * @return type array de arquivos encontrados
    */
    public function lerDiretorioCarro( $basePath, $placa ) {

        $arquivos = scandir( $this->caminhoCarro . '/' . $placa );
        $valor = array();
        if( is_array( $arquivos ) ) {
            foreach( $arquivos as $key => $value ) {
                if( $value != "." && $value != ".." && $value != 'Thumbs.db' )
                    $valor[] = $basePath . $this->caminhoCarro.'/'.$placa.'/'.$value;
                }
        }
        return $valor;
    }
    
    
    /**
     * @version 1.10
     * @todo gera o caminho fisico da imagem no servido
     * @param string $imagemOrigem imagem com o caminho completo
     * @return string - caminho fisico do servidor
     * 
     */
    public function caminhoServidorImagem( $imagemOrigem ){
        $imagem = basename($imagemOrigem);
        $explode = $imagem;
        $explode = explode('_', $explode);
        $pastaImagem = array_shift($explode);
        return str_replace('\\', '/', getcwd() . DS . 'img' . DS . 'upload' . DS . 'carro' . DS . $pastaImagem . DS . $imagem) ;
    }
    
    
    public function saveToServer() {
        $this->autoRender = NULL;
        $this->autoLayout = NULL;
        $output = $this->request->data('output');
        $imagem = $this->request->data('imagem');
        $imagem = explode(',', $imagem);
        if(isset($imagem[1])){
            $imagem = base64_decode($imagem[1]);
            $path   = '../webroot/files/upload/carros';

            if(file_put_contents($path.'/'.$output, $imagem)){
                $return = array(
                    'success' => true,
                    'mensagem' => Enum::IMAGEM_EDITADA_SUCESSO,
                    'bootstrap' => 'success'
                );
            }else {
                $return = array(
                    'success' => false,
                    'mensagem' => Enum::IMAGEM_EDITADA_ERRO,
                    'bootstrap' => 'danger'
                );           
            }
        }else{
            $return = array(
                'success' => false,
                'mensagem' => Enum::IMAGEM_NAO_ALTERADA,
                'bootstrap' => 'danger'
            ); 
        }
        
        echo json_encode($return);
    }

    
    public function StringJsonToArrayFotos( $foto ){
        $listaFotos = NULL;
        $foto = str_replace(array('\\\\' ), '', $foto);
        $foto = str_replace(array( '\\"[', ']\\"', '\\"', '"{', '}"' ), array('[',']', '"', '{', '}'), $foto);
        //return $foto;
        if ( !empty($foto) ) {
            $listaFotos = json_decode($foto, true);
            if (is_array($listaFotos)) {
                return $listaFotos;
            }            
        }
        return NULL;
    }
    
    
    
}