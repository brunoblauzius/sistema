<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href=" <?= Router::url('Eventos/index')?> "> <i class="fa fa-home"></i> Eventos</a>
            </li>
            <li>
                <a class="current">Minha Lista</a>
            </li>
        </ul>
    </div>
</div>

<section class="panel">
    <section class="panel-heading bg-header-primary">
        <?= $evento['Evento']['title']?> - <?= Utils::getDate($evento['Evento']['data'])?>
    </section>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- formulario -->
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <h3 class="pddnull ">Reservas em texto</h3><hr style="margin:5px;">
                    <form action="<?= Router::url('Eventos/add-lista-vip');?>" method="post" id="ListaAdd">
                        <div class="form-group">
                            <select class="form-control" name="tipos_listas_id" id="tipos_listas_id">
                                <option value=""> -- selecione a lista -- </option>
                                <?php foreach ( $lista as $registro ):?>
                                    <option value="<?= $registro['id']?>"> <?= $registro['title']?> </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div id="form-lista-vip" style="display: none">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" name="nomes_listas" placeholder="Nome completo - Telefone 4199889988"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
                 <!--// formulario-->
                 
                 
                <!-- resumo -->
                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="row">
                        <h3 class="pddnull ">Resumo</h3><hr style="margin:5px;">
                        <div id="resumo-minha-lista" style="min-height:20px;">

                        </div>
                    </div>
                    <div class="row">
                        <h3 class="pddnull ">Minha Lista</h3><hr style="margin:5px;">
                        <div id="minha-lista" style="min-height:20px;">

                        </div>
                    </div>
                </div>
                <!--// resumo-->
            </div>
        </div>
    </div>
</section>