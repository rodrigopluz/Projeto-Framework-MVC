<?php

error_reporting(0);
ini_set("display_errors","0");

if ($_GET['in'] != 'salvar' && $_GET['in'] != 'deletar' ){
	$HTML = new htmlStructure("structure.tpl");
	$HTML-> configPage();
	$HTML-> body->substituiValor("swfPath","SWF_PATH");
	$HTML-> setTitle($urls->title);
	$HTML-> setDescription($urls->description);
	$HTML-> setKeywords($urls->keywords);
	$HTML-> makeLog = FALSE;
	$HTML-> printPage();
} else
	Main();

function Main(){
	global $TPLV, $bottom, $urls, $db, $migalha;

	$TPLV = new TemplatePower(TEMPLATE_PATH."usuarios.tpl");
	$TPLV->assignGlobal("uploadPath",UPLOAD_PATH);
	$TPLV->assignGlobal("imagePath",IMAGE_PATH);
	$TPLV->assignGlobal("swfPath",SWF_PATH);
	$TPLV->assignGlobal("localPath",LOCAL_PATH);
	$TPLV->assignGlobal('navBottom', $bottom);
	$TPLV->assignGlobal($urls->var);
	$TPLV->prepare();

	$in = $_GET['in'];

	switch ($in){
		default:
		case 'lista':
			lista();
			break;
		case 'novo':
			novo();
			break;
		case 'editar':
			editar();
			break;
		case 'salvar':
			salvar();
			break;
		case 'deletar':
			deletar();
			break;
	}
}

function lista(){
	global $db, $TPLV, $geral;

	$TPLV->newBlock('lista_registros');
	$sql = "SELECT app_usuario.* FROM app_usuario ORDER BY app_usuario.nome";
	$rs = $db->db_query($sql);
	 $cont = 0;

	### PAGINACAO
	$navbar         = new paginar;
	$navbar->numero = 10;
	$navbar->url    = "on=usuarios".$qBusca;
	$navbar->paginas['PAGINA'] = ($_GET['pagina'] ? $_GET['pagina'] : 1);
	$navbar->processarSQL($sql);

	### IMPRIME OS REGISTROS
	$rs = $db->db_query($navbar->mysql['QUERY']);
	foreach ($rs as $r) {
		$TPLV->newBlock('lista');
		$TPLV->assign($r);
	}
	### TOTAL
	if ($navbar->paginas['TOTAL'] > 1) {
		$TPLV->newBlock('paginacao');
	}

	## MOSTRA AS IMAGENS DE RETORNO E PROXIMO HABILITADAS OU DESABILITADAS
	$TPLV->assignGlobal("paginacao_anterior", $navbar->link_pagina_anterior()  );
	$TPLV->assignGlobal("paginacao_proxima",  $navbar->link_pagina_proxima()   );
	$TPLV->assignGlobal("paginas",            $navbar->imprimir_paginas()      );
	$TPLV->assignGlobal("pagina",             $navbar->imprimir_pagina_atual() );

	$TPLV->printToScreen();
}

function novo(){
	global $db, $TPLV, $geral, $usuario;

	$TPLV->newBlock('insere_registros');
	if(isset($_SESSION['msg']['erro'])) {
		$TPLV->newBlock('bloco_msg_1');
		$TPLV->assign('msg',$_SESSION['msg']['erro']);
	}

	$sql = "SELECT * FROM app_modulos ORDER BY nome";
	$rs = $db->db_query($sql);
	foreach ($rs as $r) {
		$dados = $usuario->getUser($usuario->id);
		$permissoes = explode(",",$dados['permissoes']);

		$TPLV->newBlock('lista_modulos_1');
		$TPLV->assign($r);
	}

	unset($_SESSION['msg']['erro']);
	$TPLV->printToScreen();
}

function editar(){
	global $db, $TPLV, $geral, $usuario;

	$TPLV->newBlock('edita_registros');

	if(isset($_SESSION['msg']['erro'])) {
		$TPLV->newBlock('bloco_msg_2');
		$TPLV->assign('msg',$_SESSION['msg']['erro']);
	}

	$sql = "SELECT * FROM app_modulos ORDER BY nome";
	$rs = $db->db_query($sql);
	foreach ($rs as $r) {
		$dados = $usuario->getUser($_REQUEST['id']);
		$permissoes = explode(",",$dados['permissoes']);

		if(in_array($r['modulo_id'],$permissoes)) $r['check'] = "checked";
		else $r['check'] = "";

		$TPLV->newBlock('lista_modulos_2');
		$TPLV->assign($r);
	}

	$sql = "SELECT * FROM app_usuario WHERE id = '".$_REQUEST['id']."'";
	$rs = $db->db_query($sql);
	$TPLV->assignGlobal("id_usuario",$rs[0]['id']);
	$TPLV->assignGlobal("nome",$rs[0]['nome']);
	$TPLV->assignGlobal("email",$rs[0]['email']);
	$TPLV->assignGlobal("telefone",$rs[0]['telefone']);

	unset($_SESSION['msg']['erro']);
	$TPLV->printToScreen();
}

