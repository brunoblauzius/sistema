<form action="<?= Router::url(array('Eventos', 'addDistruibuicaoPromoters'));?>" method="post" id="addDistruibuicaoPromoters">
    <!-- menu -->
    <div>
        <div class="dropdown pull-left">
            <a class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Copiar a distribuição do <strong>Promoter</strong>
                <span class="fa fa-bars"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <?php foreach ($funcionarios as $funcionario):?>
                    <?php if( $pessoas_id != $funcionario['pessoas_id']):?>
                        <li><a href="#" class="copiar-distribuicao" data-pessoasid='<?= $pessoas_id?>' data-pessoasidcopy="<?= $funcionario['pessoas_id']?>" data-eventosid="<?= $eventos_id?>"><?= ucfirst($funcionario['nome']);?></a></li>
                    <?php endif;?>
              <?php endforeach;?>
            </ul>
        </div>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm" style="margin-bottom: 10px;">Salvar</button>
        </div>
    </div>
    <!-- // fim menu -->
    
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
                    <span class="bg-header-female"><i class="fa fa-female marginNull"></i> Feminino</span>
                    <?php elseif($registro['Lista']['sexo'] == 1 ):?>
                        <span class="bg-header-male"><i class="fa fa-male marginNull"></i> Masculino</span>
                    <?php else:?>
                        <span class="bg-header-male-female"><i class="fa fa-female marginNull"></i><i class="fa fa-male marginNull"></i> Unissex</span>
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