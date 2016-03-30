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
                Primeiras Configurações!
            </h1>
            <!-- Row -->
            <div class="pi-row ">

                <!-- Col 4 -->
                <div class="pi-col-md-6 pi-col-md-offset-3 pi-col-sm-10 pi-col-sm-offset-1 pi-col-xs-10 pi-col-xs-offset-1">
                    
                        <!-- Box -->
                        <div class="pi-box pi-round" id="PrimeiroCadastroForm" >
                                                        
                            <!-- First name form -->
                            <section class="pi-row " >
                                <div class="pi-col-md-12" id="salao" >
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-cog"></i></div>
                                            <input type="text" name="Salao[nome]" class="form-control" id="inputSalao" placeholder="Nome do Salão:">
                                        </div>
                                    </div>
                                    <section class="alert pi-alert-info">
                                        <p>
                                            <i class="icon-info" style="font-size:18px;"></i> Cadastre pelo menos um salão do seu estabelecimento. 
                                        </p>
                                    </section>
                                </div>
                            </section>
                            <!-- End first name form -->
                            <!-- First name form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12" id="ambiente" style="display:none">
                                    
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-cog"></i></div>
                                            <input type="text" name="Ambiente[nome]" class="form-control" id="inputAmbiente"  placeholder="Nome do Ambiente:">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-cog"></i></div>
                                            <input type="text" name="Ambiente[capacidade]" class="form-control" id="inputCapacidade" placeholder="Capacidade de pessoas do Ambiente:">
                                        </div>
                                    </div>
                                    
                                    <section class="alert pi-alert-info">
                                        <p>
                                            <i class="icon-info" style="font-size:18px;"></i> Agora que você ja tem um salão, cadastre um ambiente deste salão. 
                                        </p>
                                    </section>
                                </div>
                            </section>
                            <!-- End first name form -->
                            <!-- First name form -->
                            <section class="pi-row ">
                                <div class="pi-col-md-12" id="mesa" style="display:none">
                                    
                                    <div class="form-group">
                                        <div class="pi-input-with-icon">
                                            <div class="pi-input-icon"><i class="icon-cog"></i></div>
                                            <input type="text" name="Mesa[nome]" class="form-control" id="inputMesa" placeholder="Nome da Mesa:">
                                        </div>
                                    </div>
                                    
                                    <section class="alert pi-alert-info">
                                        <p>
                                            <i class="icon-info" style="font-size:18px;"></i> As configurações estão quase prontas, agora sa falta cadastrar uma mesa e pronto você pode fazer o teste do sistema! 
                                        </p>
                                    </section>
                                </div>
                            </section>
                            <!-- End first name form -->
                            
                            <!-- Submit button -->
                            <p>
                                <section  >
                                    <button id="send-form" type="submit" data-url="<?= Router::url(array('Empresas', 'cadastro-primeiras-configuracoes'));?>" class="btn pi-btn-base pi-btn-wide pi-weight-600" disabled="true">
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
