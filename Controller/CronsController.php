<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

/**
 */
class CronsController extends AppController {

    //put your code here



    public $Contato = null;
    public $Cron = null;
    public $Vacinas = null;

    public function __construct() {

        $this->Cron = new Cron();
    }

    public function agendadosEmail() {
        try {
            $agendados = $this->Cron->situacaoAgendadaEmail();
            $email = new Email();
            $email_body = $email->find('first', array('tag' => 'cron_email'));

            if (count($agendados) > 0) {
                foreach ($agendados as $registro) {

                    #condição para enviar emails
                    if ($registro['email'] != null || $registro['email'] != '') {
                        $this->eviarEmail($email_body, $registro);
                    }
                }
            }

            echo '<pre>';
            print_r($agendados);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }

    public final function eviarEmail($email_body, $registro) {
        $emailSend = false;
        $body = false;
        $dadosEmail = array(
            '__VALOR__' => $registro['valor'],
            '__CELULAR__' => $registro['celular'],
            '__TELEFONE__' => $registro['telefone'],
            '__EMAIL__' => $registro['email'],
            '__INICIO__' => $registro['start'],
            '__FIM__' => $registro['end'],
            '__DATE__' => date('d/m/Y h:i:s'),
        );

        $objeto = new MailPHPMailer();
        $objeto->setAssunto('Você tem agendamento previsto!');
        //$objeto->setRemetente();

        /**
         *   TROCAR PARA EMAIL DO usuario
         */
        $objeto->setDestinatario($registro['email'], 'Suporte: Agentus');

        /**
         *   TROCAR PARA EMAIL DO usuario
         */
        $body = str_replace(array_keys($dadosEmail), array_values($dadosEmail), $email_body[0]['Email']['corpo_mail']);
        $objeto->setBody($body);

        $emailSend = $objeto->sendMail();

        $itens = null;

        $itens[] = array(
            'fullcalendar_id' => $registro['fullcalendar_id'],
            'clientes_id' => $registro['clientes_id'],
            'empresas_id' => $registro['empresas_id'],
            'conteudo' => $body,
            'status' => $emailSend,
        );

        $this->Cron->gravaEmail($itens);
    }

    public function agendadosSMS() {
        try {
            $agendados = $this->Cron->situacaoAgendadaSMS();

            if (count($agendados) > 0) {
                foreach ($agendados as $registro) {

                    #condição para enviar emails
                    if ($registro['celular'] != null || $registro['celular'] != '') {
                        $this->eviarSMS($registro);
                    }
                }
            }
            echo '<pre>';
            print_r($agendados);
            echo "################# SMS'S ENVIADO ##################";
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }

    public final function eviarSMS($registro) {

        $body = "Você tem uma consulta agendada amanhã dia " . Utils::getDate($registro['start']) . " Retorne a mensagem para confirmação!";
        #RECUPERAR O ID DO ENVIO DO SMS
        $mensagemId = $this->Cron->SMSlastId();
        $mensagemId = str_pad( ++$mensagemId, 4, 0, STR_PAD_LEFT);

        $itens[] = array(
            'fullcalendar_id' => $registro['fullcalendar_id'],
            'clientes_id' => $registro['clientes_id'],
            'empresas_id' => $registro['empresas_id'],
            'conteudo' => addslashes($body),
            'status' => 0,
            'sms_id' => $mensagemId
        );

        try {


            $destinatario = '55' . Utils::returnNumeric($registro['celular']);
            #RECUPERA O CELULAR DA EMPRESA QUE CONTRATOU O SERVIÇO
            $remetente = '554197268858';
            //$sms     = new SimpleSendSMS( $mensagemId, $body, $destinatario, $remetente );
            #ENVIO O SMS
            //$retorno = $sms->sendSMS();
            #REGISTRO O ENVIO NO BANCO DE DADOS
            //$itens[0]['status'] = $retorno['codigo'];
            //$this->Cron->gravaSMS( $itens );
            echo '<pre>';
            print_r($itens);
        } catch (Exception $e) {
            echo $e->getMessage();
            $itens[0]['status'] = $e->getCode();
            $this->Cron->gravaEmail($itens);
        }
    }

    public function bloquearEmpresa() {
        try {

            $Empresa = new Empresa();
            $Funcionarios = new Funcionario();
            $empresasAtivas = $Empresa->empresasAtivas();
           
            
            foreach ($empresasAtivas as $ativas) { 
                
                if( strtotime($ativas['expirar']) < strtotime(date('Y-m-d H:i:s')) ){
                    
                    /**
                     * bloquear os funcionarios da empresa
                     */
                    $Funcionarios->bloquearFuncionarios( $ativas['empresas_id'] );
                    
                    /**
                     * bloquear empresa
                     */
                    $Empresa->bloquearEmpresa( $ativas['empresas_id'] );
                    
                    Utils::pre('##### EMPRESA BLOQUEADA COM SUCESSO #####'); 
                    
                }
                
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public function bloquearEmpresaTeste(){
        try {
            
            $Empresa = new Empresa();
            $Funcionarios = new Funcionario();
            $empresasTeste = $Empresa->empresasTeste();
            
            foreach ($empresasTeste as $ativas) { 
                
                if( strtotime($ativas['expirar']) < strtotime(date('Y-m-d H:i:s')) ){
                    
                    /**
                     * bloquear os funcionarios da empresa
                     */
                    $Funcionarios->bloquearFuncionarios( $ativas['empresas_id'] );
                    
                    /**
                     * bloquear empresa
                     */
                    $Empresa->bloquearEmpresa( $ativas['empresas_id'] );
                    
                    Utils::pre('##### EMPRESA BLOQUEADA COM SUCESSO #####'); 
                    
                }
                
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

}
