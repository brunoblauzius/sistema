<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url(array('Usuarios', 'painel'))?>">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url(array('Funcionarios'))?>">Lista</a>
            </li>
            <li>
                <a class="current" href="#">Cadastro</a>
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
          
            <form action="<?= Router::url(array('Funcionarios', 'add'));?>" name="FuncionarioAddForm" id="FuncionarioAddForm" class="FuncionarioAddForm" method="post" accept-charset="UTF-8">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        
                        <h3>Informações para Empresa</h3>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Tipo de Funcionário:</small>
                                <select class="form-control round-input" name="Usuario[roles_id]">
                                    <option value=""> -- selecione --</option>
                                    <?php foreach ($grupos as $grupo):?>
                                        <option value="<?= $grupo->getId()?>"> <?= $grupo->getNome()?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Nome: <strong class="text text-danger">*</strong></small>
                                <input type="text" id="" class="form-control " name="Fisica[nome]" placeholder="Nome: " >
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>RG:</small>
                                <input type="text" id="" class="form-control " name="Fisica[rg]" placeholder="RG: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>CPF: <strong class="text text-danger">*</strong></small>
                                <input type="text" id="" class="form-control  cpf" name="Fisica[cpf]" placeholder="CPF: " >
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <hr>
                        <h4>Endereço da Empresa.</h4> 
                        <div class="row">
                            <div class="col-sm-6">
                                <small>CEP: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[cep]" id="cep" class="form-control cep" placeholder="CEP:" maxlength="8">
                            </div>
                            <div class="col-sm-6">
                                <small>Logradouro: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[logradouro]" id="logradouro" class="form-control" placeholder="Logradouro:">
                            </div>
                            <div class="col-sm-6">
                                <small>Cidade: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[cidade]" id="cidade" class="form-control" placeholder="Cidade:">
                            </div>
                            <div class="col-sm-6">
                                <small>Bairro: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[bairro]" id="bairro" class="form-control" placeholder="Bairro:">
                            </div>
                            <div class="col-sm-6">
                                <small>Estado: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[uf]" id="uf" class="form-control" placeholder="Estado:">
                            </div>
                            <div class="col-sm-6">
                                <small>Número: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Endereco[numero]" class="form-control" placeholder="Número:">
                            </div>
                        </div>
                        

                        <hr>
                        <h4>Dados para Contato.</h4> 
                        <div class="row">
                            <div class="col-sm-9 form-group">
                                <small>E-mail: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Email[email]" class="form-control" placeholder="E-mail válido para contato:">
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-12">
                                <div class="col-sm-8 form-group" style="padding-left: 0px;">
                                    <small>Telefone: <strong class="text text-danger">*</strong></small>
                                    <input type="text" name="Contato[telefone][]" class="form-control fone" placeholder="Número:">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <small>Tipo: <strong class="text text-danger">*</strong></small>
                                    <select name="Contato[tipo_telefone][]" class="form-control">
                                        <option value="1"> Fixo </option>
                                        <option value="1"> Celular </option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <div class="col-sm-8 form-group" style="padding-left: 0px;">
                                    <small>Telefone: <strong class="text text-danger">*</strong></small>
                                    <input type="text" name="Contato[telefone][]" class="form-control fone" placeholder="Número:">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <small>Tipo: <strong class="text text-danger">*</strong></small>
                                    <select name="Contato[tipo_telefone][]" class="form-control">
                                        <option value="1"> Fixo </option>
                                        <option value="1"> Celular </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        
                        <hr>
                        <h4>Dados Usuário do sistema.</h4> 

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <small>Login Usuário: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Usuario[login]" class="form-control" placeholder="Login:">
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-6 form-group">
                                <small>Senha: <strong class="text text-danger">*</strong></small>
                                <input type="password" name="Usuario[senha]" class="form-control" placeholder="Senha:">
                            </div>
                            <div class="col-sm-6 form-group">
                                <small>Confirmação de senha: <strong class="text text-danger">*</strong></small>
                                <input type="password" name="Usuario[confirm_senha]" class="form-control" placeholder="Confirmação de senha:">
                            </div>
                        </div>
                        
                        
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-6">
                                <button class="btn btn-primary">Cadastrar</button>
                                <button type="reset" class="btn btn-default">Limpar Campos</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                
                
            </form>
            
        </div>
    </div>
</div>