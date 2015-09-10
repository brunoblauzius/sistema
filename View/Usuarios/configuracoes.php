<div class="row">
    <div class="col-sm-12">
            <section class="panel panel-default">
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
	<div class="col-sm-4">
		<section class="panel panel-default">
			<div class="panel-heading">
				Logo atual
			</div>
			<div class="panel-body">
                            <?php if(isset($_SESSION['Empresa']['logo'])):?>
                                <img alt="" id="img" class="img-responsive" src="<?= Router::url('View/webroot/img/logos/'.Session::read('Empresa.logo'))?>">
                            <?php else:?>
                                <img src="http://placehold.it/200x100" id="img" class="img-responsive">
                            <?php endif;?>
			</div>

		</section>
	</div>
	<div class="col-sm-8">

		<section class="panel panel-default">
			<div class="panel-heading">
				Logomarca da sua Empresa
			</div>
			<div class="panel-body">
				<form enctype="multipart/form-data" action="<?= $this->urlRoot()?>Usuarios/enviarFoto" method="POST" id="FotoAddForm">
					<input type="file" class="form-control" id="imgInp" name="foto">
					<hr>
					<button type="submit" class="btn btn-primary">Enviar imagem</button>
				</form>
			</div>

		</section>
            
                
                <section class="panel panel-default">
                    <div class="panel-heading">
                        Dados da sua Empresa
                    </div>
                    <div class="panel-body">
                        <form enctype="multipart/form-data" action="<?= $this->urlRoot()?>Empresas/edit" method="POST" id="EmpresaAddForm">
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <small>Razão social:</small>
                                    <input type="text" name="Empresa[razao]" id="razao" class="form-control" value="<?= strtoupper($empresa['razao'])?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <small>Nome fantasia:</small>
                                    <input type="text" name="Empresa[nome_fantasia]" id="nomeFantasia" class="form-control" value="<?= strtoupper($empresa['nome_fantasia'])?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-primary">Alterar Registro</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
        

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