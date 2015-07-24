<?php
//-----------------------------------------------------------------------------------------------------------
// CLASSE..................: html
// CRIADO..................: 16/05/2002
// �LTIMA MODIFICA��O......: 24/10/2002
// PROGRAMADOR.............: Marcos Pont

//-----------------------------------------------------------------------------------------------------------

//---------- lib utilizada -----------
//if (!ereg("WIN",strtoupper(PHP_OS))) include(LIB_GZDOC);
//------------------------------------

//----- classes utilizadas -----------
require_once(CLASSE_HTML_TEMPLATE);
require_once(CLASSE_POWER_TEMPLATE);
//------------------------------------

//---- defini��es da classe ----------
define("DEFAULT_PAGE_LAYOUT","defaultPageLayout.tpl");
define("DEFAULT_PAGE_ALIGN","left");
define("AUTHOR","Reweb");
//------------------------------------

class html
{
  var $title 		= TITLE;      	 // t�tulo da p�gina
  var $description  = DESCRIPTION;   // description da p�gina
  var $keywords		= KEYWORDS;      // keywords da p�gina
  var $scripts;                   // scripts .js da p�gina
  var $styles;                    // estilos .css da p�gina
  var $bodyCfg;                   // configura��es da tag BODY

  var $header;                    // objeto htmlTemplate do header
  var $menu;                      // objeto htmlTemplate do menu
  var $footer;                    // objeto htmlTemplate do footer
  var $body;                      // objeto do corpo da p�gina (htmlTemplate)

  var $pageLayout;                // layout do corpo da p�gina (arquivo .tpl)

  var $makeCache = FALSE;         // flag de grava��o de cache da p�gina
  var $makeLog = TRUE;            // flag de grava��o de log
  var $dieOnError = TRUE;         // flag de parada do script em caso de erros
  var $siteOn = TRUE;             // flag que indica se o site est� ativa

  //-----------------------------------------
  // html($pageLayout*,$pageAlign**,
  //                   $pageSize***)
  // construtor da classe
  // * $pageLayout (layout do corpo da p�gina)
  // ** $pageAlign (alinhamento para a p�gina)
  // *** $pageSize (tamanho da p�gina)
  //-----------------------------------------
  function html($pageLayout=DEFAULT_PAGE_LAYOUT,$pageAlign=DEFAULT_PAGE_ALIGN,$pageSize=PAGE_SIZE)
  { 
    $this->pageLayout = $pageLayout;
    $this->pageAlign  = $pageAlign;
    $this->pageSize   = $pageSize;
   
  }
  
  
  function getStyle () {
  	return $this->getHeader();
  }
  

  //-----------------------------------------
  // addScript($script*)
  // adiciona um js � p�gina
  // trata como array scripts separados por ','
  // * $script (js a adicionar)
  //-----------------------------------------
 function addScript($script,$common=TRUE,$extra='',$google=FALSE){
		
		if ($google == TRUE){
			$url = "http://www.google-analytics.com/".$script;
			$this->scripts .= "<script type='text/javascript' language='javascript' src='".$url."'></script>";
		}
		
		if ($script == 'plugins-jquery/jquery.pngFix.js'){
			$this->scripts .= "<!--[if lte IE 6]>\n";
			$this->scripts .= "<script type='text/javascript' language='javaScript' src='".SCRIPT_PATH.$script."' $extra></script>\n";
			$this->scripts .= "<![endif]-->\n";
		}
		
		else {
			if (ereg(",",$script)) {
				$scripts = explode(",",$script);
				for(reset($scripts); $scriptName = current($scripts); next($scripts)) {
					if($common) {
						$this->_checkFileInclusion(COMMON_SCRIPT_PATH,$scriptName);
						copy(COMMON_SCRIPT_PATH.$scriptName,SCRIPT_SERVER_PATH.$scriptName);
						$this->scripts .= "<script type='text/javascript' language='javaScript' src='".SCRIPT_PATH.$scriptName."' $extra></script>\n";
					}
					else {
						$this->_checkFileInclusion(SCRIPT_SERVER_PATH,$scriptName);
						$this->scripts .= "<script type='text/javascript' language='JavaScript' src='".SCRIPT_PATH.$scriptName."' $extra></script>\n";
					}
				}
			}
		    else {
				if ($common) {
					$this->_checkFileInclusion(COMMON_SCRIPT_PATH,$script);
					copy(COMMON_SCRIPT_PATH.$script,SCRIPT_SERVER_PATH.$script);
					$this->scripts .= "<script type='text/javascript' language='javaScript' src='".SCRIPT_PATH.$script."' $extra></script>\n";
				}
				else {
					$this->_checkFileInclusion(SCRIPT_SERVER_PATH,$script);
					$this->scripts .= "<script type='text/javascript' language='javaScript' src='".SCRIPT_PATH.$script."' $extra></script>\n";
				}
		    }
		    
		    if ($_GET['imprimir'])
		    	$this->scripts = '';
		}
	}

