<div class="pi-section-w pi-section-white piICheck piStylishSelect">
    <div class="pi-section pi-padding-bottom-60">

        <div class="pi-text-center pi-margin-bottom-50">
            <h1 class="pi-uppercase pi-weight-700 pi-has-border pi-has-tall-border pi-has-short-border">
                Baladeiro!
            </h1>
            <button class="btn pi-btn pi-btn-purple" data-toggle="modal" data-target="#ModalBaladeiro">
               Criar uma conta
            </button> 
        </div>

        
        <div class="pi-text-center pi-margin-bottom-50">
            <h1 class="pi-uppercase pi-weight-700 pi-has-border pi-has-tall-border pi-has-short-border">
                Balada!
            </h1>
            <button class="btn pi-btn pi-btn-base" data-toggle="modal" data-target="#ModalBalada">
               Criar uma conta
            </button> 
        </div>
        
        

    </div>
</div>


<!-- Button trigger modal -->
<div class="modal fade" id="ModalBaladeiro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Cadastro do Baladeiro</h4>
      </div>
      <div class="modal-body pi-section-grey">
        <!-- Row -->
        <div class="pi-row ">

            <!-- Col 4 -->
            <div class="pi-col-md-8 pi-col-md-offset-2 pi-col-sm-10 pi-col-sm-offset-1 pi-col-xs-10 pi-col-xs-offset-1">

                <!-- Box -->
                <div class="pi-box pi-round">

                    <!-- First name form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-user"></i></div>
                            <input type="text" class="form-control" id="exampleInputUsername" placeholder="Nome Completo">
                        </div>
                    </div>
                    <!-- End first name form -->

                    <!-- Email form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-mail"></i></div>
                            <input type="email" class="form-control" id="exampleInputEmail" placeholder="E-mail">
                        </div>
                    </div>
                    <!-- End email form -->
                    
                    <!-- Email form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-phone"></i></div>
                            <input type="text" class="form-control" id="exampleInputPhone" placeholder="Telefone">
                        </div>
                    </div>
                    <!-- End email form -->

                    <!-- Password form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-lock"></i></div>
                            <input type="password" class="form-control" id="exampleInputPassword" placeholder="Senha">
                        </div>
                    </div>
                    <!-- End password form -->

                    <!-- Password form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-lock"></i></div>
                            <input type="password" class="form-control" id="exampleInputConfirmPassword" placeholder="Confirmar Senha">
                        </div>
                    </div>
                    <!-- End password form -->

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

                <p class="pi-text-center">
                    Já possui uma Conta? <a href="<?= Router::url(array('Pages', 'login'));?>" class="pi-weight-600">Logar-se</a>
                </p>

            </div>
            <!-- End col 4 -->

        </div>
        <!-- End row -->
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn pi-btn pi-btn-base" data-dismiss="modal">Close</button>
      </div-->
    </div>
  </div>
</div>


<!-- Button trigger modal -->
<div class="modal fade" id="ModalBalada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Cadastro da Balada</h4>
      </div>
      <div class="modal-body pi-section-grey">
        <!-- Row -->
        <div class="pi-row ">

            <!-- Col 4 -->
            <div class="pi-col-md-8 pi-col-md-offset-2 pi-col-sm-10 pi-col-sm-offset-1 pi-col-xs-10 pi-col-xs-offset-1">

                <!-- Box -->
                <div class="pi-box pi-round">

                    <!-- First name form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-user"></i></div>
                            <input type="text" class="form-control" id="exampleInputUsername" placeholder="Nome fantasia">
                        </div>
                    </div>
                    <!-- End first name form -->

                    <!-- Email form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-mail"></i></div>
                            <input type="email" class="form-control" id="exampleInputEmail" placeholder="E-mail">
                        </div>
                    </div>
                    <!-- End email form -->
                    
                    <!-- Email form -->
                    <div class="form-group">
                        <div class="pi-input-with-icon">
                            <div class="pi-input-icon"><i class="icon-phone"></i></div>
                            <input type="text" class="form-control" id="exampleInputPhone" placeholder="Telefone">
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

                <p class="pi-text-center">
                    Já possui uma Conta? <a href="<?= Router::url(array('Pages', 'login'));?>" class="pi-weight-600">Logar-se</a>
                </p>

            </div>
            <!-- End col 4 -->

        </div>
        <!-- End row -->
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn pi-btn pi-btn-base" data-dismiss="modal">Close</button>
      </div-->
    </div>
  </div>
</div>