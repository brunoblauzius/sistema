<div class="row">
    <div style="width:200px; float: left; margin-left:20px;">
        <?php if (!empty($empresaJuridica)): ?>
            <?php if ($empresaJuridica['logo'] != NULL): ?>
                <img src="<?= Router::url(array('View/webroot/img/logos', $empresaJuridica['logo'])) ?>" class="" style="width:70px; "/>
            <?php else: ?>
                <img src="<?= Router::url(array('View/webroot/img/no-image.jpg')) ?>" class="img-thumbnail" style="width:80px; "/>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div style="width: 500px; float: left; margin: 10px;">
        Nome Fantasia: <strong class="text text-warning" style="font-size:16px;"> <?= $empresaJuridica['nome_fantasia'] ?> </strong> 
        Dia: <strong class="text text-warning" style="font-size:16px;"> <?= $dataReserva ?> </strong><br>
    </div>
</div>
<hr>
<div class="clearfix"></div>

<table class="table table-condensed table-striped" style="font-size:14px;">
    <thead>
        <tr>
            <th style="width:15%" class="">Nome</th>
            <th style="width:3%" class="text-center">PAX</th>
            <th style="width:4%" class="text-center">Horário</th>
            <th style="width:10%" class="text-center">Ambiente/Mesas</th>
            <th style="width:15%" class="text-center">Observações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($registros)):
            foreach ($registros as $registro):
                ?>
                <tr>
                    <td class="">
                        <strong><?= $registro['cliente'] ?></strong><br>
                        <?= Utils::formatarTelefone($registro['telefone']) ?><br>
                        <?//= $registro['email'] ?>
                    </td>
                    <td class="text-center"><strong><?= $registro['qtde_pessoas'] ?></strong></td>
                    <td class="text-center"><strong><?= Utils::returnHours($registro['start']); ?></strong></td>
                    <td class="text-center"> 
                        <strong><?= $registro['ambiente'] ?> </strong><br>
                        <?= $registro['mesas'] ?>
                    </td>
                    <td class="text-center"><?= (trim($registro['descricao_cliente'])) ? trim($registro['descricao_cliente']) : 'não informado'; ?></td>                        
                </tr>
                <?php
            endforeach;
        endif;
        ?>
    </tbody>
</table>
