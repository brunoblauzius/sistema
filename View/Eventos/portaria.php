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
                        <input type="text" id="buscar-potaria" placeholder="Telefone ou Nome" class="form-control input-sm">
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 marginNull pull-right pddnull">
                        <a class="btn btn-primary btn-sm"> <i class="fa fa-search-plus marginNull"></i></a>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4">
                    painel
                </div>
            </div>
        </div>
        
        <div class="row">
            <table class="table table-condensed table-hover" style="margin-top: 40px;">
                <thead class="bg-header-primary">
                    <th style="width:30%">Cliente</th>
                    <th>Telefone</th>
                    <th style="width:30%">Lista</th>
                    <th class="hidden-sm hidden-xs">Promoter</th>
                    <th style="width:6%">Ação</th>
                </thead>
                <tbody>
                    <tr>
                        <td>NOME</td>
                        <td>0000000000</td>
                        <td>LISTA</td>
                        <td class="hidden-sm hidden-xs">PROMOTER</td>
                        <td>
                            <a class="btn btn-primary btn-xs"><i class="fa fa-check marginNull"></i> Liberar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div> 
    <div class="panel-footer"></div>
</div>