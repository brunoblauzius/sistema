   
<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url('Usuarios/painel')?>">Home</a>
            </li>
            <li>
                <a class="current" href="#">Funcionarios</a>
            </li>
        </ul>
    </div>
</div>

<section class="panel">
    <header class="panel-heading">
        Funcionarios
    </header>
    
    <div class="col-md-12" style="margin-top:20px;">
        <a href="<?= Router::url(array('Funcionarios','cadastro'))?>" class="btn btn-success pull-right">Adicionar <i class="fa fa-plus"></i></a>
    </div>
    <div class="clearfix"></div>
    
    <div class="panel-body">
    <div class="adv-table">
    <table  class="display table table-bordered table-striped" id="dynamic-table">
    <thead>
    <tr>
        <th style="width: 10%"></th>
        <th>Nome</th>
        <th>Nivel</th>
        <th>Login</th>
        <th>Cpf</th>
        <th class="col-md-1">Ação</th>
    </tr>
    </thead>
    
    <tbody>
        <?php 
            foreach ($usuarios as $usuario):
        ?>
            <tr class="gradeX">
                <td class="text-center">
                    <?php if( !empty($usuario['imagem_perfil']) ):?>
                        <img src="<?= Router::url('View/webroot/img/thumb/'.$usuario['imagem_perfil'] )?>" class="img-circle img-rounded img-thumbnail" style="height:60px">
                    <?php else:?>
                        <img src="<?= Router::url('View/webroot/img/icone.png')?>" class="img-circle img-rounded img-thumbnail" style="height:60px">
                    <?php endif;?>
                </td>
                <td colspan=""><?= $usuario['nome'];?></td>
                <td colspan=""><?= $usuario['nivel_usuario'];?></td>
                <td colspan=""><?= $usuario['email'];?></td>
                <td colspan=""><?= Utils::formatarCPFCNPJ($usuario['cpf']);?></td>
                <td> 
                    <div class="btn-group">
                        <a class="btn btn-primary btn-xs" href="<?= Router::url(array('Funcionarios', 'editar', md5($usuario['pessoas_id']) ))?>" ><i class="fa fa-cog"></i> Configurar</a>
                    </div>
                </td>
            </tr>
        <?php 
            endforeach;
        ?>
    </tbody>
    
    </table>
    </div>
    </div>
</section>
