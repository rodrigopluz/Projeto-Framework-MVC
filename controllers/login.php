<?php

error_reporting(0);
ini_set("display_errors","0");

if ($_GET['in'] != 'ajax' && $_GET['in'] != 'logout'){
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
	global $TPLV, $bottom, $db, $migalha, $usuario;
		
	$TPLV = new TemplatePower(TEMPLATE_PATH."login.tpl");
	$TPLV->assignGlobal("uploadPath",UPLOAD_PATH);
	$TPLV->assignGlobal("imagePath",IMAGE_PATH);
	$TPLV->assignGlobal("swfPath",SWF_PATH);
	$TPLV->assignGlobal("localPath",LOCAL_PATH);
	$TPLV->assignGlobal('navBottom', $bottom);
	$TPLV->prepare();

	$in = $_GET['in'];

	switch ($in){
		default:
		case 'restrito':
			if($usuario->isLogado()) inicio();
			else restrito();
			break;
		case 'inicio';
			inicio();
			break;
		case 'logout':
			logout();
			break;
	}
}

function restrito(){
	global $db, $TPLV, $geral, $text, $migalha, $usuario, $imovel;
	$TPLV->printToScreen();
}

function inicio(){
	global $db, $TPLV, $geral, $text, $migalha, $usuario;
	$modulo = $usuario->getUserModuleInicial($usuario->id);
	
	header("location: ?on=".$modulo);
	$TPLV->printToScreen();
}

function logout() {
	global $db, $TPLV, $geral, $text, $usuario; 
	$usuario->logout();
	header("location: ?on=login");
}

?>
