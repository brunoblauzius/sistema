<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="alert alert-warning" style="margin-top: 10px;">
            <h3>Esqueci minha senha!</h3>
            Ao fazer a requisição de alteração de senha, verificar sua caixa de email enviaremos um link para que você possa realizar a alteração de senha de usuário...
        </div>
        
        <div class="row">
            <form class="form" method="post" action="<?= $this->urlRoot()?>Usuarios/requestSenha" name="UsuarioAlterarDadosForm" id="UsuarioAlterarDadosForm">
                <div class="form-group col-md-6">
                    <small>E-mail:</small>
                    <input class="form-control" name="Usuario[email]" placeholder="Digite seu e-mail" value="">
                </div>
                
                <div class="clearfix"></div>
                
                <div class="form-group col-md-10">
                    <button class="btn btn-primary">Enviar e-mail</button>
                </div>
                
            </form>
        </div>
    </div>
</div>