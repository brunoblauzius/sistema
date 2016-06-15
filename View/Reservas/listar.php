<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-12 col-xs-12" id="disponibilidadeMesas">
            <?php
            foreach ($mesasRestantes as $mesaRestante) :
                $mesasDisponiveis = $mesaRestante['totalMesas'] - $mesaRestante['mesasReservadas'];
                ?>
                <div class="col-xs-12 col-sm-12 col-md-3">
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

                    <p style="margin-top: -5px">
                        <?php if ($mesasDisponiveis == 0): ?>
                            <label class="label label-danger">Indisponivel para cadastro</label>
                        <?php else: ?>
                            <label class="label label-base"><?= $mesasDisponiveis ?> mesas disponiveis</label>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="clearfix"></div><hr>

        <div class="col-sm-12">
            <div class="form-group form-group-sm">
                <div class="col-xs-12 col-md-3">
                    <small>Filtrar por Ambiente: </small>
                    <select name="ambientes_id" id="ambientes_id" class="form-control">
                        <option value="0"> ** Todos ** </option>
                        <?php
                        foreach ($ambientes as $registro):
                            ?>
                            <option value="<?= $registro['Ambiente']['id'] ?>" > <?= ucwords($registro['Ambiente']['nome']) ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-3">
                    <small>Filtrar por Data: </small>
                    <div class='input-group input-group-sm date datetimepicker2'>
                        <input type="text" class="form-control date_time" name="data_inicio" id="data_inicio" placeholder="DD/MM/AAAA" value="<?= date('d/m/Y') ?>">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-md-2">
                    <button class="btn btn-primary btn-block btn-sm " id="filtrar"> <i class="fa fa-search"></i> Filtrar</button>
                </div>
                <div class="col-xs-12 col-md-2">
                    <button class="btn btn-primary btn-block btn-sm " id="imprimir-relatorio"><i class="fa fa-print"></i> Imprimir</button>
                </div>
                <div class="col-xs-12 col-md-2">
                    <button class="btn btn-primary btn-sm btn-block" id="cadastro-reserva"><i class="fa fa-pencil"></i> Cadastrar</button>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="panel">
    <div class="panel-heading bg-header-primary">Lista de Reservas.</div>
    <div class="panel-body" id="panel-body">
        <?= Render::element('Reservas/tabelaListaReservas', array('registros' => $registros, 'urlPDF' => $urlPDF))?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="ModalFormulario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Reserva</h4>
            </div>
            <div class="modal-body append-body" id="append-body"> </div>  
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Modal-lista-convidados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Convidados</h4>
            </div>
            <div class="modal-body append-body" id="body-lista-convidados"> 
            </div>  
        </div>
    </div>
</div>



<script>
    
    $(document).ready(function() {

        $('#filtrar').click(function() {

            var ambientes_id = $('#ambientes_id').val();
            var data_inicio = $('#data_inicio').val();
            var data_fim = $('#data_fim').val();
            


            if (data_inicio.length == 10) {
                filtrarReservas( ambientes_id, data_inicio, data_fim );
            }
            if (data_inicio.length == 10) {
                disponibilidadeDeMesas( data_inicio );
            }
        });
    });


    $('#imprimir-relatorio').click(function() {

        var ambientes_id = $('#ambientes_id').val();
        var data_inicio = $('#data_inicio').val();
        var data_fim = $('#data_fim').val();

        data_inicio = data_inicio.split('/');

        data_inicio = data_inicio[2] + '-' + data_inicio[1] + '-' + data_inicio[0];

        if (data_inicio.length == 10) {
            var url = 'http://snappypdf.com.br/landscape.php?url=' + web_root + 'Reservas/relatorio/' + data_inicio + '/' + ambientes_id + '/' + '<?= md5(Session::read('Empresa.empresas_id')); ?>&landscape=0';
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


    $(document).on('click', '.confirm-envio-email', function() {
        var token = $(this).data('token');
        $this = $(this);

        if (token.length > 0) {
            $('#loading').fadeIn(500);
            $.ajax({
                url: web_root + 'Reservas/confirmReserva/',
                data: {token: token},
                dataType: 'json',
                type: 'post',
                success: function(data) {

                    if (data.style == 'success') {
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
    
    
    $(document).on('click', '.email-enviado-painel', function() {
        var token = $(this).data('token');
        $this = $(this);

        if (token.length > 0) {
            $('#loading').fadeIn(500);
            $.ajax({
                url: web_root + 'Reservas/emailEnviadoPainel/',
                data: {token: token},
                dataType: 'json',
                type: 'post',
                success: function(data) {

                    if (data.style == 'success') {
                        $($this).addClass('btn-success');
                        $($this).removeClass('btn-danger');
                        $($this).find('i').removeClass('fa-times');
                        $($this).find('i').addClass('fa-check');
                    }
                    bootsAlert(data);

                }
            });
        }
    });

    $(document).on('keyup', '#qtde_pessoas', function() {
        $('#assentos').val($('#qtde_pessoas').val());
    });

    $(document).on('click', '.lista-convidados', function() {
        var url = $(this).data('url');
        chamaListaDeConvidadosAdminEpdf(url);
    });

</script>  

