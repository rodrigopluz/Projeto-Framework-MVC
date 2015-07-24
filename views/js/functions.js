$(document).ready(function(){

	/* PLUGIN DE WATERMARK */
	watermark.init();

	/* MODAL DE LOGIN */
	$('#modalLogin').click(function() {
		$.showModal('Faça seu Login',base_url+'index.php|on=ajax&in=getLogin',
		{
			classe: 'boxLogin',
			width: '458',
			topo: '150'
		});
	});
	 $('#ano-2011').live('click', function(){
        $('#abre-2011').slideToggle();
        $('#abre-2012').hide();
        $('#abre-2013').hide();
        $('#abre-2014').hide();
    });

	$('#ano-2012').live('click', function(){
        $('#abre-2012').slideToggle();
        $('#abre-2011').hide();
        $('#abre-2013').hide();
        $('#abre-2014').hide();
    });
    

    $('#ano-2013').live('click', function(){
        $('#abre-2013').slideToggle();
        $('#abre-2012').hide();
        $('#abre-2011').hide();
        $('#abre-2014').hide();
    });

	$('#ano-2014').live('click', function(){
        $('#abre-2014').slideToggle();
        $('#abre-2012').hide();
        $('#abre-2013').hide();
        $('#abre-2011').hide();
    });

    

    

   

	/* MODAL DE LOGIN */

	/* PLUGIN DE PNG FIX */
	if($.browser.msie && ($.browser.version == "6.0")){	$(document).pngFix(); }

	/* SCROLL ANIMADO NA PAGINA */
	$('.scrollPage').click(function() {
		var elementClicked = $(this).attr("href");
		var destination = $(elementClicked).offset().top;
		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
		return false;
	});
	/* SCROLL ANIMADO NA PAGINA */

	// EDITOR DE CK-EDITOR
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "descricao,valor,texto,descricao2",
		theme : "advanced",
		//mode : "exact",
		//language : "pt",
		//skin : "default",
		plugins : "safari,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		// fullscreen,pagebreak,
		// Theme options
theme_advanced_buttons1:
"code,bold,italic,underline,justifyleft,justifycenter,justifyright,justifyfull,cleanup,link,unlink,table",
		// backcolor,fullscreen,fontselect,fontsizeselect,formatselect,strikethrough,forecolor,image,

		// Theme options
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",


		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
	 content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
    file_browser_callback : "tinyBrowser",
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
});

function ordena(campo){
	var order = $('#order').val();
	var campo_atual = $('#campo').val();

	if(order == 'DESC') order = 'ASC';
	else order = 'DESC';

	if(campo_atual != campo && campo_atual != '') order = 'ASC';

	window.location = '?on=mercado&campo='+campo+'&order='+order;
}

function topo() 	 { window.location = document.URL+'#'; }
function gotoAnchor(value) {
	var elementClicked = '#'+value;
	var destination = $(elementClicked).offset().top;
	$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
}


function confirmation($url) {
	if (confirm('Tem certeza que deseja excluir esta imagem?')){
		window.location = $url;
	}
}

function removeIngrediente(id){
	$('#ing'+id).remove();
}


var ids = 5;
function addIngrediente(data){

	var novoId = ids + 1;
	ids = novoId;
	var element = "<div class='left' id='ing" + novoId + "'><label style='float: left;width:15px;'>Qtde</label>&nbsp;&nbsp;<input type='text' name='quantidade[]' maxlength='255' class='frm w270 border campoqtde' />&nbsp;&nbsp;<label style='float:left;width:75px;'>Ingrediente&nbsp;&nbsp;&nbsp;&nbsp;</label><input style='float:left;' type='text' name='ingredientes[]' value='' maxlength='255' class='frm w270 border campoac' />&nbsp;&nbsp;&nbsp;&nbsp;<a style='width:75px;float:left;margin:0 10px;' href='javascript:;' onClick='removeIngrediente(" + novoId + ")'>[-] Remove</a></div>";

	$('#ings').append(element);

	var data1 = data.split("-");
	$(".campoac").autocomplete(data1);
}

