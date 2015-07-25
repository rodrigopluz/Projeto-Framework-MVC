<?php
class tools extends system  {
	var $usuario_id;
	var $imovel_id;
	
	function __construct($usuario_id) {
		global $urls;
		
		$this->usuario_id = $usuario_id;	
	}
	
	public function getTools($usuario_tipo_id) {
		
		switch ($usuario_tipo_id) {
			case '1': // USUARIO SIMPLES
				$this->anuncios->listar(); //comprar
				$this->favoritos->listar();
				$this->leads->listar();
				break;
			case '2': // CORRETOR
				$this->anuncios->listar(); //comprar
				$this->favoritos->listar();
				$this->leads->listar();
				break;
			case '3': //IMOBILIARIA
				$this->anuncios->listar(); //limite
				$this->favoritos->listar();
				$this->leads->listar();
				break;
			case '4': //INCORPORADORA
				$this->lancamentos->listar();
				$this->favoritos->listar();
				$this->leads->listar();
				break;
		}
		
		$return 	= $this->leads->getTemplate();
		$return 	.= $this->lancamentos->getTemplate();
		$return 	.= $this->anuncios->getTemplate();
		$return 	.= $this->favoritos->getTemplate();
		
		return $return;
	}
	
	public function getAgrupador($estado,$cidade,$bairro_id,$endereco,$numero,$complemento) {
		global $geral;
		
		$endereco  = $geral->tira_acento($endereco);
		$endereco  = str_replace(" ","",$endereco);
		
		return md5($estado.$cidade.$bairro.$endereco.$numero.$complemento);
	}	
}
