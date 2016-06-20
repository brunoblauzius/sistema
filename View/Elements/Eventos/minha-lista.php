<?php if(count($registros) > 0 ):?>
<table class="table table-condensed table-hover" >
    <thead class="bg-header-primary">
        <th style="width:40%">Cliente</th>
        <th style="width:10%">Telefone</th>
        <th style="width:40%">Lista</th>
    </thead>
    <tbody>
        <?php foreach ($registros as $registro):?>
            <tr>
                <td><strong><?= $registro['nome']?></strong></td>
                <td><?= $registro['telefone']?></td>
                <td>
                    <?php if($registro['sexo'] == 0 ):?>
                        <small class="bg-header-female"><i class="fa fa-female marginNull"></i> Feminino</small>
                    <?php elseif($registro['sexo'] == 1 ):?>
                        <small class="bg-header-male"><i class="fa fa-male marginNull"></i> Masculino</small>
                    <?php else:?>
                        <small class="bg-header-male-female"><i class="fa fa-female marginNull"></i><i class="fa fa-male marginNull"></i> Unissex</small>
                    <?php endif;?>
                    <?= $registro['title']?>
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