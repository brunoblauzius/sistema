<?php if(!empty($endereco)):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel ">
                <div class="panel-body">
                    Endereço: <strong><?= $endereco['logradouro']?>, <?= $endereco['numero']?> | <?= $endereco['cidade']?> - <?= $endereco['bairro']?> - <?= $endereco['uf']?></strong>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

