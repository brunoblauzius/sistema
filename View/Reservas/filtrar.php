<table class="display table table-condensed table-striped" id="dynamic-table">    <thead>        <tr>            <th>Cliente</th>            <th>Telefone</th>            <th>Funcionário</th>            <th>Data Reserva</th>            <th>E-mail</th>            <th></th>        </tr>    </thead>    <tbody>        <?php        if (!empty($registros)):            foreach ($registros as $registro):        ?>            <tr>                <td style="width:25%"><?= $registro['cliente'] ?></td>                <td style="width:10%"><?= $registro['telefone'] ?></td>                <td style="width:20%"><?= $registro['funcionario'] ?></td>                <td style="width:11%"><?= Utils::convertData($registro['start']) ?></td>                <td><?= ($registro['email']) ?></td>                <td style="width:10%">                    <div class="btn-group">                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown">                            Ações<span class="caret"></span>                        </button>                        <ul class="dropdown-menu" role="menu">                            <li><a class="" href="<?= Router::url(array('Reservas', 'listaConvidados', $registro['token'])) ?>"><i class="fa fa-users"></i> Convidados</a></li>                            <li><a class="" target="_blank" href="http://snappypdf.com.br/gerar.php?url=http://codewave.com.br/sistema/Agendas/imprimir/<?= $registro['token'] ?>"><i class="fa fa-print"></i> Gerar PDF</a></li>                            <!--li class="divider"></li>                            <li></li-->                        </ul>                    </div>                </td>            </tr>        <?php            endforeach;        endif;        ?>    </tbody></table><script>    $(document).ready(function() {        $('#dynamic-table').dataTable({            "language": {                "url": web_root + "View/webroot/js/data-tables/json/DataTable-Portuguese-Brasil.json"            }        });    });</script>