<?php
if (eregi("textHandler.class.php",$_SERVER['PHP_SELF'])) {
    Header("Location: /404.php");
    die();
}

class textHandler {

	function strip_selected_tags($text, $tags = array()) {	
		$args = func_get_args();
		$text = array_shift($args);
		$tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
		foreach ($tags as $tag) {
			if(preg_match_all('/<'.$tag.'[^>]*>(.*)<\/'.$tag.'>/iU', $text, $found)){
				$text = str_replace($found[0],$found[1],$text);
			}
		}
		return $text;
	}

	function is_empty($val) {
	   $result = false;
	   
	   if (empty($val)) 
	       $result = true;
	
	   if (!$result && (trim($val) == ""))
	       $result = true;
	
	   if ($result && is_numeric($val) && $val == 0) 
	       $result = false;
	
	   return $result;
	}
	
	function tira_acento($texto) {
		$oque = array ( "/(?i)á|ã|â|Á|Ã|Â/","/(?i)é|ê|É|Ê/","/(?i)í|î|Í|Î/","/(?i)ó|õ|ô|Ó|Ô|Õ/","/(?i)ú|û|Ú|Û/","/(?i)ç|Ç/","/(?i)º|ª/"	);
		$peloque = array ( "a","e","i","o","u","c","" );
		return preg_replace ($oque, $peloque, $texto);
	}	
	
	function utf_to_html($texto) {
		$texto = preg_replace('/([\xc0-\xdf].)/se', "'&#' . ((ord(substr('$1', 0, 1)) - 192) * 64 + (ord(substr('$1', 1, 1)) - 128)) . ';'", $texto);
		$texto = preg_replace('/([\xe0-\xef]..)/se', "'&#' . ((ord(substr('$1', 0, 1)) - 224) * 4096 + (ord(substr('$1', 1, 1)) - 128) * 64 + (ord(substr('$1', 2, 1)) - 128)) . ';'", $texto);
		return $texto;
	}
	
	function ajaxText($texto){
		$texto = str_replace("","'",$texto);
		$texto = str_replace("","'",$texto);
		$texto = str_replace("",'"',$texto);
		$texto = str_replace("",'"',$texto);
		$texto = str_replace("",'-',$texto);		
		return $texto;
	}
	
	function strtoupper_br($texto){
		$oque = array ( "/(?i)á/","/(?i)ã/","/(?i)â/","/(?i)é/","/(?i)ê/","/(?i)í/","/(?i)î/","/(?i)ó/","/(?i)õ/","/(?i)ô/","/(?i)ú/","/(?i)û/","/(?i)ç/" );
		$peloque = array ( "Á","Ã","Â","É","Ê","Í","Î","Ó","Õ","Ô","Ú","Û","Ç" );
				
		$texto = strtoupper($texto);
		return preg_replace ($oque, $peloque, $texto);
	}
	
	function arrumaLink($site) {
		if(!empty($site) && ((substr_count($site,"http://") == 0) || (strpos($site,"http://") != 0)))
			$site = "http://".$site;
		return $site;
	}
	
	function cortaTexto ($str, $limite) {
		
		$strfinal="";
		$i = "";
		$tamanhodotexto=strlen($str);
		
		if ($tamanhodotexto < $limite) { /// CONTROLA SE O LIMITE É MAIOR QUE A STRING
			$strfinal = $str . "...";
			return $strfinal;
		} else {		
			for ($i = 0; $i <= strlen($str); $i++) { 
				if ($i > $limite) {
					if ($i == strlen($str) || $str[$i]==' ' || $str[$i]==',' || $str[$i]=='.' ) {
						$strfinal .= "...";
						return $strfinal;		
					}
					$strfinal .= $str[$i];
				} else {
					if ($i <= strlen($str)-1)
						$strfinal .= $str[$i];
				}
			}
		}
		return $strfinal;
	}
	
	function HtmlSpecialChars($t) {
		$t = htmlspecialchars($t);
		$t = str_replace("'","&#039;",$t);
		return $t;
	}
	
	function desfazerHtmlSpecialChars($input) {
		$input = preg_replace("/&gt;/i", ">", $input);
       	$input = preg_replace("/&lt;/i", "<", $input);
       	$input = preg_replace("/&quot;/i", "\"", $input);
       	$input = preg_replace("/&amp;/i", "&", $input);
		return $input;
	}
	
	function TrimPost() {
		if(!isset($_POST)) {
			global $HTTP_POST_VARS, $_POST;
			$_POST = $HTTP_POST_VARS;
		}
		foreach ($_POST as $key=> $val) {
			$_POST[$key] = trim($val);
		}
	}
	
	function Nl2Br($string) { 
		$string = preg_replace("/(\015\012)|(\015)|(\012)/","<br />",$string); 
    	$string = str_replace("<br /><br><br />","<br />",$string); 
		return $string; 
	} 
	
	function AddSlashes($t) {
		if (!get_magic_quotes_gpc()) {
			$t = addslashes($t);
		}
		return $t;
	}
	
	function StripSlashesRT($t) {
		if (get_magic_quotes_runtime()) {
			$t = stripslashes($t);
		}
		return $t;
	}
	
	function TextoParaInserir($t) {
		return $this->AddSlashes(trim($t));
	}
	
	function PrimeiraMaiscula($t) {
		return ucfirst($t);
	}
	
	function TextoParaEditar($t){
		$t = $this->StripSlashesRT($t);
		$t = $this->HtmlSpecialChars($t);
		$t = preg_replace("/&amp;/i", "&", $t);
		return $t;
	}
	
	function TextoMinusculo($t) {
		return strtolower($t);	
	}
	
	function TextoParaMostrar($t) {
		$t = $this->StripSlashesRT($t);
		$t = $this->Nl2Br($t);
		return $t;
	}
	
	function maiuscula($t) {
		$t = strtoupper(trim($t));
		$minusculo = array("á","à","ã","â","ä","é","è","ê","ë","í","ì","î", "ï","ó","ò","õ","ô","ö","ú","ù","û","ü","ç");
		$maiusculo = array("Á","À","Ã","Â","Ä","É","È","Ê","Ë","Í","Ì","Î", "Ï","Ó","Ò","Õ","Ô","Ö","Ú","Ù","Û","Ü","Ç");
		
		for ( $X = 0; $X < count($minusculo); $X++ ) { $t = str_replace
		($minusculo[$X], $maiusculo[$X], $t); }
		
		return $t;
	}
}

?>