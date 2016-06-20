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