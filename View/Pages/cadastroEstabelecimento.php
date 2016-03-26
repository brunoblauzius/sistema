<div class="pi-section-w pi-section-white piICheck piStylishSelect">
    <div class="pi-section pi-padding-bottom-60">
        
        <div class="pi-row pi-margin-bottom-50 ">
            <div class="pi-text-center ">
                <div class="pi-col-md-4 badge-cadastro ">
                    <img src="<?= Router::url('View/webroot/site/img/1458782254_42.Badge.png')?>" width="70">
                    <p>Cadastro</p>
                </div>
                <div class="pi-col-md-4 badge-cadastro badge-cadastro-active">
                    <img src="<?= Router::url('View/webroot/site/img/1458782720_03.Office.png')?>" width="70">
                    <p>Estabelecimento</p>
                </div>
                <div class="pi-col-md-4 badge-cadastro">
                    <img src="<?= Router::url('View/webroot/site/img/1458782237_12.File.png')?>" width="70">
                    <p>Configurações</p>
                </div>
            </div>
        </div>
        
        <div class="pi-text-center pi-margin-bottom-50 ">
            <h1 class="pi-uppercase pi-weight-700 pi-has-border pi-has-tall-border pi-has-short-border">
                CADASTRO
            </h1>
            <!-- Row -->
            <div class="pi-row ">

                <!-- Col 4 -->
                <div class="pi-col-md-6 pi-col-md-offset-3 pi-col-sm-10 pi-col-sm-offset-1 pi-col-xs-10 pi-col-xs-offset-1">
                    <form action="<?= Router::url(array('Pessoas', 'cadastro-site'));?>" method="post" name="CadastroFrom" id="CadastroFrom">
                        <!-- Box -->
                        <div class="pi-box pi-round">

                            <!-- First name form -->
                            <div class="form-group">
                                <div class="pi-input-with-icon">
                                    <div class="pi-input-icon"><i class="icon-user"></i></div>
                                    <input type="text" name="Pessoa[nome]" class="form-control" id="exampleInputUsername" placeholder="Seu Nome:">
                                </div>
                            </div>
                            <!-- End first name form -->

                            <!-- Email form -->
                            <div class="form-group">
                                <div class="pi-input-with-icon">
                                    <div class="pi-input-icon"><i class="icon-mail"></i></div>
                                    <input type="email" name="Pessoa[email]" class="form-control" id="exampleInputEmail" placeholder="E-mail">
                                </div>
                            </div>
                            <!-- End email form -->

                            <!-- Email form -->
                            <div class="form-group">
                                <div class="pi-input-with-icon">
                                    <div class="pi-input-icon"><i class="icon-phone"></i></div>
                                    <input type="text" name="Pessoa[telefone]" class="form-control" id="exampleInputPhone" placeholder="Telefone">
                                </div>
                            </div>
                            <!-- End email form -->


                            <!-- Checkbox -->
                            <div class="checkbox pi-margin-bottom-20">
                                <label class="pi-small-text">
                                    <input type="checkbox">Veja os  <a href="#">termos do Contrato</a>
                                </label>
                            </div>
                            <!-- End checkbox -->

                            <!-- Submit button -->
                            <p>
                                <button type="submit" class="btn pi-btn-base pi-btn-wide pi-weight-600">
                                    Criar uma Conta
                                </button>
                            </p>
                            <!-- End submit button -->

                        </div>
                        <!-- End box -->
                    </form>
                    <p class="pi-text-center">
                        Já possui uma Conta? <a href="<?= Router::url(array('Pages', 'login'));?>" class="pi-weight-600">Logar-se</a>
                    </p>

                </div>
                <!-- End col 4 -->

            </div>
            <!-- End row -->
        </div>
                
    </div>
</div>
