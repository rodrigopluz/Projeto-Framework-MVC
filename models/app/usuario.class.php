<?php

class usuario extends system {

	var $nome;
	var $email;
	var $senha;
	var $id;
	var $usuario_tipo_id;
	
	var $LOGIN;
	var $tools;
	var $usuario_id;
	
	function __construct() {
		global $urls;

		// carrega os tpls de login
		$this->LOGIN = new TemplatePower(TEMPLATE_PATH."restrito.tpl");
		$this->LOGIN->assignGlobal("uploadPath",UPLOAD_PATH);
		$this->LOGIN->assignGlobal("imagePath",IMAGE_PATH);
		$this->LOGIN->assignGlobal("swfPath",SWF_PATH);
		$this->LOGIN->assignGlobal("localPath",LOCAL_PATH);
		$this->LOGIN->prepare();
		
		// joga para variavel do objeto os dados de login
		if (isset($_COOKIE['login'])) {
			foreach ($_COOKIE['login'] as $name => $value) $this->{$name} = $value;
		}
		
		$this->tools = new tools($this->id);
	}
	
	/**
	* loga o usuario e seta cookies
	* @returns bool true se login correto false se nao
	*/
	public function login() {
		global $db, $geral;
		
		$dados = array('email' => $this->email,
				 	   'senha' => md5($this->senha));
		
		$rows = $this->get('app_usuario',$dados,'');
		
		if(is_array($rows))	{
			
			$this->id 				= $rows[0]['id'];
			$this->nome 			= $rows[0]['nome'];
			$this->email 			= $rows[0]['email'];
			$this->permissoes 		= $rows[0]['permissoes'];
			
			$expires = time()+3600*24*30;
			setcookie('login[id]',				$this->id,			$expires);
			setcookie('login[nome]',			$this->nome,		$expires);
			setcookie('login[email]',			$this->email,		$expires);
			setcookie('login[permissoes]',		$this->permissoes,	$expires);
			
			return true;
		}
		else return false;
	}
	
	/**
	* pega os dados do usuario
	* @returns $array com os dados do usuario
	*/
	public function getUser($usuario_id,$email = "") {
		global $db, $geral;
		
		if($usuario_id != '')
			$dados = array('id' => $usuario_id);
		else
			$dados = array('email' => $email);
		
		$rows = $this->get('app_usuario',$dados,'');
		
		if(is_array($rows))	{
			return $rows[0];
		}
		else return false;
	}
	
	/**
	* pega os modulos do usuario
	* @returns $array com os dados do usuario
	*/
	public function getUserModuleInicial($usuario_id) {
		global $db, $geral;
		
		$dados = $this->getUser($usuario_id);
		
		$modulo = explode(",",$dados['permissoes']);
		
		$sql = "SELECT arquivo FROM app_modulos WHERE modulo_id = '".$modulo[0]."' ";
		$rows = $db->db_query($sql);
		
		if(is_array($rows))	{
			return $rows[0]['arquivo'];
		}
		else return false;
	}
	
	/**
	* pega os modulos do usuario
	* @returns $array com os dados do usuario
	*/
	public function getUserPermissions($usuario_id) {
		global $db, $geral;
		
		$dados = $this->getUser($usuario_id);
		
		$sql = "SELECT * FROM app_modulos WHERE modulo_id IN (".$dados['permissoes'].") ";
		$rows = $db->db_query($sql);
		
		if(is_array($rows))	{
			return $rows;
		}
		else return false;
	}
	
	/**
	* pega id do contrato
	* @returns id do contrato
	*/
	public function getContratoId($usuario_id) {
		global $db, $geral;
		
		$dados = array('usuario_id' => $usuario_id);
		$rows = $this->get('app_contrato',$dados,'');
		
		if(is_array($rows))	return $rows[0]['id'];
		else 				return false;
	}
	
	/**
	* verifica se o usuário está logado
	* @returns bool true se logado
	*/
	public function isLogado() {
		global $db, $geral;

		if(count($_COOKIE['login']) > 0) return true;
		else 							 return false;
	}
	
	/**
	* limpa as cookies
	*/
	public function logout() {
		global $db, $geral;

		if (isset($_COOKIE['login'])) {
			foreach ($_COOKIE['login'] as $name => $value) {
				setcookie("login[".$name."]", "", time()-3600);
			}
		}
	}
	
