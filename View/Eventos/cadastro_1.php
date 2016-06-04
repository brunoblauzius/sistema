<div class="row">
    <div class="col-md-12">
        

            <div class="form-group">
                <div class="row">
                    <div class="col-md-12 ">
                        <a class="btn btn-primary eventos-btn" data-div="#eventos"><i class="fa fa-star"></i> Evento</a>
                        <a class="btn btn-default eventos-btn" data-div="#atracoes"><i class="fa fa-star"></i> Atrações</a>
                    </div>
                </div>
            </div>
            <div id="eventos" class="div-container">
                <form action="<?= Router::url(array('Eventos', 'add'));?>" method="post" enctype="multipart/form-data" name="EventosAdd">
                    
                    <div class="form-group" id="content-image" style="display: none">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="http://placehold.it/850x400" class="img-thumbnail" id="img-event"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <small>Titulo do Evento <b class="text text-danger">*</b></small>
                        <input type="text" name="Evento[title]" class="form-control" placeholder="Titulo do Evento:">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <small>Data: <strong class="text text-danger">*</strong></small>
                                <div class='input-group datetimepicker2'>
                                    <input type='text' class="form-control" name="Evento[data]" id="start"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <small>Horario<b class="text text-danger">*</b></small>
                                <input type="text" name="Evento[hora_inicio]" class="form-control data_time" placeholder="horario:">
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
                        <textarea  name="Evento[descricao]" class="form-control" rows="5" placeholder="Descrição do Evento:"></textarea>
                    </div>
                    <div class="form-group">
                        <small>Informações promoters <b class="text text-danger"></b></small>
                        <textarea  name="Evento[informacoes_promoters]" class="form-control" rows="5" placeholder="Esta mensagem aparece na página [Minha Lista] para todos os divulgadores:"></textarea>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block">Cadastra Evento Agora</button>
                    </div>
                </form>
            </div>
            <div id="atracoes" class=" div-container hide">
                <form action="<?= Router::url(array('Eventos', 'add-atracoes'));?>" method="post" enctype="multipart/form-data" name="EventosAddAtracoes">
                    
                    <section class="col-md-12">
                        <div class="col-md-12 pddnull">
                            <div class="alert alert-info">
                                <ol>
                                <li>
                                    <small>Para adicionar atração este evento, selecione a atração e clique no botão cadastrar <i class="fa fa-save marginNull"></i></small>
                                </li>
                                <li>
                                    <small>Para criar uma nova atração, clique no botão de adicionar mais <i class="fa fa-pencil-square marginNull"></i></small>
                                </li>
                                <li>
                                    <small>Para excluir a atração selecionada para este evento, vá até a lista de atrações clique no botão de excluir <i class="fa fa-times-circle marginNull"></i></small>
                                </li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-10 pddnull">
                            <div class="form-group">
                                <select name="Evento[atracoes_id]" class="form-control" id="atracoes_id" >
                                    <option value=""> selecione as atrações (*) </option>
                                    <?php foreach ($atracoes as $atracao):?>
                                        <option value="<?= $atracao['Atracao']['id']?>"> <?= $atracao['Atracao']['descricao']?> </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <a class="btn btn-primary" id="btn-save" title="cadastrar"><i class="fa fa-save marginNull"></i></a>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <a class="btn btn-info" id="btn-nova-atracao" title="adicionar mais"><i class="fa fa-pencil-square marginNull"></i></a>
                            </div>
                        </div>
                    </section>
                    
                    <section class="col-md-12 modal-body" id="cadastro-novas-atracoes" style="display: none; background-color:#FFF; margin-left:-15px; position: absolute; z-index:100">
                        <div class="form-group">
                            <small>Atração do Evento <b class="text text-danger">*</b></small>
                            <input type="text" name="Evento[atracao]" class="form-control" id="input-atracao" placeholder="Atração do Evento:">
                        </div>

                        <div class="form-group">
                            <a class="btn btn-primary btn-block" id="salvar-nova-atracao">salvar nova atração</a>
                            <a class="btn btn-danger btn-block" id="cancelar-cadastro">cancelar</a>
                        </div>
                    </section>
                    
                    <section class="col-md-12 margin20" >
                        <table class="table table-condensed table-hover">
                            <thead>
                                <th style="width:90%">Atração</th>
                                <th>Ação</th>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>
                    </section>
                    
                </form>
            </div>
            
    </div>
</div>

<script type="text/javascript">
$(document).ajaxComplete(function( event,request, settings ) {
         
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