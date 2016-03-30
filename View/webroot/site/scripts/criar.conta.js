/**
     * @todo funcao que envia as requisições em ajax do sistema
     */
    $(document).on('click', 'form button', function(){
        var id = $(this).parents('form').attr('id');
        
        //pre loader
            if( !$('#loadin-form-section').is(':visible') ){
                showLoaderForm("#"+id);
            }	
		
        // bind form using ajaxForm 
        $('#' + id ).ajaxForm({ 
            // dataType identifies the expected content type of the server response 
            dataType:  'json', 
            // success identifies the function to invoke when the server response 
            // has been received 
            success:   function (data){
                hideLoaderForm("#"+id);
                tratarJSON(data);
            }
        }); 
        //fim pre loader
        $(document).ajaxError(function() {
            hideLoaderForm("#"+id);
        });
        
        $.ajaxSetup({
            async: true
        });
    });

