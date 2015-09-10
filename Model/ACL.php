<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ACL
 *
 * @author bruno.blauzius
 */
class ACL extends AppModel{
    //put your code here
    
    public $useTable = 'groups_actions';
    
    public $name = 'ACL';
    
    public $primaryKey = 'id';
    
    
    public function findAclAll(){
        $lista = null;
        
        $retorno = $this->find('all');
        
        foreach ($retorno as $valor) {
            $lista[] = new ACLEntity(
                    $valor[$this->name]['id'],
                    $valor[$this->name]['grupos_id'],
                    $valor[$this->name]['metodos_id'],
                    $valor[$this->name]['controllers_id'],
                    $valor[$this->name]['metodos_nome'],
                    $valor[$this->name]['controllers_nome'],
                    $valor[$this->name]['ativo']
                    );
        }
		return $lista;
    }
    
    public function aclUpdate( $post ){
        try{ 
            
            $sql = "UPDATE {$this->useTable} SET ativo = {$post['ativo']} "
                 . "WHERE grupos_id    = {$post['grupos_id']} "
                 . "AND metodos_id     = {$post['metodos_id']} "
                 . "AND controllers_id = {$post['controllers_id']}; ";

            $retorno = $this->query($sql);
            
            return $retorno;
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function countAcl( $post ){
        try{
            $sql = "SELECT count(id) as count FROM groups_actions where controllers_id = {$post['controllers_id']} AND metodos_id = {$post['metodos_id']} AND grupos_id = {$post['grupos_id']};";
            $retorno = $this->query($sql);
            return $retorno[0]['count'];
        } catch (Exception $ex) {

        }
    }
    
    public function authenticacaoUser( $controller, $metodo, $grupo ){
        try {
            
            $sql = "SELECT count(id) as count FROM groups_actions 
                    WHERE controllers_nome = '{$controller}' AND metodos_nome = '{$metodo}' AND grupos_id = $grupo AND ativo = 1;";
            $retorno = $this->query($sql);
            return $retorno[0]['count'];  
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
   }
   
   public function carregarPermissoes( $roleId ){
       try{
           $retorno = NULL;
           $sql = " SELECT controllers_nome, metodos_nome FROM groups_actions 
                    where grupos_id = {$roleId} AND ativo = 1;";
           $retorno = $this->query($sql);
           return $retorno;           
       } catch (Exception $ex) {

       }
   }
   
   public function carregarMenu( $roleId ){
       try{
           $retorno = NULL;
           $sql = " SELECT 
                    GrupoAction.controllers_nome, 
                    GrupoAction.metodos_nome,
                    Controller.nome_link as link_name,
                    Controller.icon,
                    Metodo.nome_link,
                    concat( GrupoAction.controllers_nome, '/', GrupoAction.metodos_nome) as link
                    FROM groups_actions as GrupoAction
                    INNER JOIN methods as Metodo ON Metodo.id = GrupoAction.metodos_id
                    INNER JOIN controllers as Controller ON Controller.id = GrupoAction.controllers_id
                    where GrupoAction.grupos_id = {$roleId} AND GrupoAction.ativo = 1 AND Metodo.is_page = 1 AND Metodo.menu_primario = 1 ORDER BY Controller.nome_link ASC, Metodo.nome_link ASC ;";
                    
           $retorno = $this->query($sql);
           return $retorno;           
       } catch (Exception $ex) {

       }
   }

   
   
}
