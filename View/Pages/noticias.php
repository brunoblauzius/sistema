<style type="text/css">
    .info-cont{ width:100%; padding:10px; font-size:14px;}
    .info-cont h3{ border-bottom:1px solid #000 }
    .info-cont p{ font-size:12px;}
</style>

<div class="row">
    
    <div class="col-md-12">
        <h2 class="pgtitulo" >Noticias: </h2>

        <?php foreach ($noticias as $noticia):?>
            <div class="info-cont row">
                <a href="<?= $this->urlRoot() . '/Pages/perfilNoticia/' . $noticia['Noticia']['id'];?>">
                
                    <?php if( !empty($noticia['Noticia']['img'])):?>
                        <div class="col-md-3">
                            <img src="<?= $this->urlRoot(). 'View/webroot/img/noticias/' .  $noticia['Noticia']['img']?>" height="120" alt="<?= ucwords($noticia['Noticia']['titulo']);?>">
                        </div>
                    <?php endif;?>

                    <div class="col-md-9">
                        <h3><?= ucfirst($noticia['Noticia']['titulo'])?> <span class="pull-right text text-muted" style="font-size:12px;">postado em <?= Utils::convertData(substr($noticia['Noticia']['created'], 0, 10))?></span></h3>
                        <p>
                            <?= mb_strimwidth($noticia['Noticia']['descricao'], 0, 150, "...")?>
                        </p>
                    </div>
                
                </a>
            </div>
            <hr>
        <?php endforeach;?>
    </div>
</div>