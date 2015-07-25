/**
 *
 * Arquivo de funções comuns aos Sites
 * Autor: BiTS - Business IT Solutions
 *
 */

//Funções que inicializam com o Site
var timeoutID = 0; 

$(document).ready(function(){

    //Url Padrão do Site
    base_url = base_url();

    //$('a[rel="facebox"]').facebox();
    
	$('.nyroModal').click(function(e) {
		e.preventDefault();
		$(this).nyroModalManual();
	});
	
	$("a[rel*='gallery']").click(function(e){
		e.preventDefault();
	});
	
     //Máscaras Javascript
    $('input:text').setMask();
    
    //Links para voltar à página anterior
    $('a[rel="voltar"]').click(function(){
        history.back();
        return false;
    });
    
    //Links para abrirem em uma página nova
    $('a[rel="externo"]').each(function(){
        $(this).attr('target','_blank');
    });

    //Validação de Somente Número
    $('.numero').each(function(){
        $(this).keypress(function(e){
            if(e.which!=8 && e.which!=0 && e.which!=46 && (e.which<48 || e.which>57)){
                return false;
            }
        });
    });

    //Validação de Somente Letras
    $('.letra').each(function(){
        $(this).keypress(function(e){
            if((e.which > 64 && e.which < 91) || (e.which > 96 && e.which < 123) || e.which == 8 || e.which == 0 || (e.which > 224 && e.which < 251)) {
                return true;
            } else {
                return false;
            }
        });
    });
    
    //Validação de Somente Letras
    $('.query').each(function(){
        $(this).keypress(function(e){
            if((e.which > 64 && e.which < 91) || (e.which > 96 && e.which < 123) || (e.which > 47 && e.which < 52) || e.which == 8 || e.which == 32 || e.which == 0 || e.which == 13 || (e.which > 224 && e.which < 251)) {
                return true;
            } else {
                return false;
            }
        });
    });
});

/**
 * Função que determina a URL Padrão do Site
 *
 * @return string
 */
function base_url(){

    baseUrl = '';

    if($('base').length > 0){
        baseUrl = $('base').attr('href');
    }

    return baseUrl;
}

/**
 * Função que calcula a altura da página
 *
 * @return int
 */
function getPageHeight(){

	var windowHeight

	if (self.innerHeight) {	// all except Explorer
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowHeight = document.body.clientHeight;
	}

	return windowHeight;
}

/**
 * Função que valida o CPF
 *
 * @return boolean
 *
 */
function checaCPF(CPF){
	if (CPF.charAt(3) == '.') {
		CPF = CPF.substr(0,3) + CPF.substr(4);
	}

	if (CPF.charAt(6) == '.') {
		CPF = CPF.substr(0,6) + CPF.substr(7);
	}

	if (CPF.charAt(9) == '-') {
		CPF = CPF.substr(0,9) + CPF.substr(10);
	}

	if (CPF.length != 11 || CPF == "00000000000" || CPF == "11111111111" ||
	CPF == "22222222222" || CPF == "33333333333" || CPF == "44444444444" ||
	CPF == "55555555555" || CPF == "66666666666" || CPF == "77777777777" ||
	CPF == "88888888888" || CPF == "99999999999")
		return false;

	soma = 0;
	for (i=0; i < 9; i ++)
		soma += parseInt(CPF.charAt(i)) * (10 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(9)))
		return false;
	soma = 0;
	for (i = 0; i < 10; i ++)
		soma += parseInt(CPF.charAt(i)) * (11 - i);
	resto = 11 - (soma % 11);
	if (resto == 10 || resto == 11)
		resto = 0;
	if (resto != parseInt(CPF.charAt(10)))
		return false;

	return true;
}

/**
 * Função que valida o CNPJ
 *
 * @return boolean
 *
 */
