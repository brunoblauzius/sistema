
<div class="panel">
    <header class="bg-header-primary panel-heading">
       Lista
    </header>
    <div class="panel panel-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= Router::url(array('Listas', 'add'));?>" method="post" id="ListaAdd">
                        <div class="col-md-12">
                            <div class="col-md-3">Titulo: <span class="text text-danger">*</span></div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="Lista[title]" placeholder="Titulo:" id="title">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3">Gênero: <span class="text text-danger">*</span></div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="checkbox">
                                        <input class="" type="checkbox" name="Lista[sexo][]" value="1" id="male"> <span class="bg-header-male">Masculino</span>
                                    </label>
                                    <label class="checkbox">
                                        <input class="" type="checkbox" name="Lista[sexo][]" value="0" id="female"> <span class="bg-header-female">Feminino</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3">Informações: <span class="text text-danger"></span></div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <textarea class="form-control" name="Lista[descricao]" id="descricao" rows="6" placeholder="Informações sobre este registro:"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3"> </div>
                            <div class="col-md-9">
                                <button class="btn btn-primary "> Cadastrar </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row " style="margin-top: 50px;">
                <div class="col-md-12" id="table-lista">
                    
                </div>
            </div>

    </div>
</div>