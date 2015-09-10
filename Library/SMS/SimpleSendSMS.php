<?php

//ini_set('display_errors', "on");
//ini_set('error_reporting', E_ALL & ~E_NOTICE);
//ini_set('error_reporting', E_ALL);
require_once 'human_gateway_client_api/HumanClientMain.php';

class SimpleSendSMS {
    
    
    private $Erros = array(
        '000'  => 'MENSAGEM ENVIADA COM SUCESSO',
        '010'  => 'MENSAGEM: E UM CAMPO REQUIRIDO',
        '012'  => 'LIMITE DE CARACTERES FOI ATINGIDO, POR FAVOR DIGITE 150 CARACTERES',
        '013'  => 'O NUMERO DO DESTINATARIO ESTA INCOMPLETO OU INCORRETO',
        '014'  => 'NUMERO DE DESTINATARIO ESTA VAZIO',
        '015'  => 'DATA DE AGENDAMENTO INVALIDO OU INCORRETA',
        '016'  => 'ID PASSOU DO LIMITE',
        '080'  => 'MENSAGEM COM O MESMO ID JA FOI ENVIADA',
        '141'  => 'ENVIO INTERNACIONAL NAO PERMITIDO',
        '900'  => 'ERRO DE AUTENTICACAO DE USUARIO',
        '990'  => 'LIMIT DE ENVIO DOS SMS ATINGIDO',
        '999'  => 'ERRO DESCONHECIDO',
    );
    
    private $conta = "brunoshuindt.api";
    
    private $senha = 'On7pWDuLCx';
    
    private $callbackOption = HumanSimpleSend::CALLBACK_INACTIVE;
    
    private $sender  = null;
    
    private $message = null;
    
    private $body    = null;
    
    private $destinatario = null;
    
    private $remetente    = '554197268858';
    
    private $mensagemId   = null;
    
    public function __construct( $mensagemId, $mensagem, $destinatario, $remetente = null ) { 
        try{
            $this->mensagemId   = $mensagemId;
            $this->body         = $mensagem;
            $this->destinatario = $destinatario;
            $this->remetente    = $this->remetente;
            $this->sender  = new HumanSimpleSend( $this->conta, $this->senha );
            $this->message = new HumanSimpleMessage();
            
            /**
             * MONTAGEM DE PARAMETROS PARA ENVIO DE SMS.
             */
            $this->parametros();
            
        } catch (Exception $e){
            throw $e;
        }
    }
    
    public final function getMessage( $code ){
        return $this->Erros[$code];
    }
    
    private final function parametros(){
        $this->message->setBody($this->body);
        $this->message->setTo($this->destinatario);
        $this->message->setFrom($this->remetente);
        $this->message->setMsgId($this->mensagemId);
    }
    
    
    private final function gravarDados() {
        try {
            
            $sql = "INSERT INTO empresas_sms ( empresas_id, mensagem, telefone_destinatario, mensagem_id, created, status  ) "
                    . " VALUES( $empresasId, '{$this->body}', '{$this->destinatario}', '{$this->mensagemId}', NOW(), 1 )";
            
            $lastId = $this->query($sql); 
            return $lastId;
        }  catch (Exception $e ) {
            throw $e;
        }
    }
    
    
    /**
     * 
     * @version 1.0
     * @todo metodo de envio dos SMS
     * @return type array
     * @throws Exception
     */
    public final function sendSMS(){
        try{
            
            $response = $this->sender->sendMessage( $this->message, $this->callbackOption );
            
            if( $response->getCode() != '000' ){
                throw new Exception( $this->getMessage( $response->getCode() ), $response->getCode() );
            }
            
            return array(
                'codigo'   => $response->getCode(),
                'mensagem' => $this->getMessage( $response->getCode() ),
            );
            
        } catch ( Exception $e ){
            throw $e;
        }
    } 
    
    
    
    public function __destruct() { }
}

