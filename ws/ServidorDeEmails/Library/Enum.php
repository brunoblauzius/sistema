<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enum
 *
 * @author blauzius
 */
class Enum {
    //put your code here
    const VERIFICA_TERMO 		= 'O termo deve ser aceito para concluir seu cadastro';
    const VAZIO          		= 'Este campo é requirido';
    const EMAIL_INVALIDO 		= 'Este e-mail é inválido...';
    const SENHA_NAO_CONFERE 	= 'Senha e confirmação de senha não conferem!';
    const USUARIO_CADASTRADO 	= 'Este e-mail já foi cadastrado para outro usuário em nosso sistema.';
    const VERIFICA_CPF_CNPJ 	= 'Usuário já cadastrado em nosso sistema...';
	const CADASTRO_NAO_EFETUADO = 'Não foi possivel inserir seu cadastro em nosso sistema, por favor tente novamente mais tarde!';
	const FUNCIONARIO_OCUPADO   = 12;
}