  //-----------------------------------------
  // addStyle($style*)
  // adiciona um css � p�gina
  // trata como array estilos separados por ','
  // * $style (estilo(s) a adicionar)
  //-----------------------------------------
  
  function addStyle($style,$path=TRUE)
  {
  	
	if ($style == "styles_ie.css") {
		$style_extra_inicial = "<!--[if IE]>\n";
		$style_extra_final = "<![endif]-->\n";
	}
	
	if ($style == "style_ie6.css") {
		$style_extra_inicial = "<!--[if lte IE 6]>\n";
		$style_extra_final = "<![endif]-->\n";
	}
  	
    if (ereg(",",$style)) {
      $styles = explode(",",$style);
      for(reset($styles); $styleName = current($styles); next($styles)) {
       // $this->_checkFileInclusion(STYLE_SERVER_PATH,$styleName);
        $this->styles .= $style_extra_inicial;
        $this->styles .= "<link rel='stylesheet' type='text/css' href='".STYLE_PATH.$styleName."'/>\n";
        $this->styles .= $style_extra_final;
      }
    }
    else {
     // $this->_checkFileInclusion(STYLE_SERVER_PATH,$style);
      $this->styles .= $style_extra_inicial;
      if($path == TRUE)
     	 $this->styles .= "<link rel='stylesheet' type='text/css' href='".STYLE_PATH.$style."'/>\n";
      else
      	$this->styles .= "<link rel='stylesheet' type='text/css' href='".$style."'/>\n";
      
      $this->styles .= $style_extra_final;
    }
  }

  //-----------------------------------------
  // addBodyCFG($cfg*)
  // concatena um atributo � tag BODY
  // * $cfg (novo atributo)
  //-----------------------------------------
  function addBodyCFG($cfg)
  {
    $this->bodyCfg .= $cfg;
  }

  //-----------------------------------------
  // setTitle($title*)
  // Seta o t�tulo da p�gina
  // * $title (novo t�tulo)
  //-----------------------------------------
  function setTitle($title) {	
  	$this->title = $title;
  }
  
  function setDescription($description) {	
  	$this->description = $description;
  }
  
  function setKeywords($keywords) {	
  	$this->keywords = $keywords;
  }

  //-----------------------------------------
  // getTitle()
  // retorna o t�tulo da p�gina
  //-----------------------------------------
  function getTitle()
  {
    return $this->title;
  }

  function getDescription() {
  	return $this->description;
  }
  
	function getKeywords() {
  	return $this->keywords;
  }
  
  //-----------------------------------------
  // appendTitle($titleAppend*)
  // Concatena um texto ao t�tulo da p�gina
  // * $appendTitle (conte�do a adicionar)
  //-----------------------------------------
  function appendTitle($titleAppend)
  {
    $this->title .= $titleAppend;
  }

  //-----------------------------------------
  // makePage()
  // instancia os objetos que comp�em a p�gina
  //-----------------------------------------
  function makePage()
  {
    $this->_makeHeader();
    $this->_makeMenu();
    $this->_makeFooter();
    $this->_makeBody();
  }

  //-----------------------------------------
  // printPage()
  // exibe o conte�do dos objetos principais
  //-----------------------------------------
  function printPage()
  {
    if($this->makeLog == TRUE) {
       require_once(CLASSE_LOGS);
       $logs = new logs("Visita de Página",$GLOBALS["PHP_SELF"]);
       $logs->insertLog();
    }
    if(!$this->makeCache) {
        /*header("Expires: ".gmdate("D, d M Y H:i:s", time() + (60)) . " GMT");
        header("Cache-Control: must-revalidate, proxy-revalidate" );
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Pragma: no-cache");*/
        //header("Expires: Tue, 1 Jan 1980 12:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        // header ("Content-type: image/png");
        // header("Content-type: image/jpeg");
        // header("Content-type: image/gif");
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }

    $this->_printHeader();
    $this->_printBody();
    $this->_printFooter();
  }

  //-----------------------------------------
  // _metaTags()
  // busca no arquivo de configura��o as tags
  // META e imprime no 'head' da p�gina
  //-----------------------------------------
  function _metaTags()
  {
    $metaTags =  "<meta name=\"title\" content=\"".$this->title."\"/>\n".
                 "<meta name=\"author\" content=\"".AUTHOR."\"/>\n".
                 "<meta name=\"description\" content=\"".$this->description."\"/>\n".
                 "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n".
                 "<meta name=\"keywords\" content=\"".$this->keywords."\"/>\n".
                 "<meta name=\"identifier-url\" content=\"".IDENTIFIER."\"/>\n".
                 "<meta name=\"google-site-verification\" content=\"x7f61QZQsNBCSxbdgsPGJrptHAbqSGVJpom9dFu1zdc\" />\n".
                 "<base href=\"".LOCAL_PATH."\" />\n";
                
    return $metaTags;
  }

  //-----------------------------------------
  // _makeHeader()
  // instancia e processa o cabe�alho
  //-----------------------------------------
  function _makeHeader()
  {
    //$this->header = new header();
  }

