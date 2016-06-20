/**
 * @todo 
 * @param {string} search
 * @returns {string html}
 */
function carregaListaPortaria(search) {
    $.ajax({
        beforeSend: function (xhr) {
            $('#carregar-lista').html('<b>Carregando...</b>');
        },
        url: web_root + 'Eventos/carrega-lista-portaria',
        data: {
            nome: search,
        },
        method: 'post',
        dataType: 'html',
        success: function (data, textStatus, jqXHR) {
            $('#carregar-lista').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#carregar-lista').empty();
        }
    });
}


/**
 * 
 * @param {int} pessoas_id
 * @param {int} eventos_id
 * @returns {alert}
 */
function liberarClientePortaria(pessoas_id, eventos_id) {
    $.ajax({
        beforeSend: function (xhr) {
            $('#loading').fadeIn(500);
        },
        url: web_root + 'Eventos/liberar-cliente-portaria',
        data: {
            pessoas_id: pessoas_id,
            eventos_id: eventos_id,
        },
        method: 'post',
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            tratarJSON(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loading').fadeOut(500);
        }
    });
}

/**
 * 
 */
$(document).on('click', '.btn-input-search', function () {
    try {
        var search = $('#input-search').val();
        if (search.length < 3)
            throw 'digite pelo menos e digitos para iniciar uma procura';
        carregaListaPortaria(search);
    } catch (err) {
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
 * 
 */
$(document).on('keypress', '#input-search', function (event) {
    try {
        var search = $(this).val();
        if (event.which === 13) {
            if (search.length < 3)
                throw 'digite pelo menos e digitos para iniciar uma procura';
            carregaListaPortaria(search);
        }
    } catch (err) {
        bootsAlert({
            style: 'warning',
            title: 'Atenção',
            message: err,
            size: 'md',
            time: 3000,
        });
    }
});

$(document).on('click', '.portaria-liberar', function(){
   try{
       
       var pessoas_id = $(this).data('pessoasid');
       var eventos_id = $(this).data('eventosid');
       
       if(pessoas_id == null) throw 'não é possivel liberar este usuario motivo o id pessoa vazio';
       if(eventos_id == null) throw 'não é possivel liberar este usuario motivo o id pessoa vazio';
       
        liberarClientePortaria(pessoas_id, eventos_id);
       
   }catch(err){
       bootsAlert({
            style: 'warning',
            title: 'Atenção',
            message: err,
            size: 'md',
            time: 3000,
        });
   }
});