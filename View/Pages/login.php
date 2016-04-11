<div id="page"><!-- - - - - - - - - - SECTION - - - - - - - - - -->
<div class="pi-section-w pi-section-parallax pi-section-white pi-section-high piSectionHigh" style="background-image: url(<?= Router::url('View/webroot/site/img/fundo.jpg') ?>);" >
	<div class="pi-section pi-padding-bottom-60">
		
		<div class="pi-text-center pi-margin-bottom-50">
			<h1 class="pi-uppercase pi-weight-700 pi-has-border pi-has-tall-border pi-has-short-border">
				Entrar no sistema
			</h1>
		</div>

		<!-- Row -->
		<div class="pi-row">
			
			<!-- Col 4 -->
			<div class="pi-col-md-4 pi-col-md-offset-4 pi-col-sm-6 pi-col-sm-offset-3 pi-col-xs-8 pi-col-xs-offset-2">
			
				<!-- Box -->
                                <div class="pi-box pi-round pi-shadow-15">
                                    <form class="form-signin" action="<?= Router::url( array('Usuarios','login' ) ); ?>" method="post" id="UsuarioLoginForm">
                                        <!-- Email form -->
                                        <div class="form-group">
                                                <div class="pi-input-with-icon">
                                                        <div class="pi-input-icon"><i class="icon-mail"></i></div>
                                                        <input type="text" name="Usuario[email]" class="form-control" id="exampleInputEmail" placeholder="Login:">
                                                </div>
                                        </div>
                                        <!-- End email form -->

                                        <!-- Password form -->
                                        <div class="form-group ">
                                                <div class="pi-input-with-icon">
                                                        <div class="pi-input-icon"><i class="icon-lock"></i></div>
                                                        <input type="password" name="Usuario[senha]" class="form-control" id="exampleInputPassword" placeholder="Senha:">
                                                </div>
                                        </div>
                                        <!-- End password form -->

                                        <p class="pi-pull-right pi-small-text">
                                                <a href="<?= Router::url(array('Usuarios', 'recuperaSenha'))?>"> Esqueceu sua senha?</a>
                                        </p>

                                        <!-- Checkbox -->
                                        <div class="checkbox">
                                                <label class="pi-small-text">
                                                        <input type="checkbox">Lembrar me
                                                </label>
                                        </div>
                                        <!-- End checkbox -->

                                        <!-- Submit button -->
                                        <div class="pi-row">
                                            <div class="pi-col-md-12">
                                                <div class="form-group">
                                                        <button type="submit" class="btn pi-btn-base pi-btn-wide pi-weight-600">
                                                                Logar se
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End submit button -->
                                    </form>
				</div>
				<!-- End box -->
				
				<p class="pi-text-center">
                                    <span style="color:#FFF">Você ainda não tem conta?</span> <a href="<?= Router::url(array('Pages', 'criar-conta'))?>" class="pi-weight-700">Criar Conta</a>
				</p>
				
			</div>
			<!-- End col 4 -->
			
		</div>
		<!-- End row -->
		
	</div>
</div>
<!-- - - - - - - - - - END SECTION - - - - - - - - - --></div>