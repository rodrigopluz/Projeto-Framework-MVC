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

	$TPLV = new TemplatePower(TEMPLATE_PATH."modulos/categoria.tpl");
	$TPLV->assignGlobal("uploadPath",UPLOAD_PATH);
	$TPLV->assignGlobal("uploadPath",UPLOAD_PATH_SITE);
	$TPLV->assignGlobal("imagePath",IMAGE_PATH);
	$TPLV->assignGlobal("swfPath",SWF_PATH);
	$TPLV->assignGlobal("localPath",LOCAL_PATH);
	$TPLV->assignGlobal("localPath",LOCAL_PATH_SITE);
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

	$sql = "SELECT blog_categorias.* FROM blog_categorias ORDER BY blog_categorias.categoria";
	$rs = $db->db_query($sql);
	foreach ($rs as $r) {
		$TPLV->newBlock('lista');
		$TPLV->assign($r);
	}

	$TPLV->printToScreen();
}

function novo(){
	global $db, $TPLV, $geral, $usuario;

	$TPLV->assignGlobal("classe_botao_acao",'criar_conta');
	$TPLV->newBlock('insere_registros');

	if(isset($_SESSION['msg']['erro'])) {
		$TPLV->newBlock('bloco_msg_1');
		$TPLV->assign('msg',$_SESSION['msg']['erro']);
	}

	unset($_SESSION['msg']['erro']);
	$TPLV->printToScreen();
}

function editar(){
	global $db, $TPLV, $geral, $usuario;

	$TPLV->assignGlobal("classe_botao_acao",'salvar_conta');
	$TPLV->newBlock('edita_registros');

	if($_REQUEST['ok'])
		$TPLV->newBlock('registro_salvo');

	if(isset($_SESSION['msg']['erro'])) {
		$TPLV->newBlock('bloco_msg_2');
		$TPLV->assign('msg',$_SESSION['msg']['erro']);
	}

	//BLOCO DE NAVEGACAO - ANTERIOR E PROXIMO
	$sqlNavegaAnterior="SELECT categoria_id FROM blog_categorias WHERE categoria_id = (SELECT MAX(categoria_id) FROM blog_categorias WHERE categoria_id < ".$_REQUEST['categoria_id'].")";
	$navegaAnterior=$db->db_query($sqlNavegaAnterior);
	if($navegaAnterior[0]['categoria_id']=='')$navegaAnterior[0]['categoria_id']=$_REQUEST['categoria_id'];
	$TPLV->assignGlobal("post_id_anterior",$navegaAnterior[0]['categoria_id']);
	$sqlNavegaProximo="SELECT categoria_id FROM blog_categorias WHERE categoria_id = (SELECT MIN(categoria_id) FROM blog_categorias WHERE categoria_id > ".$_REQUEST['categoria_id'].")";
	$navegaProximo=$db->db_query($sqlNavegaProximo);
	if($navegaProximo[0]['categoria_id']=='')$navegaProximo[0]['categoria_id']=$_REQUEST['categoria_id'];
	$TPLV->assignGlobal("post_id_proximo",$navegaProximo[0]['categoria_id']);
	//BLOCO DE NAVEGACAO - ANTERIOR E PROXIMO

	$sql = "SELECT * FROM blog_categorias WHERE categoria_id = '".$_REQUEST['categoria_id']."'";
	$rs = $db->db_query($sql);

	$TPLV->assignGlobal("categoria_id",$rs[0]['categoria_id']);
	$TPLV->assignGlobal("categoria",$rs[0]['categoria']);
	$TPLV->assignGlobal("ordem",$rs[0]['ordem']);

	unset($_SESSION['msg']['erro']);
	$TPLV->printToScreen();
}

function salvar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	extract($_POST);

	if($_POST['action'] == 'insert' && $spam == false) {
		$sql = "INSERT INTO blog_categorias (categoria,ordem) VALUES('".$categoria."','".$ordem."')";
		$rs = $db->db_query($sql);

		if(isset($rs)) {
			header('Location: ?on=categoria');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	} 
	elseif($_POST['action'] == 'update' && $spam == false) {

		$sql = "UPDATE blog_categorias SET categoria='".$categoria."',ordem='".$ordem."' WHERE categoria_id = ".$_REQUEST['categoria_id']."";
		$rs = $db->db_query($sql);

		if(isset($rs)) {
			header('Location: ?on=categoria&in=editar&categoria_id='.$_REQUEST['categoria_id'].'&ok=1');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	}
}

function deletar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$sql = "SELECT * FROM blog_categorias WHERE categoria_id = '".$_REQUEST['categoria_id']."'";
	$rs = $db->db_query($sql);

	$sql = "DELETE FROM blog_categorias WHERE categoria_id = '".$_REQUEST['categoria_id']."'";
	$rs = $db->db_query($sql);

	echo "ok";
}

?>
