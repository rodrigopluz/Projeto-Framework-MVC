<?php
Main();

function Main(){
	global $TPLV, $urls, $usuario, $imovel;

	$TPLV = new TemplatePower(TEMPLATE_PATH."login.tpl");
	$TPLV->assignGlobal("uploadPath",UPLOAD_PATH);
	$TPLV->assignGlobal("imagePath",IMAGE_PATH);
	$TPLV->assignGlobal("swfPath",SWF_PATH);
	$TPLV->assignGlobal("localPath",LOCAL_PATH);
	$TPLV->assignGlobal('navBottom', $bottom);
	$TPLV->assignGlobal($urls->var);
	$TPLV->prepare();

	$in = $_GET['in'];

	switch ($in){
		//FILTROS DE BUSCAS
		default:
		case 'deletaUsuario':
			deletaUsuario();
			break;
        case 'deletaMidia':
			deletaMidia();
			break;

		//LOGIN E RECUPERA SENHA
		case 'getLogin':
			getLogin();
			break;
		case 'login':
			login();
			break;
		case 'getSenha':
			getSenha();
			break;
		case 'recuperaSenha':
			recuperaSenha();
			break;
		case 'isLogado':
			if($usuario->isLogado()) echo 'logado';
			else 				 	 echo 'erro';
			break;

		//CADASTRO
		case 'validaEmailCadastro':
			validaEmailCadastro();
			break;

		//LEADS DETALHES
		case 'getCadastro':
			getCadastro();
			break;
		case 'salvarCadastro':
			salvarCadastro();
			break;

		case 'verificaCPF':
			verificaCPF();
			break;
	}
}

function verificaCPF(){
	global $db, $geral, $usuarioRh;
	$cpf = $geral->trataCPF($_REQUEST['cpf']);
	$idU = $_REQUEST['idU'];
	$sql = $db->db_select('rh_usuarios', '*, COUNT(id) AS total', "cpf = '{$cpf}' AND id != {$idU}");
	die($sql[0]['total']);
}

function deletaMidia(){
    global $db;
    $sqlMidia="DELETE FROM multimidia WHERE id=".$_POST[id_midia];
    $db->db_query($sqlMidia);
    echo "ok";
}

function deletaUsuario() {
	global  $usuario, $log;
	$usuario = mysql_real_escape_string($_POST['id_usuario']);
	if($usuario->deletar($usuario))
		echo 'ok';
	else
		echo 'error';
}

function getSenha() {
	global $usuario;
	echo $usuario->getTelaSenha();
}

function recuperaSenha() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;
	if (preg_match( "/bcc:|cc:|Return-Path:|multipart|\[url|Content-Type:/i", implode($_REQUEST)))	$spam=true;
	if (preg_match_all("/<a|http:/i", implode($_REQUEST), $out) > 3) $spam=true;
	extract($_POST);

	/* validacao por javascript */
	if(!$geral->validaEmail($email)) 	$spam = true;
	/* validacao por javascript */

	/* verifica se usuario é existente */
	if(!$usuario->verificaEmail($email)) {
		$retorno = 'erro';
		$spam = true;
	} else
		$dadoUser = $usuario->getUser("",$email);

	if($spam == false ) {
		$senha = $geral->geraSenha();
		$usuario->setSenha($dadoUser[id],$senha);

		$titulo = 'Recuperação de Senha '.TITLE.' - '.date('d/m/Y H:i');
		$texto  = "<p>Olá, abaixo seguem seus dados de acesso ao CMS Mais Vantagens</p>
				  	<p>
				  		email: {$email}<br/>
				  		senha: {$senha}
				  	</p>
				  	<p><a href='http://".DOMINIO."'>".DOMINIO."</a></p>
				  ";

		$mail = new PHPMailer();
		$usuario->setHeaderEmail($mail);

		$mail->Subject  = $titulo;
		$mail->MsgHTML($usuario->formataEmail($titulo,$texto));

		$mail->AddAddress($email, $dadoUser['nome']);

		if($mail->Send()) {
			$retorno = 'ok';
		}
		$log->setVarsEmail($titulo,$dadoUser['email'],$email,$texto);
	}

	if(!$retorno) $retorno = 'Erro de transmissão. Tente mais tarde';
	die($retorno);
}

function login() {
	global $db, $imovel, $usuario;
	$usuario->email = mysql_real_escape_string($_POST['email']);
	$usuario->senha = mysql_real_escape_string($_POST['senha']);
	if($usuario->login()) {
		echo 'login';
	} else
		echo 'erro';
}

function validaEmailCadastro() {
	global $usuario;
	$email = mysql_real_escape_string($_POST['email']);
	$id_usuario = mysql_real_escape_string($_POST['id_usuario']);
	if(!$usuario->verificaEmailCadastro($email,$id_usuario)) echo 'ok';
	else 							  	 					 echo 'erro';
}

function getCadastro() {
	global $db, $usuario;
	$usuario->ac 	= mysql_real_escape_string($_GET['ac']);
	$usuario->vl	= mysql_real_escape_string($_GET['vl']);
	$usuario->msg 	= utf8_encode(mysql_real_escape_string($_GET['msg']));
	echo $usuario->getTelaCadastro();
}

?>