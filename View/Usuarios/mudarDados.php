<div class="col-md-12" style="margin-top:10px;">
    <a class="btn btn-warning pull-right"href="<?= $this->urlRoot()?>Usuarios/mudarSenha">Alterar minha senha</a>
    <h2 class="pgtitulo">Alterar meus dados:</h2>
    <div class="clearfix"></div>
    
    <div class="row">
        <form class="form" accept-charset="utf-8" method="post" action="<?= $this->urlRoot()?>Usuarios/alterarDados" name="UsuarioAlterarDadosForm" id="UsuarioAlterarDadosForm">
            <div class="form-group col-md-6">
                <small>Nome:</small>
                <input class="form-control" name="Usuario[nome]" placeholder="Digite seu Nome" value="<?=$usuario['Usuario']['nome']?>">
            </div>
            <div class="form-group col-md-6">
                <small>E-mail:</small>
                <input class="form-control" name="Usuario[email]" placeholder="Digite seu e-mail" value="<?=$usuario['Usuario']['email']?>">
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <small>Telefone Fixo:</small>
                <input class="form-control fone" name="Usuario[telefoneFixo]" placeholder="Digite seu Telefone Fixo" value="<?=$usuario['Usuario']['telefoneFixo']?>">
            </div>
            <div class="form-group col-md-6">
                <small>Telefone Celular:</small>
                <input class="form-control fone" name="Usuario[telefoneCelular]" placeholder="Digite seu Telefone Celular" value="<?=$usuario['Usuario']['telefoneCelular']?>">
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-10">
                <button class="btn btn-primary">Alterar meus dados</button>
            </div>
            
        </form>
    </div>
    
</div>
