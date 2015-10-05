
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-12 col-xs-12" id="disponibilidadeMesas">
            <?php
            foreach ($mesasRestantes as $mesaRestante) :
                $mesasDisponiveis = $mesaRestante['totalMesas'] - $mesaRestante['mesasReservadas'];
                ?>
                <div class="col-xs-3 col-sm-3">
                    <h5><?= $mesaRestante['ambiente'] ?></h5>
                        <!--p><small>Total de mesas:</small> <br>
                    <?php if ($mesaRestante['totalMesas'] == 0): ?>
                                    <label class="text text-warning"><i class="fa fa-warning"></i> Nenhuma mesa cadastrada!</label>
                    <?php else: ?>
                                    <label class="text text-primary"><?= $mesaRestante['totalMesas'] ?> Mesas cadastradas</label>
    <?php endif; ?>
                        </p-->

    <!--p style="margin-top: -15px"><small>Mesas reservadas hoje:</small> <br>
                    <?php if ($mesaRestante['mesasReservadas'] == 0): ?>
                <label class="text text-info">Nenhuma mesa reservada</label>
                    <?php else: ?>
                <label class="text text-primary"><?= $mesaRestante['mesasReservadas'] ?> mesas reservadas</label>
    <?php endif; ?>
    </p-->

                    <p style="margin-top: -10px"><small>Mesas disponíveis:</small> <br>
                        <?php if ($mesasDisponiveis == 0): ?>
                            <label class="label label-danger">Indisponivel para cadastro</label>
                        <?php else: ?>
                            <label class="label label-primary"><?= $mesasDisponiveis ?> mesas disponiveis</label>
    <?php endif; ?>
                    </p>
                </div>
