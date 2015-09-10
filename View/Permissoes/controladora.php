<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Usuarios/painel">Home</a>
            </li>
            <li>
                <a class="current" href="#">Controladora</a>
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
            <a href="<?= $this->urlRoot()?>Permissoes/controladoraCadastro" class="btn btn-primary ">Cadastrar Controler <i class="fa fa-plus"></i></a>
            <a href="<?= $this->urlRoot()?>Permissoes/metodosCadastro" class="btn btn-primary ">Cadastrar Metodos <i class="fa fa-plus"></i></a>
        </div>
        <div class="clearfix"></div>
        <!--tab nav start-->
        
        <div class="row col-md-12">
            <table class="table table-striped table-hover"  id="dynamic-table">
            <thead>
                <tr>
                    <th>Controladora</th>
                    <th>Nome do Link</th>
                    <th>Icone</th>
                    <th>Status</th>
                    <th class="col-md-2">Acao</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($controllers as $controller):?>
                <tr>
                    <td><?= $controller[$controlName]['nome']?></td>
                    <td><?= $controller[$controlName]['nome_link']?></td>
                    <td><?= $controller[$controlName]['icon']?></td>
                    <td>
                        <?php if( $controller[$controlName]['ativo'] == true ):?>
                            <span class="label label-success"><i class="fa fa-check"></i></span>
                        <?php else:?>
                            <span class="label label-danger"><i class="fa fa-times"></i></span>
                        <?php endif;?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-xs">
                            <a href="<?= $this->urlRoot()?>Permissoes/controladoraEditar/<?= $controller[$controlName]['id']?>" class="btn btn-info">Editar</a>
                            <a data-url="<?= $this->urlRoot()?>Permissoes/controladoraDeletar/<?= $controller[$controlName]['id']?>" class="btn btn-danger action-deletar">Excluir</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            
        </table>
        </div>
        
        
        
    </div>
    
    
    
</div>