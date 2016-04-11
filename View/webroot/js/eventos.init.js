$(document).ready(function(){
                    
            loadingElement('Carregando Gráfico...', '#graph-area');
            $.ajax({
                url: web_root + 'Reservas/graficoCasas',
                data: { empresas_id:empresas_id},
                dataType: 'json',
                type: 'post',
                success: function (json) {
                    $('#graph-area').empty();
                    Morris.Area({
                        element: 'graph-area',
                        behaveLikeLine: true,
                        gridEnabled: false,
                        gridLineColor: '#dddddd',
                        axes: true,
                        fillOpacity:.7,
                        data: json.dados,           
                        lineColors:['#E67A77','#D9DD81','#79D1CF'],
                        xkey: 'period',
                        ykeys: json.keys,
                        labels: json.empresas,
                        pointSize: 0,
                        lineWidth: 0,
                        hideHover: 'auto'

                    });
                }
            });
            
            
            $('#criar-novo-evento').click(function(){
                
                var url = $(this).data('url');
                $('#loading').fadeIn(500);
                
                $.ajax({
                    url:url,
                    data:{},
                    method: 'get',
                    dataType: 'html',
                    success: function (data, textStatus, jqXHR) {
                        
                        $('#ModalFormulario').modal('show');
                        $('#append-body').html(data);
                        $('#loading').fadeOut(500);
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        
                    }
                });
                
            });
    
});