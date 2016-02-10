
function meuModal( data){
    
    var elemento = '<div class="modal fade" id="modal-function-include" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
  '<div class="modal-dialog" role="document">'+
    '<div class="modal-content">'+
      '<div class="modal-header">'+
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
        '<h4 class="modal-title" id="myModalLabel">' + data.title + '</h4>'+
      '</div>'+
      '<div class="modal-body" id="contend">'+
        + data.conteudo +
      '</div>'+
      '<div class="modal-footer">'+
        '<button type="button" class="btn btn-primary">Save changes</button>'+
      "</div>"+
    "</div>"+
  "</div>"+
"</div>";
    
}