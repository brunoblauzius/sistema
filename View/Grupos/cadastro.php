
<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Grupos/index">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= $this->urlRoot()?>Grupos/index">Grupos</a>
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
        <h3>Grupos Cadastro</h3><hr>
        <form accept-charset="UTF-8" action="<?= $this->urlRoot()?>Grupos/add" id="GrupoAddForm" class="form" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Nome do grupo:</small>
                            <input type="text" class="form-control" name="Grupo[nome]" placeholder="Grupo:">
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="hidden" name="Grupo[status]" value="0">
                                <input type="checkbox" class="" name="Grupo[status]" value="1" checked=""> Ativo
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