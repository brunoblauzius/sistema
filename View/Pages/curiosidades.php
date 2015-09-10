<style type="text/css">
    .info-cont{ width:100%; padding:10px; font-size:14px;}
    .info-cont h3{ border-bottom:1px solid #000 }
    .info-cont p{ font-size:12px;}
</style>

<div class="row">
    
    <div class="col-md-12">
        <h2 class="pgtitulo" >Curiosidades: </h2>

        <?php foreach ($noticias as $noticia):?>
            <div class="info-cont">
                <h3><?= ucfirst($noticia['Curiosidade']['titulo'])?> <span class="pull-right text text-muted" style="font-size:12px;">postado em <?= Utils::convertData(substr($noticia['Curiosidade']['created'], 0, 10))?></span></h3>
                <p>
                    <?= nl2br($noticia['Curiosidade']['descricao'])?>
                </p>
            </div>
            <hr>
        <?php endforeach;?>
    </div>
</div>