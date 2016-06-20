<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PainelGerente
 *
 * @author BRUNO
 */
class PainelGerente extends TemplatePainel implements ImprimePainel{
    
    private $proximo;
    
    public function setProximo( ImprimePainel $proximo) {
        $this->proximo = $proximo;
        return $this;
    }
    
    public function getPainel( VerificaEstadoPainel $estado ) {
        
        if( $estado->getEstado() === PainelConstantes::GERENTE ){
            
            $this->imprimirPainel($estado->getClass());
            
        } else {
            return $this->proximo->getPainel( $estado );
        }
    }

    protected function parametros(\AppController $class) {
        $clientes     = 0;
        $funcionarios = 0;
        $class->addJs(array(
            'js/chart-js/Chart',
            'js/chartjs.init',
        ));

        $endereco = null;
        if( Session::check('Empresa')){
            $modelCliente = new Cliente();
            $modelEndereco = new Endereco();
            $modelFuncionario = new Funcionario();

            $clientes = $modelCliente->clientesProprietario(Session::read('Usuario.pessoas_id'), Session::read('Usuario.roles_id'));
            $clientes = count($clientes);

            $funcionarios = $modelFuncionario->find('all', array('empresas_id' => Session::read('Empresa.empresas_id')));
            $funcionarios = count($funcionarios);

            $endereco = $modelEndereco->findEnderecosEmpresa( Session::read('Empresa.empresas_id') );
            $endereco = $endereco[0];
        }

        $class->set('title_layout', 'Painel Administrativo');
        $class->set('endereco', $endereco);
        $class->set('clientes', $clientes);
        $class->set('funcionarios', $funcionarios);
    }

    protected function renderFile(\AppController $class) {
        $class->render(array('controller' => 'Usuarios', 'view' => 'gerente'), 'painel' );
    }

//put your code here
}
