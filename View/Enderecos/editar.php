<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url(array('Usuarios', 'painel'))?>">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url(array('Funcionarios', 'perfil', md5( $endereco->getPessoaId() ) ))?>">Perfil</a>
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
          <h3 class="panel-title">Endereço (Cadastro)</h3>
        </div>
        <div class="panel-body">
          
            <form action="<?= Router::url(array('Enderecos', 'edit'));?>" name="EnderecosEditForm" id="EnderecosEditForm" class="EnderecosEditForm" method="post" accept-charset="UTF-8">
                
                <div class="row">
                    <div class="col-md-8">
                        <h3>Endereço</h3>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>CEP:</small>
                                <input type="text" id="cep" class="form-control round-input" name="Endereco[cep]" placeholder="CEP: " value="<?= $endereco->getCep()?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Logradouro:</small>
                                <input type="text" id="logradouro" class="form-control round-input" name="Endereco[logradouro]" placeholder="Logradouro: " value="<?= $endereco->getLogradouro()?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Cidade:</small>
                                <input type="text" id="cidade" class="form-control round-input" name="Endereco[cidade]" placeholder="Cidade: " value="<?= $endereco->getCidade()?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Bairro:</small>
                                <input type="text" id="bairro" class="form-control round-input" name="Endereco[bairro]" placeholder="Bairro: " value="<?= $endereco->getBairro()?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Estado:</small>
                                <input type="text" id="uf" class="form-control round-input" name="Endereco[uf]" placeholder="Estado: " value="<?= $endereco->getUf()?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Numero:</small>
                                <input type="text" id="" class="form-control round-input" name="Endereco[numero]" placeholder="Numero: " value="<?= $endereco->getNumero()?>" >
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12">
                            <button class="btn btn-primary">Editar</button>
                            <button type="reset" class="btn btn-default">Limpar Campos</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>