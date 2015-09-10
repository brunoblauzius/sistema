<div class="panel">
    
    <div class="panel-heading">
        <h3 class="panel-title">Usuário Alterar Senha</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <form class="form" accept-charset="UTF-8" method="post" action="<?= Router::url() . 'Usuarios/alterarSenha' ;?>" id="UsuarioEditForm">
                
                <div class="col-md-3">
                    <div class="form-group">
                        <small>Senha:<span class="text text-danger">*</span></small>
                    <input name="Usuario[senha]" class="form-control" placeholder="Senha" type="password">
                    </div>    
                </div>
                <div class="clearfix"></div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <small>Confirmação de senha:<span class="text text-danger">*</span></small>
                        <input name="Usuario[confirm_senha]" class="form-control" placeholder="Confirmação desenha" type="password">
                    </div>    
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-primary">Alterar minha senha</button>
                    </div>    
                </div>
            </form>
        </div>
    </div>
    
    <div class="panel-footer"></div>
    
</div>