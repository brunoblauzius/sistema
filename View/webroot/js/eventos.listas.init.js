
/**
 * @todo metodo que limpa o formulario de cadastro e edição
 * @returns null
 */
function limparForm(){
    $('input[type="checkbox"]').prop("checked", false);
    $('input[type="text"]').val(null);
    $('textarea').val(null);
    
    /**
     * EDICAO
     */
    $('#id').remove();
    $('#ListaAdd').attr('action', web_root + 'Listas/add');
}

function carregarTableLista(){
    $.ajax({
        beforeSend: function (xhr) {
            $('#table-lista').html('<b>Carregando...</b>');
        },
        method: 'post', 
        dataType: 'html',
        data:{},
        url: web_root + 'Listas/montar-tabela-lista',
        success: function (data, textStatus, jqXHR) {
            $('#table-lista').html(data);
        }, 
        error: function (jqXHR, textStatus, errorThrown) {
            
        }
    });
}

$(document).ready(function(){  
    carregarTableLista();
});

  
$(document).on('click', '.edit-listas',function(){ 
   $.ajax({
      beforeSend: function (xhr) {
          $('#loading').fadeIn(500);
      },
      method: 'get', 
      dataType: 'json',
      data:{},
      url: $(this).data('url'),
      success: function (data, textStatus, jqXHR) {

           if( typeof data !== 'undefined'){
                
                $('input[type="checkbox"]').prop("checked", false);
                
                if( data.sexo === "2"){
                    $('input[type="checkbox"]').prop("checked", true);
                } else if( data.sexo === "1" ){
                     $('#male').prop("checked", true);
                } else {
                     $('#female').prop("checked", true);
                }
                $('#title').val(data.title);
                $('#descricao').val(data.descricao);
                $('#id').remove();
                $('#ListaAdd').attr('action', web_root + 'Listas/edit');
                $('#ListaAdd').append('<input type="hidden" name="Lista[id]" id="id" value="'+data.id+'">');
                
           }

           $('#loading').fadeOut(500);

      }, 
      error: function (jqXHR, textStatus, errorThrown) {
          $('#loading').fadeOut(500);
      }
  });
});
  
  
$(document).on('click', '.alterar-status-lista',function(){ 
   $.ajax({
      beforeSend: function (xhr) {
          $('#loading').fadeIn(500);
      },
      method: 'get', 
      dataType: 'json',
      data:{},
      url: $(this).data('url'),
      success: function (data, textStatus, jqXHR) {
            tratarJSON(data)
      }, 
      error: function (jqXHR, textStatus, errorThrown) {
          $('#loading').fadeOut(500);
      }
  });
});