 $(document).ready(function(){
       
    $('.cep').change(function (){
       var cep = $(this).val();
       if( cep.length >= 8 ){

           $.ajax({
               url: web_root + 'Webservices/cep',
               data:{
                   cep: cep
               },
               type:"post",
               dataType: "json",
               success: function (data, textStatus, jqXHR) {
                   
                   var json = $.parseJSON(data);
                   
               }
           });

       }

    });

});