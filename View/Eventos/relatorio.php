<h2><?= Utils::getDate($evento['data'])?> - <?= $evento['title']?> <small>: Relatório</small></h2>

<div class="panel">
    <header class="bg-header-primary panel-heading">
       Relátorio
    </header>
    <div class="panel panel-body">
        <div class='row'>
            <div class="col-md-8 col-md-offset-2">
                
               
                    
                    <table class="table table-condensed table-hover ">
                        <thead>
                            <th class="text-center">
                                <h4>Unissex:</h4>
                                <?= $totalEvento['unissex']?>
                            </th>
                            <th class="text-center">
                                <h4>Masculino:</h4>
                                <?= $totalEvento['male']?>
                            </th>
                            <th class="text-center">
                                <h4>Feminino:</h4>
                                <?= $totalEvento['female']?>
                            </th>
                        </thead>
                        <?php if(Session::read('Usuario.roles_id') != PainelConstantes::PROMOTER):?>
                            <thead>
                                <th class="text-center">
                                    <h4>Total na Lista:</h4>
                                    <?= $totalEvento['total']?>
                                </th>
                                <th class="text-center">
                                    <h4>Total Disponível:</h4>
                                    <?= $totalEvento['total']?>
                                </th>
                                <th class="text-center">
                                    <h4>Compareceram:</h4>
                                    <?= $totalEvento['total']?>
                                </th>
                            </thead>
                        <?php endif;?>
                    </table>
                
                
                <?php if(count($registros)):?>
                    <table class="table table-condensed table-hover" style="margin-top: 50px;">
                        <thead class="bg-header-primary">
                            <th >Lista</th>
                            <th class="text-center">Unissex</th>
                            <th class="text-center">Masculino</th>
                            <th class="text-center">Feminino</th>
                        </thead>
                        <tbody>
                            <?php foreach ( $registros as $registro ):?>
                                <tr>
                                    <td ><?= $registro['lista']?></td>
                                    <td class="text-center"><?= $registro['unissex']?></td>
                                    <td class="text-center"><?= $registro['male']?></td>
                                    <td class="text-center"><?= $registro['female']?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                <?php else:?>
                    <div class="alert alert-warning">
                        Nenhum registro foi encontrado...
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>