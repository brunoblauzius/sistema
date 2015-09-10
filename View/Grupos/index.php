<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Grupos/index">Home</a>
            </li>
            <li>
                <a class="current" href="#">Grupos</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Grupos
    </div>
    
    <div class="panel-body">
        <!--tab nav start-->
        <div class="col-md-8">
            <a href="<?= $this->urlRoot()?>Grupos/cadastro" class="btn btn-primary ">Cadastrar Grupos <i class="fa fa-plus"></i></a>
        </div>
        <div class="clearfix"></div>
        <!--tab nav start-->
        
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Status</th>
                    <th class="col-md-2">Acao</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($grupos as $grupo):?>
                <tr>
                    <td><?= $grupo->getNome()?></td>
                    <td>
                        <?php if( $grupo->getAtivo() == true ):?>
                            <span class="label label-success"><i class="fa fa-check"></i></span>
                        <?php else:?>
                            <span class="label label-danger"><i class="fa fa-times"></i></span>
                        <?php endif;?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-xs">
                            <a href="<?= $this->urlRoot()?>Grupos/editar/<?= $grupo->getId()?>" class="btn btn-info">Editar</a>
                            <a data-url="<?= $this->urlRoot()?>Grupos/deletar/<?= $grupo->getId()?>" class="btn btn-danger action-deletar">Excluir</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            
        </table>
        
        
        
    </div>
    
    
    
</div>