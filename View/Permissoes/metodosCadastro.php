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
                <a class="current" href="#">Cadastro</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Cadastro
    </div>
    
    <div class="panel-body">
        <h3>Metodos Cadastro</h3><hr>
        <form accept-charset="UTF-8" action="<?= $this->urlRoot()?>Permissoes/metodosAdd" id="PermissoesMetodosAddForm" class="form" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                            <small class="">Nome da Controladora:</small>
                            <select class="form-control" name="Metodo[controllers_id]" id="Controler" data-url="<?= $this->urlRoot()?>Permissoes/listAllMethods">
                                <option value=""> -- Selecione --</option>
                                <?php foreach ($controladoras as $control) :?>
                                    <option value="<?= $control['Control']['id']?>"> <?= $control['Control']['nome']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    
                    <div id="append"></div>
                    
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" class="" name="Metodo[ativo]" value="1" checked=""> Ativo
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

