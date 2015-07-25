<?php
error_reporting(0);
ini_set("display_errors","0");

if ($_GET['in'] != 'salvar' ){
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

	$TPLV = new TemplatePower(TEMPLATE_PATH."modulos/textos.tpl");
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

            /**-MULTIMIDIAS-**/
		case 'listaMulti':
			listaMulti();
			break;
		case 'editarMulti':
			editarMulti();
			break;
		case 'salvarMulti':
			salvarMulti();
			break;
		case 'deletarMulti':
			deletarMulti();
			break;
		case 'apagarFotoMulti':
			apagarFotoMulti();
			break;
	}
}

function lista(){
	global $db, $TPLV, $geral;

	$TPLV->newBlock('lista_registros');

	$sql = "SELECT empresa_textos.* FROM empresa_textos ORDER BY empresa_textos.texto_id ASC";
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

	$sql = "SELECT * FROM empresa_textos WHERE texto_id = '".$_REQUEST['texto_id']."'";
	$rs = $db->db_query($sql);
	$TPLV->assignGlobal("texto_id",$rs[0]['texto_id']);
	$TPLV->assignGlobal("titulo",$rs[0]['titulo']);
	$TPLV->assignGlobal("texto",$rs[0]['texto']);

	unset($_SESSION['msg']['erro']);
	$TPLV->printToScreen();
}

