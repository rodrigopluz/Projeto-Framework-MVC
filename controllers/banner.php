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
	
	$TPLV = new TemplatePower(TEMPLATE_PATH."modulos/banner.tpl");
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
		case 'apagar_foto':
			apagar_foto();
			break;	
	}
}

function lista(){
	global $db, $TPLV, $geral;
	
	$TPLV->newBlock('lista_registros');		
	$qBusca = '';
	if($_REQUEST['busca']) {
		$where = " AND (title LIKE '%".$_REQUEST['busca']."%')";
		$TPLV->assignGlobal("busca",$_REQUEST['busca']);
		$qBusca = "&busca=".$_REQUEST['busca'];
	} else {
		$where = '';
	}
	
	$sql = "SELECT * FROM banner_conceitual WHERE 1 ".$where." ORDER BY id DESC";
	$rs = $db->db_query($sql);
	foreach ($rs as $r) {
		$TPLV->newBlock('lista');
		/*- IMAGEM -*/
		$microtime = microtime();
		if(is_file(GLOBAL_PATH_SITE.'upload/banner_conceitual/'.$r['id'].'.'.$r['ext']))
			$r['imagem'] = "<img src='".LOCAL_PATH_SITE."upload/banner_conceitual/".$r['id'].".".$r['ext']."?$microtime' width='150' height='90'/>";
			
		$TPLV->assign($r);
	} 
			
	$TPLV->printToScreen();
}

function novo(){
	global $db, $TPLV, $geral, $usuario;
	
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
	
	$TPLV->newBlock('edita_registros');
	
	if($_REQUEST['ok'])
		$TPLV->newBlock('registro_salvo');
		
	if(isset($_SESSION['msg']['erro'])) {
		$TPLV->newBlock('bloco_msg_2');
		$TPLV->assign('msg',$_SESSION['msg']['erro']);
	}
	
	$sql = "SELECT * FROM banner_conceitual WHERE id = '".$_REQUEST['id']."'";
	$rs = $db->db_query($sql);
	
		$TPLV->assignGlobal("id",	$rs[0]['id']);
		$TPLV->assignGlobal("title",$rs[0]['title']);
		$TPLV->assignGlobal("link",	$rs[0]['link']);
		$TPLV->assignGlobal("ext",	$rs[0]['ext']);
					
		/*- IMAGEM -*/
		if($rs[0]['ext'] != ''){
			$TPLV->newBlock("foto");
			$microtime = microtime();
			$imagem = "<img src='".LOCAL_PATH_SITE."upload/banner_conceitual/".$rs[0]['id'].".".$rs[0]['ext']."?$microtime' width='547' height='263'/>";
			$TPLV->assign("imagem",$imagem);
			//<img src='".LOCAL_PATH_SITE."upload/banner_conceitual/".$rs[0]['id'].".".$rs[0]['ext']."?$microtime'" height="263" width="547" />
		}

		/*- -*/
		if($rs[0]['status'] == "A") $TPLV->assignGlobal("achecked","checked");
		else $TPLV->assignGlobal("ichecked","checked");
						
	unset($_SESSION['msg']['erro']);		
	$TPLV->printToScreen();
}

function salvar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;	
	extract($_POST);
	
	if($_POST['action'] == 'insert' && $spam == false) {
		/*- ARQUIVO -*/
		$ext = strtolower(basename($_FILES["file"]["name"]));
		$ext = array_pop(explode(".", $ext));
		
		$sql = "INSERT INTO banner_conceitual (title,link,status,ext) VALUES('".mysql_real_escape_string($title)."','".$link."','".$status."','".$ext."')";
		$rs = $db->db_query($sql);
		
		if($ext != ""){		
			$title = mysql_insert_id();
			$dir = GLOBAL_PATH_SITE."upload/banner_conceitual/";
			chmod(GLOBAL_PATH_SITE."upload/banner_conceitual/", 0777);
			move_uploaded_file($_FILES['file']['tmp_name'], $dir . $title.'.'.$ext);
		}
		
		if(isset($rs)) {
			header('Location: ?on=banner');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	} 
	elseif($_POST['action'] == 'update' && $spam == false) {
		### ARQUIVO
		$ext = strtolower(basename($_FILES["file"]["name"]));
		$ext = array_pop(explode(".", $ext));
		
		if($ext == ""){
			$sql = "SELECT * FROM banner_conceitual WHERE id = '".$_REQUEST['id']."'";
			$rs = $db->db_query($sql);
			$ext = $rs[0]['ext'];
		}
		
		$sql = "UPDATE banner_conceitual SET 
					title	= '".mysql_real_escape_string($title)."',
					link	= '".$link."',
					status	= '".$status."',
					ext 	= '".$ext."'
				WHERE id = ".$_REQUEST['id']."";
		$rs = $db->db_query($sql);
		
		$dir = GLOBAL_PATH_SITE."upload/banner_conceitual/";
		
		if($_FILES['file']['name'] != "") {
			$title = $_REQUEST['id'];
			move_uploaded_file($_FILES['file']['tmp_name'], $dir . $title.'.'.$ext);
		}
		
		if(isset($rs)) {
			header('Location: ?on=banner&in=editar&id='.$_REQUEST['id'].'&ok=1');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}			
	}
}

function apagar_foto() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;
	
	$sql = "SELECT * FROM banner_conceitual WHERE id = ".$_REQUEST['id']."";
	$rs = $db->db_query($sql);
	$ext = $rs[0]['ext'];
	
	$dir = GLOBAL_PATH_SITE."upload/banner_conceitual/";
	if(is_file($dir.$_REQUEST['id'].'.'.$ext)) {
		unlink($dir.$_REQUEST['id'].'.'.$ext);
	
		$sql = "UPDATE banner_conceitual SET ext = '' WHERE id = ".$_REQUEST['id']."";
		$rs = $db->db_query($sql);
	}
	 
	header("Location: ?on=banner&in=editar&id=".$_REQUEST['id']);	
}

function deletar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;
	
	$sql = "SELECT * FROM banner_conceitual WHERE id = ".$_REQUEST['id']."";
	$rs = $db->db_query($sql);
	$ext = $rs[0]['ext'];
	
	$dir = GLOBAL_PATH_SITE."upload/banner_conceitual/";
	
	if(is_file($dir.$_REQUEST['id'].'.'.$ext)) {
		unlink($dir.$_REQUEST['id'].'.'.$ext);
	}
	
	$sql = "DELETE FROM banner_conceitual WHERE id = '".$_REQUEST['id']."'";
	$rs = $db->db_query($sql);
	
	echo "ok";
}

?>
