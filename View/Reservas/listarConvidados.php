<?php if(Session::check('Usuario')):?>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12 col-xs-12">
            <a href="<?= $urlPDF;?>" target="_blank" class="btn btn-xs btn-primary">Gerar PDF</a>
            <a class="btn btn-xs btn-warning " id="cadastrar-novo-convidado" data-token="<?= $token?>"><i class="fa fa-user"></i> Cadastrar Convidado</a>
            <a class="btn btn-xs btn-info pull-right" href="<?= Router::url(array('View', 'webroot', 'arquivos', 'lista_convidados.csv'))?>"><i class="fa fa-download"></i> Baixar Lista</a>
        </div>
    </div>
<div class="clearfix"></div>
<?php endif;?>

<div class="row">
    <div class="col-sm-12" style="overflow-y:auto; height:300px; margin-top: 15px;">
        <table class="table table-condensed table-striped"  >
            <thead>
                 <tr>
                    <th><strong>Nome:</strong></th>
                    <!--th><strong>E-mail:</strong></th>
                    <th><strong>Telefone:</strong></th-->
                </tr>
            </thead>
            <tbody>
            <?php foreach ($convidados as $registro):?>
            <tr>
                <td>
                    <?= $registro['nome']?>
                </td>
                <!--td>
                    <?= strtoupper($registro['email'])?>
                </td>
                <td>
                    <?= Utils::formatarTelefone($registro['telefone'])?>
                </td-->
            </tr>
            <?php endforeach;?>

            </tbody>
        </table>
    </div>
</div>


