<form action="<?= Router::url(array('Reservas', 'add')) ?>" method="post" id="ReservaAddForm" name="ReservaAddForm">
    <div class="modal-body">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <small>Data: <strong class="text text-danger">*</strong></small>
                    <div class='input-group date datetimepicker3'>
                        <input type='text' class="form-control date_time" name="Reserva[data]" id="start"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <small>Hora: <strong class="text text-danger">*</strong></small>
                        <input type='text' class="form-control data_time " id="hora" name="Reserva[hora]" placeholder="ex. 20:00"/>                              
                </div>
            </div>
            
            
            <div class="col-md-4">
                <div class="col-md-3" style="padding-left:5px; padding-right:5px;">
                    <div class="form-group">
                        <small>DDD:</small>
                        <input type='text' class="form-control" name="Busca[ddd]" id="ddd" value="<?= substr($_SESSION['Contato'][0]['telefone'], 0,2)?>"/>
                    </div>
                </div>
                <div class="col-md-9" style="padding-left:5px; padding-right:5px;">
                    <div class="form-group">
                        <small>Nome/Telefone: <strong class="text text-danger">*</strong></small>
                        <input type='text' class="form-control" name="Busca[cliente]" id="cliente" placeholder="Telefone sem separação"/>
                    </div>
                </div>
            </div>
            
            

            <div class="col-md-3">
                <div class="form-group">
                    <small>Burcar cliente por: <strong class="text text-danger">*</strong></small>
                    <select name="Busca[buscaPor]" class="form-control" id="BuscarPor">
                        <option value="telefone"> TELEFONE </option>
                        <option value="nome"> NOME </option>
                        <option value="rg"> RG </option>
                        <option value="email"> E-MAIL </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <a class="btn btn-primary pull-right btn-xs" id="procurar-cliente">Procurar Cliente</a>
                </div>
            </div>
            
        </div>
        

        <div class="row" id="dados-cliente">                       
        </div>


        <div class="row" id="dados-reserva">
        </div>
        
    </div>
</form>