function salvar() {
	global $db, $TPLV, $geral;

	extract($_POST);
	if($_POST['action'] == 'insert' && $spam == false) {

		$sql = "INSERT INTO empresa_textos(categoria_id,data,autor,titulo,texto,ext) VALUES('".$categoria_id."','".$data."','".$autor."','".$titulo."','".$texto."','".$ext."')";
		$rs = $db->db_query($sql);

		if(isset($rs)) {
			header('Location: ?on=textos');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	} 
	elseif($_POST['action'] == 'update' && $spam == false) {

		$sql = "UPDATE empresa_textos SET texto = '".$texto."' WHERE texto_id = ".$_REQUEST['texto_id']."";
		$rs = $db->db_query($sql);

		if(isset($rs)) {
			header('Location: ?on=textos&in=editar&texto_id='.$_REQUEST['texto_id'].'&ok=1');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	}
}

function deletar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$sql = "SELECT * FROM empresa_textos WHERE texto_id = ".$_REQUEST['texto_id']."";
	$rs = $db->db_query($sql);

	$sql = "DELETE FROM empresa_textos WHERE texto_id = '".$_REQUEST['texto_id']."'";
	$rs = $db->db_query($sql);

	echo "ok";

}

function listaMulti(){
	global $db, $TPLV, $geral;

	$TPLV->newBlock('lista_registros-multi');

	$sql = "SELECT * FROM multimidia ORDER BY multimidia.id DESC";
	$rs = $db->db_query($sql);
	foreach ($rs as $r) {
		$TPLV->newBlock('lista-multi');

		$TPLV->assign($r);
	}

	if(isset($_SESSION['msg']['erro'])) {
		$TPLV->newBlock('bloco_msg_1-multi');

		$TPLV->assign('msg',$_SESSION['msg']['erro']);
	}

	unset($_SESSION['msg']['erro']);

	$TPLV->printToScreen();
}

function editarMulti(){
	global $db, $TPLV, $geral, $usuario;

	$TPLV->newBlock('edita_registros-multi');

	if($_REQUEST['ok'])
		$TPLV->newBlock('registro_salvo-multi');

	if(isset($_SESSION['msg']['erro'])) {
		$TPLV->newBlock('bloco_msg_2-multi');
		$TPLV->assign('msg',$_SESSION['msg']['erro']);
	}

	$sql = "SELECT * FROM multimidia WHERE id = '".$_REQUEST['id']."'";
	$rs = $db->db_query($sql);

		$TPLV->assignGlobal("id",$rs[0]['id']);
		$TPLV->assignGlobal("titulo",$rs[0]['titulo']);
		$TPLV->assignGlobal("tipo",$rs[0]['tipo']);
		$TPLV->assignGlobal("embed",$rs[0]['embed']);
		$TPLV->assignGlobal("ext",$rs[0]['ext']);

		### IMAGEM
		if($rs[0]['ext']){
			$TPLV->newBlock("foto-multi");
			$TPLV->assign("imagem","<img src=".LOCAL_PATH_SITE."tb.php?img=upload/multimidia/".$rs[0]['id']."_img.".$rs[0]['ext']."&x=110&y=110>");
		}

	unset($_SESSION['msg']['erro']);
	$TPLV->printToScreen();
}

function salvarMulti() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	extract($_POST);

	if($_POST['action'] == 'insert' && $spam == false) {

		### ARQUIVO
		$ext = strtolower(basename($_FILES["file"]["name"]));
		$ext = array_pop(explode(".", $ext));

		$ext2 = strtolower(basename($_FILES["file2"]["name"]));
		$ext2 = array_pop(explode(".", $ext2));

		$sql = "INSERT INTO multimidia (titulo,tipo,embed,ext,ext2) VALUES('".$titulo."','".$tipo."','".$embed."','".$ext."','".$ext2."')";
		$rs = $db->db_query($sql);

		$nome = mysql_insert_id();
		$dir = GLOBAL_PATH_SITE."upload/multimidia/";
		chmod(GLOBAL_PATH_SITE."upload/multimidia/", 0777);

		move_uploaded_file($_FILES['file']['tmp_name'], $dir . $nome.'_img.'.$ext);
		move_uploaded_file($_FILES['file2']['tmp_name'], $dir . $nome.'_file.'.$ext2);

		if(isset($rs)) {
			header('Location: ?on=textos&in=listaMulti');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}

	} elseif($_POST['action'] == 'update' && $spam == false) {

		### ARQUIVO
		$ext = strtolower(basename($_FILES["file"]["name"]));
		$ext = array_pop(explode(".", $ext));

				$ext2 = strtolower(basename($_FILES["file2"]["name"]));
		$ext2 = array_pop(explode(".", $ext2));

		if($ext == ""){
			$sql = "SELECT * FROM multimidia WHERE id = '".$_REQUEST['id']."'";
			$rs = $db->db_query($sql);
			$ext = $rs[0]['ext'];
		}

		if($ext2 == ""){
			$sql = "SELECT * FROM multimidia WHERE id = '".$_REQUEST['id']."'";
			$rs = $db->db_query($sql);
			$ext2 = $rs[0]['ext2'];
		}

		$sql = "UPDATE multimidia SET ext='".$ext."',ext2='".$ext2."',titulo='".$titulo."',tipo='".$tipo."',embed='".$embed."' WHERE id = ".$_REQUEST['id']."";
		$rs = $db->db_query($sql);


		if($_FILES['file']['name'] != "") {
			$titulo = mysql_insert_id();
			copy($_FILES['file']['tmp_name'],GLOBAL_PATH_SITE."upload/multimidia/".$_REQUEST['id']."_img.".$ext);
		}

		if($_FILES['file2']['name'] != "") {
			$titulo = mysql_insert_id();
			copy($_FILES['file2']['tmp_name'],GLOBAL_PATH_SITE."upload/multimidia/".$_REQUEST['id']."_file.".$ext);
		}

		if(isset($rs)) {
			header('Location: ?on=textos&in=editarMulti&id='.$_REQUEST['id'].'&ok=1');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	}
}

function deletarMulti() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$sql = "SELECT * FROM multimidia WHERE id = ".$_REQUEST['id']."";
	$rs = $db->db_query($sql);
	$ext = $rs[0]['ext'];
	$ext2 = $rs[0]['ext2'];

	$dir = GLOBAL_PATH_SITE."upload/multimidia/";
	if(is_file($dir.$_REQUEST['id'].'_img.'.$ext)) {

		unlink($dir.$_REQUEST['id'].'_img.'.$ext);

		$sql = "UPDATE multimidia SET ext='' WHERE id = ".$_REQUEST['id']."";
		$rs = $db->db_query($sql);
	}
	if(is_file($dir.$_REQUEST['id'].'_file.'.$ext2)) {

		unlink($dir.$_REQUEST['id'].'_file.'.$ext2);

		$sql = "UPDATE multimidia SET ext2='' WHERE id = ".$_REQUEST['id']."";
		$rs = $db->db_query($sql);
	}

	$sql = "DELETE FROM multimidia WHERE id = '".$_REQUEST['id']."'";
	$rs = $db->db_query($sql);

	echo "ok";
}

function apagarFotoMulti() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$sql = "SELECT * FROM multimidia WHERE id = ".$_REQUEST['id']."";
	$rs = $db->db_query($sql);
	$ext = $rs[0]['ext'];
	$ext2 = $rs[0]['ext2'];

	$dir = GLOBAL_PATH_SITE."upload/multimidia/";
	if(is_file($dir.$_REQUEST['id'].'.'.$ext)) {

		unlink($dir.$_REQUEST['id'].'.'.$ext);

		$sql = "UPDATE multimidia SET ext='' WHERE id = ".$_REQUEST['id']."";
		$rs = $db->db_query($sql);
	}

	header("Location: ?on=textos&in=editarMulti&id=".$_REQUEST['id'].'&ok=1');
}

?>