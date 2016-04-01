<?php

class Contato extends AppModel {

    public $useTable = 'contatos';
    public $name = 'Contato';
    public $primaryKey = 'id';
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido',
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido',
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => 'Favor inserir um email válido',
            ),
        ),
        'assunto' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido',
            ),
        ),
        'mensagem' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido',
            ),
        ),
        'code' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'validaCaptcha' => array(
                'rule' => array('validaCaptcha'),
                'mensagem' => 'captcha está incorreto!'
            ),
        ),
    );

    public function inserirTelefones($pessoaId, array $telefones) {

        $inserts = array();

        if (is_array($telefones) && !empty($telefones)) {

            foreach ($telefones['telefone'] as $telefone) {

                $tipo = current($telefones['tipo_telefone']);

                $inserts[] = " ( $pessoaId, '{$telefone}', $tipo ) ";

                next($telefones['tipo_telefone']);
            }

            $sql = "INSERT INTO reservas.contatos ( pessoas_id, telefone, tipo ) VALUES " . join(', ', $inserts);
            $this->query($sql);
        }
    }

    public function inserirContatosEmpresa($empresaId, array $contatos) {

        $contatoId = 0;

        if (is_array($contatos) && !empty($contatos)) {
            foreach ($contatos['telefone'] as $telefone) {

                $tipo = current($contatos['tipo_telefone']);

                $contatoId = $this->genericInsert(array(
                    'telefone' => $telefone,
                    'tipo' => $tipo,
                ));

                $sql = "INSERT INTO empresas_has_contatos ( empresas_id, contatos_id ) VALUES ( $empresaId, $contatoId ); ";
                $this->query($sql);

                next($contatos['tipo_telefone']);
            }
        }
    }
    
    public function inserirContatosPessoa($pessoasId, array $contatos) {

        $contatoId = 0;

        if (is_array($contatos) && !empty($contatos)) {
            foreach ($contatos['telefone'] as $telefone) {

                $tipo = current($contatos['tipo_telefone']);

                $contatoId = $this->genericInsert(array(
                    'telefone' => $telefone,
                    'tipo' => $tipo,
                ));

                $sql = "INSERT INTO pessoas_has_contatos ( pessoas_id, contatos_id ) VALUES ( $pessoasId, $contatoId ); ";
                $this->query($sql);

                next($contatos['tipo_telefone']);
            }
        }
    }
    
    public function AlterarContatosPessoa( $pessoasId, array $contatos ){
        $contatoId = 0;

        if (is_array($contatos) && !empty($contatos)) {
            
            $i = 0;
            
            foreach ($contatos['telefone'] as $telefone) {

                $tipo = $contatos['tipo_telefone'][$i];

                if( isset($contatos['id'][$i]) && !empty($contatos['id'][$i]) ){
                    
                    $id   = $contatos['id'][$i];
                    
                    $this->genericUpdate(array(
                        'id'       => $id,
                        'telefone' => $telefone,
                        'tipo'     => $tipo,
                    ));
                    
                    
                } else {
                    
                    $contatoId = $this->genericInsert(array(
                        'telefone' => $telefone,
                        'tipo' => $tipo,
                    ));
                    
                    $sql = "INSERT INTO pessoas_has_contatos ( pessoas_id, contatos_id ) VALUES ( $pessoasId, $contatoId ); ";
                    $this->query($sql);
                    
                }
                 $i++;
            }
        }
    }

    
    public function AlterarContatosEmpresa( $empresasId, array $contatos ){
        $contatoId = 0;

        if (is_array($contatos) && !empty($contatos)) {
            
            $i = 0;
            
            foreach ($contatos['telefone'] as $telefone) {

                $tipo = $contatos['tipo_telefone'][$i];

                if( isset($contatos['id'][$i]) && !empty($contatos['id'][$i]) ){
                    
                    $id   = $contatos['id'][$i];
                    
                    $this->genericUpdate(array(
                        'id'       => $id,
                        'telefone' => $telefone,
                        'tipo'     => $tipo,
                    ));
                    
                    
                } else {
                    
                    $contatoId = $this->genericInsert(array(
                        'telefone' => $telefone,
                        'tipo' => $tipo,
                    ));
                    
                    $sql = "INSERT INTO empresas_has_contatos ( empresas_id, contatos_id ) VALUES ( $empresasId, $contatoId ); ";
                    $this->query($sql);
                    
                }
                 $i++;
            }
        }
    }
    
    
    
    public function findPessoaContatos( $pessoaId = null ){
        try {
            
            $retorno = array();
            
            if( !empty($pessoaId) ){
                
                $sql = "SELECT 
                            Contato.id,
                            Contato.telefone,
                            Contato.tipo
                        FROM
                            reservas.pessoas_has_contatos AS PessoaContato
                                INNER JOIN
                            reservas.contatos AS Contato ON Contato.id = PessoaContato.contatos_id
                        WHERE
                            (PessoaContato.pessoas_id) = $pessoaId;";
                
                $retorno = $this->query($sql);
                
            }
            return $retorno;
        } catch (Exception $ex) {
            
        }
    }
    
    public function inserirContato( $pessoasId, $contatoId ){
        try {
            
            $sql = "INSERT INTO pessoas_has_contatos ( pessoas_id, contatos_id ) VALUES ( $pessoasId, $contatoId ); ";
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
