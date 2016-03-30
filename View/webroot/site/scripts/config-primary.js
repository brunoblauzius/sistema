
$(document).ready(function(){
    
    $('#inputSalao').change(function(){
        
        var salao = $(this).val();
        if( salao.length > 1 && salao !== '' ){
            $('#salao').find('.alert').fadeOut();
            $('#ambiente').show();
        }
    });
    
    $('#inputCapacidade').change(function(){
        var ambiente = $(this).val();
        if( ambiente.length > 1 && ambiente !== '' ){
            $('#ambiente').find('.alert').fadeOut();
            $('#mesa').show();
        }
    });
    
    $('#inputMesa').change(function(){
        var mesa = $(this).val();
        if( mesa.length > 1 && mesa !== '' ){
            $('#mesa').find('.alert').fadeOut();
            $('button').attr('disabled', false);
        }
    });
    
    $('#send-form').click(function(){
        var mesa       = $('#inputMesa').val();
        var ambiente   = $('#inputAmbiente').val();
        var capacidade = $('#inputCapacidade').val();
        var salao      = $('#inputSalao').val();
        
        var url        = $(this).data('url');
        
        $.ajax({
            beforeSend: function (xhr) {
                showLoaderForm('#PrimeiroCadastroForm');
            },
            url: url,
            data:{
                Ambiente:{
                    capacidade: capacidade,
                    nome: ambiente,
                },
                Mesa:{
                    nome:mesa
                },
                Salao:{
                    nome: salao
                }
            },
            method:   'post',
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                
                if( data.erro === false)
                {
                    msg_sucesso(data.mensagem, data.div);
                    setInterval(redirect(web_root + 'Pages/cadastro-sucesso'), 5000);
                }
                else 
                {
                    msg_erro(data.mensagem, data.div);
                    hideLoaderForm( data.div );
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                /**
                 * tratamento de erro
                 */
                hideLoaderForm( '#PrimeiroCadastroForm' );
            }
        });
        
    })
    
    
});