<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?= Router::url(array('Reservas', 'adicionarListaConvidados'))?>" id="ArquivoAddForm">
            <div class="row">
                
                <div class="form-group col-md-8">
                    <h5>Cadastro da lista de convidados por arquivo.</h5>
                    <small>Arquivo permitido .csv: <strong class="text text-danger">*</strong></small>
                    <input type="file" name="arquivo" class="form-control input-sm rounded" placeholder="Insira o arquivo:">
                    <input type="hidden" name="token" value="<?= ($token)?>">
                </div>
                <div class="form-group col-md-4">
                    <button class="btn btn-sm btn-warning btn-rounded btn-block" style="margin-top:55px">enviar arquivo</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?= Router::url(array('Reservas', 'adicionarConvidados'))?>" id="ClienteAddForm">
            <div class="row">
                <div class="form-group col-md-12">
                    
                    <h5>Cadastro de convidados simples.</h5>
                    
                    <small>Nome: <strong class="text text-danger">*</strong></small>
                    <input type="text" name="Cliente[nome]" class="form-control input-sm rounded" placeholder="Nome:">
                </div>
                <div class="form-group col-md-12">
                    <small>E-mail: <strong class="text text-danger"></strong></small>
                    <input type="text" name="Cliente[email]" class="form-control input-sm rounded" placeholder="E-mail:">
                </div>
                <div class="form-group col-md-12">
                    <small>RG: <strong class="text text-danger"></strong></small>
                    <input type="text" name="Cliente[rg]" class="form-control input-sm rounded" placeholder="RG:">
                </div>
                <div class="form-group col-md-12">
                    <small>Telefone: <strong class="text text-danger"></strong></small>
                    <input type="text" name="Cliente[telefone]" class="form-control input-sm  rounded telefone" placeholder="Telefone:">
                    <input type="hidden" name="Reserva[token]" value="<?= ($token)?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 ">
                    <button class="btn btn-s-md btn-primary btn-rounded btn-block">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>