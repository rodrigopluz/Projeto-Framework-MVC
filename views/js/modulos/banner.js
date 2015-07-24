
/* CADASTRO DE USUÃRIO PELO SITE */
	$(document).ready(function(){
		
		$('.dados input').keypress(function() { 
			$(this).removeClass('border_error').addClass('border');
		});
		
		/* icone deleta usuario */
			$('.lista_registros table td.del').click( function () {
				var id = $(this).find("a").attr('rel');
				if(confirm('Excluir este banner? Essa ação não pode ser anulada!')) {
					$.ajax({
						type: "POST",
						url: base_url+"?on=banner&in=deletar",
						data: "id="+$(this).find("a").attr('rel'),
						success: function(msg){
							if(msg == 'ok'){
								$('#'+id).remove();
								alert('Banner excluido!');
							}else
								alert('Falha ao tentar deletar o banner, tente novamente mais tarde.');
						}
					});
		       	}
		    });
	    /* icone deleta usuario */
	});
	
	var timeoutID = '';
	
	function setFromCadastro(valor) {
		$('.dados .hide').css('display','none');
		
		$('#usuario_tipo_id').val(valor);
		
		switch(valor) {
			case '1':
				$('#fone_c').css('display','block');
			break;
			case '2':
				$('#creci_c').css('display','block');
				$('#fone_c').css('display','block');
			break;
			case '3':
				$('#creci_c').css('display','block');
				$('#fone_c').css('display','block');
				//$('#texto').css('display','block');
			break;
			case '4':
				$('#fone_c').css('display','block');
				//$('#texto').css('display','block');
			break;
		}
		
		window.clearTimeout(timeoutID);
		$('#retorno_erro').html('');
		$('.dados input').removeClass('border_error').addClass('border');
	}
	
	function validaCadastroUsuario(){
		var msg = "";
		
		if($("#nome_c").val() == "" || $("#nome_c").val() == "Nome"){
			msg += "<span>&bull; Nome nÃ£o preenchido.</span><br />";
			$("#nome_c").addClass('border_error');
		} else
			$("#nome_c").removeClass('border_error');
		
		if($("#email_c").val() == "" || $("#email_c").val() == "Email"){
			msg += "<span>&bull; E-mail nÃ£o preenchido.</span><br />";
			$("#email_c").addClass('border_error');
		} else if(!valEmail.test($("#email_c").val())){
			msg += "<span>&bull; E-mail invÃ¡lido.</span><br />";
			$("#email_c").addClass('border_error');
		} /*else if($("#email_c").val() != $("#email_cc").val()) {
			msg += "<span>&bull; ConfirmaÃ§Ã£o de email invÃ¡lida.</span><br />";
			$("#email_cc").addClass('border_error');
		}*/ else
			$("#email_c").removeClass('border_error');
			
		if($("#fone_c").css('display') != 'none') {
			if($("#fone_c").val() == "" || $("#fone_c").val() == "Telefone"){
				msg += "<span>&bull; Telefone nÃ£o preenchido.</span><br />";
				$("#fone_c").addClass('border_error');
			} else
				$("#fone_c").removeClass('border_error');
		}
		
		if(($("#senha_c").val() == "" || $("#senha_c").val() == "Senha") && $("#action").val() != "update"){
			msg += "<span>&bull; Senha nÃ£o preenchido.</span><br />";
			$("#senha_c").addClass('border_error');
		} else if($("#senha_c").val() != $("#senha_c2").val()) {
			msg += "<span>&bull; ConfirmaÃ§Ã£o de senha invÃ¡lida.</span><br />";
			$("#senha_c2").addClass('border_error');
		}else
			$("#senha_c").removeClass('border_error');
		
		var chkPermissoes=document.getElementsByName('permissoes[]');
		var files=0;
		$(chkPermissoes).each(function(){
		if(this.checked) {
			files = files +1;					
			}
		});
		if(files==0){
				msg += "<span>&bull; MÃ³dulos permitidos nÃ£o selecionados.</span><br />";
		}
		
		
		
		disabledFormButton("input[type='submit']");
		
			
		if(msg != "") {
			msg = "<span class=\"v11\">Os seguintes campos encontram-se com problemas:<br /><br /></span>" + msg;
			$('#retorno_erro').html(msg);
			
			enabledFormButton("input[type='submit']");
			
			window.clearTimeout(timeoutID);
			timeoutID = window.setTimeout(hideError, 4000, true);
			
		} else {
			
			// VALIDA POR AJAX SE O EMAIL JÃ ESTÃ NA BASE
			$('#retorno_erro').html('Validando...');
			
			$.ajax({
				type: "POST",
				url: base_url+"?on=ajax&in=validaEmailCadastro",
				data: 'email='+$('#email_c').val()+'&id_usuario='+$('#id_usuario').val() ,
				success: function(msg){
					if(msg == 'ok') $('#cadastro_usuario').submit();
					else if (msg == 'erro') {
						msg = "<span>&bull; E-mail jÃ¡ utilizado.</span><br />";
						$("#email_c").addClass('border_error');
						
						$('#retorno_erro').html(msg);
						
						enabledFormButton("input[type='submit']");
			
						window.clearTimeout(timeoutID);
						timeoutID = window.setTimeout(hideError, 4000, true);
					}
				}
			});
		}
		
		return false;
		
	}
	
/* CADASTRO DE USUÃRIO PELO SITE */