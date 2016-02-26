
<?php if(in_array(Session::read('Usuario.roles_id'), array(2,3,4)) ):?>

<?php if(!empty($endereco)):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel ">
                <div class="panel-body">
                    Endereço: <strong><?= $endereco['logradouro']?>, <?= $endereco['numero']?> | <?= $endereco['cidade']?> - <?= $endereco['bairro']?> - <?= $endereco['uf']?></strong>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<!--mini statistics start-->
<div class="row">
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-gavel"></i></span>
            <div class="mini-stat-info" id="empresa-reservas-mes">
                <span><?= 0?></span>
                Reservas mês.
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><i class="fa fa-user"></i></span>
            <div class="mini-stat-info">
                <span> <?= $clientes?></span>
                Clientes cadastrados.
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon pink"><i class="fa fa-users"></i></span>
            <div class="mini-stat-info">
                <span> <?= $funcionarios?></span>
                Funcionários.
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-suitcase"></i></span>
            <div class="mini-stat-info" id="empresa-relacionadas">
                <span> <?= 0?></span>
                Empresas.
            </div>
        </div>
    </div>
</div>

    <?php if(in_array(Session::read('Usuario.roles_id'), array(3,4)) ):?>
        <div class="row">
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading">
                       Reservas da(s) empresa(s) cadastrada(s).
                    </header>
                    <div class="panel-body">
                        <div id="graph-area"></div>
                    </div>
                </section>
            </div>
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading">
                        Listas de Convidados.
                    </header>
                    <div class="panel-body">
                        <div class="chartJS">
                            <canvas id="bar-chart-js" height="250" width="800" ></canvas>
                        </div>
                        <div class="col-md-12" style="margin-top:68px; ">
                            <div class="col-md-5">
                                <section style="background-color: #f7aa04; width:20px; height:20px; float:left; margin-right:15px;"></section> Convidados na lista
                            </div>
                            <div class="col-md-7">
                                <section style="background-color: #79D1CF; width:20px; height:20px; float:left; margin-right:15px;"></section> Convidados que compareceram
                            </div>
                        </div>
                    </div>
                    
                </section>
            </div>
            <!--div class="col-sm-3">
                <section class="panel">
                    <header class="panel-heading">
                       IDEIA
                    </header>
                    <div class="panel-body">
                        <div id="graph-donut"></div>
                    </div>
                </section>
            </div-->
        </div>
    <?php endif;?>

<?php else:?>

<!--mini statistics start-->
<div class="row">
    
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><i class="fa fa-user"></i></span>
            <div class="mini-stat-info">
                <span> <?= Utils::real($valorMes[0]['bruto'])?></span>
                Proprietários Cadastrados.
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-suitcase"></i></span>
            <div class="mini-stat-info">
                <span> <?= Utils::real($despesaMes)?></span>
                Empresas.
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-gavel"></i></span>
            <div class="mini-stat-info">
                <span><?= 0?></span>
                Reservas mês.
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon pink"><i class="fa fa-users"></i></span>
            <div class="mini-stat-info">
                <span> <?= Utils::real($valorMes[0]['valor_total'] - $despesaMes)?></span>
                Usuários.
            </div>
        </div>
    </div>
    
    
</div>

<?php endif;?>

<script>
    $(document).ready(function() {
        //DraggablePortlet.init();
        
        
        if( empresas_id > 0 ){
            $('#empresa-reservas-mes').html( null );
            loadingElement('Carregando...', '#empresa-reservas-mes');
                        
            $.ajax({
                url: web_root + 'Reservas/reservasMes',
                data: { empresas_id:empresas_id},
                dataType: 'json',
                type: 'post',
                success: function (json) {
                    var elemento = '';
                    elemento += '<span>'+json.qtde+'</span>'+
                    'Reservas mês.';
            
                    $('#empresa-reservas-mes').html(elemento);
                }
            });
            
            
            $('#empresa-relacionadas').html( null );
            loadingElement('Carregando...', '#empresa-relacionadas');
            $.ajax({
                url: web_root + 'Empresas/totalEmpresas',
                data: { empresas_id:empresas_id },
                dataType: 'json',
                type: 'post',
                success: function (json) {
                    var elemento = '';
                    elemento += '<span>'+json.qtde+'</span>'+
                    'Empresas.';
            
                    $('#empresa-relacionadas').html(elemento);
                }
            });
            
            
            if( (roles_id == 4 || roles_id == 3) ){
                //$('#graph-area').html('<span>Carregando gráfico...</span>');
                
                loadingElement('Carregando Gráfico...', '#graph-area');
                $.ajax({
                    url: web_root + 'Reservas/graficoCasas',
                    data: { empresas_id:empresas_id},
                    dataType: 'json',
                    type: 'post',
                    success: function (json) {
                        $('#graph-area').empty();
                        Morris.Area({
                            element: 'graph-area',
                            behaveLikeLine: true,
                            gridEnabled: false,
                            gridLineColor: '#dddddd',
                            axes: true,
                            fillOpacity:.7,
                            data: json.dados,           
                            lineColors:['#E67A77','#D9DD81','#79D1CF'],
                            xkey: 'period',
                            ykeys: json.keys,
                            labels: json.empresas,
                            pointSize: 0,
                            lineWidth: 0,
                            hideHover: 'auto'

                        });
                    }
                });


                $('#graph-donut').html('<span>Carregando gráfico...</span>');
                // Use Morris.Area instead of Morris.Line
                Morris.Donut({
                    element: 'graph-donut',
                    data: [
                        {value: 70, label: 'Empresa 1', formatted: 'acima de 70%' },
                        {value: 15, label: 'Empresa 2', formatted: 'approx. 15%' },
                        {value: 10, label: 'Empresa 3', formatted: 'approx. 10%' },
                        {value: 5, label: 'TESTE', formatted: 'abaixo 5%' }
                    ],
                    backgroundColor: '#fff',
                    labelColor: '#1fb5ac',
                    colors: [
                        '#E67A77','#D9DD81','#79D1CF','#95D7BB'
                    ],
                    formatter: function (x, data) { return data.formatted; }
                });
                
                
               
                
                
            }
            
        }
          
        
    });
</script>
