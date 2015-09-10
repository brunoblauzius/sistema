<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Permissoes/index">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= $this->urlRoot()?>Permissoes/metodos">Metodos</a>
            </li>
            <li>
                <a class="current" href="#">Edição</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Editar
    </div>
    
    <div class="panel-body">
        <h3>Metodos Editar</h3><hr>
        <form accept-charset="UTF-8" action="<?= $this->urlRoot()?>Permissoes/metodosEdit" id="PermissoesMetodosEditForm" class="form" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Nome da Controladora:</small>
                            <select class="form-control" name="Metodo[controllers_id]">
                                <option value=""> -- Selecione --</option>
                                <?php 
                                    foreach ($controladoras as $control) :
                                    $selected = null;
                                    if( $metodo->getController() == $control['Control']['id'] ):
                                        $selected = 'selected="selected"';
                                    endif;  
                                ?>
                                    <option value="<?= $control['Control']['id']?>" <?= $selected?> > <?= $control['Control']['nome']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Nome da Controladora:</small>
                            <input type="text" class="form-control" name="Metodo[nome]" placeholder="Metodo:" value="<?= $metodo->getNome()?>">
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Nome Link:</small>
                            <input type="text" class="form-control" name="Metodo[nome_link]" placeholder="Nome Link:" value="<?= $metodo->getNomeLink()?>">
                        </div>       
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Descrição:</small>
                            <input type="text" class="form-control" name="Metodo[descricao]" placeholder="Descrição:" value="<?= $metodo->getDescricao()?>">
                        </div>       
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="checkbox">
                                <?php 
                                    $check = null;
                                    $value = 0;
                                    if($metodo->getAtivo() == TRUE):
                                        $check = 'checked="checked"';
                                        $value = $metodo->getAtivo();
                                    endif; 
                                ?>
                                <input type="hidden" name="Metodo[ativo]" value="0">
                                <input type="checkbox" class="" name="Metodo[ativo]" value="1" <?= $check; ?> > Ativo
                            </label>
                        </div>    
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="checkbox">
                                <?php 
                                    $check = null;
                                    $value = 0;
                                    if($metodo->getIsPage() == TRUE):
                                        $check = 'checked="checked"';
                                        $value = $metodo->getIsPage();
                                    endif; 
                                ?>
                                <input type="hidden" name="Metodo[is_page]" value="0">
                                <input type="checkbox" class="" name="Metodo[is_page]" value="1" <?= $check; ?> > Página.
                            </label>
                        </div>    
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="checkbox">
                                <?php 
                                    $check = null;
                                    $value = 0;
                                    if($metodo->getMenuPrimario() == TRUE):
                                        $check = 'checked="checked"';
                                        $value = $metodo->getMenuPrimario();
                                    endif; 
                                ?>
                                <input type="hidden" name="Metodo[menu_primario]" value="0">
                                <input type="checkbox" class="" name="Metodo[menu_primario]" value="1" <?= $check; ?> > Menu Primário.
                            </label>
                        </div>    
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="checkbox">
                                <?php 
                                    $check = null;
                                    $value = 0;
                                    if($metodo->getMenuSecundario() == TRUE):
                                        $check = 'checked="checked"';
                                        $value = $metodo->getMenuSecundario();
                                    endif; 
                                ?>
                                <input type="hidden" name="Metodo[menu_secundario]" value="0">
                                <input type="checkbox" class="" name="Metodo[menu_secundario]" value="1" <?= $check; ?> > Menu Secundário.
                            </label>
                        </div>    
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-primary">Editar</button>
                        </div>    
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    
    
</div>