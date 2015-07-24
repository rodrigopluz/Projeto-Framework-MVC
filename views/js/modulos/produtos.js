
/* CADASTRO DE USUÁRIO PELO SITE */
	$(document).ready(function(){

		$('.down_edit_file').live('click', function(){
	        var d = $(this).attr('data-d');
	        var d_titulo = $('#td_arquivo_nome_' + d).html();
	        var d_arquivo = $(this).attr('data-f');
	        $('#action').val('update');
	        $('#arquivo_atual').val(d_arquivo);
	        $('#down_id').val(d);
	        $('#titulo_arq').val(d_titulo);
	    });
	    
	    $('.down_del_file').live('click', function() {
	        var d = $(this).attr('data-d');
	        var p = $(this).attr('data-p');
	        if (confirm('Excluir o arquivo de id: -' + d + '- ?')) {
	            $.ajax({
	                type: "POST",
	                url: base_url + "?on=produtos&in=download_deletar",
	                data: {'produto_id': p, 'download_id': d},
	                success: function(msg) {
	                    if (msg == 'ok') {
	                        $('#arquivo_download_' + d).remove();
	                        //alert('Arquivo excluido!');
	                        $.colorbox({
	                            html: "Arquivo excluído com sucesso!",
	                            width: 300,
	                            height: 150
	                        });
	                    } else
	                        alert('Falha ao tentar deletar o usuário, tente novamente mais tarde.');
	                }
	            });
	        }
	    });
			
		$('.dados input').keypress(function() { 
			$(this).removeClass('border_error').addClass('border');
		});
		
		/* icone deleta registro */
			$('.lista_registros table td.del').click( function () {
				var id = $(this).find("a").attr('rel');
				if(confirm('Excluir este Produto? Essa ação não pode ser anulada!')) {
					$.ajax({
						type: "POST",
						url: base_url+"?on=produtos&in=deletar",
						data: "produto_id="+$(this).find("a").attr('rel'),
						success: function(msg){
							if(msg == 'ok'){
								$('#'+id).remove();
								alert('Produto excluido!');
							} else
								alert('Falha ao tentar deletar o usuário, tente novamente mais tarde.');
						}
					});
		       	}
		    });
	    /* icone deleta registro */
	});

	function validaDownloadSalvar() {
	    $('#form_produto_download').submit();
	}
	
	function validaCadastroProdutos(){
		var msg = "";
		
		if($("#nome").val() == ""){
			msg += "<span>&bull; Nome não preenchido.</span><br />";
			$("#nome").addClass('border_error');
		} else
			$("#nome").removeClass('border_error');
		if($("#categoria").val() == ""){
			msg += "<span>&bull; Categoria não selecionada.</span><br />";
			$("#categoria").addClass('border_error');
		} else
			$("#categoria").removeClass('border_error');
			
		disabledFormButton("input[type='submit']");
			
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
	
	function validaCategoriaProduto(){
		var msg = "";
		
		if($("#categoria").val() == ""){
			msg += "<span>&bull; Categoria não preenchido.</span><br />";
			$("#categoria").addClass('border_error');
		} else
			$("#categoria").removeClass('border_error');
		
		disabledFormButton("input[type='submit']");
			
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
	}
	
/* CADASTRO DE USUÁRIO PELO SITE */

/* adicionar / remover inputs */
var n 	= 1;
var id 	= 1;

function atualizaN()
{
	n = 1;
	$('.rows').each(function(){
		$(this).find('.NSpan').html(n);
		n += 1;
	});
}

function addFormField()
{
	atualizaN();
	    var cont = "<div class='rows' style='height: 40px;' id='row" + id + "'>";
			cont += "<div class='left'><label for='txt" + id + "a'>Titulo &nbsp;&nbsp;";
			cont += "<input type='text' name='data[valores][" + id + "][titulo]' id='txt" + id + "' maxlength='255' class='frm w270 border'>&nbsp;&nbsp</div>";
			cont += "<div class='left'><label for='txt" + id + "b'>Valor &nbsp;&nbsp;";
			cont += "<input type='text' name='data[valores][" + id + "][valor]' id='txt" + id + "' maxlength='255' class='frm w88 border'>&nbsp;&nbsp</div>";
			cont += "<div class='left'><label for='txt" + id + "c'>Percentual &nbsp;&nbsp;";
			cont += "<input type='text' name='data[valores][" + id + "][porcentagem]' id='txt" + id + "' maxlength='255' class='frm w54 border'>&nbsp;&nbsp</div>";
			cont += "<a href='#' onClick='removeFormField(" + id + "); return false;'>[-] Remove</a>";
		cont += "</div>";
	$("#divTxt").append(cont);
	
	$('#row' + id).highlightFade({
		speed:1000
	});
	
	id +=  1;

}


function removeFormField(id)
{
	$("#row"+id).remove(); atualizaN();
}

function removeFormFieldEdt(id)
{
	$.ajax({
		type: "POST",
		url: base_url+"?on=produtos&in=deletarNutricional",
		data: "id="+id,
		success: function(msg){
			if(msg == 'ok'){
				$("#row"+id).remove(); 
				atualizaN2();
			} else
				alert('Falha ao tentar deletar o registro, tente novamente mais tarde.');
		}
	});
	
}

function RemoveFieldAll(){
	$(".rows").remove(); 
	id = 1;
}
/* adicionar / remover inputs */