function salvar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	if (preg_match( "/bcc:|cc:|Return-Path:|multipart|\[url|Content-Type:/i", implode($_REQUEST)))	$spam=true;
	if (preg_match_all("/<a|http:/i", implode($_REQUEST), $out) > 3) $spam=true;

	extract($_POST);

	if($nome_c == false) 									$spam = true;
	if(!$geral->validaEmail($email_c)) 						$spam = true;
	if($senha_c  == false && $_POST['action'] == "insert") 	$spam = true;

	if($_POST['action'] == 'insert' && $spam == false) {
		$_POST['permissoes'] = implode(",",$_POST['permissoes']);

		if($usuario->inserir()) {
			#@ envia email
			$titulo = 'Bem-Vindo à '.TITLE.' - '.date('d/m/Y H:i');
			$texto  =  "<p>Olá {$usuario->nome_c}, </p>
						<p>Bem vindo ao ".TITLE."</p>
						<p>Você foi cadastrado com sucesso, e isso dá direito a você ter diversos recursos exclusivos.</p>
						<p>Abaixo os dados de acesso:<br/></p>
						<p>";

			$texto = $usuario->nome_c  != '' ? $texto . "nome: 	{$usuario->nome_c} 		<br/>" : $texto;
			$texto = $usuario->email_c != '' ? $texto . "email: {$usuario->email_c} 	<br/>" : $texto;
			$texto = $usuario->fone_c  != '' ? $texto . "fone: 	{$usuario->fone_c} 		<br/>" : $texto;
			$texto = $usuario->senha_c != '' ? $texto . "senha: {$usuario->senha_c} 	<br/>" : $texto;

			$texto .= "</p>
						<p>Para você ter acesso a sua conta acesse o <a href='".LOCAL_PATH."'>".TITLE."</a>
						<br/>Não respondemos este e-mail.<br/>
						<p>Qualquer dúvida, sugestão ou reclamação, envie uma mensagem para ".EMAIL_CONTATO."</p>";

			$mail = new PHPMailer();
			$usuario->setHeaderEmail($mail);
			$mail->Subject  = $titulo;

			$mail->AddReplyTo("rodrigopluz@gmail.com", 'CMS MVC');
			$mail->MsgHTML($usuario->formataEmail($titulo,$texto));

			$mail->AddAddress($usuario->email_c, $usuario->nome_c);

			//$log->setVarsEmail($titulo,$usuario->email_c,EMAIL_CONTATO,$texto);
			$mail->Send();

		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}

		header('Location: ?on=usuarios');

	} elseif($_POST['action'] == 'update' && $spam == false) {

		$_POST['permissoes'] = implode(",",$_POST['permissoes']);

		if($usuario->save()) {
			#@ envia email
			$titulo = 'Bem-Vindo à '.TITLE.' - '.date('d/m/Y H:i');
			$texto  =  "<p>Olá {$usuario->nome_c}, </p>
						<p>Bem vindo ao ".TITLE."</p>
						<p>Seus dados foram alterados com sucesso, e isso dá direito a você ter diversos recursos exclusivos.</p>
						<p>Abaixo os novos dados de acesso:<br/></p>
						<p>";

			$texto = $usuario->nome_c  != '' ? $texto . "nome: 	{$usuario->nome_c} 		<br/>" : $texto;
			$texto = $usuario->email_c != '' ? $texto . "email: {$usuario->email_c} 	<br/>" : $texto;
			$texto = $usuario->fone_c  != '' ? $texto . "fone: 	{$usuario->fone_c} 		<br/>" : $texto;
			$texto = $usuario->senha_c != '' ? $texto . "senha: {$usuario->senha_c} 	<br/>" : $texto;

			$texto .= "</p>
					 <p>Para você ter acesso a sua conta acesse o <a href='".LOCAL_PATH."'>".TITLE."</a>
					 <br/>Não respondemos este e-mail.<br/>
					 <p>Qualquer dúvida, sugestão ou reclamação, envie uma mensagem para ".EMAIL_CONTATO."</p>";

			$mail = new PHPMailer();
			$usuario->setHeaderEmail($mail);
			$mail->Subject  = $titulo;

			$mail->AddReplyTo("rodrigopluz@gmail.com", 'CMS MVC');
			$mail->MsgHTML($usuario->formataEmail($titulo,$texto));

			$mail->AddAddress($usuario->email_c, $usuario->nome_c);

			//$log->setVarsEmail($titulo,$usuario->email_c,EMAIL_CONTATO,$texto);
			$mail->Send();
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}

		header('Location: ?on=usuarios');
	}
}

function deletar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$sql = "SELECT * FROM app_usuario WHERE id = '".$_REQUEST['id']."'";
	$rs = $db->db_query($sql);

	$sql = "DELETE FROM app_usuario WHERE id = '".$_REQUEST['id']."'";
	$rs = $db->db_query($sql);

	echo "ok";
}


?>
