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
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
         <div class="panel ">
             <div class="panel-body">
                <strong>Legenda:</strong>
                <a class="btn btn-xs btn-primary "><i class="fa fa-sign-in marginNull"></i> Portaria</a>
                <a class="btn btn-xs btn-primary "><i class="fa fa-bar-chart-o marginNull"></i> Relatórios</a>
                <a class="btn btn-xs btn-warning "><i class="fa fa-bars marginNull"></i> Minha lista</a>
            </div>
        </div>
    </div>
</div>
    
<!--mini statistics start-->
<div class="row">
    
    <?php foreach ($meusEventos as $registro):?>
        <div class="col-lg-3 col-md-6 col-xs-12 col-sm-6 text-center">
            <div class="mini-stat clearfix">
                <h4><?= Utils::getDate($registro['data'])?></h4>
                <h5 class="marginNull pddnull"><?= $registro['title']?></h5>

                <p class="btn">
                    <a class="btn btn-xs btn-primary " href="<?= Router::url(array('Eventos', 'portaria',  md5($registro['id'])))?>"   title="Portaria" ><i class="fa fa-sign-in marginNull"></i></a>
                    <a class="btn btn-xs btn-primary " href="<?= Router::url(array('Eventos', 'relatorio',  md5($registro['id'])))?>"   title="Relatórios" ><i class="fa fa-bar-chart-o marginNull"></i></a>
                    <a class="btn btn-xs btn-warning " href="<?= Router::url(array('Eventos', 'minha-lista',  md5($registro['id'])))?>"   title="Minha Lista Vip" ><i class="fa fa-bars marginNull"></i></a>
                </p>
            </div>
        </div>
        
    <?php endforeach;?>
    
</div>


    
