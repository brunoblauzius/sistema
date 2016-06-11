<?php if(count($registros) > 0 ):?>
<table class="table table-condensed table-hover" >
    <thead class="bg-header-primary">
        <th style="width:30%">Cliente</th>
        <th>Telefone</th>
        <th style="width:30%">Lista</th>
        <th class="hidden-sm hidden-xs">Promoter</th>
        <th style="width:6%">Ação</th>
    </thead>
    <tbody>
        <?php foreach ($registros as $registro):?>
            <tr>
                <td><?= $registro['nome']?></td>
                <td><?= $registro['telefone']?></td>
                <td>
                    <?php if($registro['sexo'] == 0 ):?>
                    <span class="bg-header-female"><i class="fa fa-female marginNull"></i> Feminino</span>
                    <?php elseif($registro['sexo'] == 1 ):?>
                        <span class="bg-header-male"><i class="fa fa-male marginNull"></i> Masculino</span>
                    <?php else:?>
                        <span class="bg-header-male-female"><i class="fa fa-female marginNull"></i><i class="fa fa-male marginNull"></i> Unissex</span>
                    <?php endif;?>
                    <?= $registro['title']?>
                </td>
                <td class="hidden-sm hidden-xs"><?= $registro['promoter']?></td>
                <td>
                    <a class="btn btn-primary btn-xs portaria-liberar" data-pessoasid="<?= $registro['pessoas_id']?>" data-eventosid="<?= $registro['eventos_id']?>"><i class="fa fa-check marginNull"></i> Liberar</a>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php else:?>
    <section class="alert alert-warning" >
        <p>
            Nenhum registro encontrado!
        </p>
    </section>
<?php endif;?>