<div class="panel panel-primary">
    <div class="panel-heading">Lista de Reservas.</div>
    <div class="panel-body" id="panel-body">

        <table class="table table-condensed " id="dynamic-table">
            <thead>
                <tr>
                    <th style="width:15%">Cliente</th>
                    <th style="width:10%">Ambiente</th>
                    <th style="width:3%">PAX</th>
                    <th style="width:10%">Mesas</th>
                    <th style="width:5%">Total lista</th>
                    <th style="width:5%">Não Confirmados</th>
                    <th style="width:5%">Confirmados</th>
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
                            <td ><?= $registro['ambiente'] ?></td>
                            <td ><?= $registro['qtde_pessoas'] ?></td>
                            <td ><small><?= $registro['mesas'] ?></small></td>
                            <td class="text-center">
                                <?= $registro['total_pessoas_lista'] ?>
                            </td>
                            <td class="text-center">
                                <?= $registro['nao_confirmado'] ?>
                            </td>
                            <td class="text-center">
                                <?= $registro['confirmado'] ?>
                            </td>
                            <td >
                                <div class="btn-group btn-group-xs" >
                                    <button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">
                                        Ações <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="font-size:11px; margin-left:-95px">
                                        <li><a href="<?= Router::url(array('Reservas', 'listarConvidadosHostess', $registro['token'])) ?>"><i class="fa fa-users"></i> Convidados</a></li>
                                        <!--li><a class="" target="_blank" href="<?//= $urlPDF . DS . md5($registro['id']) ?>"><i class="fa fa-print"></i> Gerar PDF</a></li-->
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


            if (data_inicio.length == 10) {
                $('#panel-body').empty();
                //$('<div class="alert alert-info"><p>Filtrando Reservas ' + fraseLoading + ' ...</p></div>').appendTo('#panel-body');
                loadingElement('<br>Filtrando Reservas ' + fraseLoading, '#panel-body');
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
            if (data_inicio.length == 10) {

                $('#disponibilidadeMesas').empty();
                //$('<div class="alert alert-info"><p>Verificando a disponibilidade de mesas para a data <b>'+data_inicio+'</b></p></div>').appendTo('#disponibilidadeMesas');
                loadingElement('<br>Verificando a disponibilidade de mesas para a data <b>' + data_inicio, '#disponibilidadeMesas');
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
        var data_inicio = $('#data_inicio').val();
        var data_fim = $('#data_fim').val();

        data_inicio = data_inicio.split('/');

        data_inicio = data_inicio[2] + '-' + data_inicio[1] + '-' + data_inicio[0];

        if (data_inicio.length == 10) {
            var url = 'http://snappypdf.com.br/landscape.php?url=' + web_root + 'Reservas/relatorio/' + data_inicio + '/' + ambientes_id + '/' + '<?= md5(Session::read('Empresa.empresas_id')); ?>&landscape=1';
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

    $(document).on('keyup', '#qtde_pessoas', function() {
        $('#assentos').val($('#qtde_pessoas').val());
    });

    $(document).on('click', '.lista-convidados', function() {
        var url = $(this).data('url');
        chamaListaDeConvidadosAdminEpdf(url);
    });

</script>  

