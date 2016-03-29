<?php

header('Content-Type: text/html; charset=utf-8');
error_reporting( 0 );
ini_set( "display_errors", 0 );
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Curl
 *
 * @author bruno.blauzius
 */
class CurlCEP {
    
    /**
     *  @todo var cominho do sservidor dos correios
     * @var string
     */
    private $url = 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm?t';
    
    private $_post = null;
    
    private $contador = 0;
    
    private $parametros;
    
    /**
     *  @todo atributto contentod estado e sigla
     * @var array
     */
    public $estados = array(
        "AC"=>"Acre",
        "AL"=>"Alagoas",
        "AP"=>"Amapá",
        "AM"=>"Amazonas",
        "BA"=>"Bahia",
        "CE"=>"Ceará",
        "DF"=>"Distrito Federal",
        "ES"=>"Espírito Santo",
        "GO"=>"Goiás",
        "MA"=>"Maranhão",
        "MT"=>"Mato Grosso",
        "MS"=>"Mato Grosso do Sul",
        "MG"=>"Minas Gerais",
        "PA"=>"Pará",
        "PB"=>"Paraíba",
        "PR"=>"Paraná",
        "PE"=>"Pernambuco",
        "PI"=>"Piauí",
        "RJ"=>"Rio de Janeiro",
        "RN"=>"Rio Grande do Norte",
        "RS"=>"Rio Grande do Sul",
        "RO"=>"Rondônia",
        "RR"=>"Roraima",
        "SC"=>"Santa Catarina",
        "SP"=>"São Paulo",
        "SE"=>"Sergipe",
        "TO"=>"Tocantins",
    );
    
    
    public function __construct( $valorDeBusca ) {
        $parametros = array(
            'relaxation' => utf8_decode( $valorDeBusca ),
            'Metodo' => 'listaLogradouro',
            'TipoConsulta' => 'relaxation',
            'StartRow' => 1,
            'EndRow' => 10,
            );

        $this->parametros = $parametros;
        $this->_post = http_build_query( $parametros , '&' );
    }
    
    /**
     * @todo metodo que realiza a consulta no servidor dos correios
     * @return string/json
     */
    public function consultaCep(){
        try {
            
            $this->isNull($this->parametros['relaxation']);
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL , $this->url );
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION , TRUE );
            curl_setopt($ch, CURLOPT_AUTOREFERER , TRUE );
            curl_setopt($ch, CURLOPT_POST , TRUE );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER , TRUE );
            curl_setopt($ch, CURLOPT_POSTFIELDS ,  $this->_post );

            $page = curl_exec($ch);
            $domDocument = new DOMDocument();
            $domDocument->loadHTML($page);
            $elemento = $domDocument->getElementsByTagName('tr');
            
            foreach ( $elemento as $node ){
                
                $array[] = ($node->nodeValue);
                
            }

            curl_close($ch);
                       
            return json_encode( $this->geralista($array) );
            
        } catch (Exception $ex) {
            return json_encode(array(
                'erro' => TRUE,
                'mensagem' => $ex->getMessage(),
                'resultado' => NULL
            ));
        }
    }
    
    /**
     * @todo metodo que gera a lista dos ceps recuperados da pagina do correios
     * @param array $lista
     * @return arrays
     * @throws Exception
     */
    private function geralista( array $lista ){
        try{
            
            $novoArray = array();
            unset($lista[0]);
            
            foreach ($lista as $value) {
                /**
                 * limpar arrays em branco
                 */
                $novoArray[] = $this->explodeCep($value);
            }
            /**
             * ajustando os nodes dos ceps
             */
            return $this->retornaCeps($novoArray);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * @todo metodo que explode as strings vinda dos correios
     * @param string $cep
     * @return array
     */
    private function explodeCep($cep){
        $ex = explode('  ' ,$cep);
        $newArray = array();
        foreach ($ex as $value) {
            $value = trim($value);
            $value = str_replace('&nbsp;', NULL,$value);
            if(!empty($value))
            {
                $newArray[] = $value;
            }
        }
        return $newArray;
    }
    

    /**
     * @todo metodo que retorna os ceps parametrizados
     * @param array $oldArray
     * @return srray
     * @throws Exception
     */
    private function retornaCeps( array $oldArray = NULL ){
        try{
            
           $novoArray = array();
           
           if( !is_null($oldArray) ){
                
                foreach ($oldArray as $value) {
                    
                    $cidadeUf = explode('/', $value[2]);
                    
                    $novoArray[] = array(
                        'logradouro' => (($value[0])),
                        'bairro'     => (str_replace('&nbsp;', NULL,$value[1])),
                        'cidade'     => ($cidadeUf[0]),
                        'estado'     => $this->estados[strtoupper($cidadeUf[1])],
                        'uf'         => ($cidadeUf[1]),
                        'cep'        => ($value[3]),
                    );
                    
                }

                if( !empty($novoArray) ){
                    $novoArray = array(
                        'erro' => false,
                        'mensagem' => 'Sucesso',
                        'resultado' => $novoArray
                    );
                } else {
                    throw new Exception('Nenhum registro foi encontrado...');
                }
                
                return $novoArray;
            } 
        } catch (Exception $ex) {
            throw $ex;
        }
    }  
    
    /**
     * @todo metodo que verifica se o cep é nulo
     * @param string $valor
     * @return boolean
     * @throws Exception
     */
    public function isNull( $valor ){
        try{
            if(empty($valor)){
                throw new Exception('Cep está vazio favor informar!');
            }
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}


$cep = new CurlCEP($_GET['valor']);
echo $cep->consultaCep();