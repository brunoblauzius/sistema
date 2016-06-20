<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href=" <?= Router::url('Eventos/index')?> "> <i class="fa fa-home"></i> Eventos</a>
            </li>
            <li>
                <a class="current">Portaria</a>
            </li>
        </ul>
    </div>
</div>

<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="col-xs-3 col-sm-3">
                    <strong class="text text-maroon"><?= Session::read('Empresa.nome_fantasia')?></strong>
                </div>
                <div class="col-xs-5 col-sm-5">
                    <div class="col-xs-10 col-sm-10 col-md-10 marginNull pull-left pddnull" >
                        <input type="text" id="input-search" placeholder="Telefone ou Nome" class="form-control input-sm">
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 marginNull pull-right pddnull">
                        <a class="btn btn-primary btn-sm btn-input-search"> <i class="fa fa-search-plus marginNull"></i></a>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4">
                    
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12" id="carregar-lista" style="margin-top: 40px;">
                <?= Render::element('Eventos/lista-portaria', array('registros' => $registros));?>
            </div>
        </div>
        
    </div> 
    <div class="panel-footer"></div>
</div>