	/**
	* verifica se o email já consta na base
	* @param string $email 
	* @returns bool true se valido
	*/
	public function verificaEmail($email,$id_usuario) {
		global $db, $geral;
		
		if($id_usuario != "")  $and = "AND id != '$id_usuario'";
		
		$sql = "SELECT email FROM app_usuario WHERE email = '$email'".$and;
		$rows = $db->db_query($sql);

		if(count($rows)>0)	return true;
		else 				return false;
	}
	
	/**
	* verifica se o email já consta na base
	* @param string $email 
	* @returns bool true se valido
	*/
	public function verificaEmailCadastro($email,$id_usuario) {
		global $db, $geral;
		
		if($id_usuario != "")  $and = "AND usuario_id != '$id_usuario'";
		
		$sql = "SELECT email FROM rec_usuarios WHERE email = '$email'".$and;
		$rows = $db->db_query($sql);

		if(count($rows)>0)	return true;
		else 				return false;
	}
	
	/**
	* pega a tela de login
	* @returns html Retorna a tela de login
	*/
	public function getTelaLogin() {
		global $db, $geral;

		$this->LOGIN->newBlock("login");
		$this->LOGIN->assign("ac",$this->ac);
		$this->LOGIN->assign("vl",$this->vl);
		
		return $this->LOGIN->getOutputContent();
	}
	
	/**
	* pega a tela de casdastro
	* @returns html Retorna a tela de login
	*/
	public function getTelaCadastro() {
		global $db, $geral;

		$this->LOGIN->newBlock("cadastro");
		$this->LOGIN->assign("ac",$this->ac);
		$this->LOGIN->assign("vl",$this->vl);
		$this->LOGIN->assign("msg",$this->msg);
		
		return $this->LOGIN->getOutputContent();
	}
	
	/**
	* pega a tela de casdastro
	* @returns html Retorna a tela de login
	*/
	public function getTelaVisita() {
		global $db, $geral;

		$this->LOGIN->newBlock("visita");
		$this->LOGIN->assign("ac",$this->ac);
		$this->LOGIN->assign("vl",$this->vl);
		$this->LOGIN->assign("logado_nome",$this->nome);
		
		return $this->LOGIN->getOutputContent();
	}
	
	/**
	* pega a tela para recuperar senha
	* @returns html Retorna a tela de login
	*/
	public function getTelaSenha() {
		global $db, $geral;
		
		$this->LOGIN->newBlock("recupera_senha");
		return $this->LOGIN->getOutputContent();
	}
	
	/**
	* grava o usuario no sistema
	*/
	public function inserir() {
		global $db, $geral;
		
		// trata as variaveis de inserção
		foreach ($_POST as $key=>$value) {
			$this->{$key} = mysql_real_escape_string($value);
		}
		
		$set 	= array();
		$set[]	= "data_cadastro='"		.date('Y-m-d')."'";
		$set[]	= "hora_cadastro='"		.date('H:i')."'";
		$set[]	= "email='"				.$this->email_c."'";
		$set[]	= "nome='"				.$this->nome_c."'";
		$set[]	= "telefone='"			.$this->fone_c."'";
		$set[]	= "senha='"				.md5($this->senha_c)."'";
		$set[]	= "permissoes='"		.$this->permissoes."'";
		
		$set = implode(',',$set);
		
		if(!$this->verificaEmail($this->email_c) && isset($this->nome_c) && isset($this->permissoes)){
			$db->db_insert('app_usuario',$set);
			return true;
		}else
			return false;
	}
	
	/**
	* grava o usuario no sistema
	*/
	public function insert_user_site() {
		global $db, $geral;
		
		// trata as variaveis de inserção
		foreach ($_POST as $key=>$value) {
			$this->{$key} = mysql_real_escape_string($value);
		}
		
		$set 	= array();
		$set[]	= "data_cadastro='"		.date('Y-m-d')."'";
		
		$set[]	= "nome='"				.mysql_real_escape_string($_POST['nome_c'])."'";
		$set[]	= "cpf='"				.mysql_real_escape_string($_POST['cpf'])."'";
		$set[]	= "email='"				.mysql_real_escape_string($_POST['email_c'])."'";
		$set[]	= "data_nascimento='"	.mysql_real_escape_string($_POST['data_nascimento'])."'";
		$set[]	= "endereco='"			.mysql_real_escape_string($_POST['endereco'])."'";
		$set[]	= "numero='"			.mysql_real_escape_string($_POST['numero'])."'";
		$set[]	= "complemento='"		.mysql_real_escape_string($_POST['complemento'])."'";
		$set[]	= "bairro='"			.mysql_real_escape_string($_POST['bairro'])."'";
		$set[]	= "cidade='"			.mysql_real_escape_string($_POST['cidade'])."'";
		$set[]	= "estado='"			.mysql_real_escape_string($_POST['estado'])."'";
		$set[]	= "telefone='"			.mysql_real_escape_string($_POST['fone_c'])."'";
		$set[]	= "profissao='"			.mysql_real_escape_string($_POST['profissao'])."'";
		$set[]	= "ativo='"				.mysql_real_escape_string($_POST['ativo'])."'";
		
		$set = implode(',',$set);
		
		if(!$this->verificaEmail($this->email_c) && isset($this->nome_c)){
			$db->db_insert('rec_usuarios',$set);
			return true;
		}else
			return false;
	}
	
