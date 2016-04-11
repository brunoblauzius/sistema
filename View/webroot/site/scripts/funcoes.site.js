function msg_sucesso( msg , div){
    
    $('.pi-alert-success').remove();
    $('.pi-alert-danger').remove();
    
    var elemento = '<section class="pi-alert-success">'+
                                '<p>'+
                                    msg
                                +'</p>'+
                            '</section>';
    $(elemento).prependTo(div).fadeIn(500).delay(3000).fadeOut(500);
}

function msg_erro( msg , div){
    
    $('.pi-alert-success').remove();
    $('.pi-alert-danger').remove();
    
    var elemento = '<section class="pi-alert-danger">'+
                                '<p>'+
                                    msg
                                +'</p>'+
                            '</section>';
    $(elemento).prependTo(div).fadeIn(500);
    
}

function showLoaderForm( div ){
    $('#loadin-form-section').remove();
    $(div).find('button').hide();
    var img = '<img src="'+web_root+'/View/webroot/img/ajax-loader.gif">';
    var elemento = '<section id="loadin-form-section">'+img+'</section>';
    $(elemento).appendTo(div);
    
}

function hideLoaderForm( div ){
    $('#loadin-form-section').remove();
    $(div).find('button').show(200);
}

function redirect( url ){
    $(location).attr('href',url);
}

/**
* @todo controladora de dos metodos
* @param {type} data
* @returns {undefined}
*/
function tratarJSON( data ) {
   if( data.funcao ){
       eval(data.funcao);
   }
}

function limparFormulario(){
    $('input').val(null);
    $('textarea').val(null);
}