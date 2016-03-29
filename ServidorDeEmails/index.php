<?php

require_once 'autoload.php';
 date_default_timezone_set('America/Sao_Paulo');
//error_reporting( E_ALL );
//ini_set( "display_errors", true );

/**
 * @todo envio basico de email
 * @author Bruno Blauzius Schuindt <brunoblauzius@gmail.com>
 * @version 1.0
 */

$email  = new MailPHPMailer();
$render = new Render();
$model  = new Email();

/**
 * configurações de envio
 * 
 * $_post(
        
 *      'assunto'           =>  *IMPORTANTE -- assunto do envio 
        'destinatario'      =>  *IMPORTANTE --- email do destinatario
        'nome_destinatario' =>  *IMPORTANTE --- nome do destinatário
        'layout'            =>  *IMPORTANTE --- layout que vai ser enviado
 
        'nome'              => 'Bruno Blauzius Schuindt', 
        'email'             => 'brunoblauzius@gmail.com', 
        'mensagem'          => 'TESTE DE ENVIO DO PRIMEIRO HTML PARA O ALESSANDRO',
        
        )
 */

echo $render->element( 'email_cadastro' );exit();

try {
    
    $_POST = Utils::sanitazeArray(
            array(
                'Email' => $_POST
                )
            );
    
    $model->data = $_POST['Email'];
    
    if( $model->validates() ){
       
        /**
         * setando o assunto do meu envio
         */
        $email->setAssunto($model->data['assunto']);
        /**
         * setando o meu destinatario para o envio
         */
        $email->setDestinatario( $model->data['destinatario'], $model->data['nome_destinatario'] );
        /**
         * setando uma cópia para o remetente (USUARIO)
         */
        $email->setCC($model->data['email'], $model->data['nome']);
        /**
         * setando as minhas variaveis para o corpo do email
         */
        $render->set($model->data);
        /**
         * setando o cordo do meu envio com o layout desejado
         */
        $email->setBody( $render->element($model->data['layout']) );
        
        /**
         * enviando meu email para o destinatario
         */
        if( $email->sendMail() ){
            echo json_encode(array(
                'success' => true,
                'style'   => 'success',
                'message' => 'Sucesso',
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'style'   => 'warning',
                'message' => $email->getError(),
            ));
        }
        
    } else {
        echo json_encode(
                array_merge(
                        array(
                            'success' => false,
                            'style'   => 'warning'
                        ), 
                        $model->validateErros
                        )
                );
    }
    
} catch (Exception $ex) {
    //Utils::pre($ex->getTrace());
    echo json_encode(array(
        'success' => false,
        'style'   => 'danger',
        'message' => $ex->getMessage(),
    ));
}