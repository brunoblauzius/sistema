$(document).ready(function () {

    $('#inputMesa').focusout(function ()
    {
        $('#alerta-erros').empty();
        var mesa = $(this).val();
        if (mesa.length > 1 && mesa > 50)
        {
            var elemento = '<section class="pi-alert-danger" style="padding: 5px;">' +
                    'Ultrapassou o limite maximo!' +
                    '</section>';
            $(elemento).appendTo('#alerta-erros');
        }
    });

    $('#send-form').click(function ()
    {
        var mesa = $('#inputMesa').val();

        var url = $(this).data('url');

        $.ajax({
            beforeSend: function (xhr) {
                showLoaderForm('#PrimeiroCadastroForm');
            },
            url: url,
            data: {
                Mesa: {
                    quantidade: mesa
                },
            },
            method: 'post',
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {

                if (data.erro === false)
                {
                    msg_sucesso(data.mensagem, data.div);
                    setInterval(redirect(web_root + 'Pages/cadastro-sucesso'), 5000);
                } else
                {
                    msg_erro(data.mensagem, data.div);
                    hideLoaderForm(data.div);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                /**
                 * tratamento de erro
                 */
                hideLoaderForm('#PrimeiroCadastroForm');
            }
        });

    })


});