<div class="panel">
    <header class="bg-header-primary panel-heading">
       Eventos Editar
    </header>
    <div class="panel panel-body">
        <div class="row">
            <div class="col-md-9">

                    <div id="eventos" class="div-container">
                        <form action="<?= Router::url(array('Eventos', 'edit'));?>" method="post" enctype="multipart/form-data" id="EventosEdit">

                            <div class="form-group" id="content-image">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if( !empty($registro['imagem']) && file_exists( ROOT. DS .'View/webroot/img/eventos_banner/'.$registro['imagem'] ) ):?>
                                            <img src="<?= Router::url('/View/webroot/img/eventos_banner/'.$registro['imagem'])?>" class="img-thumbnail" id="img-event"/>
                                        <?php else:?>
                                            <img src="http://placehold.it/850x400" class="img-thumbnail" id="img-event"/>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <small>Titulo do Evento <b class="text text-danger">*</b></small>
                                <input type="text" name="Evento[title]" class="form-control" placeholder="Titulo do Evento:" value="<?= $registro['title']?>">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <small>Data: <strong class="text text-danger">*</strong></small>
                                        <div class='input-group datetimepicker2'>
                                            <input type='text' class="form-control" name="Evento[data]" id="start" value="<?= Utils::getDate($registro['data'])?>"/>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Horario<b class="text text-danger">*</b></small>
                                        <input type="text" name="Evento[hora_inicio]" class="form-control data_time" placeholder="horario:" value="<?= $registro['hora_inicio']?>">
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <small>Banner (800 x 350 JPG) <b class="text text-danger"></b></small>
                                            <input type="file" id="imgInpEvent" name="arquivo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <small>Descrição <b class="text text-danger"></b></small>
                                <textarea  name="Evento[descricao]" class="form-control" rows="5" placeholder="Descrição do Evento:"><?= $registro['descricao']?></textarea>
                            </div>
                            <div class="form-group">
                                <small>Informações promoters <b class="text text-danger"></b></small>
                                <textarea  name="Evento[informacoes_promoters]" class="form-control" rows="5" placeholder="Esta mensagem aparece na página [Minha Lista] para todos os divulgadores:"><?= $registro['informacoes_promoters']?></textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-block">Editar Evento</button>
                            </div>
                        </form>
                    </div>


            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
$(document).ready(function( event,request, settings ) {
         
            function readURL(input) {

                if (input.files && input.files[0]) {
                    $('#content-image').show();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#img-event').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInpEvent").change(function(){
                readURL(this);
            });
});
</script>