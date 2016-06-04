<form action="<?= Router::url(array('Eventos', 'addDistruibuicaoPromoters'));?>" method="post" id="addDistruibuicaoPromoters">
    <div>
        <button class="btn btn-primary btn-sm pull-right" style="margin-bottom: 10px;">Salvar</button>
    </div>
    <div class="clearfix"></div>
    <table class="table table-condensed table-hover table-responsive table-striped" id="data-table-eventos">
        <thead class="bg-header-primary">
            <th style="width: 5%">Gênero</th>
            <th style="width: 10%">Qtde.</th>
            <th style="width: 30%">Listas</th>
            <th style="width: 6%">Distribuição Total (<?= $totalNaLista?>)</th>
        </thead>
        <tbody>
            <?php foreach ($registros as $registro):?>
           <tr>
                <td>
                    <?php if($registro['Lista']['sexo'] == 0 ):?>
                        <span class="bg-header-female">Feminino</span>
                    <?php elseif($registro['Lista']['sexo'] == 1 ):?>
                        <span class="bg-header-male">Masculino</span>
                    <?php else:?>
                        <span class="bg-header-male-female">Unissex</span>
                    <?php endif;?>
                </td> 
                <td>
                    <input type="text" class="form-control input-sm" name="qtde[<?= $registro['Lista']['id']?>]" value="<?= $listaCadastro[$registro['Lista']['id']]?>">
                </td>
                <td>
                    <?= $registro['Lista']['title']?>
                </td>
                <td>
                    <?= $listaCadastro[$registro['Lista']['id']]?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <input type="hidden" name="pessoas_id" value="<?= $pessoas_id;?>">
    <input type="hidden" name="eventos_id" value="<?= $eventos_id;?>">
    <div>
        <button class="btn btn-primary btn-sm pull-right" style="margin-top: 10px;">Salvar</button>
    </div>
</form>