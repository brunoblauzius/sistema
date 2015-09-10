  
<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url()?>Usuarios/painel">Home</a>
            </li>
            <li>
                <a class="current" href="#">Usuarios</a>
            </li>
        </ul>
    </div>
</div>


<section class="panel">
    <header class="panel-heading">
        Usuarios
    </header>
    
    <div class="col-md-12" style="margin-top:20px;">
        <a href="<?= $this->urlRoot()?>Usuarios/cadastro" class="btn btn-success pull-right">Adicionar <i class="fa fa-plus"></i></a>
    </div>
    <div class="clearfix"></div>
    
    <div class="panel-body">
    <div class="adv-table">
    <table  class="display table table-bordered table-striped" id="dynamic-table">
    <thead>
    <tr>
        <th>Login</th>
        <th>E-mail</th>
        <th>Status</th>
        <th class="hidden-phone">Data de criação</th>
        <th class="hidden-phone"></th>
    </tr>
    </thead>
    <tbody>
        <?php 
            if(count($usuarios) > 0):
                foreach( $usuarios as $usuario ):
        ?>
            <tr class="gradeX">
                <td><?= $usuario['Usuario']['login']?></td>
                <td><?= $usuario['Usuario']['email']?></td>
                <td>
                    <?php 
                        $class = 'btn btn-danger';
                        $icone = 'fa fa-times';
                        if( $usuario['Usuario']['status'] == TRUE ):
                            $class = 'btn btn-success';
                            $icone = 'fa fa-check';
                        endif;
                    ?>
                    <span class="<?= $class?> btn-xs"><i class="<?= $icone?>"></i></span>

                </td>
                <td class="center hidden-phone"> <?= Utils::convertData( $usuario['Usuario']['created'] )?> </td>
                <td class="center hidden-phone">
                    <div class="btn-group btn-group-xs">
                        <a href="<?= Router::url()?>Usuarios/editar/<?= $usuario['Usuario']['id']?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        <a data-url="<?= Router::url()?>Usuarios/deletar/<?= $usuario['Usuario']['id']?>" class="btn btn-danger action-deletar"><i class="fa fa-trash-o"></i></a>
                        <a href="<?= Router::url()?>" class="btn btn-primary"><i class="fa fa-comment"></i></a>
                    </div>
                </td>
            </tr>
        <?php 
                endforeach;
            endif;
        ?>
    </tbody>
    </table>
    </div>
    </div>
</section>


