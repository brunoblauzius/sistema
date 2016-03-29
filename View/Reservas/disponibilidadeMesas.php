<?php
    foreach ($mesasRestantes as $mesaRestante) :
    $mesasDisponiveis = $mesaRestante['totalMesas'] - $mesaRestante['mesasReservadas'];
?>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <h5><?= $mesaRestante['ambiente'] ?></h5>
                    <!--p><small>Total de mesas:</small> <br>
                <?php if ($mesaRestante['totalMesas'] == 0): ?>
                                <label class="text text-warning"><i class="fa fa-warning"></i> Nenhuma mesa cadastrada!</label>
                <?php else: ?>
                                <label class="text text-primary"><?= $mesaRestante['totalMesas'] ?> Mesas cadastradas</label>
                <?php endif; ?>
                    </p-->

            <!--p style="margin-top: -15px"><small>Mesas reservadas hoje:</small> <br>
                <?php if ($mesaRestante['mesasReservadas'] == 0): ?>
            <label class="text text-info">Nenhuma mesa reservada</label>
                <?php else: ?>
            <label class="text text-primary"><?= $mesaRestante['mesasReservadas'] ?> mesas reservadas</label>
            <?php endif; ?>
            </p-->

                <p style="margin-top:-5px">
                    <?php if ($mesasDisponiveis == 0): ?>
                        <label class="label label-danger">Indisponivel para cadastro</label>
                    <?php else: ?>
                        <label class="label label-base"><?= $mesasDisponiveis ?> mesas disponiveis</label>
                <?php endif; ?>
                </p>
            </div>
<?php endforeach; ?>