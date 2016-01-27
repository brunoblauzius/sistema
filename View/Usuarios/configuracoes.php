<div class="row">
    <div class="col-sm-12">
            <section class="panel panel-primary">
                <div class="panel-heading">
                    Empresa
                </div>
                <div class="panel-body">
                    <div class="col-sm-4">Razão social: <strong><?= strtoupper($empresa['razao'])?></strong></div>
                    <div class="col-sm-4">Nome Fantasia: <strong><?= strtoupper($empresa['nome_fantasia'])?></strong></div>
                    <div class="col-sm-4">Situação da Empresa: 
                        <?php if( $empresa['status'] ):?>
                            <strong> ATIVA</strong>
                        <?php else:?>
                            <strong class="text text-danger">BLOQUEADA</strong>
                        <?php endif;?>
                    </div>
                </div>
            </section>
    </div>
</div>
<div class="row">
        <div class="row">
            <div class="col-md-12">
                <div class="col-sm-4">
                    <section class="panel panel-info">
                        <div class="panel-heading">
                            Logomarca da sua Empresa
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <?php if(isset($_SESSION['Empresa']['logo'])):?>
                                    <img alt="" id="img" class="img-responsive" src="<?= Router::url('View/webroot/img/logos/'.Session::read('Empresa.logo'))?>">
                                <?php else:?>
                                    <img src="http://placehold.it/200x100" id="img" class="img-responsive">
                                <?php endif;?>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="col-sm-12">
                                <form enctype="multipart/form-data" action="<?= $this->urlRoot()?>Usuarios/enviarFoto" method="POST" id="FotoAddForm">
                                        <input type="file" class="form-control" id="imgInp" name="foto">

                                        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Enviar imagem</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                
                
                <div class="col-sm-4">
                    <section class="panel panel-info">
                        <div class="panel-heading">
                            Configurações de E-mails.
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <form enctype="multipart/form-data" action="<?= $this->urlRoot()?>Empresas/configEnvioEmail" method="POST" id="ConfigEmailAddForm">
                                    <div class="m-bot20">
                                        <?php 
                                            $envio_outlook = NULL;
                                            $envio_sistema = NULL;
                                            if($_SESSION['Empresa']['envio_outlook'] == 1){
                                                $envio_outlook = 'checked';
                                            }
                                            if($_SESSION['Empresa']['envio_sistema'] == 1){
                                                $envio_sistema = 'checked';
                                            }
                                        ?>
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <input type="checkbox" name="Empresa[envio_outlook]" <?= $envio_outlook?>> Envio pelo OUTLOOK.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <input type="checkbox" name="Empresa[envio_sistema]" <?= $envio_sistema?>> Envio pelo SISTEMA.
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="margin-top:20px;">Alterar</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                
                
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <section class="panel panel-info">
                        <div class="panel-heading">
                            Razão / Nome Fantasia.
                        </div>
                        <div class="panel-body">
                            <form enctype="multipart/form-data" action="<?= Router::url(array('Empresas', 'edit'));?>" method="POST" id="EmpresaAddForm">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <small>Razão social:</small>
                                        <input type="text" name="Empresa[razao]" id="razao" class="form-control" value="<?= strtoupper($empresa['razao'])?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <small>Nome fantasia:</small>
                                        <input type="text" name="Empresa[nome_fantasia]" id="nomeFantasia" class="form-control" value="<?= strtoupper($empresa['nome_fantasia'])?>">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-primary">Alterar dados da empresa</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="col-md-6">
                    <section class="panel panel-info">
                        <div class="panel-heading">
                            Telefones de Contato.
                        </div>
                        <div class="panel-body">
                            <form enctype="multipart/form-data" action="<?= Router::url( array('Contatos', 'edit') ) ?>" method="POST" id="ContatoEditForm">
                                <div class="row">
                                    <div class="col-md-12">         
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
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-primary">Alterar dados</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    
    
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-6">
                <section class="panel panel-info">
                    <div class="panel-heading">
                        Endereço.
                    </div>
                    <div class="panel-body">
                        <form enctype="multipart/form-data" action="<?= Router::url( array('Enderecos', 'edit') ) ?>" method="POST" id="EnderecosEditForm">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <small>CEP: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Endereco[cep]" id="cep" class="form-control cep" placeholder="CEP:" maxlength="8" value="<?= $endereco['cep']?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <small>Logradouro: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Endereco[logradouro]" id="logradouro" class="form-control" placeholder="Logradouro:" value="<?= $endereco['logradouro']?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <small>Cidade: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Endereco[cidade]" id="cidade" class="form-control" placeholder="Cidade:" value="<?= $endereco['cidade']?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <small>Bairro: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Endereco[bairro]" id="bairro" class="form-control" placeholder="Bairro:" value="<?= $endereco['bairro']?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <small>Estado: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Endereco[uf]" id="uf" class="form-control" placeholder="Estado:" value="<?= $endereco['uf']?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <small>Número: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Endereco[numero]" class="form-control" placeholder="Número:" value="<?= $endereco['numero']?>">
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-primary">Alterar dados do endereço</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            
	</div>
        </div>
    </div>
    
        
    
</div>	
<script type="text/javascript">
$(document).ready(function(){
	
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