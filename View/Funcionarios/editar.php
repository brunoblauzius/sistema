<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url(array('Usuarios', 'painel'))?>">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url(array('Funcionarios', 'index'))?>">Funcionários</a>
            </li>
            <li>
                <a class="current" href="#">Editar</a>
            </li>
        </ul>
    </div>
</div>


<div class="panel">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Funcionarios (Cadastro)</h3>
        </div>
        <div class="panel-body">
          
            <form action="<?= Router::url(array('Funcionarios', 'edit'));?>" name="FuncionarioAddForm" id="FuncionarioAddForm" class="FuncionarioAddForm" method="post" accept-charset="UTF-8">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        
                        <h3>Informações para Empresa</h3>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Tipo de Funcionário:</small>
                                <select class="form-control round-input" name="Usuario[roles_id]">
                                    <?php foreach ($grupos as $grupo):?>
                                        <?php if( $funcionario['roles_id'] == $grupo->getId() ):?>
                                            <option value="<?= $grupo->getId()?>" selected="selected"> <?= $grupo->getNome()?></option>
                                        <?php else:?>
                                            <option value="<?= $grupo->getId()?>"> <?= $grupo->getNome()?></option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Nome: <strong class="text text-danger">*</strong></small>
                                <input type="text" id="" class="form-control " name="Fisica[nome]" placeholder="Nome: " value="<?= $funcionario['nome']?>">
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>RG:</small>
                                <input type="text" id="" class="form-control " name="Fisica[rg]" placeholder="RG: " value="<?= $funcionario['rg']?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>CPF: <strong class="text text-danger">*</strong></small>
                                <input type="text" id="" class="form-control  cpf" name="Fisica[cpf]" placeholder="CPF: " value="<?= $funcionario['cpf']?>">
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <hr>
                        <h4>Endereço da Empresa.</h4> 
                        <div class="row">
                            <div class="col-sm-6">
                                <small>CEP: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[cep]" id="cep" class="form-control cep" placeholder="CEP:" maxlength="8" value="<?= $endereco['cep']?>">
                            </div>
                            <div class="col-sm-6">
                                <small>Logradouro: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[logradouro]" id="logradouro" class="form-control" placeholder="Logradouro:" value="<?= $endereco['logradouro']?>">
                            </div>
                            <div class="col-sm-6">
                                <small>Cidade: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[cidade]" id="cidade" class="form-control" placeholder="Cidade:" value="<?= $endereco['cidade']?>">
                            </div>
                            <div class="col-sm-6">
                                <small>Bairro: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[bairro]" id="bairro" class="form-control" placeholder="Bairro:" value="<?= $endereco['bairro']?>">
                            </div>
                            <div class="col-sm-6">
                                <small>Estado: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[uf]" id="uf" class="form-control" placeholder="Estado:" value="<?= $endereco['uf']?>">
                            </div>
                            <div class="col-sm-6">
                                <small>Número: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[numero]" class="form-control" placeholder="Número:" value="<?= $endereco['numero']?>">
                            </div>
                        </div>
                        

                        <hr>
                        <h4>Dados para Contato.</h4> 
                        <div class="row">
                            <div class="col-sm-9 form-group">
                                <small>E-mail: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Email[email]" class="form-control" placeholder="E-mail válido para contato:" value="<?= $funcionario['email']?>">
                            </div>

                            <div class="clearfix"></div>
                            
                            <?php foreach ($contatos as $contato):?>
                                <div class="col-sm-12">
                                    <div class="col-sm-8 form-group" style="padding-left: 0px;">
                                        <small>Telefone: <strong class="text text-danger">*</strong></small>
                                        <input type="text" name="Contato[telefone][]" class="form-control fone" placeholder="Número:" value="<?= $contato['telefone']?>">
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <small>Tipo: <strong class="text text-danger">*</strong></small>
                                        <select name="Contato[tipo_telefone][]" class="form-control">
                                            <?php
                                                $fixo    = null;
                                                $celular = null;
                                                if( $contato['tipo'] == 1 ):
                                                    $fixo = 'selected="selected"';
                                                else:
                                                    $celular = 'selected="selected"';
                                                endif;
                                            ?>
                                            <option value="1" <?= $fixo?>> Fixo </option>
                                            <option value="2" <?= $celular?>> Celular </option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="Contato[id][]" value="<?= $contato['id']?>">
                                </div>
                                <div class="clearfix"></div>
                            <?php endforeach;?>
                            
                        </div>
                        
                        
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-6">
                                <button class="btn btn-primary">Alterar Registro</button>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                
                
            </form>
            
        </div>
    </div>
</div>