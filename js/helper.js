	// JavaScript Document
$(document).ready(function(){

	parts = window.base_url.split('/');
	var url = parts[0]+'//'+parts[2]+'/';

	$('.sel_regra_tipo').on('change', function() {
		if (this.value == 1 ) {
			$(".especific_field").hide();
			$("#script_python").hide();
		}
	});

	$('.timemask').mask('00:00:00');

	$(".removeSensortoCI").click(function () {
	    var selectedItem = $(".sensorsInCI option:selected");
	    $(".sensorsOutCI").append(selectedItem);
	    $(".sensorsInCI option").prop('selected', true);
	});

	$(".addSensortoCI").click(function () {
	    var selectedItem = $(".sensorsOutCI option:selected");
	    $(".sensorsInCI").append(selectedItem);
	    $(".sensorsInCI option").prop('selected', true);
	});


	$('.addrule').click(function(){
	    $('.ruleTemplate').clone().removeClass('ruleTemplate').show().appendTo('.rules');
	    	$('.operacaoLogicaValue').numeric({allow:"."});
	    	$(".operacaoLogica").change(function(){
	      	if($(this).val()=='all'){
	        	$(this).parent().parent().find(".operacaoLogicaValue").prop('disabled', true);
	      	}else{
	        	$(this).parent().parent().find(".operacaoLogicaValue").prop('disabled', false);
	      	}
	    });
	    $('.removerule').click(function(e){
	      	e.preventDefault();
	      	$(this).parent().parent().remove();        
    	});
  	});

	$('#contextointeresse-value').on('change', function() {
		if (this.value != 0 && this.value != "") {
			$.ajax({
				type:"POST",
				dataType: 'json',
				url:window.base_url+"index.php?/CI_visualizacao/getSensoresByCiID",
				data: {contextointeresse:$("#contextointeresse-value").val()},
				success: function(data) {
					$('#sensor-value').html('');
					$("#sensor-value").append('<option value="" selected="" disabled="">Selecione um Sensor</option>');
	
					$.each(data, function(key,val) {
						$("#sensor-value").append('<option value="'+val.sensor_id+'">'+val.nome+'</option>');
					});
				}
			});
		}
	}).change();

	$('#sensor_servidorborda').on('change', function() {
		if (this.value != 0 && this.value != "") {
			$.ajax({
				type:"POST",
				dataType: 'json',
				url:window.base_url+"index.php/cadastros/CI_gateway/getGatewaysBySBID",
				data: {servidorborda:$("#sensor_servidorborda").val()},
				success: function(data) {
					$('#sensor_gateway').html('');
					$("#sensor_gateway").append('<option value="" selected="" disabled="">Selecione um Gateway</option>');
	
					$.each(data, function(key,val) {
						$("#sensor_gateway").append('<option value="'+val.gateway_id+'">'+val.nome+'</option>');
					});
					if ($('#sel_sensor_gateway').val() != "")
						$("#sensor_gateway").val($('#sel_sensor_gateway').val());
				}
			});
		}
	}).change();

	$('#publicacao_servidorborda').on('change', function() {
		if (this.value != 0 && this.value != "") {
			$.ajax({
				type:"POST",
				dataType: 'json',
				url:window.base_url+"index.php/cadastros/CI_sensor/getSensoresBySBID",
				data: {servidorborda:$("#publicacao_servidorborda").val()},
				success: function(data) {
					$('#publicacao_sensor').html('');
					$("#publicacao_sensor").append('<option value="" selected="" disabled="">Selecione um Sensor</option>');
	
					$.each(data, function(key,val) {
						$("#publicacao_sensor").append('<option value="'+val.gateway_id+'">'+val.nome+'</option>');
						console.log(val.gateway_id+" , "+val.nome);
					});
					if ($('#sel_publicacao_sensor').val() != "")
						$("#publicacao_sensor").val($('#sel_publicacao_sensor').val());
				}
			});
		}
	}).change();


	$('#regra_contextointeresse').on('change', function() {
		if (this.value != 0 && this.value != "") {
			$.ajax({
				type:"POST",
				dataType: 'json',
				url:window.base_url+"index.php/cadastros/CI_regras/getSensorByRci",
				data: {contextointeresse:$("#regra_contextointeresse").val()},
				success: function(data) {
					$('#regra_sensor').html('');
					$("#regra_sensor").append('<option value="" selected="" disabled="">Selecione um Sensor</option>');
					$.each(data, function(key,val) {
						if ($("#regra_sensor_id").val() == val.sensor_id){
							$("#regra_sensor option")[0].remove();
							$("#regra_sensor").append('<option value="'+val.sensor_id+'" selected="">'+val.sensor_nome+'</option>');
						}else{
							$("#regra_sensor").append('<option value="'+val.sensor_id+'">'+val.sensor_nome+'</option>');
						}
					});
				}
			});
		}
	}).change();

	$("#perm_tipo").on('change', function() {
		if (this.value != 0 && this.value != "") {
			var type_id = this.value;
			if (this.value == 1)
				type = "CI_ambiente";
			if (this.value == 2)
				type = "CI_contextointeresse";
			if (this.value == 3)
				type = "CI_regras";
			if (this.value == 4)
				type = "CI_sensor";
			$.ajax({
				type:"POST",
				dataType: 'json',
				url:window.base_url+"index.php/cadastros/"+type+"/select",
				success: function(data) {
					$('#perm_registro').html('');
					$('#perm_registro').empty()
					$("#perm_registro").append('<option value="" selected="" disabled="">Selecione</option>');
					$.each(data, function(key,val) {
						if (type_id == 1)
							$("#perm_registro").append('<option value="'+val.ambiente_id+'">'+val.nome+'</option>');
						if (type_id == 2)
							$("#perm_registro").append('<option value="'+val.contextointeresse_id+'">'+val.nome+'</option>');
						if (type_id == 3)
							$("#perm_registro").append('<option value="'+val.regra_id+'">'+val.nome+'</option>');
						if (type_id == 4)
							$("#perm_registro").append('<option value="'+val.sensor_id+'">'+val.nome+'</option>');						
					});
				}
			});
		}
	}).change();

	$('#insertSensorCI').click(function(){
		itemText = $(".sensorsOutCI").find(":selected")[0].text;
		itemVal = $(".sensorsOutCI").find(":selected")[0].value;
		console.log("oi");
		$(".ciSensorList").append("<li class='ciSensorItem' data-id='"+itemVal+"' data-text='"+itemText+"'><input type='hidden' name='contextointeresse_sensores[]' value='"+itemVal+"'><div class='col-xs-7'>"+itemText+"</div><div class='col-xs-4'><input type='checkbox' name='contextointeresse_trigger[]' value='"+itemVal+"'>Dispara regra</div><div class='col-xs-1'><div class='removeSensorCI'><i class='fa fa-times fa-2x'></div></i></div></li>");
		$(".sensorsOutCI").find(":selected")[0].remove();
	});

	$('ul.ciSensorList').on('click', 'div.removeSensorCI', function(){
		var e = $(this).parent().parent();
		value = e.data('id');
		text = e.data('text');
		e.remove();
		$(".sensorsOutCI").append('<option value="'+value+'">'+text+'</option>');
	});

	$('[data-toggle="tooltip"]').tooltip(); 

		var data_inicio;
		var data_fim;
		var eqid;

		$('.botaoVisualizar').click(function(){
			data_inicio = $(this).parent().parent().find(".data_inicio").attr('data-data');
			data_fim = $(this).parent().parent().find(".data_fim").attr('data-data');
			sensorid = $(this).parent().parent().find(".ambiente").attr('data-sensorid').split(',');
			ambiente = $(this).parent().parent().find(".ambiente").text();
			sensornome = $(this).parent().parent().find(".ambiente").attr('data-sensornome').split(',');
		})

		$('#modalView').on('shown.bs.modal', function (e){
			$.ajax({
			  	method: "POST",
			  	url: window.base_url+"index.php/CI_visualizacao/geraJsonSeries",
			  	crossDomain: true,
			  	dataType : "json",
                contentType: "application/x-www-form-urlencoded",
                async: false,
			  	data: {sensor: sensorid, datainicio: data_inicio, datafim: data_fim}
			}).done(function( data ) {
	    		console.log(JSON.stringify(data));
	    		var minvalue = Number.POSITIVE_INFINITY;
				var maxvalue = Number.NEGATIVE_INFINITY;
				var tmp;
				for (var i=data.length-1; i>=0; i--) {
				    tmp = data[i].minvalue;
				    tmp2 = data[i].maxvalue;
				    if (tmp < minvalue) minvalue = tmp;
				    if (tmp2 > maxvalue) maxvalue = tmp2;
				}

	    		$('#chart').highcharts("StockChart", {
			        chart: {
			        	zoomType: 'x'
			        },
			        credits: {
                        enabled: false
                    },
			        title: {
			            text : ambiente+'<br>'+sensornome.join(", ")
			        },
			        xAxis: {
			            type: 'datetime',
	                    ordinal: false,
			        },
			        tooltip: 
			        	{pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                        valueDecimals: 2
                    },
			        series: data

		    	});
		  	});
        });
		 
		$('.input-select select').chosen();
				
		$(".linkSubmenu").click(function(){
			var menu = $(this).attr('rel');
			$(".menuPrincipal").find(".subMenu").each(function(){
				if($(this).attr('id')!="sub-"+menu){											   
					$(this).slideUp();
				}
			});
			$("#sub-"+menu).slideToggle();
		});

		$(".botaoPermissao").click(function(){
			var form = $(this).closest("form");
			var secao = $("#caminho").val();
			var dataItem = $(this).attr("id");
			var selectedItem = dataItem.split("-",2);	
			$(form).find(".item-selected").val(selectedItem[1]);	
			document.lista.action = window.base_url+"index.php/cadastros/CI_permissoes/editar";
			document.lista.submit();
		});
		
		$(".botaoExcluir").click(function(){
			if (confirm("Você realmente deseja excluir esse registro?")){
				var form = $(this).closest("form");
				var secao = $("#caminho").val();
				var dataItem = $(this).attr("id");
				var selectedItem = dataItem.split("-",2);	
				$(form).find(".item-selected").val(selectedItem[1]);						  
				document.lista.action = window.base_url+"index.php/"+ secao +"/excluir";
				document.lista.submit();
			}	
		});
	
		$(".botaoEditar").click(function(){
			var form = $(this).closest("form");
			var secao = $("#caminho").val();
			var dataItem = $(this).attr("id");
			var selectedItem = dataItem.split("-",2);	
			$(form).find(".item-selected").val(selectedItem[1]);						  
			document.lista.action = window.base_url+"index.php/"+ secao +"/editar";
			document.lista.submit();
		});

		$(".botaoStatus").click(function(){
			var status= $(this).data('status');
			console.log(status);
			if (status=='t')
				strconf= 'Você realmente deseja DESATIVAR?';
			else if (status=='f')
				strconf= 'Você realmente deseja ATIVAR?';

			if (confirm(strconf)){				
				var form = $(this).closest("form");
				var secao = $("#caminho").val();
				var dataItem = $(this).attr("id");
				var selectedItem = dataItem.split("-",2);	
				$(form).find(".item-selected").val(selectedItem[1]);

				if (status == 'f')				  
					document.lista.action = window.base_url+"index.php/"+ secao +"/ativar";
				else if (status == 't')
					document.lista.action = window.base_url+"index.php/"+ secao +"/desativar";
				document.lista.submit();
			}
		});
	
		$(".perpage-button").click(function(e){
			atualizaListagem();
		})
		
		function atualizaListagem() {
	
			var caminho = $("#caminho").val();
			var metodo = $("#metodo").val();
			var nr_pagina = $("#perpage").val();
			var href		= window.base_url+'index.php/'+caminho+'/'+metodo+'/'+nr_pagina;
			location.href 	= href;
		}
	
		$('table.tabela-dados tbody .dados:even').css('background','#E6E6E6'); 
		$('table.tabela-dados tbody .dados:odd').css('background','#FFFFFF'); 
		
		$(".link-abas li").find("a").each(function(ev){
			$(this).bind("click",function(){
				var hasClass = $(this).hasClass('active-tab');
				if (hasClass === false){
					var _this = $(this);
					$('.active-tab').removeClass('active-tab');
					var nomeAba = $(this).attr("id");
					$(".aba-ativa").removeClass("aba-ativa").fadeOut(function(){
						_this.addClass('active-tab');
						$('#container-' + nomeAba).fadeIn('100').addClass("aba-ativa");
					});
				}	
			});	
		});

		var relDay = 0;
		var actualClassDay = "block-blue";
		$(".days-calendar td a").each(function(){
			var newRel = $(this).attr("rel");
			if (newRel === relDay){
				$(this).find("span").removeAttr('class');
				$(this).find("span").attr('class',actualClassDay);
			
			} else {
				relDay = newRel;
				if (relDay.length < 3) {
					if (actualClassDay == "block-blue") {
						actualClassDay = "block-gray";
					} else {
						actualClassDay = "block-blue";
					}
				} else if (relDay.length === 6) {
					actualClassDay = 'block-green';
				} else if (relDay.length >= 10) {				
					actualClassDay = 'block-red';
				}	
				$(this).find("span").removeAttr('class');
				$(this).find("span").attr('class',actualClassDay);
			}
		});


		$(".days-calendar td a").bind('click',function(ev){
			var events = $(this).attr('rel').split('||');
			var idEvent = events;
			var caminhoAgenda = window.base_url+"index.php/agenda/CI_agenda/buscar";
			$.ajax ({
				type:'post',
				data:{item:idEvent},
				url:caminhoAgenda,
				success:function(result){
					$('#container-resultados-eventos').html(result);
				}
			});
			ev.preventDefault();
		});

		$('.btn-cadastro-agendamento').unbind('click').bind("click",function(ev) {
			var DateTimeInicial = "";
			var DateTimeFinal = "";
			var idVerificacao = $('#agendamento_id').val();
			var agendamentoambiente = $('#agendamento_ambiente').val();
			var caminhoVerificacao = window.base_url+"index.php/agenda/CI_agenda/verificarData";
			
			if (idVerificacao == "") {
				idVerificacao = 0;
			} 

			if ($("#dt-inicio").val().length > 1) {
				DateTimeInicial = $("#dt-inicio").val();
			}
			if ($("#dt-final").val().length > 1){		
				DateTimeFinal = $("#dt-final").val();
			}	
			if (DateTimeFinal == "" || DateTimeInicial == "") {
				alert("Preencha todos os campos corretamente.");
				return false;
			}
			if (typeof DateTimeFinal != 'undefined' && typeof DateTimeInicial != 'undefined') {
				$.ajax ({
					type:"POST",
					data:{idAg:idVerificacao, DateTimeInicial:DateTimeInicial, DateTimeFinal:DateTimeFinal, agendamentoambiente:agendamentoambiente},
					url:caminhoVerificacao,
					success:function(result){
						console.log(result);
						if (result[0] == '0') {
							$('.formulario-agendamento').submit();
						} else {
							alert('Já existe agendamento neste intervalo de datas para este ambiente.');
						}
					},
					error: function() {
						alert('Preencha todos os campos corretamente.');
					}
				});
			}					
		});

		$('.btn-cancelar-operacao').bind("click",function(){
			var href		= window.base_url+'index.php/CI_inicio';
			location.href 	= href;
		});
		
		$('.checkbox-pai').on('click', function(){
			var $this = $(this);
			var parentMenu = $this.closest('.item-menu-perfil');
			var listaMenus = parentMenu.find('.lista-menus');
			if ($this.is(':checked')){
				listaMenus.find('input').each(function(){
					$(this).prop('checked', true);
					$(this).attr('checked', true);
				});
			} else {
				listaMenus.find('input').each(function(){
					$(this).attr('checked', false);
				});
			}	
		});		

		$(".botao-submit-usuario").on('click', function(ev){
			var camposValidos = 0;
			$('#form-usuario').find('.campo-obrigatorio').each(function(){
				if (!$(this).val() == "" || !$(this).val() == this.defaultValue) {
					camposValidos++;
				}
			});
			
			if (camposValidos > 0) {
				$('#form-usuario').submit();
			} else {
				alert('Digite ao menos um número de telefone!');
				ev.preventDefault();
			}	
		});
	});
(function() {
    var matched, browser;

    // Use of jQuery.browser is frowned upon.
    // More details: http://api.jquery.com/jQuery.browser
    // jQuery.uaMatch maintained for back-compat
    jQuery.uaMatch = function( ua ) {
        ua = ua.toLowerCase();

        var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
            /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
            /(msie) ([\w.]+)/.exec( ua ) ||
            ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
            [];

        return {
            browser: match[ 1 ] || "",
            version: match[ 2 ] || "0"
        };
    };

    matched = jQuery.uaMatch( navigator.userAgent );
    browser = {};

    if ( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }

    // Chrome is Webkit, but Webkit is also Safari.
    if ( browser.chrome ) {
        browser.webkit = true;
    } else if ( browser.webkit ) {
        browser.safari = true;
    }

    jQuery.browser = browser;
})();


