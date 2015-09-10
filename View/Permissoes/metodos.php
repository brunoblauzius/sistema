<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Permissoes/index">Home</a>
            </li>
            <li>
                <a class="current" href="#">Metodos</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Controladoras
    </div>
    
    <div class="panel-body">
        <!--tab nav start-->
        <div class="col-md-8">
            <a href="<?= $this->urlRoot()?>Permissoes/metodosCadastro" class="btn btn-primary ">Cadastrar Metodos <i class="fa fa-plus"></i></a>
        </div>
        <div class="clearfix"></div>
        <!--tab nav start-->
        
        <table class="table table-striped table-hover"  id="dynamic-table">
            <thead>
                <tr>
                    <th>Controladora</th>
                    <th>Metodo</th>
                    <th>Descricao</th>
                    <th>Página/Metodo</th>
                    <th>Menu 1º</th>
                    <th>Menu 2º</th>
                    <th>Status</th>
                    <th class="col-md-2">Acao</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($metodos as $metodo):?>
                <tr>
                    <td><?= $metodo->getController()?></td>
                    <td><?= $metodo->getNome()?></td>
                    <td><?= $metodo->getDescricao()?></td>
                    <td>
                        <?php if( $metodo->getIsPage() == true ):?>
                            <span class="label label-info"><i class="fa fa-file"></i> Página</span>
                        <?php else:?>
                            Método
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if( $metodo->getMenuPrimario() == true ):?>
                            <span class="label label-success"><i class="fa fa-check"></i></span>
                        <?php else:?>
                            <span class="label label-danger"><i class="fa fa-times"></i></span>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if( $metodo->getMenuSecundario() == true ):?>
                            <span class="label label-success"><i class="fa fa-check"></i></span>
                        <?php else:?>
                            <span class="label label-danger"><i class="fa fa-times"></i></span>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if( $metodo->getAtivo() == true ):?>
                            <span class="label label-success"><i class="fa fa-check"></i></span>
                        <?php else:?>
                            <span class="label label-danger"><i class="fa fa-times"></i></span>
                        <?php endif;?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-xs">
                            <a href="<?= $this->urlRoot()?>Permissoes/metodosEditar/<?= $metodo->getId()?>" class="btn btn-info">Editar</a>
                            <a data-url="<?= $this->urlRoot()?>Permissoes/metodosDeletar/<?= $metodo->getId()?>" class="btn btn-danger action-deletar">Excluir</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            
        </table>
        
        
        
    </div>
    
    
    
</div>