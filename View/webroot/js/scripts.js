        
	$( document ).ajaxComplete(function( event,request, settings ) {
		
                $(".chosen-select").chosen();
                
		$('#cpf').mask('000.000.000-00');
                $('#cnpj').mask('00.000.000/0000-00');
		$('.money').mask("###0.00", {reverse: true, maxlength: false});
		$('.telefones').mask('(00) 000000000');
                $('.fone').mask('(00) 000000000');
                $('.telefone').attr('placeholder','ex. 4199665588');
                $('.date2').mask('00/00/0000'); 
		$('.data_time').mask('00:00');
                
		$(function () {
                    $('.datetimepicker2').datetimepicker({
                            language: 'pt-br',
                            format: 'DD/MM/YYYY',
                            disabledHours: true,
                     });
                     
                    $('#datetimepicker3').datetimepicker({
                       format: 'LT'
                    });
		});
		
		
		if( $('#despesa_fixa option:selected').val() == 0 ){
			$('#dataVencimento').show();
			$('#diaDeVencimento').hide();
		} else {
			$('#dataVencimento').hide();
			$('#diaDeVencimento').show();
		}
		
                
                $('#continuar-reserva').click(function(){
                    var url   = web_root + 'Reservas/cadastroContinuacao';
                    //$('#loading').fadeIn(500);
                    // iniciar o loader
                    $('#dados-reserva').empty();
                    loadingElement('<br>Carregando Informações...','#dados-reserva' );
                    $.ajax({
                        url: url,
                        data:{},
                        dataType: 'html',
                        type: 'get',
                        success: function (html) {
                            // encerrar loader
                            //$('#loading').fadeOut(500);  
                            // dados
                            $('#dados-reserva').html(html);
                            $('#continuar-reserva').remove();
                        }
                    });
                });
                
//                $(document).on('click', '.check-all', function(){
//                    $('.mesas-lista').each(
//                         function(){
//                           if ($(this).prop( "checked")) 
//                           $(this).prop("checked", false);
//                           else $(this).prop("checked", true);               
//                         }
//                    );
//                });
                
	});
	
	$(document).ready(function () {
		
                $(".chosen-select").chosen();
                
		$('#cpf').mask('000.000.000-00');
                $('#cnpj').mask('00.000.000/0000-00');
		$('.money').mask("###0.00", {reverse: true, maxlength: false});
                $('.telefone').attr('placeholder','ex. 4199665588');
                $('.fone').mask('(00) 000000000');
                $('.telefones').mask('(00) 000000000');
		$('.date2').mask('00/00/0000'); 
		$('.data_time').mask('00:00'); 
		
		$(function () {
			$('.datetimepicker2').datetimepicker({
                            language: 'pt-br',
                            format: 'DD/MM/YYYY',
                            disabledHours: true,
			 });
                        $('#datetimepicker3').datetimepicker({
                           format: 'LT'
                        });
		});
		
                $('.excluir-convidado').click(function(){
                    var clienteId = $(this).data('clienteid');
                    var token     = $(this).data('token');
                    var url       = web_root + 'Reservas/desvincularConvidado';
                    
                    $.ajax({
                        url :  url,
                        data:{
                            clienteId:clienteId,
                            token:token,
                        },
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        success: function (data, textStatus, jqXHR) {
                            bootsAlert(data);
                        }
                    });
                    
                    
                });
                
                
                
                
		if( $('#despesa_fixa').val() == 0 ){
			$('#dataVencimento').show();
			$('#diaDeVencimento').hide();
		} else {
			$('#dataVencimento').hide();
			$('#diaDeVencimento').show();
		}
		
                $(document).on('click', '.check-all', function(){
                    $('.mesas-lista').each(
                         function(){
                           if ($(this).prop( "checked")) 
                           $(this).prop("checked", false);
                           else $(this).prop("checked", true);               
                         }
                    );
                });
                
                
		$(document).on('change', '.Profissional', function(){
                    $('#loading').fadeIn(500);
                    var pessoas_id = $(this).val();

                    $.ajax({
                            url : web_root + 'Profissionais/relacaoServicos',
                            data:{
                                    pessoas_id: pessoas_id
                            },
                            dataType: "json",
                            type    : 'post',
                            success: function(json){
                                    
                                    
                                        var elemento = "<option value=''> -- Serviços -- </option>";
                                        $.each(json,function( key, value ){
                                                elemento += "<option value=' " + value.id + "'> " + value.nome + " </option>";
                                        });

                                        var selectElement = $('.clonado').last().find('.ServicoId');

                                        /*if(selectElement != null || selectElement != '' ) {
                                                selectElement = $('.clonado').find('.ServicoId');
                                        }*/

                                        selectElement.empty();
                                        $( elemento ).appendTo( selectElement );
                                    
                                    
                                    $('#loading').fadeOut(500);
                            }
                    });
			
		});
		
                
                $(document).on('click', '.ativar-status', function(){
                    $('#loading').fadeIn(500);
                    
                    var id     = $(this).data('id');
                    var status = $(this).data('status');
                    var url    = $(this).data('url');
                    
                    $.ajax({
                        url : url,
                        data:{
                            id:     id,
                            status: status
                        },
                        dataType: "json",
                        type    : 'post',
                        success: function(json){
                            tratarJSON(json);
                            $('#loading').fadeOut(500);
                        }
                    });
                    
                });
		
		
		$(document).on('change', '#despesa_fixa', function(){
			var valor = $(this).val();
			
			if( valor == 0 ){
				$('#dataVencimento').show();
				$('#diaDeVencimento').hide();
			} else {
				$('#dataVencimento').hide();
				$('#diaDeVencimento').show();
			}
		});
		
		$(document).on('click', '.cancelarRegistro', function(){
			
                        var id  = $(this).data('idregistro');
			var url = $(this).data('href');
			var confirma = confirm("Você deseja realmente cancelar essa reserva?");
                        
                        if( confirma == true ){
                            $('#loading').fadeIn(500);
                            $.ajax({
                                    url : url,
                                    data:{
                                            id: id
                                    },
                                    dataType: "json",
                                    type    : 'post',
                                    success: function(json){
                                        bootsAlert(json);	
                                    }
                            });
                        }
		});
		
                
		
		$(document).on('click', '.editarRegistro', function(){
                        var id  = $(this).data('idregistro');
			var url = $(this).data('href');
			$('#loading').fadeIn(500);
			
			$.ajax({
				url : url,
				data:{
					id: id
				},
				dataType: "html",
				type    : 'post',
				success: function(json){
                                        
                                        if( $("#ModalFormulario").is(":visible") ){
                                            
                                        } else{
                                           $('#ModalFormulario').modal('show');
                                        }
                                        
                                        $(".chosen-select").chosen();
                                        
					$('.append-body').html(json);
                                        $('#loading').fadeOut(500);
					//$('#viewModal').modal('show');
                                        
				}
			});
			
		});
		
		$(document).on('click', '.add-item', function(){
                    $('#loading').fadeIn(500);
                    var btn_cancel = '<a class="btn btn-danger btn-xs delete-item" style="margin-top:23px;" title="excluir"> <i class="fa fa-times"></i></a>';
                    $('.clonado').first().clone().appendTo('#itens-clonados, #alterar-itens-clonados');
                    $('#loading').fadeOut(500);
                    $('#itens-clonados, #alterar-itens-clonados').find('.btn-cancel').last().append( btn_cancel );
                    $('#itens-clonados, #alterar-itens-clonados').find('.money').last().val( null );
                    $('#itens-clonados, #alterar-itens-clonados').find('.TipoServicoId option:0').last();
		});
                
                $(document).on('click', '.add-item-despesas', function(){
                    $('#loading').fadeIn(500);              
                    var btn_cancel = '<a class="btn btn-danger btn-xs delete-item-despesas" style="margin-top:23px;" title="excluir"> <i class="fa fa-times"></i></a>';
                    $('.clonado-despesas').first().clone().appendTo('#itens-clonados-despesas, #alterar-itens-clonados-despesas');
                    $('#itens-clonados-despesas, #alterar-itens-clonados-despesas').find('.btn-cancel').last().append( btn_cancel );
                    $('#itens-clonados-despesas, #alterar-itens-clonados-despesas').find('.money').last().val( null );
                    $('#itens-clonados-despesas, #alterar-itens-clonados-despesas').find('.despesa_nome').last().val( null );
                    $('#itens-clonados-despesas, #alterar-itens-clonados-despesas').find('.date_time').last().val( null );
                    $('.add-item-despesas').trigger('ajaxComplete');
                    $('#loading').fadeOut(500);
		});
		
		$(document).on('click', '.delete-item', function(){
                    $('#loading').fadeIn(500);
                    $this = $(this);
                    var ids = $(this).data( 'ids' );
                    if( typeof ids != 'undefined' ){
                        $.ajax({
                            url : web_root + "Agendas/deletarIten",
                            data:{
                                    registros : ids,
                            },
                            dataType : 'json',
                            type: 'post',
                            success: function(json){
                                if(json.erro == false ){
                                    $this.parent('.btn-cancel').parent('.clonado').remove();
                                    $('#loading').fadeOut(500);
                                } else {
                                    alert(json.mensagem);
                                    $('#loading').fadeOut(500);
                                }
                            }
                        });
                    } else {
                        $this.parent('.btn-cancel').parent('.clonado, .clonado-despesas').remove();
                        $('#loading').fadeOut(500);
                    }
		});
                
                
                
                $(document).on('click', '.delete-item-despesas', function(){
                    $('#loading').fadeIn(500);
                    $this = $(this);
                    var ids = $(this).data( 'ids' );
                    
                    if( typeof ids != 'undefined' ){
                        $.ajax({
                            url : web_root + "Agendas/deletarItenDespesas",
                            data:{
                                    registro : ids,
                            },
                            dataType : 'json',
                            type: 'post',
                            success: function(json){
                                if(json.erro == false ){
                                    $this.parent('.btn-cancel').parent('.clonado, .clonado-despesas').remove();
                                    $('#loading').fadeOut(500);
                                } else {
                                    alert(json.mensagem);
                                    $('#loading').fadeOut(500);
                                }
                            }
                        });
                    } else {
                        $this.parent('.btn-cancel').parent('.clonado, .clonado-despesas').remove();
                        $('#loading').fadeOut(500);
                    }
		});
		
		
		$('#tipo_pessoa').change(function(){
			var valor = $(this).val();
			if( valor == 1 ){
				$('#pessoa-fisica').show();
				$('#pessoa-juridica').hide();
			} else {
				$('#pessoa-fisica').hide();
				$('#pessoa-juridica').show();
			}
		});
   
		
		$(document).on('click','.editar-filtro', function(){
			var id = $(this).data('id');
			viewEnventoAjax( id );
		});
		
		$(document).on('change', '.ClienteId', function(){
			var nomeCliente = $(this).find('option:selected').text();
			$(this).parents('form').find('input[name="Agendas[title]"]').val( nomeCliente );
		});
                
                $(document).on('change', '#SelectAmbienteId', function(){
                    var id    = $(this).val();
                    var data  = $('#start').val();
                    var url = web_root + 'Mesas/mesasAmbiente';

                    if( id != null || id != '' ){
                        //$('#loading').fadeIn(500);
                        
                        $('#mesas-cadastro').empty();
                        loadingElement('<br>Carregando mesas disponíveis...', '#mesas-cadastro');
                        
                        $.ajax({
                            url:url,
                            data:{
                                id:id,
                                data:data
                            },
                            dataType: 'html',
                            type: 'post',
                            success:function(html){
                                $('#mesas-cadastro').html(html);
                                //$('#loading').fadeOut(500);
                            }
                        });
                    }   
		});
		
                
		$(document).on('change', '#SalaoId', function(){
			//$('#loading').fadeIn(500);
                        var id  = $(this).val();
			var url = web_root + 'Ambientes/saloesAmbientes'; 
			$this   = $(this);
			
                        loadingElement('', '#AmbienteId');
                        $('#SelectAmbienteId_chosen').parent('#AmbienteId').children('small').hide(100);
                        $('#SelectAmbienteId_chosen').hide(100);
			$.ajax({
				url:url,
				data:{
					id:id,
				},
				dataType: 'json',
				type: 'post',
				success:function(json){
					var elemento = '<small>Ambiente: <strong class="text text-danger ">*</strong></small><br>'+
                                                       '<select name="Reserva[ambientes_id]" class="form-control chosen-select rounded" id="SelectAmbienteId">' + 
                                                       "<option value=''> -- Ambientes -- </option>";
                                                 
                                                        $.each(json,function( key, value ){
                                                                elemento += "<option value=' " + value.id + "'> " + value.nome + " </option>";
                                                        });
                                                        
                                                        elemento += '</select>';
                                                     
					$('#AmbienteId').empty();
					$('#gif-loader').remove();
					$( elemento ).appendTo( '#AmbienteId' );
                                        $('#AmbienteId').focus();
                                        $('#SelectAmbienteId_chosen').parent('#AmbienteId').children('small').show(100);
                                        $('#SelectAmbienteId_chosen').show(100);
				}
			});	
		});
		
		
		
		$('.add-especialidades').click(function(){
			//var pessoasId       = $(this).data('pessoasId');
			$('#loading').fadeIn(500);
                        var tiposServicosId = $(this).val();
			var url             = $(this).data('url');
			var vStatus         = $(this).data('vstatus');
			
			/*if( vStatus == 1 ){
				$(this).attr('data-vstatus', '0');
			} else {
				$(this).attr('data-vstatus', '1');
			}*/
			
			$.ajax({
				url : url,
				data:{
					tipos_servicos_id: tiposServicosId,
					status: vStatus
				},
				dataType:'json',
				type: 'post',
				success: function(data) {
                                    tratarJSON(data);
                                    $('#loading').fadeOut(500);
                                }
			});
			
		});
		
		$('.edit-action').click(function(){
                    $('#loading').fadeIn(500);
                    var url = $(this).data('url');
                    var id  = $(this).data('id');
                    //abrir o modal
                    //$('#modal-content').empty();
                    $('.painel-edit').empty();
                    //$('#editModal').modal('show');

                    $.ajax({
                            url : url + '/' + id,
                            data:{},
                            dataType: 'html',
                            type:     'get',
                            success: function(data) {
                                $('.painel-edit').html(data);
                                $('.painel-cadastro').hide();
                                $('#loading').fadeOut(500);
                            }
			});
		});
		
		
        $('#cep').change(function(){
           
           var cep = $(this).val();
           var url = web_root + 'webservices/cep';
           
           if( cep.length == 8 ){
               //$('#loading').fadeIn(500);
               
               $('#logradouro').val('Aguarde...');
               $('#cidade').val('Aguarde...');
               $('#uf').val('Aguarde...');
               $('#bairro').val('Aguarde...');
               
               $('#logradouro').attr('disabled', true);
               $('#cidade').attr('disabled', true);
               $('#uf').attr('disabled', true);
               $('#bairro').attr('disabled', true);
               
               $.ajax({
                dataType: "json",
                type:'post',
                url: url,
                data:{
                    cep: cep
                },
                success: function(json){
                    
                    
                    $('#logradouro').attr('disabled', false);
                    $('#cidade').attr('disabled', false);
                    $('#uf').attr('disabled', false);
                    $('#bairro').attr('disabled', false);
                    if(json == null){
                        //$('#loading').fadeOut(500);
                    }
                    if( json.erro == false ){
                        $('#logradouro').val(json.resultado.logradouro);
                        $('#cidade').val(json.resultado.cidade);
                        $('#uf').val(json.resultado.uf);
                        $('#bairro').val(json.resultado.bairro);
                        //$('#loading').fadeOut(500);
                    } else {
                        $('#logradouro').attr('disabled', false);
                        $('#cidade').attr('disabled', false);
                        $('#uf').attr('disabled', false);
                        $('#bairro').attr('disabled', false);

                        $('#logradouro').val(null);
                        $('#cidade').val(null);
                        $('#uf').val(null);
                        $('#bairro').val(null);
                        //$('#loading').fadeOut(500);
                    }
                    
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#logradouro').attr('disabled', false);
                    $('#cidade').attr('disabled', false);
                    $('#uf').attr('disabled', false);
                    $('#bairro').attr('disabled', false);
                    
                    $('#logradouro').val(null);
                    $('#cidade').val(null);
                    $('#uf').val(null);
                    $('#bairro').val(null);
                   // $('#loading').fadeOut(500);
                }
              });
           }
           
       });
        
        
        $('.delete-actions').click(function(){
            alertaInformacao();
        }); 
        
         $('#Controler').change(function(){
            $('#loading').fadeIn(500);
            var controller = $('#Controler option:selected').text();
            var url        = $(this).data('url');
            $.ajax({
                url: url,
                data:{
                    controllers_name: controller,
                    controllers_id:   $(this).val(),
                },
                dataType: 'html',
                type:     'post',
                success: function(data) {
                    $('#append').html(data);
                    $('#loading').fadeOut(500);
                }
            }); 
         });  
        
       $('.add-actions').click(function(){
            $('#loading').fadeIn(500);
            var  elemento   = $(this);
            var  grupoId   = elemento.data('grupo');
            var  metodoId  = elemento.data('metodo');
            var  controlId = elemento.data('control');
            var  ativo     = elemento.data('ativo');
            var  url       = elemento.data('url');
            
            var Array = {
                 grupos_id      :grupoId,
                 metodos_id     :metodoId,
                 controllers_id :controlId,
                 ativo          :ativo
            };

            $.ajax({
                url : url,
                data:{
                    ACL: Array
                },
                dataType: 'json',
                type: 'post',
                 success: function(data) {
//                    if( data.erro == 0 && data.acao == 'insert'){
//                        elemento.addClass('btn-success').removeClass( 'btn-danger' );
//                        elemento.children('i').addClass('fa-check').removeClass('fa-times');
//                        elemento.attr('data-ativo', 1 );
//                    } else if( data.erro == 0 && data.acao == 'update'){
//                        elemento.addClass('btn-danger').removeClass( 'btn-success' );
//                        elemento.children('i').addClass('fa-times').removeClass('fa-check');
//                        elemento.attr('data-ativo', 0 );
//                    } else {
//                        alert('erro');
//                    }
                    if( data.erro == 0){
                        alertaInformacao();
                        window.location.reload();
                    }
                    $('#loading').fadeOut(500);
                 }  
            });

         });
         
         /**
        * @todo
        * funcao que é usada para exclusoes de registro ou inativação
        */

       $('.action-deletar').click(function(){
          $('#loading').fadeOut(500);
          var url = $(this).data('url'); 
          var id  = $(this).data('id'); 
          var confirma = confirm('Você deseja realmente excluir este registro?');

          if( confirma ){
               alertaInformacao();

               $.ajax({
                   url:url,
                   data:{
                            id: id,
                        },
                   dataType:"JSON",
                   type:'post',
                    success: function(data){
                        tratarJSON(data);
                        $('#loading').fadeOut(500);
                    }
               });
          }
       });
        
       
        $('#SelectEmpresa').change(function(){
            var empresas_id = $(this).val();
            
           if( empresas_id != null || empresas_id != '' ){
               $('#loading').fadeIn(500);
               
               $.ajax({
                   url: web_root + 'Empresas/recuperaEmpresa',
                   data:{
                            empresas_id: empresas_id,
                        },
                   dataType:"json",
                   type:'post',
                    success: function(data){
                        tratarJSON(data);
                        $('#loading').fadeOut(500);
                    }
               });
           }
        });
       
        
        /*==Left Navigation Accordion ==*/
        if ($.fn.dcAccordion) {
            $('#nav-accordion').dcAccordion({
                eventType: 'click',
                autoClose: true,
                saveState: true,
                disableLink: true,
                speed: 'slow',
                showCount: false,
                autoExpand: true,
                classExpand: 'dcjq-current-parent'
            });
        }
        /*==Slim Scroll ==*/
        if ($.fn.slimScroll) {
            $('.event-list').slimscroll({
                height: '305px',
                wheelStep: 20
            });
            $('.conversation-list').slimscroll({
                height: '360px',
                wheelStep: 35
            });
            $('.to-do-list').slimscroll({
                height: '300px',
                wheelStep: 35
            });
        }
        /*==Nice Scroll ==*/
        if ($.fn.niceScroll) {


            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $(".leftside-navigation").getNiceScroll().resize();
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();

            $(".right-stat-bar").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

        }

        /*==Easy Pie chart ==*/
        if ($.fn.easyPieChart) {

            $('.notification-pie-chart').easyPieChart({
                onStep: function (from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                },
                barColor: "#39b6ac",
                lineWidth: 3,
                size: 50,
                trackColor: "#efefef",
                scaleColor: "#cccccc"

            });

            $('.pc-epie-chart').easyPieChart({
                onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                },
                barColor: "#5bc6f0",
                lineWidth: 3,
                size:50,
                trackColor: "#32323a",
                scaleColor:"#cccccc"

            });

        }

        /*== SPARKLINE==*/
        if ($.fn.sparkline) {

            $(".d-pending").sparkline([3, 1], {
                type: 'pie',
                width: '40',
                height: '40',
                sliceColors: ['#e1e1e1', '#8175c9']
            });



            var sparkLine = function () {
                $(".sparkline").each(function () {
                    var $data = $(this).data();
                    ($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
                    ($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));

                    $data.valueSpots = {
                        '0:': $data.spotColor
                    };
                    $(this).sparkline($data.data || "html", $data);


                    if ($(this).data("compositeData")) {
                        $spdata.composite = true;
                        $spdata.minSpotColor = false;
                        $spdata.maxSpotColor = false;
                        $spdata.valueSpots = {
                            '0:': $spdata.spotColor
                        };
                        $(this).sparkline($(this).data("compositeData"), $spdata);
                    };
                });
            };

            var sparkResize;
            $(window).resize(function (e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(function () {
                    sparkLine(true)
                }, 500);
            });
            sparkLine(false);



        }



        if ($.fn.plot) {
            var datatPie = [30, 50];
            // DONUT
            $.plot($(".target-sell"), datatPie, {
                series: {
                    pie: {
                        innerRadius: 0.6,
                        show: true,
                        label: {
                            show: false

                        },
                        stroke: {
                            width: .01,
                            color: '#fff'

                        }
                    }
                },

                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                    clickable: true
                },

                colors: ["#ff6d60", "#cbcdd9"]
            });
        }

        

        /*==Collapsible==*/
        $('.widget-head').click(function (e) {
            var widgetElem = $(this).children('.widget-collapse').children('i');

            $(this)
                .next('.widget-container')
                .slideToggle('slow');
            if ($(widgetElem).hasClass('ico-minus')) {
                $(widgetElem).removeClass('ico-minus');
                $(widgetElem).addClass('ico-plus');
            } else {
                $(widgetElem).removeClass('ico-plus');
                $(widgetElem).addClass('ico-minus');
            }
            e.preventDefault();
        });




        /*==Sidebar Toggle==*/

        $(".leftside-navigation .sub-menu > a").click(function () {
            var o = ($(this).offset());
            var diff = 80 - o.top;
            if (diff > 0)
                $(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
            else
                $(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
        });



        $('.sidebar-toggle-box .fa-bars').click(function (e) {

            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $('#sidebar').toggleClass('hide-left-bar');
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();
            $('#main-content').toggleClass('merge-left');
            e.stopPropagation();
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });
        $('.toggle-right-box .fa-bars').click(function (e) {
            $('#container').toggleClass('open-right-panel');
            $('.right-sidebar').toggleClass('open-right-bar');
            $('.header').toggleClass('merge-header');

            e.stopPropagation();
        });

        $('.header,#main-content,#sidebar').click(function () {
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });


        $('.panel .tools .fa').click(function () {
            var el = $(this).parents(".panel").children(".panel-body");
            if ($(this).hasClass("fa-chevron-down")) {
                $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
                el.slideUp(200);
            } else {
                $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
                el.slideDown(200); }
        });



        $('.panel .tools .fa-times').click(function () {
            $(this).parents(".panel").parent().remove();
        });

        // tool tips

        $('.tooltips').tooltip();

        // popovers

        $('.popovers').popover();
    });


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
        $('#'+form).find('.form-group').removeClass('has-error');
        
        $.each(erros,function( key, value ) {
             var item = $('#'+form+' input[name$="['+key+']"], textarea[name$="['+key+']"], select[name$="['+key+']"]').parent('.form-group, label, div');
             $('#'+form+' input[name$="['+key+']"], textarea[name$="['+key+']"], select[name$="['+key+']"]').parents('.form-group').addClass('has-error');
             $('<span class="text-danger pi-text-red alert-error" for="inputError"><i class="fa fa-times-circle-o icon-cancel"></i> '+value+' </span>').appendTo( item );
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
        }
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

    
    /**
     * @todo funcao que envia as requisições em ajax do sistema
     */
    $(document).on('click', 'form button', function(){
        var id = $(this).parents('form').attr('id');
        var button = $(this).parent('.form-group');
        //pre loader
            $('#loading').fadeIn(500);
            if( !$('#loading').is(':visible') ){
                loadingElement('Carregando...', button);
            }
            $('form button').hide();	
		
        // bind form using ajaxForm 
        $('#' + id ).ajaxForm({ 
            // dataType identifies the expected content type of the server response 
            dataType:  'json', 
            // success identifies the function to invoke when the server response 
            // has been received 
            success:   function (data){
                $('#loading').fadeOut(500);
                $('form button').show();
                $('#gif-loader').remove();
                tratarJSON(data);
            }
        }); 
        //fim pre loader
        $(document).ajaxError(function() {
            $('#loading').fadeOut(500);
            $('form button').show();
            $('#gif-loader').remove();
        });
        
        $.ajaxSetup({
            async: true
        });
    });
    
    
    $(document).on('click', '#procurar-cliente', function(){
        
        var url   = web_root + 'Clientes/procurarCliente';
        var busca = $('#BuscarPor').val();
        var valor = $('#cliente').val();
        
        
        if( busca === 'telefone' ){
            var ddd = $('#ddd').val();
            valor = ddd + valor;
        }
        
        if( valor != null || valor != '' ){
            //$('#loading').fadeIn(500);
            //
            $('#dados-cliente').empty();
            $('#dados-reserva').empty();
            $('#dados-cliente').empty();
            loadingElement('<br>Carregando Informações...', '#dados-cliente');
            // iniciar o loader
            $.ajax({
                url: url,
                data:{
                    busca: busca,
                    valor: valor,
                },
                dataType: 'html',
                type: 'post',
                success: function (html) {
                    // encerrar loader
                    //$('#loading').fadeOut(500);
                    // dados
                    
                    $('#dados-cliente').html(html);
                    $('input[name$="['+busca+']"]').val(valor);
                    $('#dados-reserva').empty();
                }
            });
        }
    });
    
    
    $(document).on('keypress', "#cliente", function(e){
        if(e.which == 13 ){
            $('#dados-cliente').empty();
            $('#dados-reserva').empty();
            
            var url   = web_root + 'Clientes/procurarCliente';
            var busca = $('#BuscarPor').val();
            var valor = $('#cliente').val();

            if( busca === 'telefone' ){
                var ddd = $('#ddd').val();
                valor = ddd + valor;
            }


            if( valor != null || valor != '' ){
                
                loadingElement('<br>Carregando Informações...', '#dados-cliente');
                
                // iniciar o loader
                $.ajax({
                    url: url,
                    data:{
                        busca: busca,
                        valor: valor,
                    },
                    dataType: 'html',
                    type: 'post',
                    success: function (html) {
                        // encerrar loader
                        //$('#loading').fadeOut(500);
                        // dados
                        
                        $('#dados-cliente').html(html);
                        $('input[name$="['+busca+']"]').val(valor);
                        $('#dados-reserva').empty();
                    }
                });
            }
        }
    })
    
    $(document).on('change', '#BuscarPor', function(){
        if( $('#BuscarPor').val() == 'telefone' ){
            $('#cliente').parent('div').parent('div').addClass('col-md-9');
            $('#cliente').parent('div').parent('div').removeClass('col-md-12');
            $('#ddd').attr('disabled', false);
            $('#ddd').parent('div').parent('div').show(300);
            $('#cliente').attr('placeholder', 'Telefone sem separação');
        } else {
            $('#ddd').parent('div').parent('div').hide();
            $('#ddd').attr('disabled', true);
            $('#cliente').parent('div').parent('div').removeClass('col-md-9');
            $('#cliente').parent('div').parent('div').addClass('col-md-12');
            $('#cliente').removeClass('telefone');
            $('#cliente').removeAttr('autocomplete');
            $('#cliente').removeAttr('maxlength');
            $('#cliente').attr('placeholder', 'Digite aqui o valor');
        }
        $('#cliente').val(null);
    });
    

    function infoErro( mensagem, elementoDiv ) {
        $(elementoDiv).find('.msgError').remove();
        var elemento = '';
        elemento = '<div class="row pi-row msgError"><div class="col-md-12">'
                           + '<!-- msgError box -->'
                           + '<div class="alert alert-danger pi-alert-danger">'
                             //+   '<h4>Erro: </h4>'
                             +   '<a class="close" data-dismiss="alert">×</a>'
                             +   "<p style='color:#fff;'> NOTIFICAÇÃO: " +  mensagem  +  '</p>'
                            +'</div><!-- /.box -->'
                        +'</div></div><!-- /.col -->';
        //( elemento ).prependTo( elementoDiv ).delay(5000).fadeOut();
        $( elemento ).prependTo( elementoDiv );
        $('.row input, select , textarea').removeClass('has-error');
    }


    function sucessoForm( mensagem, elementoDiv ) {
        $(elementoDiv).find('.sucesso').remove();
		$(elementoDiv).find('.msgError').remove();
        var elemento = '';
        elemento = '<div class="row pi-row sucesso"><div class="col-md-12">'
                           + '<!-- Success box -->'
                           + '<div class="alert alert-success pi-alert-success">'
                             //+   '<h4 class="box-title">Sucesso na sua operação</h4>'
                             +   "<p style='color:#fff;'> " +  mensagem  +  '</p>'
                            +'</div><!-- /.box -->'
                        +'</div></div><!-- /.col -->';
        $( elemento ).prependTo(elementoDiv).delay(2000).fadeOut(100);
        $('.row input, select , textarea').removeClass('has-error');
    }

    
    function redirect( url ){
        $(location).attr('href',url);
    }
    
    
    function novoEvento( date, url ){
        $('#loading').fadeIn(500);
                
        var dataInit = null;
        var dataEnd = null;
        
        if( date.length ){
            $.ajax({
                url: web_root + url,
                data:{
                    data: date
                },
                dataType: 'html',
                type: 'post',
                success: function (html) {
                                        
                    if( date.length < 19 ){
                        dataInit = date.split("-");
                        //dataEnd      = '20:00';
                        dataInit     = dataInit[2] +"/"+ dataInit[1] +"/"+ dataInit[0];
                     } else {
                        dataInit = date.split("T");
                        var hora = dataInit[1];
                        var data = dataInit[0];
                        dataInit = data.split("-");
                        dataEnd      = hora;
                        dataInit     = dataInit[2] +"/"+ dataInit[1] +"/"+ dataInit[0];
                    }
                    
                    $('#loading').fadeOut(1000);
                    $('.append-body').html(html);
                    $('#ModalFormulario').modal('show');

                    $('#start').val( dataInit );
                    $('#hora').val( dataEnd );
                    $('#dados-cliente').empty();
                    $('#dados-reserva').empty();
                    
                    
                }
            });
        }
    }
    
    
	/**
	 * 	FUNÇÃO PARA ENVIAR OS DADOS POR AJAX
	 */
	function viewEnventoAjax( id ){
            $('#loading').fadeIn(500);
            $.ajax({
                url: web_root + 'Reservas/perfil',
                data:{ id: id },
                dataType: 'html',
                type: 'post',
                success: function (html) {
                    $('.append-body').html(html);
                    $('#ModalFormulario').modal('show');
                    $('#loading').fadeOut(1000);
                }
            });
	}
	
    /**
    * 	FUNÇÃO DE ALERTA DE INFORMAÇÃO
    */
    function alertaInformacao(){
           $('.alerta').remove();
           var elemento  = '<div class="alert alert-dismissable alert-info col-md-3 alerta">';
                   elemento +=	'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>';
                   elemento +=	'<strong><i class="glyphicon glyphicon-exclamation-sign"></i> Aguarde!</strong> Estamos enviando seu registro para nossos servidores.';
                   elemento +=	'</div>';
           $(elemento).appendTo( 'body' ).delay(1000).fadeOut(1000);
    }

    /**
    * 	FUNÇÃO DE ALERTA DE SUCESSO
    */
    function alertaSucesso(){
           $('.alerta').remove();
           var elemento  = '<div class="alert alert-dismissable alert-success col-md-3 alerta">';
                   elemento +=	'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>';
                   elemento +=	'<strong><i class="glyphicon glyphicon-floppy-saved"></i></strong> Seu registro foi efetuado com sucesso!.';
                   elemento +=	'</div>';
           $(elemento).appendTo( 'body' ).delay(1000).fadeOut(1000);
    }
    
    
    /**
    * 	FUNÇÃO DE ALERTA DE SUCESSO
    */
    function sucesso( msg ){
           $('.alerta').remove();
           var elemento  = '<div class="alert alert-dismissable alert-success col-md-3 alerta">';
                   elemento +=	'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>';
                   elemento +=	'<strong><i class="fa fa-sign"></i></strong> ' + msg;
                   elemento +=	'</div>';
           $(elemento).appendTo( 'body' ).delay(1000).fadeOut(1000);
    }

    function chamaListaDeConvidadosAdminEpdf( url ){
        $.ajax({
                url: url,
                data:{},
                type: "get",
                dataType: 'html',
                success: function (json) {
                    
                    if( $('#Modal-lista-convidados').is(':visible') == false ){
                        $('#Modal-lista-convidados').modal('show');
                    }
                    
                    $('#body-lista-convidados').html(json);
                }
            });
    }


    $(document).on('hidden.bs.modal', '#ModalFormulario', function () {
        
        var data_inicio  = $("#start").val();
        
        if( data_inicio.length > 0 ){
            $('#loading').fadeIn(500);
            $.ajax({
                url: web_root + 'Reservas/deletaCadastroInicio',
                data:{ data_inicio: data_inicio },
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    $('#loading').fadeOut(1000);
                    if( data.style == 'success'){
                        bootsAlert(data);
                        $('#dados-cliente').empty();
                        $('#dados-reserva').empty();
                    } else {
                        if(data.erro){
                            bootsAlert(data);
                        }
                    }
                }
            });
        }
    });
    
    
    $(document).on('click', '#cadastrar-novo-convidado', function(){
       
        var token = $(this).data('token');
       
        if( token != null || token != '' ){
            $('#body-lista-convidados').empty();
            loadingElement('<br>Aguarde um Momento...', '#body-lista-convidados');
            
            $.ajax({
                url: web_root + 'Reservas/cadastraConvidado',
                data:{
                    token: token
                },
                dataType: 'html',
                type: 'post',
                success: function(data) {
                    
                    $('#body-lista-convidados').html(data);
                }
            });
            
        }
       
    });