  //-----------------------------------------
  // _makeMenu()
  // instancia e processa o menu
  //-----------------------------------------
  function _makeMenu()
  {
    //$this->menu = new menu();
  }

  //-----------------------------------------
  // _makeFooter()
  // instancia e processa o footer
  //-----------------------------------------
  function _makeFooter()
  {
    //$this->footer = new footer();
  }

  //-----------------------------------------
  // _makeBody()
  // instancia o template do esqueleto da p�gina
  //-----------------------------------------
  function _makeBody()
  {
    $this->body = new htmlTemplate($this->pageLayout,TEMPLATE_PATH);
    $this->body->loadTemplate();
  }

  function getHeader () {
    $pageHeader = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" >\n";
   	//$pageHeader = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">";
    $pageHeader .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
    $pageHeader .= "<head>\n";
    $pageHeader .= "<title>".$this->title."</title>";
    $pageHeader .= $this->_metaTags();
    $pageHeader .= $this->styles;
    //$pageHeader .= $this->scripts;
    $pageHeader .= "<link rel=\"shortcut icon\" href=\"favicon.ico\" />\n";
    $pageHeader .= $this->scripts;
    $pageHeader .= "</head>\n";
    return $pageHeader;
  	
  }
  
  
  //-----------------------------------------
  // _printHeader()
  // imprime o cabe�alho 'head' da p�gina
  //-----------------------------------------
  function _printHeader()
  {

    //$pageHeader = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" >\n";
    $pageHeader = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
   	//$pageHeader = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">";
    $pageHeader .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
    $pageHeader .= "<head>\n";
    $pageHeader .= "<title>".$this->title."</title>";
    $pageHeader .= $this->_metaTags();
    $pageHeader .= $this->styles;
   // $pageHeader .= $this->scripts;
    $pageHeader .= "<link rel=\"shortcut icon\" href=\"favicon.ico\" />\n";
    $pageHeader .= $this->scripts;
    $pageHeader .= "</head>\n";
    print $pageHeader;

  }

  //-----------------------------------------
  // _printBody()
  // Imprime as tags BODY da p�gina e chama
  // a fun��o Main() que deve ser escrita;
  // Exibe a tela de site fora do ar se a
  // configura��o indicar este estado
  //-----------------------------------------
  
  function _printBody()
  {
    if (!$this->siteOn) {
      print "<body>\n";
      $tpl = new htmlTemplate(OFF_STATUS_TEMPLATE,TEMPLATE_PATH);
      $tpl->loadTemplate();
      $tpl->substituiValor("imagePath",IMAGE_PATH);
      $tpl->printTemplate();
      print "</body>\n";
    }
    else if (is_object($this->body)) {
      $this->body->substituiValor("width",$this->pageSize);
      $this->body->substituiValor("align",$this->pageAlign);
      $this->body->substituiValor("main",$this->_getMain());
      print "<body ".$this->bodyCfg.">\n";
      print $this->body->getContents();
//      print $this->scripts;
      print "</body>\n";
    }
    else {
      $this->_error("O objeto body n�o foi instanciado. Execute a fun��o makePage() antes da printPage() ou crie uma classe extendida � classe html.");
    }
  }

  //-----------------------------------------
  // _printFooter()
  // imprime a tag </HTML>
  //-----------------------------------------
  function _printFooter()
  {
  	
    print "</html>\n";
   // if (!ereg("WIN",strtoupper(PHP_OS))) GzDocOut();
  }

  //-----------------------------------------
  // _getMain()
  // carrega no buffer o conte�do da fun��o
  // Main() e retorna para a classe inserir
  // no layout de p�gina escolhido
  //-----------------------------------------
  function _getMain()
  {
    ob_start();
    Main();
    $main = ob_get_contents();
    ob_end_clean();
    return $main;
  }

  //-----------------------------------------
  // _getNavigator()
  // retorna o navegador do usu�rio
  //-----------------------------------------
  function _getNavigator()
  {
    $navAgent = @getenv("HTTP_USER_AGENT");
    if (ereg("MSIE",$navAgent))         return "IE";
    else if (ereg("Gecko",$navAgent))   return "NS6";
    else if (ereg("Mozilla",$navAgent)) return "NS";
    else if (ereg("Opera",$navAgent))   return "OP";
    else return "XX";
  }

  //-----------------------------------------
  // _checkFileInclusion($path*,$file**)
  // Verifica se um arquivo inclu�do existe
  // * path (caminho do arquivo)
  // ** $file (arquivo)
  //-----------------------------------------
  function _checkFileInclusion($path,$file)
  {  	
    if (!file_exists($path.$file)) {
      $this->_error("O arquivo ".$file." não foi encontrado no caminho ".$path."!");
    }
  }

  //-----------------------------------------
  // _error($errorString*)
  // mensagem de erro da classe
  // * $errorString (mensagem de erro)
  //-----------------------------------------
  function _error($errorString)
  {
    print "<B>Erro na Classe html</B>: ".$errorString;
    if ($this->dieOnError) {
      exit;
    }
  }
}
?>