function removePasso(id){
	$('#pas'+id).remove();
}


var pas = 5;
function addPasso(){

	var novoId = pas + 1;
	pas = novoId;
	var element = "<div class='left' id='pas" + novoId + "'><label style='float:left;width:45px;'>Passo&nbsp;&nbsp;&nbsp;</label><input style='float:left;' type='text' name='passos[]' value='' maxlength='255' class='frm w270 border' />&nbsp;&nbsp;&nbsp;&nbsp;<a style='width:75px;float:left;margin:0 10px;' href='javascript:;' onClick='removePasso(" + novoId + ")'>[-] Remove</a></div>";

	$('#passos').append(element);
}

/**
* var valEmail
* Expressão regular de validação de e-mail
*/
var valEmail = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;


/* LOADING */
function setLoading(id,texto) {
	if($.browser.msie)	$(id+' div').addClass('loading_bg');
	else				$(id).addClass('loading_bg');

	$('.container').append('<div class="loading"><div class="loading_content"><br /><br /><img src="'+base_url+'views/img/bg/carregando.gif" /><br />'+texto+'</div></div>');
}

function unsetLoading(id) {
	if($.browser.msie)	$(id + ' div').removeClass('loading_bg');
	else				$(id).removeClass('loading_bg');

	$('.loading').remove();
}
/* LOADING */

/* RECARREGA A PAGINA */
function reload() {
	window.location = document.URL;
}
/* RECARREGA A PAGINA */

/* LOGIN DO USUARIO  */
	function login(ac,vl) {
		var url = ''

		if(ac != '') url +='&ac='+ac;
		if(vl != '') url +='&vl='+vl;

		$.showModal('Faça seu Login',base_url+'index.php|on=ajax&in=getLogin' + url,
		{
			classe: 'boxLogin',
			width: '458',
			topo: '150'
		});
	}

	function logar(funcao) {
		var msg = "";

		if(funcao == 'undefined' || funcao == false || funcao == undefined) funcao = '';

		if($("#senha_login").val() == ""){
			msg = "<span>* Senha não preenchido.</span><br />";
		}

		if($("#email_login").val() == ""){
			msg = "<span>* E-mail não preenchido.</span><br />";
		} else if(!valEmail.test($("#email_login").val())){
			msg = "<span>* E-mail inválido.</span><br />";
		}

		disabledFormButton(".btn_entrar");

		if(msg != ""){
			$('.login #result_login').html(msg);
			$('.login #result_login span').addClass('verm');
			enabledFormButton(".btn_entrar");
		} else {
			$('.login #result_login span').removeClass('verm');
			$('.login #result_login').html('<span>... carregando dados</span>');

			$.ajax({
				type: "POST",
				url: base_url+"?on=ajax&in=login",
				data: "email="+$("#email_login").val()+"&senha="+$("#senha_login").val(),
				success: function(msg){
					//alert(msg);
					if(msg == 'erro') {
						$('.login #result_login').html('<span>Dados de login incorretos. Tente novamente.</span>');
						$('.login #result_login span').addClass('verm');
						enabledFormButton(".btn_entrar");
					} else if (msg == 'login') {
						$('.login #result_login').html('<span>...redirecionado</span>');
						$('.login #result_login span').addClass('green');

						if(funcao != '') {
							eval(funcao+'();');
							$('#containerModal .close').click();
						} else if($('#ac').val() != '') window.location = document.URL;
						else					 		window.location = $('.login').attr('rel');

					} else {
						$('.login #result_login').html('<span>Erro de conexão. Tente novamente.</span>');
						$('.login #result_login span').addClass('verm');
						enabledFormButton(".btn_entrar");
					}
				}
			});
		}
	}
/* LOGIN DO USUARIO */

/* RECUPERAR SENHA */
function getBoxSenha() {
	$.showModal('Recuperar Senha',base_url+'?on=ajax&in=getSenha',
	{
		classe: 'boxLogin',
		width: '458',
		topo: '150'
	});
}