	/**
	*
	* salva o perfil de usuario
	*
	*/
	public function save() {
		global $db, $geral;
		
		$id = mysql_real_escape_string($_POST['id_usuario']);
		
		$set 	= array();

		$set[]	= "nome='"				.mysql_real_escape_string($_POST['nome_c'])."'";
		$set[]	= "telefone='"			.mysql_real_escape_string($_POST['fone_c'])."'";
		$set[]	= "email='"				.mysql_real_escape_string($_POST['email_c'])."'";
		$set[]	= "permissoes='"		.mysql_real_escape_string($_POST['permissoes'])."'";
		
		$set[]	= "data_edicao='"		.date('Y-m-d')."'";
		
		/* altera a senha se tiver campo senha nova alterado */
		if($_POST['senha_c'] != '') 		$set[]	= "senha='"	.md5($_POST['senha_c'])."'";

		$set = implode(',',$set);
		
		if($id) {
			
			$db->db_update('app_usuario',$set," id = '{$id}' ");
			$usuario_id = $id;
			
			return true;
		}
		
		
	}
	
	/**
	*
	* salva o perfil de usuario
	*
	*/
	public function save_user_site() {
		global $db, $geral;
		
		$id = mysql_real_escape_string($_POST['id_usuario']);
		
		$set 	= array();

		$set[]	= "nome='"				.mysql_real_escape_string($_POST['nome_c'])."'";
		$set[]	= "cpf='"				.mysql_real_escape_string($_POST['cpf'])."'";
		$set[]	= "email='"				.mysql_real_escape_string($_POST['email_c'])."'";
		$set[]	= "data_nascimento='"	.mysql_real_escape_string($_POST['data_nascimento'])."'";
		$set[]	= "endereco='"			.mysql_real_escape_string($_POST['endereco'])."'";
		$set[]	= "numero='"			.mysql_real_escape_string($_POST['numero'])."'";
		$set[]	= "complemento='"		.mysql_real_escape_string($_POST['complemento'])."'";
		$set[]	= "bairro='"			.mysql_real_escape_string($_POST['bairro'])."'";
		$set[]	= "cidade='"			.mysql_real_escape_string($_POST['cidade'])."'";
		$set[]	= "estado='"			.mysql_real_escape_string($_POST['estado'])."'";
		$set[]	= "telefone='"			.mysql_real_escape_string($_POST['fone_c'])."'";
		$set[]	= "profissao='"			.mysql_real_escape_string($_POST['profissao'])."'";
		$set[]	= "ativo='"				.mysql_real_escape_string($_POST['ativo'])."'";
		
		//$set[]	= "data_edicao='"		.date('Y-m-d')."'";
		
		/* altera a senha se tiver campo senha nova alterado */
		if($_POST['senha_c'] != '') 		$set[]	= "senha='"	.$_POST['senha_c']."'";

		$set = implode(',',$set);
		
		if($id) {
			
			$db->db_update('rec_usuarios',$set," usuario_id = '{$id}' ");
			$usuario_id = $id;
			
			return true;
		}
		
		
	}
	
	/**
	*
	* seta uma nova senha
	*/
	public function setSenha($usuario_id,$senha) {
		global $db;
		
		$set 	= array();
		$set[]	= "senha='"			.md5($senha)."'";
		$set 	= implode(',',$set);
		
		$where 	= " id = '{$usuario_id}' ";
		
		$db->db_update('app_usuario',$set,$where);
	}
	
	public function deletar($usuario_id) {
		global $db, $geral;
		
		$set 	= array();
		$set[]	= "id='".$usuario_id."'";
		$set 	= implode(' AND ',$set);
		
		$db->db_delete('app_usuario',$set);
		
		return true;
		
	}
}
