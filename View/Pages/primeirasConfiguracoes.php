<div class="pi-section-w pi-section-white piICheck piStylishSelect">
    <div class="pi-section pi-padding-bottom-60">
        
        <div class="pi-row pi-margin-bottom-50 ">
            <div class="pi-text-center ">
                <div class="pi-col-md-4 badge-cadastro ">
                    <img src="<?= Router::url('View/webroot/site/img/1458782254_42.Badge.png')?>" width="70">
                    <p>Cadastro</p>
                </div>
                <div class="pi-col-md-4 badge-cadastro">
                    <img src="<?= Router::url('View/webroot/site/img/1458782720_03.Office.png')?>" width="70">
                    <p>Estabelecimento</p>
                </div>
                <div class="pi-col-md-4 badge-cadastro badge-cadastro-active">
                    <img src="<?= Router::url('View/webroot/site/img/1458782237_12.File.png')?>" width="70">
                    <p>Configurações</p>
                </div>
            </div>
        </div>
        
        <div class="pi-text-center pi-margin-bottom-50 ">
            <h1 class="pi-uppercase pi-weight-700 pi-has-border pi-has-tall-border pi-has-short-border">
                Configurações
            </h1>
            <!-- Row -->
            <div class="pi-row ">

                <!-- Col 4 -->
                <div class="pi-col-md-6 pi-col-md-offset-3 pi-col-sm-10 pi-col-sm-offset-1 pi-col-xs-10 pi-col-xs-offset-1">
                    
                        <!-- Box -->
                        <div class="pi-box pi-round" id="PrimeiroCadastroForm" >
                                                        
                            
                            
                            <!-- First name form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12">
                                    <section class="alert pi-alert-info" style="padding: 10px;">
                                        <p style="margin-bottom: 0px;">
                                            <i class="icon-info" style="font-size:20px;"></i> Quantas mesas você utiliza para fazer reservas no estabelecimento?<br>
                                            <small>*Limite maximo de 50 mesas para esta conta!</small>
                                        </p>
                                    </section>
                                    
                                    <div class="form-group">
                                        <div class="pi-col-md-6" style="padding-left: 0px;">
                                            <div class="pi-input-with-icon">
                                                <div class="pi-input-icon"><i class="icon-cog"></i></div>
                                                <input type="text" name="Mesa[quantidade]" class="form-control" id="inputMesa" placeholder="Quantidade">
                                            </div>
                                        </div>
                                        <div class="pi-col-md-6" style="padding-left: 0px;" id="alerta-erros">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- End first name form -->
                            
                            <!-- Submit button -->
                            <p>
                                <section  >
                                    <button id="send-form" type="submit" data-url="<?= Router::url(array('Empresas', 'cadastro-primeiras-configuracoes'));?>" class="btn pi-btn-base pi-btn-wide pi-weight-600">
                                        Cadastrar suas primeiras configurações!
                                    </button>
                                </section>
                            </p>
                            <!-- End submit button -->

                        </div>
                        <!-- End box -->
                    
                    
                </div>
                <!-- End col 4 -->

            </div>
            <!-- End row -->
        </div>
                
    </div>
</div>
