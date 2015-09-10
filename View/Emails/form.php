
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">Teste</div>
    </div>
    <div class="panel-body">
        
        
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body">
                        <h3>Teste para envio de e-mail:</h3><hr>
                        <div class="form">
                            <form action="<?= Router::url();?>Emails/send" class="form" accept-charset="UTF-8" method="post" name="EmailAddForm" id="EmailAddForm">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <input class="form-control" name="Email[nome]" id="EmailTag" placeholder="Nome:">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <input class="form-control" name="Email[email]" id="EmailTag" placeholder="Email:">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <input class="form-control" name="Email[assunto]" id="EmailTag" placeholder="Assunto:">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea class="form-control" name="Email[mensagem]" rows="6" placeholder="digite sua mensagem"></textarea>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Eviar</button>
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

