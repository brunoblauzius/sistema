<style type="text/css">
    .info-cont{ width:100%; padding:10px; font-size:14px;}
    .info-cont h3{ border-bottom:1px solid #000 }
    .info-cont p{ font-size:12px;}
</style>
<script type="text/javascript">
$(document).ready(function(){

      $('.buscar').click(function(){

            $('.info-vacinas').empty();
            $('<h4>Carregando os registros ...</h4>').appendTo('.info-vacinas');

            var id = $('#vacina').val();
            var url = '<?php echo $this->urlRoot();?>/Pages/viewPerfilVacina/' + id;
            $.get( url , function( data ){
                $('.info-vacinas').empty();
                $('.info-vacinas').html(data);
            });

      });
     //
});
</script>



<div class="row">
    
    <div class="col-md-12">
        <h2 class="pgtitulo" >Informações: </h2>
    
        <div class="col-md-4">
                <small>Selecione a vacina para obter informações:</small>
                <select name="vacina" id="vacina" class="form-control">
                    <option value=""> -- selecione a vacina -- </option>
                        <?php foreach ($vacinas as $vacina): ?>
                            <option value="<?php echo $vacina['Vacina']['id'] ?>"> <?php echo ucwords( $vacina['Vacina']['nome'] )?> </option>
                        <?php endforeach; ?>
                </select>
                <!-- <input type="submit" class="btn btn-primary" value="Ver Informação"> -->
        </div>
        <div class="col-md-2" style="padding-top:20px;">
            <a class="btn btn-primary buscar" > Buscar</a>
        </div>
        <div class="clearfix"></div>
        <hr>

        <div class="col-md-12 info-vacinas"></div>

    </div>
</div>

