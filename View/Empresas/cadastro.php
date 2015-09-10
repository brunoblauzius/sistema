

<section class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-primary">
            <div class="panel panel-heading">Passo 2: Cadastro de Empresa</div>
            
            <form action="<?= Router::url(array('Empresas', 'add'))?>" method="post" name="EmpresaAddForm" id="EmpresaAddForm" class="">
                
                <div class="panel panel-body">
                        <h4>Dados da Empresa.</h4> 
                        <div class="row">
                            <div class="col-sm-6">
                                <small>Razao Social: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Juridica[razao]" class="form-control" placeholder="Razão Social:">
                            </div>
                            <div class="col-sm-6">
                                <small>Nome Fantasia: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Juridica[nome_fantasia]" class="form-control" placeholder="Nome Fantasia:">
                            </div>
                            <div class="col-sm-6">
                                <small>CNPJ: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Juridica[cnpj]" class="form-control" id="cnpj" placeholder="CNPJ:">
                            </div>
                            <div class="col-sm-6">
                                <small>Inscrição Estadual: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Juridica[ie]" class="form-control" placeholder="Inscrição Estadual:">
                            </div>
                        </div>
                        
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
                            <div class="col-sm-9">
                                <small>E-mail: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Email[email]" class="form-control" placeholder="E-mail válido para contato:">
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="col-sm-8" style="padding-left: 0px;">
                                    <small>Telefone: <strong class="text text-danger">*</strong></small>
                                    <input type="text" name="Contato[telefone][]" class="form-control fone" placeholder="Número:">
                                </div>
                                <div class="col-sm-4">
                                    <small>Tipo Telefone: <strong class="text text-danger">*</strong></small>
                                    <select name="Contato[tipo_telefone][]" class="form-control">
                                        <option value="1"> Fixo </option>
                                        <option value="1"> Celular </option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="col-sm-8" style="padding-left: 0px;">
                                    <small>Telefone: <strong class="text text-danger">*</strong></small>
                                    <input type="text" name="Contato[telefone][]" class="form-control fone" placeholder="Número:">
                                </div>
                                <div class="col-sm-4">
                                    <small>Tipo Telefone: <strong class="text text-danger">*</strong></small>
                                    <select name="Contato[tipo_telefone][]" class="form-control">
                                        <option value="1"> Fixo </option>
                                        <option value="1"> Celular </option>
                                    </select>
                                </div>
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