<?php endforeach; ?>
        </div>

        <div class="clearfix"></div><hr>

        <div class="col-sm-12">
            <div class="form-group form-group-sm">
                <div class="col-sm-3">
                    <small>Ambientes: </small>
                    <select name="ambientes_id" id="ambientes_id" class="form-control">
                        <option value="0"> ** Todos ** </option>
                        <?php
                        foreach ($ambientes as $registro):
                            ?>
                            <option value="<?= $registro['Ambiente']['id'] ?>" > <?= ucwords($registro['Ambiente']['nome']) ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <small>Escolha a data: </small>
                    <div class='input-group input-group-sm date datetimepicker2'>
                        <input type="text" class="form-control date_time" name="data_inicio" id="data_inicio" placeholder="DD/MM/AAAA" value="<?= date('d/m/Y')?>">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
    
                <!--div class="col-md-3">
                        <small>Data Fim: </small>
                        <div class='input-group date datetimepicker2'>
                                <input type="text" class="form-control date_time" name="data_fim" id="data_fim" placeholder="DD/MM/AAAA">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                </div-->
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <button class="btn btn-primary btn-block btn-sm " id="filtrar"> Filtrar</button>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <button class="btn btn-primary btn-block btn-sm " id="imprimir-relatorio"><i class="fa fa-print"></i> Imprimir</button>
                </div>
            </div>
            <div class="col-sm-2 pull-right">
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-block" id="cadastro-reserva"> Cadastrar reserva</button>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">Lista de Reservas.</div>
    <div class="panel-body" id="panel-body">
        
        <table class="table table-condensed " id="dynamic-table">
            <thead>
                <tr>
                    <th style="width:15%">Cliente</th>
                    <th style="width:8%">Telefone</th>
                    <th style="width:10%">Ambiente</th>
                    <th style="width:10%">Mesas</th>
                    <th style="width:10%">Data Reserva</th>
                    <th style="width:5%">Enviado</th>
                    <th style="width:5%">Confirmado</th>
                    <th style="width:5%"></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($registros)):
                foreach ($registros as $registro):
            ?>
                    <tr>
                        <td ><?= $registro['cliente'] ?></td>
                        <td ><strong><?= $registro['telefone'] ?></strong></td>
                        <td ><?= $registro['ambiente'] ?></td>
                        <td ><small><?= $registro['mesas'] ?></small></td>
                        <td ><?= Utils::convertData($registro['start']) ?></td>
                        <td class="text-center">
                            <?php if($registro['status']):?>
                                <strong class="text text-success"><i class="fa fa-check"></i> Sim</strong>
                            <?php else:?>
                                <strong class="text text-danger"><i class="fa fa-times"></i> Não</strong>
                            <?php endif;?>
                        </td>
                        <td class="text-center">
                            <?php if($registro['confirm']):?>
                                <a class="label label-success"><i class="fa fa-check"></i></a>
                            <?php else:?>
                                <a class="label label-danger confirm-envio-email" data-token="<?= $registro['token'];?>"><i class="fa fa-times"></i></a>
                            <?php endif;?>
                        </td>
                        <td >
                            <div class="btn-group btn-group-xs" >
                                <button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">
                                    Ações <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" style="font-size:11px; margin-left:-95px">
                                    <!--li><a class="" href="<?= Router::url(array('Reservas', 'listaConvidados', $registro['token'] )) ?>"><i class="fa fa-users"></i> Convidados</a></li-->
                                    <li><a class="" target="_blank" href="<?= $urlPDF .DS.md5($registro['id']) ?>"><i class="fa fa-print"></i> Gerar PDF</a></li>
                                    <li><a class="editarRegistro" style="cursor: pointer" data-idregistro="<?= ($registro['id']) ?>" data-href="<?= Router::url(array('Reservas', 'editar')) ?>" > <i class="fa fa-edit"></i> Editar</a></li>
                                    <li><a class="cancelarRegistro" style="cursor: pointer" data-idregistro="<?= ($registro['token']) ?>" data-href="<?= Router::url(array('Reservas', 'cancelarRegistro')) ?>"> <i class="fa fa-times"></i> Cancelar Registro</a></li>
                                    <li class="divider"></li>
                                    <li><a class="envioEmail" style="cursor:pointer" data-url="<?= Router::url(array('Reservas', 'envioEmail', $registro['token'])) ?>"><i class="fa fa-envelope"></i> Enviar E-mail</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
            <?php
                endforeach;
            endif;
            ?>
            </tbody>
        </table>
        
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalFormulario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Reserva</h4>
            </div>
            <div class="modal-body append-body" id="append-body"> </div>  
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        
        $('#filtrar').click(function() {
            
            var ambientes_id = $('#ambientes_id').val();
            var data_inicio = $('#data_inicio').val();
            var data_fim = $('#data_fim').val();
            var fraseLoading = '';
            if (data_inicio.length > 0) {
                fraseLoading = ' para a data <strong>' + data_inicio + '</strong> ';
            }


            if( data_inicio.length == 10 ){
                $('#panel-body').empty();
                $('<div class="alert alert-info"><p>Filtrando Reservas ' + fraseLoading + ' ...</p></div>').appendTo('#panel-body');
                $.ajax({
                    url: web_root + 'Reservas/filtrar',
                    data: {
                        ambientes_id: ambientes_id,
                        data_inicio: data_inicio,
                        data_fim: data_fim,
                    },
                    dataType: 'html',
                    type: 'post',
                    success: function(data, textStatus, jqXHR) {
                        $('#panel-body').html(data);
                    }
                });
            }
            if( data_inicio.length == 10 ){
                
                $('#disponibilidadeMesas').empty();
                $('<div class="alert alert-info"><p>Verificando a disponibilidade de mesas para a data <b>'+data_inicio+'</b></p></div>').appendTo('#disponibilidadeMesas');
                $.ajax({
                    url: web_root + 'Reservas/disponibilidadeMesas',
                    data: {
                        data: data_inicio,
                    },
                    dataType: 'html',
                    type: 'post',
                    success: function(data, textStatus, jqXHR) {
                        $('#disponibilidadeMesas').html(data);
                    }
                });
            }
        });
    });


    $('#imprimir-relatorio').click(function() {
            
            var ambientes_id = $('#ambientes_id').val();
            var data_inicio  = $('#data_inicio').val();
            var data_fim     = $('#data_fim').val();

            data_inicio = data_inicio.split('/');

            data_inicio = data_inicio[2] + '-' + data_inicio[1] + '-' + data_inicio[0];

            if( data_inicio.length == 10 ){
                var url = 'http://snappypdf.com.br/gerar.php?url=' + web_root + 'Reservas/relatorio/' + data_inicio + '/' + ambientes_id + '/' + '<?= md5( Session::read('Empresa.empresas_id') ); ?>';
                window.open(url, '_blank');
            }
            
    });


    $(document).on('click', '.envioEmail', function() {
        $('#loading').fadeIn(500);
        var url = $(this).data('url');
        $this = $(this);

        $.ajax({
            url: url,
            data: {},
            dataType: 'json',
            type: 'get',
            success: function(data, textStatus, jqXHR) {
                if (data.style == 'success') {

                    $this.parent().parent().parent().parent().parent().find('.text').addClass('text-success');
                    $this.parent().parent().parent().parent().parent().find('.text').removeClass('text-danger');
                    $this.parent().parent().parent().parent().parent().find('.text').html('<i class="fa fa-check"></i> Sim');

                    bootsAlert(data);
                } else {
                    bootsAlert(data);
                }
            }
        });
    });

    $(document).on('click', '#cadastro-reserva', function() {
        //$('#loading').fadeIn(500);
        var url = $(this).data('url');
        var ambientes_id = $("#ambientes_id").val();
        var data_inicio = $("#data_inicio").val();

        if (data_inicio.length > 0) {
            data_inicio = data_inicio.split('/');
            data_inicio = data_inicio[2] + '-' + data_inicio[1] + '-' + data_inicio[0];
            novoEvento(data_inicio, 'Reservas/cadastro');
        } else {
            bootsAlert({
                style: 'warning',
                icon: 'warning',
                title: 'Atenção',
                message: 'Para fazer uma nova reserva, você deve escolher uma data!',
                button: 'Fechar',
                time: 5000,
                size: 'sm',
            });
        }
    });


    $(document).on('click', '.confirm-envio-email', function(){
          var token = $(this).data('token'); 
          $this     = $(this);
                    
          if( token.length > 0 ){
            $('#loading').fadeIn(500);
            $.ajax({
                url: web_root + 'Reservas/confirmReserva/',
                data:{ token: token},
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    
                    if( data.style == 'success' ){
                        $($this).addClass('label-success');
                        $($this).removeClass('label-danger');
                        $($this).find('i').removeClass('fa-times');
                        $($this).find('i').addClass('fa-check');
                    }
                    bootsAlert(data);
                    
                }
            });
        }  
       });
       
        $(document).on('keyup', '#qtde_pessoas', function(){
            $('#assentos').val( $('#qtde_pessoas').val() ) ;
        });
</script>  

