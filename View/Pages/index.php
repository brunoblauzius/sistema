<form class="form-signin" action="<?= Router::url( array('Usuarios','login' ) ); ?>" method="post" id="UsuarioLoginForm">
        
        <?php if( Session::read('form_error.erro') ):?>
                <div class="alert alert-danger">
                        <p style="color:#fff;">
                                <?php echo Session::read('form_error.message') ?>
                        </p>
                </div>
        <?php endif;?>
        
        <div class="login-wrap">
            <div class="user-login-info">
				<h2 class="text-center"><img src="<?= Router::url(array('View', 'webroot', 'images', 'logo.png'))?>"></h2>
                <input type="text" id="nome" name="Usuario[email]"  class="form-control" placeholder="Login:" autofocus>
                <input type="password" id="nome" name="Usuario[senha]" class="form-control" placeholder="Senha:">
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Lembrar-me
                <span class="pull-right">
                    <a href="<?= Router::url(array('Usuarios', 'recuperaSenha'))?>"> Esqueceu sua senha?</a>
                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" >Logar</button>

            <div class="registration">
                Ainda não tenho uma conta?
                <a class="" href="/">
                    Criar uma conta.
                </a>
            </div>
        </div>
</form>