$(document).ready(function(){
    carregaMinhaLista();
    carregaResumoFuncionario();
});

/**
 * @todo 
 * @param {string} search
 * @returns {string html}
 */
function carregaMinhaLista() {
    $.ajax({
        beforeSend: function (xhr) {
            $('#minha-lista').html('<b>Carregando...</b>');
        },
        url: web_root + 'Eventos/carrega-minha-lista',
        data: {},
        method: 'post',
        dataType: 'html',
        success: function (data, textStatus, jqXHR) {
            $('#minha-lista').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#minha-lista').empty();
        }
    });
}

function carregaResumoFuncionario() {
    $.ajax({
        beforeSend: function (xhr) {
            $('#resumo-minha-lista').html('<b>Carregando...</b>');
        },
        url: web_root + 'Eventos/resumo',
        data: {},
        method: 'post',
        dataType: 'html',
        success: function (data, textStatus, jqXHR) {
            $('#resumo-minha-lista').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#resumo-minha-lista').empty();
        }
    });
}


$(document).on('change', '#tipos_listas_id', function(){
   
    var tipos_listas_id = $(this).val();
    
    if( tipos_listas_id !== '' ){
        $('#form-lista-vip').fadeIn(300);
    } else {
        $('#form-lista-vip').fadeOut(400);
        $('#form-lista-vip textarea').val(null);
    }
    
});