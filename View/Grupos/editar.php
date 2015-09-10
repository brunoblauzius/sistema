
<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Usuarios/painel">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= $this->urlRoot()?>Grupos/index">Grupos</a>
            </li>
            <li>
                <a class="current" href="#">Editar</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Editar
    </div>
    
    <div class="panel-body">
        <h3>Grupos Cadastro</h3><hr>
        <form accept-charset="UTF-8" action="<?= $this->urlRoot()?>Grupos/edit" id="GrupoEditForm" class="form" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Nome do grupo:</small>
                            <input type="text" class="form-control" name="Grupo[nome]" placeholder="Grupo:" value="<?= $registro->getNome()?>">
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="checkbox">
                                <?php 
                                    $check = null;
                                    $value = 0;
                                    if($registro->getAtivo() == TRUE):
                                        $check = 'checked="checked"';
                                        $value = $registro->getAtivo();
                                    endif; 
                                ?>
                                <input type="hidden" name="Grupo[status]" value="0">
                                <input type="checkbox" class="" name="Grupo[status]" value="1" <?= $check; ?> > Ativo
                                
                            </label>
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-primary">Cadastrar</button>
                        </div>    
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    
    
</div>