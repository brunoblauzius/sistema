<div class="row">
    <div class="col-md-12">
        <h3 class="pgtitulo">Noticia: <?= ucfirst($noticia['Noticia']['titulo'])?></h3>
        <?php if( !empty($noticia['Noticia']['img'])):?>
            <div class="col-md-4">
                <img src="<?= $this->urlRoot(). 'View/webroot/img/noticias/' .  $noticia['Noticia']['img']?>" height="200" alt="<?= ucwords($noticia['Noticia']['titulo']);?>">
            </div>
        <?php endif;?>
        <div class="col-md-8">
            <p>
                <?= ($noticia['Noticia']['descricao'])?>
            </p>            
        </div>
        <div class="clearfix"></div>
        <hr>
        <span class="pull-right text text-muted" style="font-size:12px;">postado em <?= Utils::convertData(substr($noticia['Noticia']['created'], 0, 10))?></span>
    </div>
</div>