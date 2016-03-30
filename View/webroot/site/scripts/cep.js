 $(document).ready(function(){
       
    $('.cep').change(function (){
       var cep = $(this).val();
       if( cep.length >= 8 ){

           $('#logradouro').attr('disabled', true).val('Buscando informações!');
           $('#cidade').attr('disabled', true).val('Buscando informações!');
           $('#bairro').attr('disabled', true).val('Buscando informações!');
           $('#uf').attr('disabled', true).val('Buscando informações!');
           
           $.ajax({
               url: web_root + 'Webservices/cep',
               data:{
                   cep: cep
               },
               method:"post",
               dataType: "json",
               success: function (data, textStatus, jqXHR) {
                   var json = data.resultado[0];
                    if( data.erro === false ){
                        $('#logradouro').attr('disabled', false).val(json.logradouro);
                        $('#cidade').attr('disabled', false).val(json.cidade);
                        $('#bairro').attr('disabled', false).val(json.bairro);
                        $('#uf').attr('disabled', false).val(json.uf);
                    } else {
                        $('#logradouro').attr('disabled', false).val(null);
                        $('#cidade').attr('disabled', false).val(null);
                        $('#bairro').attr('disabled', false).val(null);
                        $('#uf').attr('disabled', false).val(null);
                    }
               },
               error: function (jqXHR, textStatus, errorThrown ){
                   $('#logradouro').attr('disabled', false).val(null);
                   $('#cidade').attr('disabled', false).val(null);
                   $('#bairro').attr('disabled', false).val(null);
                   $('#uf').attr('disabled', false).val(null);
               }
           });

       }

    });

});