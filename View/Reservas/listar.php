<div class="panel panel-default">    <div class="panel-body">        <div class="col-sm-12">            <?php            foreach ($mesasRestantes as $mesaRestante) :                $mesasDisponiveis = $mesaRestante['totalMesas'] - $mesaRestante['mesasReservadas'];                ?>                <div class="col-sm-3">                    <h5><?= $mesaRestante['ambiente'] ?></h5>                        <!--p><small>Total de mesas:</small> <br>                    <?php if ($mesaRestante['totalMesas'] == 0): ?>                                    <label class="text text-warning"><i class="fa fa-warning"></i> Nenhuma mesa cadastrada!</label>                    <?php else: ?>                                    <label class="text text-primary"><?= $mesaRestante['totalMesas'] ?> Mesas cadastradas</label>    <?php endif; ?>                        </p-->    <!--p style="margin-top: -15px"><small>Mesas reservadas hoje:</small> <br>                    <?php if ($mesaRestante['mesasReservadas'] == 0): ?>                <label class="text text-info">Nenhuma mesa reservada</label>                    <?php else: ?>                <label class="text text-primary"><?= $mesaRestante['mesasReservadas'] ?> mesas reservadas</label>    <?php endif; ?>    </p-->                    <p style="margin-top: -10px"><small>Mesas disponíveis:</small> <br>                        <?php if ($mesasDisponiveis == 0): ?>                            <label class="label label-danger">Indisponivel para cadastro</label>                        <?php else: ?>                            <label class="label label-primary"><?= $mesasDisponiveis ?> mesas disponiveis</label>    <?php endif; ?>                    </p>                </div><?php endforeach; ?>        </div>        <div class="clearfix"></div><hr>        <div class="col-sm-12">            <div class="form-group form-group-sm">                <div class="col-md-3">                    <small>Ambientes: </small>                    <select name="ambientes_id" id="ambientes_id" class="form-control">                        <?php                        foreach ($ambientes as $registro):                            ?>                            <option value="<?= $registro['Ambiente']['id'] ?>" > <?= ucwords($registro['Ambiente']['nome']) ?> </option>                        <?php endforeach; ?>                    </select>                </div>                <div class="col-md-3">                    <small>Escolha a data: </small>                    <div class='input-group input-group-sm date datetimepicker2'>                        <input type="text" class="form-control date_time" name="data_inicio" id="data_inicio" placeholder="DD/MM/AAAA">                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>                        </span>                    </div>                </div>                <!--div class="col-md-3">                        <small>Data Fim: </small>                        <div class='input-group date datetimepicker2'>                                <input type="text" class="form-control date_time" name="data_fim" id="data_fim" placeholder="DD/MM/AAAA">                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>                                </span>                        </div>                </div-->            </div>            <div class="form-group">                <div class="col-md-2">                    <button class="btn btn-primary btn-block btn-sm " id="filtrar"> Filtrar</button>                </div>            </div>            <div class="form-group pull-right">                <div class="">                    <button class="btn btn-primary btn-sm btn-block" id="cadastro-reserva"> Cadastrar reserva</button>                </div>            </div>        </div>    </div></div><div class="panel panel-primary">    <div class="panel-heading">Lista de Reservas.</div>    <div class="panel-body" id="panel-body">    </div></div><!-- Modal --><div class="modal fade" id="ModalFormulario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">    <div class="modal-dialog">        <div class="modal-content">            <div class="modal-header">                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                <h4 class="modal-title" id="myModalLabel">Reserva</h4>            </div>            <div class="modal-body append-body" id="append-body"> </div>          </div>    </div></div><script>    $(document).ready(function() {        $('#filtrar').click(function() {            $('#panel-body').empty();            var ambientes_id = $('#ambientes_id').val();            var data_inicio = $('#data_inicio').val();            var data_fim = $('#data_fim').val();            var fraseLoading = '';            if (data_inicio.length > 0) {                fraseLoading = ' para a data <strong>' + data_inicio + '</strong> ';            }            $('<div class="alert alert-info"><p>Filtrando Reservas ' + fraseLoading + ' ...</p></div>').appendTo('#panel-body');            $.ajax({                url: web_root + 'Reservas/filtrar',                data: {                    ambientes_id: ambientes_id,                    data_inicio: data_inicio,                    data_fim: data_fim,                },                dataType: 'html',                type: 'post',                success: function(data, textStatus, jqXHR) {                    $('#panel-body').html(data);                }            });        });    });    $(document).on('click', '.envioEmail', function() {        $('#loading').fadeIn(500);        var url = $(this).data('url');        $this = $(this);        $.ajax({            url: url,            data: {},            dataType: 'json',            type: 'get',            success: function(data, textStatus, jqXHR) {                if (data.style == 'success') {                    $this.parent().parent().parent().parent().parent().find('.text').addClass('text-success');                    $this.parent().parent().parent().parent().parent().find('.text').removeClass('text-danger');                    $this.parent().parent().parent().parent().parent().find('.text').html('<i class="fa fa-check"></i> Sim');                    bootsAlert(data);                } else {                    bootsAlert(data);                }            }        });    });    $(document).on('click', '#cadastro-reserva', function() {        //$('#loading').fadeIn(500);        var url = $(this).data('url');        var ambientes_id = $("#ambientes_id").val();        var data_inicio = $("#data_inicio").val();        if (data_inicio.length > 0) {            data_inicio = data_inicio.split('/');            data_inicio = data_inicio[2] + '-' + data_inicio[1] + '-' + data_inicio[0];            novoEvento(data_inicio, 'Reservas/cadastro');        } else {            bootsAlert({                style: 'warning',                icon: 'alert',                title: 'Atenção',                message: 'Para fazer uma nova reserva, você deve escolher uma data!',                button: 'Fechar',                time: 5000,                size: 'sm',            });        }    });</script>  