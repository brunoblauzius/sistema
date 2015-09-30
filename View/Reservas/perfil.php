<div class="container-fluid">    <div class="col-md-12">        <div class="col-md-6">        </div>        <div class="col-md-6 ">            <?php if ($lista['status'] == 0): ?>                <small>Status: </small> <strong class="text text-primary">Iniciado</strong>            <?php elseif ($lista['status'] == 1): ?>                <small>Status: </small> <strong class="text text-success">Concluido</strong>            <?php elseif ($lista['status'] == 2): ?>                <small>Status: </small> <strong class="text text-danger">Cancelado</strong>            <?php endif; ?>        </div>        <hr style="margin-bottom: 0px;">        <div class="col-md-6">            <small>Cliente: </small><br>            <strong><?= ucwords($lista['cliente']) ?></strong>        </div>        <div class="col-md-6">            <small>Funcionário cadastrante: </small><br>            <strong><?= ucwords($lista['funcionario']) ?></strong>        </div>        <div class="col-md-6">            <small>Data da reserva: </small><br>            <strong><?= Utils::convertData($lista['start']) ?></strong>        </div>        <div class="col-md-6">            <small>Quantidade de pessoas: </small><br>            <strong><?= ($lista['qtde_pessoas']) ?></strong>        </div>    </div>    <div class="clearfix"></div>	    <div class="col-md-12">        <hr style="margin-bottom: 0px;">        <div class="col-md-6">            <small>Telefone: </small><br>            <strong><?= $lista['telefone'] ?></strong>        </div>        <div class="col-md-6">            <small>E-mail: </small><br>            <strong><?= $lista['email'] ?></strong>        </div>    </div>    <div class="clearfix"></div>    <hr style="margin-bottom: 0px;">    <div class="col-sm-12">        <div class="col-md-6">            <small>Salão: </small><br>            <strong><?= ucwords($lista['salao']) ?></strong>        </div>        <div class="col-md-6">            <small>Ambiente: </small><br>            <strong><?= ucwords($lista['ambiente']) ?></strong>        </div>        <div class="clearfix"></div>        <hr style="margin-bottom: 0px;">        <p>            <strong>Mesas reservadas: </strong>         </p>        <?php foreach ($mesas as $mesa) : ?>            <?php foreach ($mesa as $key => $value) : ?>                <p>                    <strong class="label label-default"><?= $value; ?></strong>                </p>            <?php endforeach; ?>        <?php endforeach; ?>    </div>    <div class="clearfix"></div>    <hr style="margin-bottom: 0px;">    <?php if (!empty($lista['descricao_interna'])): ?>        <div class="alert alert-default">            <p>                <strong>Observações Interna: </strong> <br> <?= nl2br($lista['descricao_interna']) ?>            </p>        </div>    <?php endif; ?>    <hr style="margin-bottom: 0px;">    <?php if (!empty($lista['descricao_cliente'])): ?>        <div class="alert alert-default">            <p>                <strong>Observações Cliente: </strong> <br> <?= nl2br($lista['descricao_cliente']) ?>            </p>        </div>    <?php endif; ?></div><div class="clearfix"></div><hr><!--a class="btn btn-primary btn-sm" target="_blank" href="http://snappypdf.com.br/gerar.php?url=http://codewave.com.br/sistema/Reservas/imprimir/<?= ($lista['id']) ?>"> <i class="fa fa-print"></i> Imprimir</a--><a class="btn btn-primary btn-sm" target="_blank" href="<?= ($urlPDF) ?>"> <i class="fa fa-print"></i> Imprimir</a><?php if ((($lista['pessoas_id'] == Session::read('Usuario.pessoas_id')) || in_array(Session::read('Usuario.roles_id'), array(3, 4))) && $lista['status'] < 2): ?>    <div class="btn-group btn-group-sm pull-right">        <a class="btn btn-info editarRegistro" data-idregistro="<?= ($lista['id']) ?>" data-href="<?= Router::url(array('Reservas', 'editar')) ?>" > <i class="fa fa-edit"></i> Editar</a>        <a class="btn btn-danger cancelarRegistro" data-idregistro="<?= ($lista['token']) ?>" data-href="<?= Router::url(array('Reservas', 'cancelarRegistro')) ?>"> <i class="fa fa-times"></i> Cancelar Registro</a>    </div><?php endif; ?><div class="clearfix"></div>