function checaCNPJ(cnpj){
	
	vr = cnpj;
	vr = vr.replace( "/", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( ",", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( "-", "" );
	vr = vr.replace( "-", "" );
	vr = vr.replace( "-", "" );
	vr = vr.replace( "-", "" );
	vr = vr.replace( "-", "" );
	cnpj = vr;
	
	var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
	digitos_iguais = 1;
	if (cnpj.length < 14 && cnpj.length < 15)
		return false;
	for (i = 0; i < cnpj.length - 1; i++)
		if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
			digitos_iguais = 0;
			break;
		}
		if (!digitos_iguais) {
			tamanho = cnpj.length - 2
			numeros = cnpj.substring(0,tamanho);
			digitos = cnpj.substring(tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--) {
				soma += numeros.charAt(tamanho - i) * pos--;
				if (pos < 2) 
					pos = 9;
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(0))
				return false;
			
			tamanho = tamanho + 1;
			numeros = cnpj.substring(0,tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--) {
				soma += numeros.charAt(tamanho - i) * pos--;
				if (pos < 2)
					pos = 9;
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(1))
				return false;
				return true;
		}
		else
			return false;
}

/**
 * Função Modal para Linklar
 * 
 */
$.showModal = function(titulo,url,settings) {
	var defaults = {
		classe: '',
		topo: '50',
		btn_close: true,
		width: '820',
		texto: '',
		textWait: 'carregando'
	}
	
	if (url != '') {
		createModal();
		addLoad();
		addAjaxContent();
	} else {
		createModal();
		close();
		btn_ok();
	}
	
	function addLoad() {
		$('#containerModal .contentModal .bodyModal').html('<div class="content_image"><img src="'+base_url+'views/img/bg/carregando.gif" class="imgLoad" /><br />'+settings.textWait+'</div>');
		$('#containerModal .contentModal .bodyModal .content_image').css('margin-top','50px').css('margin-bottom','50px');
	}
	
	function addAjaxContent() {
		$.ajax({
			type: "POST",
			url: url,
			success: function(msg){
				$('#containerModal .contentModal .bodyModal').html(msg);
				close();
				btn_ok();
			}
		});
	}
	
	function createModal() { 
		settings = $.extend(defaults, settings);
		
		//FIX SELECT IE6
		$('select').each(function() { 
			if($(this).css('display') != 'none') {
				$(this).addClass('selectOut');
			}
		});
			
		$('input').attr('readonly','readonly');
		
		if($('#containerModal').size() ) $('#containerModal').remove();
		
		// BASE HTML
		var content = '<div id="containerModal" class="'+settings.classe+'"> \
					   		<div class="contentModal"> \
					   			<div class="btn_close close">X</div> \
								<span class="title"></span> \
								<div class="bodyModal"></div> \
							</div> \
						</div>';
		$('body').append(content);
		
		if(settings.btn_close == false) 
			$('#containerModal .contentModal .close').remove();
		
		$('#containerModal .contentModal .title').html(titulo);
		$('#containerModal .contentModal .bodyModal').html(settings.texto);
		
		// ATRIBUICOES CSS
		if($.browser.msie && ($.browser.version == "6.0")) {	
			$('#containerModal').css('position','absolute');
			 var total = parseInt(getTopPage())+parseInt(settings.topo);
			$('#containerModal').css('top',total+'px');
			$(window).scroll(function () {
			    var total = parseInt(getTopPage())+parseInt(settings.topo);
			    $('#containerModal').css('top',total+'px');
			});
		} else {
			$('#containerModal').css('position','fixed').css('top',settings.topo+'px');
		}
		
		margin_left = parseInt(settings.width/2);
		$('#containerModal').css('width',settings.width+'px').css('height','auto');
		$('#containerModal').css('left','50%').css('margin-left','-'+margin_left+'px');
		$('#containerModal .contentModal').css('height','auto');
	}
	
	function close() {
		//BTN_CLOSE
		$('#containerModal .close').each(function() { 
			$(this).click(function() {
				$('#containerModal').remove();
				
				//FIX SELECT
				$('select').each(function() { 
					$(this).removeClass('selectOut');
				});
				
				$('input').attr('readonly','');
				return false;
			});
		});
	}
	
	function btn_ok() {
		//BTN_OK
		$('#containerModal .ok').each(function() { 
			$(this).click(function() {
				//FIX SELECT IE6
				$('select').each(function() { 
					if($(this).is('.selectOut')) {
						$(this).removeClass('selectOut');
					}
				});
			});
		});
	}
	
	function getTopPage() {
		if (self.pageYOffset) {
	      yScroll = self.pageYOffset;
	    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
	      yScroll = document.documentElement.scrollTop;
	    } else if (document.body) {// all other Explorers
	      yScroll = document.body.scrollTop;
	    }
	    return yScroll;
	}
}

/**
 * Função extendida de URLEncode
 *
 * http://www.meiocodigo.com/projects/meiomask/
 *
 */
$.extend({
	URLEncode:function(c){var o='';var x=0;c=c.toString();var r=/(^[a-zA-Z0-9_.]*)/;while(x<c.length){var m=r.exec(c.substr(x));if(m!=null && m.length>1 && m[1]!=''){o+=m[1];x+=m[1].length;}else{if(c[x]==' ')o+='+';else{var d=c.charCodeAt(x);var h=d.toString(16);o+='%'+(h.length<2?'0':'')+h.toUpperCase();}x++;}}return o;},
	URLDecode:function(s){var o=s;var binVal,t;var r=/(%[^%]{2})/;while((m=r.exec(o))!=null && m.length>1 && m[1]!=''){b=parseInt(m[1].substr(1),16);t=String.fromCharCode(b);o=o.replace(m[1],t);}return o;}
});

/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "stylish-select"
 * Version: 1.1, 11.09.2007
 * by reweb
 *
 * Copyright (c) 2010
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
(function(a){a("html").addClass("stylish-select");Array.prototype.indexOf=function(c,d){for(var b=(d||0);b<this.length;b++){if(this[b]==c){return b}}};a.fn.extend({getSetSSValue:function(b){if(b){a(this).val(b).change();return this}else{return a(this).find(":selected").val()}},resetSS:function(){var b=a(this).data("ssOpts");$this=a(this);$this.next().remove();$this.unbind(".sSelect").sSelect(b)}});a.fn.sSelect=function(b){return this.each(function(){var i={defaultText:"Please select",animationSpeed:0,ddMaxHeight:"",containerClass:""};var l=a.extend(i,b),e=a(this),j=a('<div class="selectedTxt"></div>'),r=a('<div class="newListSelected '+l.containerClass+'"></div>'),z=a('<ul class="newList" style="visibility:hidden;"></ul>'),t=-1,d=-1,m=[],w=false,v=false,x;a(this).data("ssOpts",b);r.insertAfter(e);r.attr("tabindex",e.attr("tabindex")||"0");j.prependTo(r);z.appendTo(r);e.hide();j.data("ssReRender",!j.is(":visible"));if(e.children("optgroup").length==0){e.children().each(function(B){var C=a(this).html();var A=a(this).val();m.push(C.charAt(0).toLowerCase());if(a(this).attr("selected")==true){l.defaultText=C;d=B}z.append(a('<li><a href="JavaScript:void(0);">'+C+"</a></li>").data("key",A))});x=z.children().children()}else{e.children("optgroup").each(function(){var A=a(this).attr("label"),C=a('<li class="newListOptionTitle">'+A+"</li>");C.appendTo(z);var B=a("<ul></ul>");B.appendTo(C);a(this).children().each(function(){++t;var E=a(this).html();var D=a(this).val();m.push(E.charAt(0).toLowerCase());if(a(this).attr("selected")==true){l.defaultText=E;d=t}B.append(a('<li><a href="JavaScript:void(0);">'+E+"</a></li>").data("key",D))})});x=z.find("ul li a")}var o=z.height(),n=r.height(),y=x.length;if(d!=-1){h(d,true)}else{j.text(l.defaultText)}function p(){var B=r.offset().top,A=jQuery(window).height(),C=jQuery(window).scrollTop();if(o>parseInt(l.ddMaxHeight)){o=parseInt(l.ddMaxHeight)}B=B-C;if(B+o>=A){z.css({top:"-"+o+"px",height:o});e.onTop=true}else{z.css({top:n+"px",height:o});e.onTop=false}}p();a(window).bind("resize.sSelect scroll.sSelect",p);function s(){r.css("position","relative")}function c(){r.css("position","static")}j.bind("click.sSelect",function(A){A.stopPropagation();if(a(this).data("ssReRender")){o=z.height("").height();n=r.height();a(this).data("ssReRender",false);p()}a(".newList").not(a(this).next()).hide().parent().css("position","static").removeClass("newListSelFocus");z.toggle();s();x.eq(d).focus()});x.bind("click.sSelect",function(B){var A=a(B.target);d=x.index(A);v=true;h(d);z.hide();r.css("position","static")});x.bind("mouseenter.sSelect",function(B){var A=a(B.target);A.addClass("newListHover")}).bind("mouseleave.sSelect",function(B){var A=a(B.target);A.removeClass("newListHover")});function h(A,E){x.removeClass("hiLite").eq(A).addClass("hiLite");if(z.is(":visible")){x.eq(A).focus()}var D=x.eq(A).html();var C=x.eq(A).parent().data("key");if(E==true){e.val(C);j.text(D);return false}try{e.val(C)}catch(B){e[0].selectedIndex=A}e.change();j.text(D)}e.bind("change.sSelect",function(A){$targetInput=a(A.target);if(v==true){v=false;return false}$currentOpt=$targetInput.find(":selected");d=$targetInput.find("option").index($currentOpt);h(d,true)});function q(A){a(A).unbind("keydown.sSelect").bind("keydown.sSelect",function(D){var C=D.which;v=true;switch(C){case 40:case 39:u();return false;break;case 38:case 37:k();return false;break;case 33:case 36:g();return false;break;case 34:case 35:f();return false;break;case 13:case 27:z.hide();c();return false;break}keyPressed=String.fromCharCode(C).toLowerCase();var B=m.indexOf(keyPressed);if(typeof B!="undefined"){++d;d=m.indexOf(keyPressed,d);if(d==-1||d==null||w!=keyPressed){d=m.indexOf(keyPressed)}h(d);w=keyPressed;return false}})}function u(){if(d<(y-1)){++d;h(d)}}function k(){if(d>0){--d;h(d)}}function g(){d=0;h(d)}function f(){d=y-1;h(d)}r.bind("click.sSelect",function(A){A.stopPropagation();q(this)});r.bind("focus.sSelect",function(){a(this).addClass("newListSelFocus");q(this)});r.bind("blur.sSelect",function(){a(this).removeClass("newListSelFocus")});a(document).bind("click.sSelect",function(){r.removeClass("newListSelFocus");z.hide();c()});j.bind("mouseenter.sSelect",function(B){var A=a(B.target);A.parent().addClass("newListSelHover")}).bind("mouseleave.sSelect",function(B){var A=a(B.target);A.parent().removeClass("newListSelHover")});z.css({left:"0",display:"none",visibility:"visible"})})}})(jQuery);

/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "captalize"
 * Version: 1.1, 11.09.2007
 * by reweb
 *
 * Copyright (c) 2010
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
 (function($){jQuery.fn.capitalize=function(options){var defaults={capitalize_on:'keyup'};var opts=$.extend(defaults,options);this.each(function(){jQuery(this).bind(defaults.capitalize_on,function(){jQuery(this).val(jQuery.cap(jQuery(this).val()));});});}})(jQuery);jQuery.cap=function capitalizeTxt(txt){txt=txt.toLowerCase();var split_txt=txt.split(' ');var result='';for(var i=0;i<split_txt.length;i++){result=result.concat(' '+split_txt[i].substring(0,1).toUpperCase()+split_txt[i].substring(1,split_txt[i].length));}return result.substring(1,result.length);};

/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "watermark"
 * Version: 1.1, 11.09.2007
 * by bits
 *
 * Copyright (c) 2009
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
watermark = {
	init:function(){
		$('input.watermark[type="text"], input.watermark[type="password"], textarea.watermark').focus(
			function(){
				watermark.focus($(this))
		}).blur(
			function(){
				watermark.blur($(this))
		}).each(function(){
			if($(this).attr("type") == 'password') {
				$(this).addClass('watermarkPass');
			} else
				$(this).attr("title",$(this).val()
		)}
	)}
	,focus:function(a){
		val=$(a).val();
		if($(a).val()==$(a).attr("title")) {
			$(a).val("");
			$(a).attr("alt",val);
			if($(a).attr("type") == 'password')
				$(a).removeClass('watermarkPass');
		} 
	}
	,blur:function(a){
		val=$(a).attr("alt");
		if($(a).val()=="") {
			$(a).val(val);
			$(a).attr("alt","");
			if($(a).attr("type") == 'password')
				$(a).addClass('watermarkPass');
		}
	}
};

/**
 * --------------------------------------------------------------------
 * jQuery-Plugin "pngFix"
 * Version: 1.1, 11.09.2007
 * by Andreas Eberhard, andreas.eberhard@gmail.com
 *                      http://jquery.andreaseberhard.de/
 *
 * Copyright (c) 2007 Andreas Eberhard
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
eval(function(p,a,c,k,e,r){e=function(c){return(c<62?'':e(parseInt(c/62)))+((c=c%62)>35?String.fromCharCode(c+29):c.toString(36))};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'([237-9n-zA-Z]|1\\w)'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(s(m){3.fn.pngFix=s(c){c=3.extend({P:\'blank.gif\'},c);8 e=(o.Q=="t R S"&&T(o.u)==4&&o.u.A("U 5.5")!=-1);8 f=(o.Q=="t R S"&&T(o.u)==4&&o.u.A("U 6.0")!=-1);p(3.browser.msie&&(e||f)){3(2).B("img[n$=.C]").D(s(){3(2).7(\'q\',3(2).q());3(2).7(\'r\',3(2).r());8 a=\'\';8 b=\'\';8 g=(3(2).7(\'E\'))?\'E="\'+3(2).7(\'E\')+\'" \':\'\';8 h=(3(2).7(\'F\'))?\'F="\'+3(2).7(\'F\')+\'" \':\'\';8 i=(3(2).7(\'G\'))?\'G="\'+3(2).7(\'G\')+\'" \':\'\';8 j=(3(2).7(\'H\'))?\'H="\'+3(2).7(\'H\')+\'" \':\'\';8 k=(3(2).7(\'V\'))?\'float:\'+3(2).7(\'V\')+\';\':\'\';8 d=(3(2).parent().7(\'href\'))?\'cursor:hand;\':\'\';p(2.9.v){a+=\'v:\'+2.9.v+\';\';2.9.v=\'\'}p(2.9.w){a+=\'w:\'+2.9.w+\';\';2.9.w=\'\'}p(2.9.x){a+=\'x:\'+2.9.x+\';\';2.9.x=\'\'}8 l=(2.9.cssText);b+=\'<y \'+g+h+i+j;b+=\'9="W:X;white-space:pre-line;Y:Z-10;I:transparent;\'+k+d;b+=\'q:\'+3(2).q()+\'z;r:\'+3(2).r()+\'z;\';b+=\'J:K:L.t.M(n=\\\'\'+3(2).7(\'n\')+\'\\\', N=\\\'O\\\');\';b+=l+\'"></y>\';p(a!=\'\'){b=\'<y 9="W:X;Y:Z-10;\'+a+d+\'q:\'+3(2).q()+\'z;r:\'+3(2).r()+\'z;">\'+b+\'</y>\'}3(2).hide();3(2).after(b)});3(2).B("*").D(s(){8 a=3(2).11(\'I-12\');p(a.A(".C")!=-1){8 b=a.13(\'url("\')[1].13(\'")\')[0];3(2).11(\'I-12\',\'none\');3(2).14(0).15.J="K:L.t.M(n=\'"+b+"\',N=\'O\')"}});3(2).B("input[n$=.C]").D(s(){8 a=3(2).7(\'n\');3(2).14(0).15.J=\'K:L.t.M(n=\\\'\'+a+\'\\\', N=\\\'O\\\');\';3(2).7(\'n\',c.P)})}return 3}})(3);',[],68,'||this|jQuery||||attr|var|style||||||||||||||src|navigator|if|width|height|function|Microsoft|appVersion|border|padding|margin|span|px|indexOf|find|png|each|id|class|title|alt|background|filter|progid|DXImageTransform|AlphaImageLoader|sizingMethod|scale|blankgif|appName|Internet|Explorer|parseInt|MSIE|align|position|relative|display|inline|block|css|image|split|get|runtimeStyle'.split('|'),0,{}))

/*
 * jQuery Autocomplete plugin 1.1
 *
 * Copyright (c) 2009 Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id: jquery.autocomplete.js 15 2009-08-22 10:30:27Z joern.zaefferer $
 */;(function($){$.fn.extend({autocomplete:function(urlOrData,options){var isUrl=typeof urlOrData=="string";options=$.extend({},$.Autocompleter.defaults,{url:isUrl?urlOrData:null,data:isUrl?null:urlOrData,delay:isUrl?$.Autocompleter.defaults.delay:10,max:options&&!options.scroll?10:150},options);options.highlight=options.highlight||function(value){return value;};options.formatMatch=options.formatMatch||options.formatItem;return this.each(function(){new $.Autocompleter(this,options);});},result:function(handler){return this.bind("result",handler);},search:function(handler){return this.trigger("search",[handler]);},flushCache:function(){return this.trigger("flushCache");},setOptions:function(options){return this.trigger("setOptions",[options]);},unautocomplete:function(){return this.trigger("unautocomplete");}});$.Autocompleter=function(input,options){var KEY={UP:38,DOWN:40,DEL:46,TAB:9,RETURN:13,ESC:27,COMMA:188,PAGEUP:33,PAGEDOWN:34,BACKSPACE:8};var $input=$(input).attr("autocomplete","off").addClass(options.inputClass);var timeout;var previousValue="";var cache=$.Autocompleter.Cache(options);var hasFocus=0;var lastKeyPressCode;var config={mouseDownOnSelect:false};var select=$.Autocompleter.Select(options,input,selectCurrent,config);var blockSubmit;$.browser.opera&&$(input.form).bind("submit.autocomplete",function(){if(blockSubmit){blockSubmit=false;return false;}});$input.bind(($.browser.opera?"keypress":"keydown")+".autocomplete",function(event){hasFocus=1;lastKeyPressCode=event.keyCode;switch(event.keyCode){case KEY.UP:event.preventDefault();if(select.visible()){select.prev();}else{onChange(0,true);}break;case KEY.DOWN:event.preventDefault();if(select.visible()){select.next();}else{onChange(0,true);}break;case KEY.PAGEUP:event.preventDefault();if(select.visible()){select.pageUp();}else{onChange(0,true);}break;case KEY.PAGEDOWN:event.preventDefault();if(select.visible()){select.pageDown();}else{onChange(0,true);}break;case options.multiple&&$.trim(options.multipleSeparator)==","&&KEY.COMMA:case KEY.TAB:case KEY.RETURN:if(selectCurrent()){event.preventDefault();blockSubmit=true;return false;}break;case KEY.ESC:select.hide();break;default:clearTimeout(timeout);timeout=setTimeout(onChange,options.delay);break;}}).focus(function(){hasFocus++;}).blur(function(){hasFocus=0;if(!config.mouseDownOnSelect){hideResults();}}).click(function(){if(hasFocus++>1&&!select.visible()){onChange(0,true);}}).bind("search",function(){var fn=(arguments.length>1)?arguments[1]:null;function findValueCallback(q,data){var result;if(data&&data.length){for(var i=0;i<data.length;i++){if(data[i].result.toLowerCase()==q.toLowerCase()){result=data[i];break;}}}if(typeof fn=="function")fn(result);else $input.trigger("result",result&&[result.data,result.value]);}$.each(trimWords($input.val()),function(i,value){request(value,findValueCallback,findValueCallback);});}).bind("flushCache",function(){cache.flush();}).bind("setOptions",function(){$.extend(options,arguments[1]);if("data"in arguments[1])cache.populate();}).bind("unautocomplete",function(){select.unbind();$input.unbind();$(input.form).unbind(".autocomplete");});function selectCurrent(){var selected=select.selected();if(!selected)return false;var v=selected.result;previousValue=v;if(options.multiple){var words=trimWords($input.val());if(words.length>1){var seperator=options.multipleSeparator.length;var cursorAt=$(input).selection().start;var wordAt,progress=0;$.each(words,function(i,word){progress+=word.length;if(cursorAt<=progress){wordAt=i;return false;}progress+=seperator;});words[wordAt]=v;v=words.join(options.multipleSeparator);}v+=options.multipleSeparator;}$input.val(v);hideResultsNow();$input.trigger("result",[selected.data,selected.value]);return true;}function onChange(crap,skipPrevCheck){if(lastKeyPressCode==KEY.DEL){select.hide();return;}var currentValue=$input.val();if(!skipPrevCheck&&currentValue==previousValue)return;previousValue=currentValue;currentValue=lastWord(currentValue);if(currentValue.length>=options.minChars){$input.addClass(options.loadingClass);if(!options.matchCase)currentValue=currentValue.toLowerCase();request(currentValue,receiveData,hideResultsNow);}else{stopLoading();select.hide();}};function trimWords(value){if(!value)return[""];if(!options.multiple)return[$.trim(value)];return $.map(value.split(options.multipleSeparator),function(word){return $.trim(value).length?$.trim(word):null;});}function lastWord(value){if(!options.multiple)return value;var words=trimWords(value);if(words.length==1)return words[0];var cursorAt=$(input).selection().start;if(cursorAt==value.length){words=trimWords(value)}else{words=trimWords(value.replace(value.substring(cursorAt),""));}return words[words.length-1];}function autoFill(q,sValue){if(options.autoFill&&(lastWord($input.val()).toLowerCase()==q.toLowerCase())&&lastKeyPressCode!=KEY.BACKSPACE){$input.val($input.val()+sValue.substring(lastWord(previousValue).length));$(input).selection(previousValue.length,previousValue.length+sValue.length);}};function hideResults(){clearTimeout(timeout);timeout=setTimeout(hideResultsNow,200);};function hideResultsNow(){var wasVisible=select.visible();select.hide();clearTimeout(timeout);stopLoading();if(options.mustMatch){$input.search(function(result){if(!result){if(options.multiple){var words=trimWords($input.val()).slice(0,-1);$input.val(words.join(options.multipleSeparator)+(words.length?options.multipleSeparator:""));}else{$input.val("");$input.trigger("result",null);}}});}};function receiveData(q,data){if(data&&data.length&&hasFocus){stopLoading();select.display(data,q);autoFill(q,data[0].value);select.show();}else{hideResultsNow();}};function request(term,success,failure){if(!options.matchCase)term=term.toLowerCase();var data=cache.load(term);if(data&&data.length){success(term,data);}else if((typeof options.url=="string")&&(options.url.length>0)){var extraParams={timestamp:+new Date()};$.each(options.extraParams,function(key,param){extraParams[key]=typeof param=="function"?param():param;});$.ajax({mode:"abort",port:"autocomplete"+input.name,dataType:options.dataType,url:options.url,data:$.extend({q:lastWord(term),limit:options.max},extraParams),success:function(data){var parsed=options.parse&&options.parse(data)||parse(data);cache.add(term,parsed);success(term,parsed);}});}else{select.emptyList();failure(term);}};function parse(data){var parsed=[];var rows=data.split("\n");for(var i=0;i<rows.length;i++){var row=$.trim(rows[i]);if(row){row=row.split("|");parsed[parsed.length]={data:row,value:row[0],result:options.formatResult&&options.formatResult(row,row[0])||row[0]};}}return parsed;};function stopLoading(){$input.removeClass(options.loadingClass);};};$.Autocompleter.defaults={inputClass:"ac_input",resultsClass:"ac_results",loadingClass:"ac_loading",minChars:1,delay:400,matchCase:false,matchSubset:true,matchContains:false,cacheLength:10,max:100,mustMatch:false,extraParams:{},selectFirst:true,formatItem:function(row){return row[0];},formatMatch:null,autoFill:false,width:0,multiple:false,multipleSeparator:", ",highlight:function(value,term){return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>");},scroll:true,scrollHeight:180};$.Autocompleter.Cache=function(options){var data={};var length=0;function matchSubset(s,sub){if(!options.matchCase)s=s.toLowerCase();var i=s.indexOf(sub);if(options.matchContains=="word"){i=s.toLowerCase().search("\\b"+sub.toLowerCase());}if(i==-1)return false;return i==0||options.matchContains;};function add(q,value){if(length>options.cacheLength){flush();}if(!data[q]){length++;}data[q]=value;}function populate(){if(!options.data)return false;var stMatchSets={},nullData=0;if(!options.url)options.cacheLength=1;stMatchSets[""]=[];for(var i=0,ol=options.data.length;i<ol;i++){var rawValue=options.data[i];rawValue=(typeof rawValue=="string")?[rawValue]:rawValue;var value=options.formatMatch(rawValue,i+1,options.data.length);if(value===false)continue;var firstChar=value.charAt(0).toLowerCase();if(!stMatchSets[firstChar])stMatchSets[firstChar]=[];var row={value:value,data:rawValue,result:options.formatResult&&options.formatResult(rawValue)||value};stMatchSets[firstChar].push(row);if(nullData++<options.max){stMatchSets[""].push(row);}};$.each(stMatchSets,function(i,value){options.cacheLength++;add(i,value);});}setTimeout(populate,25);function flush(){data={};length=0;}return{flush:flush,add:add,populate:populate,load:function(q){if(!options.cacheLength||!length)return null;if(!options.url&&options.matchContains){var csub=[];for(var k in data){if(k.length>0){var c=data[k];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub.push(x);}});}}return csub;}else
if(data[q]){return data[q];}else
if(options.matchSubset){for(var i=q.length-1;i>=options.minChars;i--){var c=data[q.substr(0,i)];if(c){var csub=[];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub[csub.length]=x;}});return csub;}}}return null;}};};$.Autocompleter.Select=function(options,input,select,config){var CLASSES={ACTIVE:"ac_over"};var listItems,active=-1,data,term="",needsInit=true,element,list;function init(){if(!needsInit)return;element=$("<div/>").hide().addClass(options.resultsClass).css("position","absolute").appendTo(document.body);list=$("<ul/>").appendTo(element).mouseover(function(event){if(target(event).nodeName&&target(event).nodeName.toUpperCase()=='LI'){active=$("li",list).removeClass(CLASSES.ACTIVE).index(target(event));$(target(event)).addClass(CLASSES.ACTIVE);}}).click(function(event){$(target(event)).addClass(CLASSES.ACTIVE);select();input.focus();return false;}).mousedown(function(){config.mouseDownOnSelect=true;}).mouseup(function(){config.mouseDownOnSelect=false;});if(options.width>0)element.css("width",options.width);needsInit=false;}function target(event){var element=event.target;while(element&&element.tagName!="LI")element=element.parentNode;if(!element)return[];return element;}function moveSelect(step){listItems.slice(active,active+1).removeClass(CLASSES.ACTIVE);movePosition(step);var activeItem=listItems.slice(active,active+1).addClass(CLASSES.ACTIVE);if(options.scroll){var offset=0;listItems.slice(0,active).each(function(){offset+=this.offsetHeight;});if((offset+activeItem[0].offsetHeight-list.scrollTop())>list[0].clientHeight){list.scrollTop(offset+activeItem[0].offsetHeight-list.innerHeight());}else if(offset<list.scrollTop()){list.scrollTop(offset);}}};function movePosition(step){active+=step;if(active<0){active=listItems.size()-1;}else if(active>=listItems.size()){active=0;}}function limitNumberOfItems(available){return options.max&&options.max<available?options.max:available;}function fillList(){list.empty();var max=limitNumberOfItems(data.length);for(var i=0;i<max;i++){if(!data[i])continue;var formatted=options.formatItem(data[i].data,i+1,max,data[i].value,term);if(formatted===false)continue;var li=$("<li/>").html(options.highlight(formatted,term)).addClass(i%2==0?"ac_even":"ac_odd").appendTo(list)[0];$.data(li,"ac_data",data[i]);}listItems=list.find("li");if(options.selectFirst){listItems.slice(0,1).addClass(CLASSES.ACTIVE);active=0;}if($.fn.bgiframe)list.bgiframe();}return{display:function(d,q){init();data=d;term=q;fillList();},next:function(){moveSelect(1);},prev:function(){moveSelect(-1);},pageUp:function(){if(active!=0&&active-8<0){moveSelect(-active);}else{moveSelect(-8);}},pageDown:function(){if(active!=listItems.size()-1&&active+8>listItems.size()){moveSelect(listItems.size()-1-active);}else{moveSelect(8);}},hide:function(){element&&element.hide();listItems&&listItems.removeClass(CLASSES.ACTIVE);active=-1;},visible:function(){return element&&element.is(":visible");},current:function(){return this.visible()&&(listItems.filter("."+CLASSES.ACTIVE)[0]||options.selectFirst&&listItems[0]);},show:function(){var offset=$(input).offset();element.css({width:typeof options.width=="string"||options.width>0?options.width:$(input).width(),top:offset.top+input.offsetHeight,left:offset.left}).show();if(options.scroll){list.scrollTop(0);list.css({maxHeight:options.scrollHeight,overflow:'auto'});if($.browser.msie&&typeof document.body.style.maxHeight==="undefined"){var listHeight=0;listItems.each(function(){listHeight+=this.offsetHeight;});var scrollbarsVisible=listHeight>options.scrollHeight;list.css('height',scrollbarsVisible?options.scrollHeight:listHeight);if(!scrollbarsVisible){listItems.width(list.width()-parseInt(listItems.css("padding-left"))-parseInt(listItems.css("padding-right")));}}}},selected:function(){var selected=listItems&&listItems.filter("."+CLASSES.ACTIVE).removeClass(CLASSES.ACTIVE);return selected&&selected.length&&$.data(selected[0],"ac_data");},emptyList:function(){list&&list.empty();},unbind:function(){element&&element.remove();}};};$.fn.selection=function(start,end){if(start!==undefined){return this.each(function(){if(this.createTextRange){var selRange=this.createTextRange();if(end===undefined||start==end){selRange.move("character",start);selRange.select();}else{selRange.collapse(true);selRange.moveStart("character",start);selRange.moveEnd("character",end);selRange.select();}}else if(this.setSelectionRange){this.setSelectionRange(start,end);}else if(this.selectionStart){this.selectionStart=start;this.selectionEnd=end;}});}var field=this[0];if(field.createTextRange){var range=document.selection.createRange(),orig=field.value,teststring="<->",textLength=range.text.length;range.text=teststring;var caretAt=field.value.indexOf(teststring);field.value=orig;this.selection(caretAt,caretAt+textLength);return{start:caretAt,end:caretAt+textLength}}else if(field.selectionStart!==undefined){return{start:field.selectionStart,end:field.selectionEnd}}};})(jQuery);

