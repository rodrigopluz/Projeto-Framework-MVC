<?php
class log {
	
	var $assunto 		 = '';
	var $email_destino 	 = '';
	var $email_remetente = '';
	var $mensagem 		 = '';
	var $sendVar		 = '';
	
	function __construct() {
		$this->sendVar = 'N';
	}
	
	public function setVarsEmail($assunto,$email_destino,$email_remetente,$mensagem) {
		global $usuario;
		
		$this->assunto			= mysql_real_escape_string($assunto);
		$this->email_destino	= mysql_real_escape_string($email_destinho);
		$this->email_remetente	= mysql_real_escape_string($email_remetente);
		$this->mensagem			= mysql_real_escape_string($mensagem);
		$this->usuario_id 		= $usuario->id;
		$this->ip 				= $_SERVER['REMOTE_ADDR'];
		
		$this->gravaLogEmail();
	}
	
	private function gravaLogEmail() {
		global $db;
		
		$set 	= array();
		$set[]	= "assunto='"			.$this->assunto."'";
		$set[]	= "email_destino='"		.$this->email_destino."'";
		$set[]	= "email_remetente='"	.$this->email_remetente."'";
		$set[]	= "mensagem='"			.$this->mensagem."'";
		$set[]	= "usuario_id='"		.$this->usuario_id."'";
		$set[]	= "enviado='"			.$this->sendVar."'";
		$set[]	= "ip='"				.$this->ip."'";
		
		$set = implode(',',$set);
		
		$db->db_insert('log_email',$set);	
	}
}