function bootsAlert(options)
{
    if(typeof options === "undefined"){var options = ""};
    var style       = (typeof options.style     === "undefined") ? "default" : options.style;
    var message     = (typeof options.message   === "undefined") ? "" : options.message;
    var title       = (typeof options.title     === "undefined") ? "" : options.title;
    var button      = (typeof options.button    === "undefined") ? "OK" : options.button;
    var time        = (typeof options.time      === "undefined") ? 0 : options.time;
    var size        = (typeof options.size      === "undefined") ? 'sm' : options.size;
    var align       = (typeof options.align     === "undefined") ? 'center' : options.align;
    var callback    = (typeof options.callback  === "undefined") ? '' : options.callback;
    var before      = (typeof options.before    === "undefined") ? '' : options.before;
    var icon        = (typeof options.icon      === "undefined") ? '' : options.icon;
    if(icon == '' && icon != 'empty'){
        switch(style){
            case 'default':
                var icon = 'ok-circle';
                break;
            case 'primary':
                var icon = 'ok-circle';
                break;
            case 'warning':
                var icon = 'exclamation-sign';
                break;
            case 'danger':
                var icon = 'remove-sign';
                break;
            case 'info':
                var icon = 'info-sign';
                break;
            case 'success':
                var icon = 'ok-sign';
                break;
            default:
                var icon = 'ok-circle';
        }
    }

    var html = '<div class="modal fade bootsAlert bootsAlert-'+style+'" id="loadAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
    html += '   <div class="modal-dialog modal-'+size+'">';
    html += '       <div class="modal-content">';
    html += '           <div class="modal-header text-center">';
    html += '               <i class="ba-icon-title fa fa-'+icon+'"></i>';
    html += '           </div>';
    html += '           <div class="modal-body text-'+align+'">';
    html += '               <h4>'+title+'</h4>';
    html += '               <p>'+message+'</p>';
    if(button!=false){
        html += '               <div class="text-center"><button type="button" class="ba-btn btn btn-'+style+'" data-dismiss="modal">'+button+'</button></div>';
    }
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    
    eval(before);
    if ( $("#boxAlert").length ){}else{$('body').append('<div id="boxAlert"></div>');}
    $("#boxAlert").html(html);
    $('#loadAlert').modal('show');
    if(time!=0) {setTimeout(function(){$('#loadAlert').modal('hide')},time)};
    $('#loadAlert').on('hidden.bs.modal', function () {eval(callback)});
}