   
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

<div class="row">
    
    <?php if($quantidadeFuncionarios['total_restante'] == 0): ?>
    <div class="col-md-12">
        <section class="mini-stat clearfix bg-warning">
            <span class="mini-stat-icon" style="background-color:#FFF; color:#ffa000">
                <i class="fa fa-warning" style="margin-right: 0px;"></i>
            </span>
            <section class="mini-stat-info">
                <span style="font-size:16px;">Atenção: limite de cadastro excedido.</span>
                não fique sem cadastrar seus funcionários faça já uma compra de funcionários adicionais para seu plano.<br><br>
                <!--a href="<?//= Router::url(array('Funcionarios','cadastro'))?>" class="btn btn-primary btn-sm">Adicionar <i class="fa fa-plus"></i></a-->
            </section>
        </section>
    </div>
    <?php endif; ?>
    
    
    <div class="col-md-4">
        <section class="mini-stat clearfix">
            <span class="mini-stat-icon tar">
                <i class="fa fa-users marginNull"></i>
            </span>
            <section class="mini-stat-info">
                <span><?= $quantidadeFuncionarios['qtde_funcionarios'] ?></span>
                Quantidade de funcionários do plano. 
            </section>
        </section>
    </div>
    <div class="col-md-4">
        <section class="mini-stat clearfix">
            <span class="mini-stat-icon tar">
                <i class="fa fa-user marginNull"></i>
            </span>
            <section class="mini-stat-info">
                <span><?= $quantidadeFuncionarios['total_restante'] ?></span>
                Quantidade de funcionários para cadastrar.
            </section>
        </section>
    </div>
    <div class="col-md-4">
        <section class="mini-stat clearfix">
            
            <section class="mini-stat-info">
                <span style="font-size:16px;"><?= $quantidadeFuncionarios['nome'] ?></span>
                Nome do plano contratado.
            </section>
        </section>
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
        <th>Nome/Nível</th>
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
                <td colspan="">
                    <strong><?= $usuario['nome'];?></strong>
                    <p class="text text-green"><?= $usuario['nivel_usuario'];?></p>
                </td>
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
