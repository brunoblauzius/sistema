 <!-- page script -->
<script type="text/javascript">
    $(function() {
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Emails (Painel)
            <small>usuário master</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Página Inicial</li>
        </ol>
    </section>

    
    <!-- conteudo -->
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            
            <div class="clearfix"></div>
            <hr>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Emails enviados</h3>                                    
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Assunto</th>
                                <th>Mensagem</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(count($emails) == 0):
                                echo '<tr><td colspan="4">Não encontramos nenhum registro</td></tr>';
                            endif;
                            foreach($emails as $email ):?>
                            <tr>
                                <td><?= $email['Contato']['nome']?></td>
                                <td><?= $email['Contato']['email']?></td>
                                <td><?= $email['Contato']['assunto']?></td>
                                <td><?= mb_strimwidth($email['Contato']['mensagem'], 0, 200, '...')?></td>
                                
                                <td class="col-md-2">
                                    <div class="btn-group"> 
                                        <a data-url="<?= $this->urlRoot()?>Contatos/inativar/<?= $email['Contato']['id']?>" class="btn btn-danger action-deletar"> Lido </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Assunto</th>
                                <th>Mensagem</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>    
    <!-- fim conteudo-->
</aside><!-- /.right-side -->


