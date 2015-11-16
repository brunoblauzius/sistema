    <div class="row">
        <div style="width:200px; float: left; margin-left:20px;">
            <?php if ( !empty($empresaJuridica) ): ?>
                <?php if ($empresaJuridica['logo'] != NULL): ?>
                    <img src="<?= Router::url(array('View/webroot/img/logos', $empresaJuridica['logo'])) ?>" class="" style="width:70px; "/>
                <?php else: ?>
                    <img src="<?= Router::url(array('View/webroot/img/no-image.jpg')) ?>" class="img-thumbnail" style="width:80px; "/>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div style="width: 500px; float: left; margin: 10px;">
            <small>Nome Fantasia:</small><br>
            <strong class="text text-warning"> <?= $empresaJuridica['nome_fantasia'] ?> </strong><br>
            <small>Data Reservas:</small><br>
            <strong class="text text-warning"> <?= $dataReserva ?> </strong><br>
        </div>
    </div>
    <hr>
    <div class="clearfix"></div>

        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th style="width:10%" class="text-center">Nome</th>
                    <th style="width:4%" class="text-center">PAX</th>
                    <th style="width:4%" class="text-center">Horário</th>
                    <th style="width:10%" class="text-center">Ambiente</th>
                    <th style="width:25%" class="text-center">Observações</th>
                    <th style="width:15%" class="text-center">Responsável</th>
                    <th style="width:15%" class="text-center">Data Reserva</th>
                    <th style="width:10%" class="text-center">Envio E-mail</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($registros)):
                foreach ($registros as $registro):
            ?>
                    <tr>
                        <td class="text-center">
                            <strong><?= $registro['cliente'] ?></strong><br>
                            <small><?= Utils::formatarTelefone($registro['telefone']) ?></small><br>
                            <small><?= $registro['email'] ?></small>
                        </td>
                        <td class="text-center"><strong><?= $registro['qtde_pessoas'] ?></strong></td>
                        <td class="text-center"><strong><?= Utils::returnHours( $registro['start'] );?></strong></td>
                        <td class="text-center">
                            <strong><?= $registro['ambiente'] ?></strong><br>
                            <small><?= $registro['mesas'] ?></small>
                        </td>
                        <td class="text-center">
                            <small><?= ($registro['descricao_cliente']) ? $registro['descricao_cliente'] : 'não informado';?></small><hr style="margin:2px;">
                            <small><?= ($registro['descricao_interna']) ? $registro['descricao_interna'] : 'não informado';?></small>
                        </td>
                        <td class="text-center"><?= $registro['funcionario'] ?></td>
                        <td class="text-center"><strong><?= Utils::convertData( $registro['start'] );?></strong></td>
                        <td class="text-center"><?= ($registro['data_envio']) ? Utils::convertData($registro['data_envio']) : '<strong class="text text-danger">E-mail ainda não foi enviado</strong>'; ?></td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            
                            <?php
                                $i = 1;
                                foreach ($registro['lista_convidados'] as $convidado):
                                    echo $i . ': ' .$convidado['nome'] . '<br>';
                                $i++;
                                endforeach;
                            ?>
                            
                        </td>
                    </tr>
            <?php
                endforeach;
            endif;
            ?>
            </tbody>
        </table>
