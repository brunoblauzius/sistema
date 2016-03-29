$(document).ready(function(){
    
    $('#inputSalao').change(function(){
        
        var salao = $(this).val();
        if( salao.length > 1 && salao !== '' ){
            $('#salao').find('.alert').fadeOut(100);
            $('#ambiente').show(500);
        }
    });
    
    $('#inputAmbiente').change(function(){
        var ambiente = $(this).val();
        if( ambiente.length > 1 && ambiente !== '' ){
            $('#ambiente').find('.alert').fadeOut(100);
            $('#mesa').show(500);
        }
    });
    
    $('#inputMesa').change(function(){
        var mesa = $(this).val();
        if( mesa.length > 1 && mesa !== '' ){
            $('#mesa').find('.alert').fadeOut(100);
            $('#button').fadeIn(200);
        }
    });
    
});