function envia_senha() {
	var msg = "";

	if($("#email_senha").val() == ""){
		msg = "<span>* E-mail não preenchido.</span><br />";
	} else if(!valEmail.test($("#email_senha").val())){
		msg = "<span>* E-mail inválido.</span><br />";
	}

	disabledFormButton(".btn_entrar");

	if(msg != ""){
		$('.bx_senha #result_login').html(msg);
		$('.bx_senha #result_login span').addClass('verm');
		enabledFormButton(".btn_entrar");
	} else {
		$('.bx_senha #result_login span').removeClass('verm');
		$('.bx_senha #result_login').html('<span>... carregando dados</span>');

		$.ajax({
			type: "POST",
			url: base_url+"?on=ajax&in=recuperaSenha",
			data: "email="+$("#email_senha").val(),
			success: function(msg){
				if(msg == 'erro') {
					$('.bx_senha #result_login').html('<span>Email incorreto. Tente novamente.</span>');
					$('.bx_senha #result_login span').addClass('verm');
					enabledFormButton(".btn_entrar");
				} else if (msg == 'ok') {
					$('.bx_senha #result_login').html('<span>Sua senha foi enviada. Para acessar seu cadastro clique em "Faça seu login".</span>');
					$('.bx_senha #result_login span').addClass('green');
				} else {
					$('.bx_senha #result_login').html('<span>Erro de conexão. Tente novamente.</span>');
					$('.bx_senha #result_login span').addClass('verm');
					enabledFormButton(".btn_entrar");
				}
			}
		});
	}
}
/* RECUPERAR SENHA */

/* function gerais */
function disabledFormButton(ct) {
	$(ct).attr('disabled','disabled').css('cursor','default').css('filter','alpha(opacity=40)').css('-moz-opacity','0.4').css('opacity','0.4');
}

function enabledFormButton(ct) {
	$(ct).attr('disabled','').css('cursor','pointer').css('filter','alpha(opacity=100)').css('-moz-opacity','1').css('opacity','1');
}

function hideError() {
	$("#retorno_erro").animate({
	    left: '+=50',
	    height: 'toggle'
	  }, 500, function() {
	 		$("#retorno_erro").html('');
	 		$("#retorno_erro").css('display','block');
	});

	window.clearTimeout(timeoutID);
}

