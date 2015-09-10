
<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Usuarios/painel">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= $this->urlRoot()?>Permissoes/controladora">Controladora</a>
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
        <h3>Controladora Cadastro</h3><hr>
        <form accept-charset="UTF-8" action="<?= $this->urlRoot()?>Permissoes/controladoraAdd" id="PermissoesControladoraAddForm" class="form" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Nome da Controladora:</small>
                            <input type="text" class="form-control" name="Control[nome]" placeholder="Controladora:">
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Nome do Link:</small>
                            <input type="text" class="form-control" name="Control[nome_link]" placeholder="Nome do link:">
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="">Icone do link:</small>
                            <input type="text" class="form-control" name="Control[icon]" placeholder="Icone do link:">
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" class="" name="Control[ativo]" value="1" checked="checked"> Ativo
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