/**
 * 
 * @todo funcção que chama a continuação do cadastro da reserva
 * @returns html
 */
function contirnuarReserva(){
    try {
        
        $.ajax({
            beforeSend: function (xhr) {
                // iniciar o loader
                $('#dados-reserva').empty();
                loadingElement('<br>Carregando Informações...','#dados-reserva' );
            },
            url: web_root + 'Reservas/cadastroContinuacao',
            data:{},
            dataType: 'html',
            type: 'get',
            async: true,
            success: function (html) { 
                // dados
                $('#dados-reserva').empty();
                $('#dados-reserva').html(html);
                $('#continuar-reserva').remove();
            },error: function (jqXHR, textStatus, errorThrown) {
                $('#dados-reserva').empty();
            }
        });
    
    } catch (err){
        bootsAlert({
            style: 'warning',
            title: 'Atenção',
            message: err,
            size: 'md',
            time: 3000,
        });
    }
}

/**
 * @todo metodo que chama a função de continuar reserva!
 */
$(document).on('click', '#continuar-reserva', function(){
    contirnuarReserva();
});



$(document).on('click', '#procurar-cliente', function(){
    try {
        var busca = $('#BuscarPor').val();
        var valor = $('#cliente').val();
        var ddd   = null;
        
        if( valor === null || valor === '' ) throw 'insira algum telefone, nome ou email para que seja efetuada a busca!';

        if( busca === 'telefone' ){

            /**
             * verifico se esta vindo um numero
             */
            if( isNaN(parseInt(valor)) && !isFinite(parseInt(valor)) ) throw 'Digite Apenas Números';

            var ddd = $('#ddd').val();
            valor = ddd + valor;

        }
        
        
        $.ajax({
            beforeSend: function (xhr) {
                $('#dados-cliente').empty();
                $('#dados-reserva').empty();
                loadingElement('<br>Carregando Informações...', '#dados-cliente');
            },
            url: web_root + 'Clientes/procurarCliente',
            data:{
                busca: busca,
                valor: valor,
            },
            dataType: 'json',
            type: 'post',
            async: true,
            success: function (dados) {     

                $('#dados-reserva').empty();
                if( dados.total === 1 ){
                    contirnuarReserva();
                } 

                $('#dados-cliente').html(dados.html);
                $('input[name$="['+busca+']"]').val(valor);

            },error: function (jqXHR, textStatus, errorThrown) {
                $('#dados-cliente').empty();
                $('#dados-reserva').empty();
            }
        });
            
    } catch ( err ){
        bootsAlert({
            style: 'warning',
            title: 'Atenção',
            message: err,
            size: 'md',
            time: 3000,
        });
    } 
});


/**
 * @todo busca de cliente por enter
 */
$(document).on('keypress', "#cliente", function(e){
        if(e.which == 13 ){
            try {
                
                var busca = $('#BuscarPor').val();
                var valor = $('#cliente').val();

                if( valor === null || valor === '' ) throw 'insira algum telefone, nome ou email para que seja efetuada a busca!';

                if( busca === 'telefone' ){
                    
                    /**
                     * verifico se esta vindo um numero
                     */
                    if( isNaN(parseInt(valor)) && !isFinite(parseInt(valor)) ) throw 'Digite Apenas Números';
                    
                    var ddd = $('#ddd').val();
                    valor = ddd + valor;
                    
                }
                
                    // iniciar o loader
                    $.ajax({
                        beforeSend: function (xhr) {
                            $('#dados-cliente').empty();
                            $('#dados-reserva').empty();
                            loadingElement('<br>Carregando Informações...', '#dados-cliente');
                        },
                        url: web_root + 'Clientes/procurarCliente',
                        data:{
                            busca: busca,
                            valor: valor,
                        },
                        dataType: 'json',
                        type: 'post',
                        async: true,
                        success: function (dados) {
                    
                            $('#dados-reserva').empty();

                            if( dados.total === 1 ){
                                contirnuarReserva();
                            } 
                            
                            $('#dados-cliente').html(dados.html);
                            $('input[name$="['+busca+']"]').val(valor);
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('#dados-cliente').empty();
                            $('#dados-reserva').empty();
                        }
                    });
                
                
            } catch (err){
                bootsAlert({
                    style: 'warning',
                    title: 'Atenção',
                    message: err,
                    size: 'md',
                    time: 3000,
                });
            }
        }
 });


/**
 * @todo metodo que seleciona um cliente
 */
$(document).on('click', '#encontratId',function(){
    
    try {
        var id = $(this).data('id');
    
        if( id === null ) throw 'Não é posivel realizar a seleção!';
    
        // iniciar o loader
        $.ajax({
            beforeSend: function (xhr) {
                $('#dados-cliente').empty();
                loadingElement('<br>Carregando Informações...', '#dados-cliente');
            },
            url: web_root + 'Clientes/procurarCliente/' + id,
            data:{},
            dataType: 'json',
            type: 'get',
            async: true,
            success: function (dados) { 
                // dados
                $('#dados-cliente').empty();
                $('#dados-reserva').empty();
                if( dados.total === 1 ){
                    contirnuarReserva();
                }
                $('#dados-cliente').html(dados.html);
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#dados-cliente').empty();
                $('#dados-reserva').empty();
            }
        });
        
    } catch (err){
        bootsAlert({
            style: 'warning',
            title: 'Atenção',
            message: err,
            size: 'md',
            time: 3000,
        });
    }
    
});


$(document).on('change', '#BuscarPor', function(){
    if( $('#BuscarPor').val() == 'telefone' ){
        $('#cliente').parent('div').parent('div').addClass('col-md-9');
        $('#cliente').parent('div').parent('div').removeClass('col-md-12');
        $('#ddd').attr('disabled', false);
        $('#ddd').parent('div').parent('div').show(300);
        $('#cliente').attr('placeholder', 'Telefone sem separação');
    } else {
        $('#ddd').parent('div').parent('div').hide();
        $('#ddd').attr('disabled', true);
        $('#cliente').parent('div').parent('div').removeClass('col-md-9');
        $('#cliente').parent('div').parent('div').addClass('col-md-12');
        $('#cliente').removeClass('telefone');
        $('#cliente').removeAttr('autocomplete');
        $('#cliente').removeAttr('maxlength');
        $('#cliente').attr('placeholder', 'Digite o Nome');
    }
    $('#cliente').val(null);
});

