<div class="row" style="font-size:13px;">

<div class="col-md-2">
    <img src="<?php echo $this->urlRoot();?>View/webroot/images/logo.png" width="180">
</div>
    
<div class="col-md-12" >

    <table style="width:100%; padding:10px;">
        <tr style="background-color:#efefef; border-bottom:1px solid #adadad; font-size:14px;">
            <td>Nome:</td>
            <td>CPF ou DMV:</td>
            <td>Contato</td>
        </tr>
        <tr style="font-size:12px; color:#1b8dbb; font-size:12px;">
            <td><?php echo $usuario['Usuario']['nome'] ?></td>
            <td><?php echo $usuario['Usuario']['cpf'] ?></td>
            <td><?php echo $usuario['Usuario']['telefoneFixo'] ?></td>
        </tr>
    </table>
    
    <hr>

    <h4>Vacinas Agendadas</h4>

    <table style="width:100%; padding:5px;">

        <thead >

            <tr style="background-color:#efefef; border-bottom:1px solid #adadad; font-size:14px;">

                <th class="col-md-3">PACIENTE</th>

                <th class="col-md-3">VACINA</th>

                <th class="col-md-2">POSTO</th>

                <th class="col-md-2">DATA AGENDADA</th>

            </tr>

        </thead>

        <tbody>

            <?php 

            if(empty($vacinas)):

                echo '<tr>

                <td  colspan="3" style="font-size:12px; color:#1b8dbb"> <h4>Nenhum registro foi encontrado...</h4></td></tr>';

            else:

                foreach ($vacinas as $vacina) :

            ?>

                <tr style="font-size:12px; color:#1b8dbb; text-align:center">

                    <td><?= $vacina['nome']?></td>

                    <td><?= $vacina['vacinaNome']?></td>

                    <td><?= ( $vacina['localVacina'] )?></td>

                    <td>

                        <?php 

                            if( !empty($vacina['dataAgenda'])){

                                $data = explode(' ', $vacina['dataAgenda']);

                                echo Utils::convertData($data[0]);

                            }

                        ?>

                    </td>

                </tr>

            <?php 

                endforeach;

            endif;

            ?>

        </tbody>

    </table>

</div>

<hr>

<div class="col-md-12">

    <h4>Vacinas que já foram aplicadas</h4>

    <table  style="width:100%; padding:5px;">

        <thead>

            <tr style="background-color:#efefef; border-bottom:1px solid #adadad; font-size:14px;">

                <th class="col-md-3">PACIENTE</th>

                <th class="col-md-3">VACINA</th>

                <th class="col-md-2">POSTO</th>

                <th class="col-md-2">DATA APLICAÇÃO</th>

            </tr>

        </thead>

        <tbody>

            <?php 

            if(empty($vacinasAplicadas)):

                echo '<tr>

                <td  colspan="3" style="font-size:12px; color:#1b8dbb"> <h4>Nenhum registro foi encontrado...</h4></td></tr>';

            else:

                foreach ($vacinasAplicadas as $vacinasAplicada) :

            ?>

                <tr style="font-size:12px; text-align:center;">

                    <td><?= $vacinasAplicada['nome']?></td>

                    <td><?= $vacinasAplicada['vacinaNome']?></td>

                    <td><?= ( $vacinasAplicada['localVacina'] )?></td>

                    <td>

                        <?php 

                            if( !empty($vacinasAplicada['data_vacina'])){

                                $data = explode(' ', $vacinasAplicada['data_vacina']);

                                echo Utils::convertData($data[0]);

                            }

                        ?>

                    </td>

                </tr>

            <?php 

                endforeach;

            endif;

            ?>

        </tbody>

    </table>

</div>

</div>