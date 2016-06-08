$(document).ready(function(){
                    
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
            
            
            $('#criar-novo-evento').click(function(){
                
                var url = $(this).data('url');
                $('#loading').fadeIn(500);
                $('#append-body').empty();
                
                $.ajax({
                    url:url,
                    data:{},
                    method: 'get',
                    dataType: 'html',
                    success: function (data, textStatus, jqXHR) {
                        
                        $('#ModalFormulario').modal('show');
                        $('#append-body').html(data);
                        $('#loading').fadeOut(500);
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        
                    }
                });
                
            });
    
});


$(document).on('click', '.eventos-btn', function(){
    
    var divOK = $(this).data('div');
    $('.eventos-btn').addClass('btn-default').removeClass('btn-primary');
    $(this).addClass('btn-primary').removeClass('btn-default');
    
    $('.div-container').addClass('hide');
    $(divOK).removeClass('hide').show();

});


$(document).on('click', '#btn-nova-atracao, #cancelar-cadastro', function(){
    $('#cadastro-novas-atracoes').slideToggle('500');
    $('#input-atracao').val(null);
});


$(document).on('click', '#salvar-nova-atracao', function(){
    var atracao = $('#input-atracao').val();
    $.ajax({
        beforeSend: function (xhr) {
            $('#loading').fadeIn(500);
        },
        method: 'post', 
        dataType: 'json',
        data:{
            descricao: atracao
        },
        url: web_root + 'Eventos/add-atracao',
        success: function (data, textStatus, jqXHR) {
            bootsAlert(data);
        }, 
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loading').fadeOut(500);
        }
    });
});


/**
 * 
 * @param {integer} id
 * @param {string} atracao
 * @returns {undefined}
 */
function addAtracaoTable( id, atracao ){
   var elemento = '<tr>'+
                    '<td>'+atracao+'</td>'+
                    '<td><a class="btn btn-xs btn-danger btn-delete-atracao"><i class="fa fa-times-circle marginNull"></i></a></td>'+
                  '</tr>';
   $(elemento).appendTo('#tbody');
}

function selectAtracoes(){
    $.ajax({
        method: 'post', 
        dataType: 'json',
        data:{},
        url: web_root + 'Eventos/list-atracao',
        success: function (data, textStatus, jqXHR) {
            
            var elemento = '<option value=""> selecione as atrações (*) </option>';
            
            $.each(data, function(key, value){
               elemento += '<option value="'+value.Atracao.id+'">'+value.Atracao.descricao+'</option>'; 
            });
            
            $('#atracoes_id').empty();
            $('#atracoes_id').append(elemento);
            
        }, 
        error: function (jqXHR, textStatus, errorThrown) {
            
        }
    });
}

function carregarListaFuncionarios( pessoasid, eventosid){
    $.ajax({
        beforeSend: function (xhr) {
            $('#carregar-lista').html('<b>Carregando...</b>');
        },
        method: 'get', 
        dataType: 'html',
        data:{
            pessoas_id: pessoasid,
            eventos_id: eventosid,
        },
        url: web_root + 'Listas/carregar-lista-promoters',
        success: function (data, textStatus, jqXHR) {
            $('#carregar-lista').html(data);
        }, 
        error: function (jqXHR, textStatus, errorThrown) {
            
        }
    });
}

/**
 * deletar atração
 */
$(document).on('click', '.btn-delete-atracao', function(){
    var elemento = $(this).parents('tr');
    elemento.remove();
});


$(document).on('click', '#btn-save', function(){
   
    var id      = $('#atracoes_id').val();
    var atracao = $( '#atracoes_id option:selected' ).text();
   
    try {
        
        if( id === null || id === '' ) throw " Selecione uma Atração!";
        if( atracao === null || atracao === '' ) throw " a atração está vazio!";
        addAtracaoTable(id, atracao);
        
    } catch ( err ){
        bootsAlert({
            style: 'warning',
            message: err,
            title: 'ATENÇÃO',
            callback: null,
            before: null,
        });
    } finally {
        /**
         * finalizando a operação
         */
    }
    
});


$(document).on('click', '.carregar-lista-funcionario', function(){
    carregarListaFuncionarios($(this).data('pessoasid'), $(this).data('eventosid'));
});

$(document).on('click', '.copiar-distribuicao', function(){
   var pessoas_id    = $(this).data('pessoasid');
   var eventos_id    = $(this).data('eventosid');
   var pessoasidcopy = $(this).data('pessoasidcopy');
   
   $.ajax({
        beforeSend: function (xhr) {
            $('#loading').fadeIn(500);
        },
        method: 'post', 
        dataType: 'json',
        data:{
            pessoas_id: pessoas_id,
            eventos_id: eventos_id,
            pessoas_idcopy: pessoasidcopy,
        },
        url: web_root + 'Listas/copiar-lista-promoter',
        success: function (data, textStatus, jqXHR) {
            
            tratarJSON(data);
            
        }, 
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loading').fadeOut(500);
        }
    });
   
});
