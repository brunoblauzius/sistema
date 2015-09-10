<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <?php if ($this->AclCheck('Usuarios', 'painel', Session::read('Usuario.roles_id'))): ?>
                <li>
                    <a href="<?= $this->urlRoot() ?>Usuarios/painel">Home</a>
                </li>
            <?php endif; ?>
            <?php if ($this->AclCheck('Usuarios', 'index', Session::read('Usuario.roles_id'))): ?>
                <li>
                    <a class="active-trail active" href="<?= $this->urlRoot() ?>Usuarios/index">Usuários</a>
                </li>
            <?php endif; ?>
            <li>
                <a class="current" href="#">Alterar meus dados</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Usuário Editar
    </div>

    <div class="panel-body">
        <div class=" col-md-6" >
            <form id="UsuarioEditForm" action="<?= Router::url(array('Usuarios', 'edit')); ?>" method="POST" accept-charset="UTF-8">
                <div class=" col-md-12" >

                    <p>Entre com suas informações pessoais.</p>

                    <div class="form-group">
                        <small>Tipo de Pessoa:</small>
                        <select name="Pessoa[tipo_pessoa]" class="form-control" id="tipo_pessoa" disabled="disabled">
                            <?php if (Session::read('Usuario.tipo_pessoa') == 1): ?>
                                <option value="1">Pessoa Física</option>
                            <?php else: ?>
                                <option value="2">Pessoa Juridica</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <!-- PESSOA FISICA -->
                    <div id="pessoa-fisica" style="display: none;">
                        <small>CPF:</small>
                        <div class="form-group">
                            <input type="text" disabled="disabled" class="form-control cpf" id="cpf" name="Fisica[cpf]" placeholder="CPF" autofocus value="<?= Session::read('Usuario.cpf') ?>">
                        </div>
                    </div>
                    <!-- FIM -->

                    <div class="form-group">
                        <small>Nome completo:</small>
                        <input type="text" class="form-control" name="Fisica[nome]" placeholder="Nome" autofocus value="<?= Session::read('Usuario.nome') ?>">
                    </div>
                    <!-- PESSOA JURIDICA -->
                    <div id="pessoa-juridica">
                        <small>Razão Social:</small>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Juridica[razao]" placeholder="Razão social" autofocus value="<?= Session::read('Usuario.razao') ?>">
                        </div>
                        <div class="form-group">
                            <small>Nome Fantasia:</small>
                            <input type="text" class="form-control" name="Juridica[nome_fantasia]" placeholder="Nome Fantasia" autofocus value="<?= Session::read('Usuario.nome_fantasia') ?>">
                        </div>
                        <div class="form-group">
                            <small>Inscrição Estadual:</small>
                            <input type="text" class="form-control" name="Juridica[ie]" placeholder="Inscrição Estadual" autofocus value="<?= Session::read('Usuario.ie') ?>">
                        </div>
                        <div class="form-group">
                            <small>CNPJ:</small>
                            <input type="text" disabled="disabled" class="form-control cnpj" id="cnpj" name="Juridica[cpf_cnpj]" placeholder="CNPJ" autofocus value="<?= Session::read('Usuario.cnpj') ?>">
                        </div>
                    </div>
                    <!-- FIM -->

                    <div class="form-group">
                        <small>E-mail pessoal:</small>
                        <input type="text" class="form-control" name="Email[email]" placeholder="E-mail" autofocus value="<?= $email['email'] ?>">
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <p>Endereço.</p>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small>CEP:</small>
                            <input type="text" id="cep" class="form-control" name="Endereco[cep]" placeholder="CEP: " value="<?= $endereco[0]['cep'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small>Logradouro:</small>
                            <input type="text" id="logradouro" class="form-control " name="Endereco[logradouro]" placeholder="Logradouro: " value="<?= $endereco[0]['logradouro'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small>Cidade:</small>
                            <input type="text" id="cidade" class="form-control" name="Endereco[cidade]" placeholder="Cidade: " value="<?= $endereco[0]['cidade'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small>Bairro:</small>
                            <input type="text" id="bairro" class="form-control" name="Endereco[bairro]" placeholder="Bairro: " value="<?= $endereco[0]['bairro'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small>Estado:</small>
                            <input type="text" id="uf" class="form-control" name="Endereco[uf]" placeholder="Estado: " value="<?= $endereco[0]['uf'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small>Numero:</small>
                            <input type="text" id="" class="form-control" name="Endereco[numero]" placeholder="Numero: " value="<?= $endereco[0]['numero'] ?>">
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <p>Contato.</p>
                    <div class="clearfix"></div>
                            
                    <?php foreach ($contatos as $contato):?>
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
                            <input type="hidden" name="Contato[id][]" value="<?= $contato['id']?>">
                            </div>
                           
                     
                        <div class="clearfix"></div>
                    <?php endforeach;?>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-4 form-group">
                    <button class="btn btn-primary"> Alterar</button>
                </div>
            </form>
        </div>
        
        
        <div class="col-md-6">
            <div class="col-sm-8">
                    <section class="panel panel-default">
                            <div class="panel-heading">
                                   <p>Imagem do usuário.</p>
                            </div>
                            <div class="panel-body">
                                    <?php if(isset($_SESSION['Usuario']['imagem_perfil'])):?>
                                        <img alt="" id="img" class="img-responsive" src="<?= Router::url('View/webroot/img/thumb/'.Session::read('Usuario.imagem_perfil'))?>">
                                    <?php else:?>
                                        <img src="http://placehold.it/400x300" id="img" class="img-responsive">
                                    <?php endif;?>
                                    
                            </div>
                    </section>
            </div>
            <div class="col-sm-8">
                    <section class="panel panel-default">
                            <div class="panel-heading">
                                    Alterar imagem
                            </div>
                            <div class="panel-body">
                                    <form enctype="multipart/form-data" action="<?= $this->urlRoot()?>Usuarios/enviarFotoUsuario" method="POST" id="FotoAddForm">
                                            <input type="file" class="form-control" id="imgInp" name="foto">
                                            <hr>
                                            <button type="submit" class="btn btn-primary">Enviar imagem</button>
                                    </form>
                            </div>
                    </section>
            </div>
            
        </div>
        
        
    </div>
</div>
<script>
    $(document).ready(function() {
        var idTipoPessoa = $('#tipo_pessoa').val();
        if (idTipoPessoa == 1) {
            $('#pessoa-fisica').show();
            $('#pessoa-juridica').hide();
        } else {
            $('#pessoa-fisica').hide();
            $('#pessoa-juridica').show();
        }
        
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
        
        
    });
        
</script>