/**
 * Função máscara javascript para inputs
 *
 * http://www.meiocodigo.com/projects/meiomask/
 *
 */
(function(B){var A=(window.orientation!=undefined);B.extend({mask:{rules:{"z":/[a-z]/,"Z":/[A-Z]/,"a":/[a-zA-Z]/,"*":/[0-9a-zA-Z]/,"@":/[0-9a-zA-ZÃƒÆ’Ã‚Â§ÃƒÆ’Ã¢â‚¬Â¡ÃƒÆ’Ã‚Â¡ÃƒÆ’ ÃƒÆ’Ã‚Â£ÃƒÆ’Ã‚Â©ÃƒÆ’Ã‚Â¨ÃƒÆ’Ã‚Â­ÃƒÆ’Ã‚Â¬ÃƒÆ’Ã‚Â³ÃƒÆ’Ã‚Â²ÃƒÆ’Ã‚ÂµÃƒÆ’Ã‚ÂºÃƒÆ’Ã‚Â¹ÃƒÆ’Ã‚Â¼]/},fixedChars:"[(),.:/ -]",keyRepresentation:{8:"backspace",9:"tab",13:"enter",27:"esc",37:"left",38:"up",39:"right",40:"down",46:"delete"},ignoreKeys:[8,9,13,16,17,18,27,33,34,35,36,37,38,39,40,45,46,91,116],iphoneIgnoreKeys:[10,127],signals:["+","-"],options:{attr:"mask",mask:null,type:"fixed",defaultValue:"",signal:false,onInvalid:function(){},onValid:function(){},onOverflow:function(){}},masks:{"phone":{mask:"9999-9999"},"phone-br":{mask:"99 9999-9999"},"phone-us":{mask:"(999) 9999-9999"},"cpf":{mask:"999.999.999-99"},"cnpj":{mask:"99.999.999/9999-99"},"date":{mask:"39/19/9999"},"hour":{mask:"24:60"},"date-us":{mask:"19/39/9999"},"date-cc":{mask:"39/9999"},"cep":{mask:"99999-999"},"hour":{mask:"29:69"},"cc":{mask:"9999 9999 9999 9999"},"integer":{mask:"999.999.999.999",type:"reverse"},"decimal":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"000"},"decimal-us":{mask:"99.999,999,999,999",type:"reverse",defaultValue:"000"},"signed-decimal":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"+000"},"signed-decimal-us":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"+000"}},init:function(){if(!this.hasInit){var C;this.ignore=false;this.fixedCharsReg=new RegExp(this.fixedChars);this.fixedCharsRegG=new RegExp(this.fixedChars,"g");for(C=0;C<=9;C++){this.rules[C]=new RegExp("[0-"+C+"]")}this.hasInit=true}},set:function(G,D){var C=this,E=B(G),F="maxLength";this.init();return E.each(function(){var N=B(this),O=B.extend({},C.options),M=N.attr(O.attr),H="",J=C.__getPasteEvent();H=(typeof D=="string")?D:(M!="")?M:null;if(H){O.mask=H}if(C.masks[H]){O=B.extend(O,C.masks[H])}if(typeof D=="object"){O=B.extend(O,D)}if(B.metadata){O=B.extend(O,N.metadata())}if(O.mask!=null){if(N.data("mask")){C.unset(N)}var I=O.defaultValue,L=N.attr(F),K=(O.type=="reverse");O=B.extend({},O,{maxlength:L,maskArray:O.mask.split(""),maskNonFixedCharsArray:O.mask.replace(C.fixedCharsRegG,"").split(""),defaultValue:I.split("")});if(K){N.css("text-align","right")}if(N.val()!=""){N.val(C.string(N.val(),O))}else{if(I!=""){N.val(C.string(I,O))}}N.data("mask",O);N.removeAttr(F);N.bind("keydown",{func:C._keyDown,thisObj:C},C._onMask).bind("keyup",{func:C._keyUp,thisObj:C},C._onMask).bind("keypress",{func:C._keyPress,thisObj:C},C._onMask).bind(J,{func:C._paste,thisObj:C},C._delayedOnMask)}})},unset:function(D){var C=B(D),E=this;return C.each(function(){var H=B(this);if(H.data("mask")){var F=H.data("mask").maxlength,G=E.__getPasteEvent();if(F!=-1){H.attr("maxLength",F)}H.unbind("keydown",E._onMask).unbind("keypress",E._onMask).unbind("keyup",E._onMask).unbind(G,E._delayedOnMask).removeData("mask")}})},string:function(F,D){this.init();var E={};if(typeof F!="string"){F=String(F)}switch(typeof D){case"string":if(this.masks[D]){E=B.extend(E,this.masks[D])}else{E.mask=D}break;case"object":E=D;break}var C=(E.type=="reverse");this._insertSignal(C,F,E);return this.__maskArray(F.split(""),E.mask.replace(this.fixedCharsRegG,"").split(""),E.mask.split(""),C,E.defaultValue,E.signal)},_onMask:function(C){var E=C.data.thisObj,D={};D._this=C.target;D.$this=B(D._this);if(D.$this.attr("readonly")){return true}D.value=D.$this.val();D.nKey=E.__getKeyNumber(C);D.range=E.__getRangePosition(D._this);D.valueArray=D.value.split("");D.data=D.$this.data("mask");D.reverse=(D.data.type=="reverse");return C.data.func.call(E,C,D)},_delayedOnMask:function(C){C.type="paste";setTimeout(function(){C.data.thisObj._onMask(C)},1)},_keyDown:function(D,E){var C=A?this.iphoneIgnoreKeys:this.ignoreKeys;this.ignore=(B.inArray(E.nKey,C)>-1);if(this.ignore){E.data.onValid.call(E._this,this.keyRepresentation[E.nKey]?this.keyRepresentation[E.nKey]:"",E.nKey)}return A?this._keyPress(D,E):true},_keyUp:function(C,D){if(D.nKey==9&&(B.browser.safari||B.browser.msie)){return true}return this._paste(C,D)},_paste:function(D,E){this._changeSignal(D.type,E);var C=this.__maskArray(E.valueArray,E.data.maskNonFixedCharsArray,E.data.maskArray,E.reverse,E.data.defaultValue,E.data.signal);E.$this.val(C);if(!E.reverse&&E.data.defaultValue.length&&(E.range.start==E.range.end)){this.__setRange(E._this,E.range.start,E.range.end)}return true},_keyPress:function(J,C){if(this.ignore||J.ctrlKey||J.metaKey||J.altKey){return true}this._changeSignal(J.type,C);var K=String.fromCharCode(C.nKey),M=C.range.start,G=C.value,E=C.data.maskArray;if(C.reverse){var F=G.substr(0,M),I=G.substr(C.range.end,G.length);G=(F+K+I);if(C.data.signal&&(M-C.data.signal.length>0)){M-=C.data.signal.length}}var L=G.replace(this.fixedCharsRegG,"").split(""),D=this.__extraPositionsTill(M,E);C.rsEp=M+D;if(!this.rules[E[C.rsEp]]){C.data.onOverflow.call(C._this,K,C.nKey);return false}else{if(!this.rules[E[C.rsEp]].test(K)){C.data.onInvalid.call(C._this,K,C.nKey);return false}else{C.data.onValid.call(C._this,K,C.nKey)}}var H=this.__maskArray(L,C.data.maskNonFixedCharsArray,E,C.reverse,C.data.defaultValue,C.data.signal,D);C.$this.val(H);return(C.reverse)?this._keyPressReverse(J,C):this._keyPressFixed(J,C)},_keyPressFixed:function(C,D){if(D.range.start==D.range.end){if((D.rsEp==0&&D.value.length==0)||D.rsEp<D.value.length){this.__setRange(D._this,D.rsEp,D.rsEp+1)}}else{this.__setRange(D._this,D.range.start,D.range.end)}return true},_keyPressReverse:function(C,D){if(B.browser.msie&&((D.rangeStart==0&&D.range.end==0)||D.rangeStart!=D.range.end)){this.__setRange(D._this,D.value.length)}return false},_setMaskData:function(F,C,E){var D=F.data("mask");D[C]=E;F.data("mask",D)},_changeSignal:function(D,E){if(E.data.signal!==false){var C=(D=="paste")?E.value.substr(0,1):String.fromCharCode(E.nKey);if(B.inArray(C,this.signals)>-1){if(C=="+"){C=""}this._setMaskData(E.$this,"signal",C);E.data.signal=C}}},_insertSignal:function(C,F,E){if(C&&E.defaultValue){if(typeof E.defaultValue=="string"){E.defaultValue=E.defaultValue.split("")}if(B.inArray(E.defaultValue[0],this.signals)>-1){var D=F.substr(0,1);E.signal=(B.inArray(D,this.signals)>-1)?D:E.defaultValue[0];if(E.signal=="+"){E.signal=""}E.defaultValue.shift()}}},__getPasteEvent:function(){return(B.browser.opera||(B.browser.mozilla&&parseFloat(B.browser.version.substr(0,3))<1.9))?"input":"paste"},__getKeyNumber:function(C){return(C.charCode||C.keyCode||C.which)},__maskArray:function(H,G,E,D,C,I,F){if(D){H.reverse()}H=this.__removeInvalidChars(H,G);if(C){H=this.__applyDefaultValue.call(H,C)}H=this.__applyMask(H,E,F);if(D){H.reverse();if(!I||I=="+"){I=""}return I+H.join("").substring(H.length-E.length)}else{return H.join("").substring(0,E.length)}},__applyDefaultValue:function(E){var C=E.length,D=this.length,F;for(F=D-1;F>=0;F--){if(this[F]==E[0]){this.pop()}else{break}}for(F=0;F<C;F++){if(!this[F]){this[F]=E[F]}}return this},__removeInvalidChars:function(E,D){for(var C=0;C<E.length;C++){if(D[C]&&this.rules[D[C]]&&!this.rules[D[C]].test(E[C])){E.splice(C,1);C--}}return E},__applyMask:function(E,C,F){if(typeof F=="undefined"){F=0}for(var D=0;D<E.length+F;D++){if(C[D]&&this.fixedCharsReg.test(C[D])){E.splice(D,0,C[D])}}return E},__extraPositionsTill:function(E,C){var D=0;while(this.fixedCharsReg.test(C[E])){E++;D++}return D},__setRange:function(E,F,C){if(typeof C=="undefined"){C=F}if(E.setSelectionRange){E.setSelectionRange(F,C)}else{var D=E.createTextRange();D.collapse();D.moveStart("character",F);D.moveEnd("character",C-F);D.select()}},__getRangePosition:function(D){if(!B.browser.msie){return{start:D.selectionStart,end:D.selectionEnd}}var E={start:0,end:0},C=document.selection.createRange();E.start=0-C.duplicate().moveStart("character",-100000);E.end=E.start+C.text.length;return E}}});B.fn.extend({setMask:function(C){B.invalid;return B.mask.set(this,C)},unsetMask:function(){return B.mask.unset(this)}})})(jQuery)