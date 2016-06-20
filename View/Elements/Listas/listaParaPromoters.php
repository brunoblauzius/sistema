<table class="table table-condensed table-hover table-responsive table-striped" id="data-table-eventos">
    <thead class="bg-header-primary">
        <th style="width: 30%">TITULO</th>
        <th style="width: 10%">GÊNERO</th>
        <th class="text-center" style="width: 6%">ATIVO</th>
        <th style="width: 6%"></th>
    </thead>
    <tbody>
        <?php foreach ($registros as $registro):?>
       <tr>
            <td>
                <a href="#" class="edit-listas" data-url="<?= Router::url(array('Listas', 'editar',  md5($registro['Lista']['id'])))?>">
                <?= $registro['Lista']['title']?>
                </a>
            </td>
            <td>
                <?php if($registro['Lista']['sexo'] == 0 ):?>
                <span class="bg-header-female"><i class="fa fa-female marginNull"></i> Feminino</span>
                <?php elseif($registro['Lista']['sexo'] == 1 ):?>
                    <span class="bg-header-male"><i class="fa fa-male marginNull"></i> Masculino</span>
                <?php else:?>
                    <span class="bg-header-male-female"><i class="fa fa-female marginNull"></i><i class="fa fa-male marginNull"></i> Unissex</span>
                <?php endif;?>
            </td>                               
            <td class="text-center">
                <?php if($registro['Lista']['status'] == 1 ):?>
                    <a class="btn btn-success btn-xs tooltips alterar-status-lista" data-url="<?= Router::url(array('Listas', 'alterarStatus',  md5($registro['Lista']['id'])))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle marginNull"></i></a>
                <?php else:?>
                    <a class="btn btn-danger btn-xs tooltips alterar-status-lista" data-url="<?= Router::url(array('Listas', 'alterarStatus',  md5($registro['Lista']['id'])))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle marginNull"></i></a>
                <?php endif;?>
            </td>
            <td>
                <a class="btn btn-xs btn-info tooltips edit-listas" data-url="<?= Router::url(array('Listas', 'editar',  md5($registro['Lista']['id'])))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" ><i class="fa fa-pencil marginNull"></i></a>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>