function coloca_mascara(objCampo, mascara) {
	switch(mascara) {
		//000.000.000-00
		case 'cpf':
			objCampo.value = somente_numero(objCampo.value);
			pri = objCampo.value.substring(0,3);
			seg = objCampo.value.substring(3,6);
			ter = objCampo.value.substring(6,9);
			qua = objCampo.value.substring(9,11);

			objCampo.value = pri+
			((seg!='') ? '.'+seg : '')+
			((ter!='') ? '.'+ter : '')+
			((qua!='') ? '-'+qua : '');
		break;

		//00.000.000/0000-00
		case 'cnpj':
			objCampo.value = somente_numero(objCampo.value);
			pri = objCampo.value.substring(0,2);
			seg = objCampo.value.substring(2,5);
			ter = objCampo.value.substring(5,8);
			qua = objCampo.value.substring(8,12);
			qui = objCampo.value.substring(12,14);

			objCampo.value = pri+
			((seg!='') ? '.'+seg : '')+
			((ter!='') ? '.'+ter : '')+
			((qua!='') ? '/'+qua : '')+
			((qui!='') ? '-'+qui : '');
		break;

		//(00) 0000-0000
		case 'telefone':
			objCampo.value = somente_numero(objCampo.value);

			pri = objCampo.value.substring(0,2);
			seg = objCampo.value.substring(2,6);
			ter = objCampo.value.substring(6,10);

			objCampo.value = ((pri!='') ? pri+'-' : '')+
			((seg!='') ? seg : '')+
			((ter!='') ? '.'+ter : '');
		break;

		case 'telefone2':
			objCampo.value = somente_numero(objCampo.value);

			pri = objCampo.value.substring(0,2);
			seg = objCampo.value.substring(2,7);
			ter = objCampo.value.substring(7,11);

			objCampo.value = ((pri!='') ? pri+'-' : '')+
			((seg!='') ? seg : '')+
			((ter!='') ? '.'+ter : '');
		break;

		//00000-000
		case 'cep':
			objCampo.value = somente_numero(objCampo.value);

			pri = objCampo.value.substring(0,5);
			seg = objCampo.value.substring(5,8);

			objCampo.value = pri+
			((seg!='') ? '-'+seg : '');
		break;

		//00/00/0000
		case 'data':
			objCampo.value = somente_numero(objCampo.value);

			pri = objCampo.value.substring(0,2);
			seg = objCampo.value.substring(2,4);
			ter = objCampo.value.substring(4,8);

			objCampo.value = pri+
			((seg!='') ? '/'+seg : '')+
			((ter!='') ? '/'+ter : '')
		break;

		//00/0000
		case 'venc_cartao':
			objCampo.value = somente_numero(objCampo.value);

			pri = objCampo.value.substring(0,2);
			seg = objCampo.value.substring(2,6);

			objCampo.value = pri+
			((seg!='') ? '/'+seg : '')
		break;

		//0000 0000 0000 0000
		case 'cartao':
			objCampo.value = somente_numero(objCampo.value);

			pri = objCampo.value.substring(0,4);
			seg = objCampo.value.substring(4,8);
			ter = objCampo.value.substring(8,12);
			qua = objCampo.value.substring(12,16);

			objCampo.value = pri+
			((seg!='') ? '-'+seg : '')+
			((ter!='') ? '-'+ter : '')+
			((qua!='') ? '-'+qua : '');
		break;

		case 'numero':
			objCampo.value = somente_numero(objCampo.value);
		break;

		case 'letra':
			objCampo.value = somente_letras(objCampo.value);
		break;

		//1.000.000.000.000,00
		case 'moeda':
			len = 20
			cur = objCampo
			n   = '0123456789';
			d   = objCampo.value;
			l   = d.length;
			r   = '';

			if ( l > 0 ) {
				z = d.substr(0,l);
				s = '';
				a = 0;

				for ( i=0; i < l; i++ ) {
					c = d.charAt(i);
					if ( n.indexOf(c) > a ) {
						a  = -1;
						s += c;
					};
				};
				l = s.length;
				t = len - 1;
				if ( l > t ) {
					l = t;
					s = s.substr(0,t);
				}
				if ( l > 2 ) {
					r = s.substr(0,l-2)+','+s.substr(l-2,2);
				}
				else {
					if ( l == 2 ) {
						r='0,'+s;
					}
					else {
						if ( l == 1 ) {
							r = '0,0'+s;
						}
					}
				}
				if ( r == '' ) {
					r = '0,00';
				}
				else {
					l=r.length;
					if (l > 6) {
						j  = l%3;
						w  = r.substr(0,j);
						wa = r.substr(j,l-j-6);
						wb = r.substr(l-6,6);
						if ( j > 0 )
						{
							w+='.';
						};
						k = (l-j)/3-2;
						for ( i=0; i < k; i++ )
						{
							w += wa.substr(i*3,3)+'.';
						};
						r = w + wb;
					}
				}
			}
			if ( cur.value.length == len || cur.value.length > len ) {
				cur.value = cur.value.substring(0 ,len);
				return false;
			}
			else {
				if ( r.length <= len ) {
					cur.value = r;
				}
				else {
					cur.value = z;
				};
			}
		break;
	}
}

function somente_numero(numero)
{
	var validos = "0123456789";
	var numero_ok = '';
	for(i = 0; i < numero.length; i++)
	{
		if(validos.indexOf(numero.substr(i,1)) != -1)
		{
			numero_ok += numero.substr(i,1);
		}
	}
	return numero_ok;
}

function somente_letras(letra) {
	var validos  = "_abcdefghijklmnopqrstuvxzywABCDEFGHIJKLMNOPQRSTUVXZYW ";
	var letra_ok = '';

	for(i = 0; i < letra.length; i++) {
		if(validos.indexOf(letra.substr(i,1)) != -1) {
			letra_ok += letra.substr(i,1);
		}
	}
	return letra_ok;
}