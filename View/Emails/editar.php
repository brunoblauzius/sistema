<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Usuarios/painel"> <i class="fa fa-home"></i> Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url();?>Emails/index">E-mails</a>
            </li>
            <li>
                <a class="current" href="#">Editar</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">Editar E-mail</div>
    </div>
    <div class="panel-body">
        
        
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body">
                        <h3>Alteração de mensagem para o email:</h3><hr>
                        <div class="form">
                            <form action="<?= Router::url();?>Emails/edit" class="form" accept-charset="UTF-8" method="post" name="EmailEditForm" id="EmailEditForm">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <input class="form-control" name="Email[tag]" id="EmailTag" placeholder="Tag do email:" value="<?= $objeto->getTag()?>">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="checkbox">
                                                <?php 
                                                    $check = null;
                                                    $value = 0;
                                                    if($objeto->getAtivo() == TRUE):
                                                        $check = 'checked="checked"';
                                                        $value = $objeto->getAtivo();
                                                    endif; 
                                                ?>
                                                <input type="hidden" name="Email[ativo]" value="0">
                                                <input type="checkbox" class="" name="Email[ativo]" value="1" <?= $check; ?> > Ativo

                                            </label>
                                        </div>    
                                    </div>
                                    
                                    <div class="clearfix"></div>
                                    
                                    <div class="col-md-8" style="margin-top:30px;">
                                        <textarea class="form-control ckeditor" name="Email[corpo_mail]" rows="6"><?= $objeto->getCorpoEmail()?></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="badge bg-info"> Legenda:</small>
                                        <table class="table table-condensed table-striped" style="font-size:12px;">
                                            <thead>
                                                <tr>
                                                    <th>link</th>
                                                    <th>valor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>__NOME_REMETENTE__</td>
                                                    <td>Nome do remetente</td>
                                                </tr>
                                                <tr>
                                                    <td>__EMAIL_REMETENTE__</td>
                                                    <td>E-mail do remetente</td>
                                                </tr>
                                                <tr>
                                                    <td>__NOME_DESTINATARIO__</td>
                                                    <td>Nome do destinatário</td>
                                                </tr>
                                                <tr>
                                                    <td>__EMAIL_DESTINATARIO__</td>
                                                    <td>E-mail do destinatário</td>
                                                </tr>
                                                <tr>
                                                    <td>__ASSUNTO__</td>
                                                    <td>Assunto do e-mail</td>
                                                </tr>
                                                <tr>
                                                    <td>__MSG__</td>
                                                    <td>Mensagem do e-mail</td>
                                                </tr>
                                                <tr>
                                                    <td>__DATE__</td>
                                                    <td>Date de envio do e-mail</td>
                                                </tr>
                                                <tr>
                                                    <td>__URL__</td>
                                                    <td>URL do sistema aonde vai ser redirecionado o email.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                <div class="clearfix"></div>
                                <div class="col-md-6" style="margin-top:30px;">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Editar</button>
                                    </div>    
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="panel-footer"></div>
</div>

