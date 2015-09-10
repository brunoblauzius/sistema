<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url(array('Usuarios', 'painel'))?>">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url(array('Clientes'))?>">Lista</a>
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
          <h3 class="panel-title">Clientes (Cadastro)</h3>
        </div>
        <div class="panel-body">
          
            <form action="<?= Router::url(array('Clientes', 'add'));?>" name="ClienteAddForm" id="ClienteAddForm" class="ClienteAddForm" method="post" accept-charset="UTF-8">
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3>Dados Pessoais</h3>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Nome:</small>
                                <input type="text" id="" class="form-control round-input" name="Cliente[nome]" placeholder="Nome: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>RG:</small>
                                <input type="text" id="" class="form-control round-input" name="Cliente[rg]" placeholder="RG: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>CPF:</small>
                                <input type="text" id="cpf" class="form-control round-input" name="Cliente[cpf]" placeholder="CPF: " >
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3>Endereço</h3>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>CEP:</small>
                                <input type="text" id="cep" class="form-control round-input" name="Cliente[cep]" placeholder="CEP: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Logradouro:</small>
                                <input type="text" id="logradouro" class="form-control round-input" name="Cliente[logradouro]" placeholder="Logradouro: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Cidade:</small>
                                <input type="text" id="cidade" class="form-control round-input" name="Cliente[cidade]" placeholder="Cidade: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Bairro:</small>
                                <input type="text" id="bairro" class="form-control round-input" name="Cliente[bairro]" placeholder="Bairro: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Estado:</small>
                                <input type="text" id="uf" class="form-control round-input" name="Cliente[uf]" placeholder="Estado: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Numero:</small>
                                <input type="text" id="" class="form-control round-input" name="Cliente[numero]" placeholder="Numero: " >
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3>Contato</h3>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Telefone Fixo:</small>
                                <input type="text" id="" class="form-control telefone round-input" name="Cliente[telefone]" placeholder="Telefone Fixo: " >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Telefone Celular:</small>
                                <input type="text" id="" class="form-control telefone round-input" name="Cliente[celular]" placeholder="Telefone Celular: " >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>E-mail:</small>
                                <input type="text" id="" class="form-control round-input" name="Cliente[email]" placeholder="E-mail: " >
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-12">
                            <button class="btn btn-primary">Cadastrar</button>
                            <button type="reset" class="btn btn-default">Limpar Campos</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>