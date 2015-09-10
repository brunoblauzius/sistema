

<section class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-primary">
            <div class="panel panel-heading">Passo 1: Cadastro titular da conta</div>
            
            <form action="<?= Router::url(array('Pessoas', 'add'))?>" method="post" name="PessoaAddForm" id="PessoaAddForm" class="">
                
                <div class="panel panel-body">
                        <h4>Dados Pessoais.</h4> 

                        <div class="row">
                            <div class="col-sm-6">
                                <small>titular da conta: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Fisica[nome]" class="form-control" placeholder="Nome do Titular da conta:">
                            </div>
                            <div class="col-sm-6">
                                <small>CPF: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Fisica[cpf]" class="form-control cpf" id="cpf" placeholder="CPF do Titular da conta:">
                            </div>
                            <div class="col-sm-6">
                                <small>RG: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Fisica[rg]" class="form-control" placeholder="RG do Titular da conta:">
                            </div>
                        </div>

                        <hr>
                        <h4>Dados para Contato.</h4> 

                        <div class="row">
                            <div class="col-sm-9">
                                <small>E-mail: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Email[email]" class="form-control" placeholder="E-mail válido para contato:">
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="col-sm-8" style="padding-left: 0px;">
                                    <small>Telefone: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Contato[telefone][]" class="form-control fone" placeholder="Número:">
                                </div>
                                <div class="col-sm-4">
                                    <small>Tipo Telefone: <strong class="text text-danger"></strong></small>
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
                            <div class="col-sm-6">
                                <small>Login Usuário: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Usuario[login]" class="form-control" placeholder="Login:">
                            </div>
                            
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <small>Senha: <strong class="text text-danger">*</strong></small>
                                <input type="password" name="Usuario[senha]" class="form-control" placeholder="Senha:">
                            </div>
                            <div class="col-sm-6">
                                <small>Confirmação de senha: <strong class="text text-danger">*</strong></small>
                                <input type="password" name="Usuario[confirm_senha]" class="form-control" placeholder="Confirmação de senha:">
                            </div>
                        </div>
                        

                </div>
                <div class="panel panel-footer">
                        <button class="btn btn-primary">CADASTRAR</button>
                </div>
            
            </form>
        </div>
    </div>
</section>