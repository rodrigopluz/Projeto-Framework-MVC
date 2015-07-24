
/* CADASTRO DE USUÁRIO PELO SITE */
	$(document).ready(function(){

		$('.dados input').keypress(function() {
			$(this).removeClass('border_error').addClass('border');
		});

		/* icone deleta usuario */
			$('.lista_registros table td.del').click( function () {
				if(confirm('Excluir este usuário? Essa ação não pode ser anulada!')) {
					$.ajax({
						type: "POST",
						url: base_url+"?on=ajax&in=deletaUsuario",
						data: "id_usuario="+$(this).find("a").attr('rel'),
						success: function(msg){
							if(msg == 'ok'){
								$(this).parent().remove();
								alert('Usuário excluido!');
							}else
								alert('Falha ao tentar deletar o usuário, tente novamente mais tarde.');
						}
					});
		       	}
		    });
	    /* icone deleta usuario */

            /* icone deleta multimidia */
			$('.lista_registros table td.delMulti').click( function () {
				if(confirm('Excluir esta mídia? Essa ação não pode ser anulada!')) {
					$.ajax({
						type: "POST",
						url: base_url+"?on=ajax&in=deletaMidia",
						data: "id_midia="+$(this).find("a").attr('rel'),
						success: function(msg){
							if(msg == 'ok'){
								$(this).parent().remove();
								alert('Midia excluida com sucesso!');
							}else
								alert('Falha ao tentar deletar a mídia, tente novamente mais tarde.');
						}
					});
		       	}
		    });
            /* icone deleta multimidia */
	});

	function validaCadastroTexto(){
		var msg = "";

		disabledFormButton("input[type='submit']");

		if($("#titulo").val() == ""){
			msg += "<span>&bull; Titulo não preenchido.</span><br />";
			$("#titulo").addClass('border_error');
		} else
			$("#titulo").removeClass('border_error');


		if($("#texto").val() == ""){
			msg += "<span>&bull; Texto não preenchido.</span><br />";
			$("#texto").addClass('border_error');
		} else
			$("#texto").removeClass('border_error');

		if(msg != "") {
			msg = "<span class=\"v11\">Os seguintes campos encontram-se com problemas:<br /><br /></span>" + msg;
			$('#retorno_erro').html(msg);

			enabledFormButton("input[type='submit']");

			window.clearTimeout(timeoutID);
			timeoutID = window.setTimeout(hideError, 4000, true);

		} else {

			// VALIDA POR AJAX SE O EMAIL JÁ ESTÁ NA BASE
			$('#retorno_erro').html('Validando...');

			$('#cadastro_usuario').submit();
		}

		return false;

	}

/* CADASTRO DE USUÁRIO PELO SITE */