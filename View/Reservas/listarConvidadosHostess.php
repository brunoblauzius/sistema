
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Lista de Convidados.</div>
            <div class="panel-body" id="panel-body">
                
                <div id="tabela-dinamica">
                    <table class="table table-condensed table-striped" id="dynamic-table" >
                        <thead>
                             <tr>
                                <th style="width:20%">Confirmado</th>
                                <th><strong>Nome do Cliente:</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listaDeConvidados as $registro):?>
                            <tr>
                                <td>
                                    <?php if($registro['confirmado'] == 0): ?>
                                        <a data-clientesid="<?= $registro['id']?>" data-reservasid="<?= $registro['reservas_id']?>" class="confirma-presenca-hostess btn btn-xs btn-danger"><span class="fa fa-times"></span></a>
                                    <?php else:?>
                                        <a data-clientesid="<?= $registro['id']?>" data-reservasid="<?= $registro['reservas_id']?>" class="btn btn-xs btn-success"><span class="fa fa-check"></span></a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?= $registro['nome']?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div id="loader-painel"></div>
            </div>
        </div>
    </div>
</div>


