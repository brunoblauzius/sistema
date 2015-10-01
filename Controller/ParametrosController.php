<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ParametrosController
 *
 * @author bruno.blauzius
 */
class ParametrosController extends AppController {
    
    private $TiposPagamento = null;
    private $SituacaoConta = null;
    
    public function __construct() {
        parent::__construct();
        
        $this->TiposPagamento = new TiposPagamento();
        $this->SituacaoConta  = new SituacaoConta();
        $this->layout = 'painel';
        
    }
    
    
    /**
     * 
     */
    public function tiposPagamento(){
        try {
            
            $registros = $this->TiposPagamento->find('all', array('status' => true));
            
            $this->set('title_layout', 'Parametros do sistema: tipos de pagamento');
            $this->set('registros', $registros);
            $this->render();
            
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    /**
     * 
     */
    public function addTiposPagamento(){
        try {
            
            if( $this->is('post')){
                
                if( $this->TiposPagamento->genericInsert( $_POST[$this->TiposPagamento->name] ) ){
                    $json = json_encode(array(
                        'style' => 'success',
                        'icon'  => 'check',
                        'title' => 'SUCESSO',
                        'message' => 'Cadastro efetuado com sucesso!',
                        'button' => 'Fechar',
                        'time' => 5000,
                        'callback' => 'window.location.reload();',
                        'size' => 'sm',
                    ));

                    echo json_encode(array(
                        'funcao' => "bootsAlert(".$json.");"
                    ));
                } else {
                    $json = json_encode(array(
                        'erro'  => 1,
                        'style' => 'warning',
                        'icon'  => 'warning',
                        'title' => 'ALERTA!',
                        'message' => 'Não foi possivel efetuar seu cadastro!',
                        'button' => 'Fechar',
                        'time' => 5000,
                        'size' => 'md',
                    ));
                    
                    echo json_encode(array(
                        'funcao' => "bootsAlert(".$json.");"
                    ));
                }
                
            }
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                    'erro'  => 1,
                    'style' => 'danger',
                    'icon'  => 'times',
                    'title' => 'ALERTA!',
                    'message' => $ex->getMessage(),
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'md',
                ));
            echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
        }
    }
    
    /**
     * 
     */
    public function editTiposPagamento(){
        try {
            
            $_POST[$this->TiposPagamento->name]['id'] = $_SESSION['Form']['tipos_pagamentos_id'];
            unset($_SESSION['Form']['tipos_pagamentos_id']);
            
            if( $this->TiposPagamento->genericUpdate( $_POST[$this->TiposPagamento->name] ) ){
                $json = json_encode(array(
                    'style' => 'success',
                    'icon'  => 'check',
                    'title' => 'SUCESSO',
                    'message' => 'Alteração efetuada com sucesso!',
                    'button' => 'Fechar',
                    'time' => 5000,
                    'callback' => 'window.location.reload();',
                    'size' => 'sm',
                ));

                echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
            } else {
                $json = json_encode(array(
                    'erro'  => 1,
                    'style' => 'warning',
                    'icon'  => 'warning',
                    'title' => 'ALERTA!',
                    'message' => 'Não foi possivel efetuar sua alteração!',
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'md',
                ));

                echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
            }
                        
        } catch (Exception $ex) {
            $json = json_encode(array(
                    'erro'  => 1,
                    'style' => 'danger',
                    'icon'  => 'times',
                    'title' => 'ALERTA!',
                    'message' => $ex->getMessage(),
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'md',
                ));
            echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
        }
    }
    
    /**
     * 
     */
    public function editarTiposPagamento(){
        try {
            $this->layout = 'null';
            
            $registro = $this->TiposPagamento->find('first', array('id' => $_GET['param'] ));
            $_SESSION['Form']['tipos_pagamentos_id'] = $registro[0][$this->TiposPagamento->name]['id'];
            
            
            $this->set('title_layout', 'Parametros do sistema: tipos de pagamento');
            $this->set('registro', $registro[0][$this->TiposPagamento->name]);
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public function situacaoContas(){
        try {
            
            $registros = $this->SituacaoConta->find('all');
            
            $this->set('title_layout', 'Parametros do sistema: Situação de contas');
            $this->set('registros', $registros);
            $this->render();
            
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    /**
     * 
     */
    public function addSituacaoContas(){
        try {
            
            if( $this->is('post')){
                
                if( $this->SituacaoConta->genericInsert( $_POST[$this->SituacaoConta->name] ) ){
                    $json = json_encode(array(
                        'style' => 'success',
                        'icon'  => 'check',
                        'title' => 'SUCESSO',
                        'message' => 'Cadastro efetuado com sucesso!',
                        'button' => 'Fechar',
                        'time' => 5000,
                        'callback' => 'window.location.reload();',
                        'size' => 'sm',
                    ));

                    echo json_encode(array(
                        'funcao' => "bootsAlert(".$json.");"
                    ));
                } else {
                    $json = json_encode(array(
                        'erro'  => 1,
                        'style' => 'warning',
                        'icon'  => 'warning',
                        'title' => 'ALERTA!',
                        'message' => 'Não foi possivel efetuar seu cadastro!',
                        'button' => 'Fechar',
                        'time' => 5000,
                        'size' => 'md',
                    ));
                    
                    echo json_encode(array(
                        'funcao' => "bootsAlert(".$json.");"
                    ));
                }
                
            }
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                    'erro'  => 1,
                    'style' => 'danger',
                    'icon'  => 'times',
                    'title' => 'ALERTA!',
                    'message' => $ex->getMessage(),
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'md',
                ));
            echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
        }
    }
    
    /**
     * 
     */
    public function editSituacaoContas(){
        try {
            
            $_POST[$this->SituacaoConta->name]['id'] = $_SESSION['Form']['situacao_contas_id'];
            unset($_SESSION['Form']['situacao_contas_id']);
            
            if( $this->SituacaoConta->genericUpdate( $_POST[$this->SituacaoConta->name] ) ){
                $json = json_encode(array(
                    'style' => 'success',
                    'icon'  => 'check',
                    'title' => 'SUCESSO',
                    'message' => 'Alteração efetuada com sucesso!',
                    'button' => 'Fechar',
                    'time' => 5000,
                    'callback' => 'window.location.reload();',
                    'size' => 'sm',
                ));

                echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
            } else {
                $json = json_encode(array(
                    'erro'  => 1,
                    'style' => 'warning',
                    'icon'  => 'warning',
                    'title' => 'ALERTA!',
                    'message' => 'Não foi possivel efetuar sua alteração!',
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'md',
                ));

                echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
            }
                        
        } catch (Exception $ex) {
            $json = json_encode(array(
                    'erro'  => 1,
                    'style' => 'danger',
                    'icon'  => 'times',
                    'title' => 'ALERTA!',
                    'message' => $ex->getMessage(),
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'md',
                ));
            echo json_encode(array(
                    'funcao' => "bootsAlert(".$json.");"
                ));
        }
    }
    
    /**
     * 
     */
    public function editarSituacaoContas(){
        try {
            $this->layout = 'null';
            
            $registro = $this->SituacaoConta->find('first', array('id' => $_GET['param'] ));
            $_SESSION['Form']['situacao_contas_id'] = $registro[0][$this->SituacaoConta->name]['id'];
            
            
            $this->set('title_layout', 'Parametros do sistema: tipos de pagamento');
            $this->set('registro', $registro[0][$this->SituacaoConta->name]);
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
}
