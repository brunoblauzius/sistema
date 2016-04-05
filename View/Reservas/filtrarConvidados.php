<?php if (!empty($registros)): ?>
<table class="table table-condensed">
            <tbody>
                <tr>
                    <td>
                        <?php foreach ($registros as $registro): ?>
                        <table class="table table-condensed" style="border-bottom: 1px #fff0f2;">
                            <tbody>
                                <tr>
                                    <td style="width:8%;">
                                        <small>Presença:</small><br>
                                        <?php if( $registro['confirmado'] ):?>
                                            <a class="btn btn-xs btn-success"><span class="fa fa-check"></span></a>
                                        <?php else:?>
                                            <a data-clientesid="<?= $registro['id']?>" data-reservasid="<?= $registro['reservas_id']?>" class="confirma-presenca-hostess btn btn-xs btn-danger"><span class="fa fa-times"></span></a>
                                        <?php endif;?>
                                    </td>
                                    <td style="width:35%;">
                                        <p>
                                            <small>Convidado:</small> <strong><?= $registro['nome'] ?></strong>
                                        </p>
                                        <p>
                                            <small>Reservado para:</small> <strong class="text text-info"><?= $registro['nome_cliente'] ?></strong>
                                        </p>
                                    </td>
                                    <td style="width:35%;">
                                        <p>
                                            <small>Ambiente:</small> <strong><?= $registro['nome_ambiente'] ?></strong>
                                        </p>
                                        <p>
                                            <small>Mesa(s):</small> <strong><?= $registro['mesas'] ?></strong>
                                        </p>
                                    </td>
                                    <td colspan="4">
                                        <p>
                                        <small>Total Lista / Presentes:</small>  <strong><?= $registro['total_pessoas_lista'] ?> / <?= $registro['confirmados'] ?></strong>
                                        </p>
                                        <p>
                                            <a href="#" data-url="<?= Router::url(array('Reservas', 'listarConvidadosHostess', $registro['token'])) ?>" class=" lista-convidados-hostess"><i class="fa fa-users"></i> Convidados</a>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr style="margin:0px; padding: 0px;">
                        <?php endforeach; ?>
                    </td>
                </tr>
            </tbody>
        </table>
<?php else: ?>
<div class="alert alert-info text-center">
    <h4 style="margin-bottom: 0px; padding-bottom: 0px;">
        <i class="fa fa-info-circle"></i> Atenção: Nenhum registro encontrado para a sua busca!
    </h4>
</div>
<?php endif; ?>