<?php
class system {
	
	function __construct() {
		
	}
	
	/**
	* Retorna uma lista de dados em sql conforme parametros
	* @params string $tabela nome da tabela.
	* @params array $dados campo e valor para execucao do sql.
	* @params string $order campo para passar a ordenacao da execução do sql.
	* @returns array $rows com os dados do sql.
	*/
	public function get($tabela,$dados=array(),$order) {
		global $db;
		
		if(count($dados) > 0)
		foreach ($dados as $key=>$value) $where .= " AND $key = '".$value."' ";

		$sql  = "SELECT * FROM ".$tabela." WHERE 1 ". $where . $order;
		$rows = $db->db_query($sql);
		
		if(count($rows) > 0) return $rows;
		else 				 return false;
	}
	
	/**
	* Retorna uma lista de dados em sql conforme parametros
	* @params string $tabela nome da tabela.
	* @params array $dados campo e valor para execucao do sql.
	* @params string $order campo para passar a ordenacao da execução do sql.
	* @returns array $rows com os dados do sql.
	*/
	public function getIn($tabela,$where,$order) {
		global $db;
	
		if($where != '') $where = " AND ".$where;

		$sql  = "SELECT * FROM ".$tabela." WHERE 1 ". $where . $order;
		$rows = $db->db_query($sql);
		
		if(count($rows) > 0) return $rows;
		else 				 return false;
	}
	
	/**
	* Monta a lista de opcoes (options) com parametros passados
	* @params string $tabela nome da tabela.
	* @params array $array_value dados para popular o option.
	* @params string $request campo de selecao caso haja valor.
	* @params string $value valor do indice da $array_value para o value do option .
	* @params string $text nome do indice da $array_value para o text do option .
	* @returns string $return com os option montados.
	*/
	public function createOption($array_value,$request,$value,$text) {
		if(!isset($value)) $value = $text;

		foreach ($array_value as $row) {
			$selected = $row[$value] == $request ? 'selected="selected"' : '';
			$return .= '<option value="'.$row[$value].'" '.$selected.'>'.($row[$text]).'</option>';
		}

		return $return;
	}
	
	/**
	* Transforma uma array, ou string, com dados para armazenas no banco
	* @params string/array $data para encryptar
	* @returns string/array encriptada
	*/
	public function base_encrypt($data) {
		if(is_array($data)) {
			$r = json_encode($data);
			return base64_encode($r);
		} else {
			return base64_encode($data);
		}
	}
	
	/**
	* Transforma encrypt em uma array, ou string
	* @params string/array $data encrypt
	* @returns string/array  desincriptada.
	*/
	public function unbase_encrypt($data) {
		$r  = base64_decode($data);
		$ar = json_decode($r);
		
		if(is_array($ar)) return $ar;
		else 			  return $r;
	}
	
	/**
	* Formata a news padrão da linklar
	* @params string $titulo
	* @params string $texto
	* @returns html formatada.
	*/
	public function formataEmail($titulo,$texto) {
		global $geral;
		
		$MAIL = new TemplatePower(TEMPLATE_PATH."includes/mail.tpl");
		$MAIL->assignGlobal("uploadPath",UPLOAD_PATH);
		$MAIL->assignGlobal("imagePath",IMAGE_PATH);
		$MAIL->prepare();
		
		$MAIL->newBlock('mail');
		$MAIL->assign('titulo',$titulo);
		$MAIL->assign('texto',$texto);
		
		return $MAIL->getOutputContent();
	}
	
	/**
	* Configura o cabecalho da classe phpmailer 
	* @params $mail classe por referencia
	*/
	public function setHeaderEmail(&$mail) {
		$mail->IsSMTP(); 							// telling the class to use SMTP
		$mail->SMTPAuth   = true;                  	// enable SMTP authentication
		$mail->SMTPSecure = "tls";                 	// sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      	// sets GMAIL as the SMTP server
		$mail->CharSet    = "utf-8";      			// sets GMAIL as the SMTP server
		$mail->Port       = 587;                   	// set the SMTP port for the GMAIL server
		$mail->Username   = "rewebnews@gmail.com";  // GMAIL username
		$mail->Password   = "troqueiaenhadenobo";  // GMAIL password
		$mail->SetFrom	('maisvantagens@maisvantagens.com', 'CMS Mais Vantagens');
		
		//$mail->AddBCC('google@linklar.com.br','Linklar');	
	}
	
	/**
	*
	*envia a imagem do usuario e redimenciona
	*/
	public function redirImage($maxLargura,$maxAltura,$arquivo, $arquivo_novo,$tamanho_fixo) {
		$arquivo_novo = $arquivo_novo == '' ? $arquivo : $arquivo_novo;
		
		$img = imagecreatefromjpeg($arquivo);

		if ($img) {
			$width = imagesx($img);
			$height = imagesy($img);

			$scale = min($maxLargura/$width, $maxAltura/$height);
			if ($scale < 1) {
				$new_width = floor($scale * $width);
				$new_height = floor($scale * $height);
				
				if(!$tamanho_fixo) {
					$tmp_img = imagecreatetruecolor($new_width, $new_height);
					imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				} else {
					$tmp_img = imagecreatetruecolor($tamanho_fixo, $tamanho_fixo);
					
					$white = imagecolorallocate($tmp_img, 255, 255, 255);
					imagefill($tmp_img, 0, 0, $white);
					
			        $posicao_altura  =	round(-1*($new_height	- $tamanho_fixo)/2);
			        $posicao_largura =	round(-1*($new_width	- $tamanho_fixo)/2);
					imagecopyresampled($tmp_img, $img, $posicao_largura, $posicao_altura, 0, 0, $new_width, $new_height, $width, $height);
				}
				
				$img = $tmp_img;
				
			} else if($tamanho_fixo) {
				$new_width = floor($scale * $width);
				$new_height = floor($scale * $height);
				
				$tmp_img = imagecreatetruecolor($tamanho_fixo, $tamanho_fixo);
					
				$white = imagecolorallocate($tmp_img, 255, 255, 255);
				imagefill($tmp_img, 0, 0, $white);
				
		        $posicao_altura  =	round(-1*($new_height	- $tamanho_fixo)/2);
		        $posicao_largura =	round(-1*($new_width	- $tamanho_fixo)/2);
				imagecopyresampled($tmp_img, $img, $posicao_largura, $posicao_altura, 0, 0, $new_width, $new_height, $width, $height);
				$img = $tmp_img;
			}
			
			imagejpeg($img, $arquivo_novo);
		}
	}
}