$(document).ready(function(){
    
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.data').mask('00/00/0000');
    
    
    function loader( este ){
        var elemento = '<div class="overlay"></div>'+
                       '<div class="loading-img"></div>';
        $( elemento ).appendTo( este );
    }
    
    function removeLoader(){
        $('.overlay').remove();
        $('.loading-img').remove();
    }
    
    
    function sucesso( mensagem, elementoDiv ){
        $(elementoDiv).find('.sucesso').remove();
        var elemento = '';
        elemento = '<div class="col-md-10 sucesso">'
                           + '<!-- Success box -->'
                           + '<div class="box box-solid bg-green">'
                            +    '<div class="box-header">'
                             +       '<h4 class="box-title">Sucesso na sua operação</h4>'
                              +  "</div>"
                               + '<div class="box-body">'
                                +    "<p>" +  mensagem  +  '</p>'
                                +'</div><!-- /.box-body -->'
                            +'</div><!-- /.box -->'
                        +'</div><!-- /.col -->';
        $( elemento ).appendTo('.row').delay(1000).fadeOut();
        $('.row input, select , textarea').removeClass('has-error');
    }
    
    
    
    /**
     * FUNÇÃO QUE LIMPA OS CAMPOS DE DETERMINADO FORMULARIO
     * @param {type} id
     * @returns {undefined}
     */
    function limparForm( id ){
        $('input[type="text"]').val(null);
        $('input').val(null);
        $('select').val(null);
        $('textarea').val(null);
        $('checkbox').val(null);
        $('file').val(null);
        $(id).find('div').removeClass('has-error');
        $('.alert-error').remove();
    }
    
    
    
    function tartaErros( erros, form ) {
        
            $('.alert-error').remove();
            $('#'+form).find('div').removeClass('has-error');
            $.each(erros,function( key, value ) {
                 $item = $('#'+form+' input[name$="['+key+']"], textarea[name$="['+key+']"], select[name$="['+key+']"]').parent('.form-group');
                 $('#'+form+' input[name$="['+key+']"], textarea[name$="['+key+']"], select[name$="['+key+']"]').parents('.form-group').addClass('has-error');
                 $('<label class="control-label alert-error" for="inputError"><i class="fa fa-times-circle-o"></i> '+value+' </label>').appendTo( $item );
            });  
    }
    
    /**
     * @todo controladora de dos metodos
     * @param {type} data
     * @returns {undefined}
     */
    function tratarJSON( data ) {
        if( data.msg ){
            sucesso( data.msg );
        }tratarJSON
        if( data.erros ){
            tartaErros(data.erros, data.form);
        }
        if( data.funcao ){
            eval(data.funcao);
        }
        if(data.limparForm) {
            eval(data.limparForm);
        }
    }
    
    
    
    $('.libera').click(function(){
       var id       = $(this).data('id');
       var url      = $(this).data('url');
       var elemento = $(this);
       loader( $(this).parents('.box') );
       $.ajax({
          url: url,
          data:{
              id:id
          },
          dataType:'json',
          type:'post',
          success: function (data, textStatus, jqXHR) {
              $(elemento).removeClass('label-default');
              $(elemento).addClass('label-success');
              sucesso(data.msg, $(elemento).parents('.row') );
              removeLoader();
          }
        });  
    });
  
  
    $('.ul-links').hover(function(){
        $('.ul-content').slideToggle();
    });
    
    
    
});

function number_format(number, decimals, dec_point, thousands_sep) {
  //  discuss at: http://phpjs.org/functions/number_format/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: davook
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Theriault
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Michael White (http://getsprink.com)
  // bugfixed by: Benjamin Lupton
  // bugfixed by: Allan Jensen (http://www.winternet.no)
  // bugfixed by: Howard Yeend
  // bugfixed by: Diogo Resende
  // bugfixed by: Rival
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  //  revised by: Luke Smith (http://lucassmith.name)
  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
  //    input by: Jay Klehr
  //    input by: Amir Habibi (http://www.residence-mixte.com/)
  //    input by: Amirouche
  //   example 1: number_format(1234.56);
  //   returns 1: '1,235'
  //   example 2: number_format(1234.56, 2, ',', ' ');
  //   returns 2: '1 234,56'
  //   example 3: number_format(1234.5678, 2, '.', '');
  //   returns 3: '1234.57'
  //   example 4: number_format(67, 2, ',', '.');
  //   returns 4: '67,00'
  //   example 5: number_format(1000);
  //   returns 5: '1,000'
  //   example 6: number_format(67.311, 2);
  //   returns 6: '67.31'
  //   example 7: number_format(1000.55, 1);
  //   returns 7: '1,000.6'
  //   example 8: number_format(67000, 5, ',', '.');
  //   returns 8: '67.000,00000'
  //   example 9: number_format(0.9, 0);
  //   returns 9: '1'
  //  example 10: number_format('1.20', 2);
  //  returns 10: '1.20'
  //  example 11: number_format('1.20', 4);
  //  returns 11: '1.2000'
  //  example 12: number_format('1.2000', 3);
  //  returns 12: '1.200'
  //  example 13: number_format('1 000,50', 2, '.', ' ');
  //  returns 13: '100 050.00'
  //  example 14: number_format(1e-8, 8, '.', '');
  //  returns 14: '0.00000001'

  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}


function cadastroClienteHtml( json ){
    var elemento = '';
    
    elemento += '<div class="col-sm-12 form-group-sm">'+
                    '<table class="table table-condensed">'+
                        '<tbody> <tr> <td> <small>Nome:</small>'+
                                    '<input type="text"  class="form-control" value="'+json.nome+'" disabled="true">'+
                                '</td> <td> <small>E-mail:</small>'+
                                    '<input type="text" class="form-control" value="'+json.email+'" disabled="true">'+
                                '</td>  </tr> <tr> <td> <small>Rg:</small>'+
                                    '<input type="text"  class="form-control" value="'+json.rg+'" disabled="true">'+
                                '</td> <td> <small>Telefone:</small>'+
                                   ' <input type="text"  class="form-control" value="'+json.telefone+'" disabled="true">'+
                                '</td> </tr> </tbody> </table> <div>' +
                        '<a class="btn btn-primary btn-xs pull-right" id="continuar-reserva" > Continuar a reserva </a>'+
                        '<input type="hidden" name="Reserva[clientes_id]" class="form-control" value="'+json.id+'">'+
                    '</div></div>';
    
    $('#dados-cliente').html(elemento);
    
}

function loadingElement(frase, elemento){
    $('<div class="row text-center"  id="gif-loader"><img src="'+web_root+'View/webroot/img/ajax-loader.gif"/><br>'+ frase +'</div>').appendTo( elemento );
}

function chamaListaConvidadosHostess( url ){
    if( url !== '' || url!== null ){
        
          $('#modal-convidados').find('#contend').empty();
          $('#modal-convidados').modal('show');
          loadingElement('<br>Aguarde um momento, estamos guardando suas informações...', '#contend');
        
          $.ajax({
              url: url,
              data:{},
              dataType: 'html',
              type: 'get',
              success: function (data) {
                  
                  $('#modal-convidados').find('#contend').html(data);
                  
              }
          }); 
    }
}