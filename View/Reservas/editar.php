<form action="<?= Router::url(array('Reservas', 'edit')) ?>" method="post" id="ReservaAddForm" name="ReservaAddForm">
    <div class="modal-body">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <small>Data: <strong class="text text-danger">*</strong></small>
                    <div class='input-group date datetimepicker2'>
                        <input type='text' class="form-control date_time" name="Reserva[data]" id="start" value="<?= $lista['Reserva']['start']?>"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <small>Hora: <strong class="text text-danger">*</strong></small>
                    <div class='input-group' id=''>
                        <span class="input-group-addon">
                            <div class="glyphicon glyphicon-time"></div>
                        </span>
                        <input type='text' class="form-control data_time " id="hora" name="Reserva[hora]" value="<?= $lista['Reserva']['end']?>"/>
                    </div>                               
                </div>
            </div>
        </div>
        
        <?php if( $lista['Reserva']['status'] == 0 ):?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <small>Cliente: <strong class="text text-danger">*</strong></small>
                        <input type='text' class="form-control" name="Busca[cliente]" id="cliente" value="<?= $cliente[0]['Cliente']['nome']?>"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <small>Burcar cliente por: <strong class="text text-danger">*</strong></small>
                        <select name="Busca[buscaPor]" class="form-control" id="BuscarPor">
                            <option value="nome"> NOME </option>
                            <option value="rg"> RG </option>
                            <option value="telefone"> TELEFONE </option>
                            <option value="email"> E-MAIL </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <a class="btn btn-primary pull-right btn-xs" id="procurar-cliente">Procurar Cliente</a>
                    </div>
                </div>
            </div>
        <?php endif;?>
        
        <div class="row" id="dados-cliente"> 
            <div class="col-sm-12 form-group-sm">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <small>Nome:</small>
                                <input type="text"  class="form-control" value="<?= $cliente[0]['Cliente']['nome']?>" disabled="true">
                            </td>
                            <td>
                                <small>E-mail:</small>
                                <input type="text" class="form-control" value="<?= $cliente[0]['Cliente']['email']?>" disabled="true">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>Rg:</small>
                                <input type="text"  class="form-control" value="<?= $cliente[0]['Cliente']['rg']?>" disabled="true">
                            </td>
                            <td>
                                <small>Telefone:</small>
                                <input type="text"  class="form-control" value="<?= $cliente[0]['Cliente']['telefone']?>" disabled="true">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    
                    <input type="hidden" name="Reserva[clientes_id]" class="form-control" value="<?= md5($cliente[0]['Cliente']['id'])?>">
                </div>
            </div>
            
        </div>


        <div class="row" id="dados-reserva">
            <div class="col-sm-6">
                <div class="form-group">
                    <small>Número Pessoas: <strong class="text text-danger">*</strong></small>
                    <input type='text' class="form-control" name="Reserva[qtde_pessoas]" id="qtde_pessoas" value="<?= $lista['Reserva']['qtde_pessoas']?>"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <small>Lugares: <strong class="text text-danger">*</strong></small>
                    <input type='text' class="form-control" name="Reserva[assentos]" id="assentos" value="<?= $lista['Reserva']['assentos']?>"/>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-6">
                <div class="form-group">
                    <small>Salões: <strong class="text text-danger">*</strong></small>
                    <select name="Reserva[saloes_id]" class="form-control rounded" id="SalaoId">
                        <?php foreach ($saloes as $salao):?>
                            
                            <?php if($lista['Reserva']['saloes_id'] == $salao['Salao']['id'] ):?>
                                <option value="<?= $salao['Salao']['id']?>" selected="selected"> <?= $salao['Salao']['nome']?> </option>
                            <?php else:?>
                                <option value="<?= $salao['Salao']['id']?>"> <?= $salao['Salao']['nome']?> </option>
                            <?php endif;?>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <small>Ambiente: <strong class="text text-danger">*</strong></small>
                    <select name="Reserva[ambientes_id]" class="form-control rounded" id="AmbienteId">
                        <?php foreach ($ambientes as $ambiente):?>
                            
                            <?php if($lista['Reserva']['ambientes_id'] == $ambiente['Ambiente']['id'] ):?>
                                <option value="<?= $ambiente['Ambiente']['id']?>" selected="selected"> <?= $ambiente['Ambiente']['nome']?> </option>
                            <?php else:?>
                                <option value="<?= $ambiente['Ambiente']['id']?>"> <?= $ambiente['Ambiente']['nome']?> </option>
                            <?php endif;?>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12" id="mesas-cadastro">
                <h5>Mesas Livres:</h5>
                    <?php if(empty($mesas)):?>
                        <div class="alert alert-warning">
                            <p class="text-center"> Não existem mesas disponíveis para esse ambiente!</p>
                        </div>
                    <?php endif;?>

                    <div class="col-sm-12">
                        <?php foreach ($mesas as $mesa) :?>
                            <div class="col-sm-4">
                                <?php foreach ($mesa as $key => $value) :?>

                                    <?php if( array_keys($mesasReservadas, $value)):?>
                                        <label class="checkbox">
                                            <input type="checkbox" name="Reserva[mesas_id][]" value="<?= $key ?>" checked="checked"> <?= ucwords($value) ?>
                                        </label>
                                    <?php else:?>
                                        <label class="checkbox">
                                            <input type="checkbox" name="Reserva[mesas_id][]" value="<?= $key ?>"> <?= ucwords($value) ?>
                                        </label>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </div>
                        <?php endforeach;?>
                    </div>

                    <div class="clearfix"></div>
                    <hr>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <small>Observação interna:</small>
                        <textarea name="Reserva[descricao_interna]" id="descricao" class="form-control" rows="4"><?= $lista['Reserva']['descricao_interna']?></textarea>
                    </div>
                    <div class="col-md-12">
                        <small>Observação Cliente:</small>
                        <textarea name="Reserva[descricao_cliente]" id="descricao" class="form-control" rows="4"><?= $lista['Reserva']['descricao_cliente']?></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <input type="hidden" name="Reserva[color]" id="cor" value="#1fb5ad" class="form-control">
                    <input type="hidden" name="Reserva[title]" id="title"  class="form-control">
                    <input type="hidden" name="Reserva[textColor]" id="textColor" value="#FFFFFF" class="form-control">
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer" style="margin-top:20px;">
                    <button class="btn btn-primary enviaForm">Alterar registro</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
                    <input type="hidden" id="id" value="">
                    <input type="hidden" id="acao" value="cadastrar">
                </div>
            </div>
        </div>
    
</form>
<!--script>
$(document).ready(function(){
    
        var ambientes_id = $('#AmbienteId').val();
        var data         = $('#start').val();
        var url          = web_root + 'Mesas/mesasAmbiente';
    
        if( ambientes_id != null || ambientes_id != '' ){
                $.ajax({
                    url:url,
                    data:{
                        id:ambientes_id,
                        data:data
                    },
                    dataType: 'html',
                    type: 'post',
                    success:function(html){
                        $('#mesas-cadastro').html(html);
                    }
                });
        }  
    });
</script-->