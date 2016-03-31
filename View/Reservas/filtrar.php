<table class="table table-condensed " id="dynamic-table">
    <thead>
        <tr>
            <th style="width:15%">Cliente</th>
            <th style="width:8%">Telefone</th>
            <th style="width:10%">Ambiente</th>
            <th style="width:3%">PAX</th>
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

                    $statusCadastro = NULL;
                    if( $registro['status_reserva'] == 0 ){
                        $statusCadastro = 'background-color:#ffcc66;  color:#1c1c1c;';
                    }
    ?>
            <tr style="<?= $statusCadastro?>">
                <td style="<?= $statusCadastro?>"><?= ( $registro['status_reserva'] > 0 )? $registro['cliente'] : 'Cadastro Iniciado' ?></td>
                <td ><strong><?= $registro['telefone'] ?></strong></td>
                <td ><?= $registro['ambiente'] ?></td>
                <td ><?= $registro['qtde_pessoas'] ?></td>
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
                        <?php if($registro['status_reserva'] == 1):?>
                            <button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">
                                Ações <span class="caret"></span>
                            </button>
                                <ul class="dropdown-menu" role="menu" style="font-size:11px; margin-left:-95px">
                                    <li><a class="lista-convidados" style="cursor:pointer" data-url="<?= Router::url(array('Reservas', 'listarConvidados', $registro['token'])) ?>"><i class="fa fa-users"></i> Convidados</a></li>
                                    <li><a class="" target="_blank" href="<?= $urlPDF . DS . md5($registro['id']) ?>"><i class="fa fa-print"></i> Gerar PDF</a></li>
                                    <li><a class="editarRegistro" style="cursor: pointer" data-idregistro="<?= ($registro['id']) ?>" data-href="<?= Router::url(array('Reservas', 'editar')) ?>" > <i class="fa fa-edit"></i> Editar</a></li>
                                    <li><a class="cancelarRegistro" style="cursor: pointer" data-idregistro="<?= ($registro['token']) ?>" data-href="<?= Router::url(array('Reservas', 'cancelarRegistro')) ?>"> <i class="fa fa-times"></i> Cancelar Registro</a></li>
                                    <li class="divider"></li>
                                    <?php if($_SESSION['Empresa']['envio_sistema'] == 1):?>
                                        <li><a class="envioEmail" style="cursor:pointer" data-url="<?= Router::url(array('Reservas', 'envioEmail', $registro['token'])) ?>"><i class="fa fa-envelope"></i> Enviar E-mail (Sistema)</a></li-->
                                    <?php endif;?>
                                    <?php if($_SESSION['Empresa']['envio_outlook'] == 1):?>
                                        <li><a href="mailto:<?= $registro['email']; ?>" style="cursor:pointer" ><i class="fa fa-envelope"></i> Enviar E-mail (Outlook)</a></li>
                                    <?php endif;?>
                                </ul>

                        <?php else :?>
                            <a class="deletarRegistro btn btn-danger" data-idregistro="<?= ($registro['id']) ?>" data-href="<?= Router::url(array('Reservas', 'deletar-registro')) ?>" > <i class="fa fa-times-circle"></i> Deletar</a>
                        <?php endif;?>
                    </div>
                </td>
            </tr>
    <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {

        $('#dynamic-table').dataTable({
            "language": {
                "url": web_root + "View/webroot/js/data-tables/json/DataTable-Portuguese-Brasil.json"
            }
        });
              
    });
</script>


