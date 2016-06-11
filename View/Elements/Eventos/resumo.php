<?php if(count($registros) > 0 ):?>
<table class="table table-condensed table-hover" >
    <thead class="bg-header-primary">
        <th class="text-center" style="width:25%">Unissex</th>
        <th class="text-center" style="width:25%">Feminino</th>
        <th class="text-center" style="width:25%">Masculino</th>
        <th class="text-center" style="width:25%">Total</th>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"><?= $registros['unissex']?></td>
            <td class="text-center"><?= $registros['feminino']?></td>
            <td class="text-center"><?= $registros['masculino']?></td>
            <td class="text-center"><?= $registros['total']?></td>
        </tr>
    </tbody>
</table>
<?php else:?>
    <section class="alert alert-warning" >
        <p>
            Nenhum registro encontrado!
        </p>
    </section>
<?php endif;?>