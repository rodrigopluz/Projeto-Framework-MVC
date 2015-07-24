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

	$TPLV = new TemplatePower(TEMPLATE_PATH."modulos/online.tpl");
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
		case 'importar':
			importar();
			break;
		case 'salvaImportar':
			salvaImportar();
			break;
		case 'dadosImport':
			dadosImport();
			break;
		case 'gravaImportar':
			gravaImportar();
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
	$sql = "SELECT onde_comprar_online.* FROM onde_comprar_online ORDER BY onde_comprar_online.loja_id ASC";
	$rs = $db->db_query($sql);
	$cont = 0;

	### PAGINACAO
	$navbar         = new paginar;
	$navbar->numero = 10;
	$navbar->url    = "on=online".$qBusca;
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
	$TPLV->assignGlobal("paginacao_primeira", $navbar->link_pagina_primeira());
	$TPLV->assignGlobal("paginacao_anterior", $navbar->link_pagina_anterior()  );
	$TPLV->assignGlobal("paginacao_proxima",  $navbar->link_pagina_proxima()   );
	$TPLV->assignGlobal("paginacao_ultima",   $navbar->link_pagina_ultima());
	$TPLV->assignGlobal("paginas",            $navbar->imprimir_paginas()      );
	$TPLV->assignGlobal("pagina",             $navbar->imprimir_pagina_atual() );

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
	$sqlNavegaAnterior = "SELECT loja_id FROM onde_comprar_online WHERE loja_id = (SELECT MAX(loja_id) FROM onde_comprar_online WHERE loja_id < ".$_REQUEST['loja_id'].")";
	$navegaAnterior = $db->db_query($sqlNavegaAnterior);
	if($navegaAnterior[0]['loja_id']=='')$navegaAnterior[0]['loja_id']=$_REQUEST['loja_id'];
	$TPLV->assignGlobal("post_id_anterior",$navegaAnterior[0]['loja_id']);
	$sqlNavegaProximo="SELECT loja_id FROM onde_comprar_online WHERE loja_id = (SELECT MIN(loja_id) FROM onde_comprar_online WHERE loja_id > ".$_REQUEST['loja_id'].")";
	$navegaProximo=$db->db_query($sqlNavegaProximo);
	if($navegaProximo[0]['loja_id']=='')$navegaProximo[0]['loja_id']=$_REQUEST['loja_id'];
	$TPLV->assignGlobal("post_id_proximo",$navegaProximo[0]['loja_id']);
	//BLOCO DE NAVEGACAO - ANTERIOR E PROXIMO

	$sql = "SELECT * FROM onde_comprar_online WHERE loja_id = '".$_REQUEST['loja_id']."'";
	$rs = $db->db_query($sql);
	$TPLV->assignGlobal("loja_id",$rs[0]['loja_id']);
	$TPLV->assignGlobal("nome",$rs[0]['nome']);
	$TPLV->assignGlobal("atuacao",$rs[0]['atuacao']);
	$TPLV->assignGlobal("link",$rs[0]['link']);
	$TPLV->assignGlobal("cnpj",$rs[0]['cnpj']);
	$TPLV->assignGlobal("responsavel",$rs[0]['responsavel']);
	$TPLV->assignGlobal("email",$rs[0]['email']);
	$TPLV->assignGlobal("fone",$rs[0]['fone']);
	$TPLV->assignGlobal("ativo",$rs[0]['ativo']);

	### ATIVO
	if($rs[0]['ativo'] == "1") $TPLV->assignGlobal("schecked","checked");
	else $TPLV->assignGlobal("nchecked","checked");

	unset($_SESSION['msg']['erro']);
	$TPLV->printToScreen();
}

function salvar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;
	extract($_POST);
	if($_POST['action'] == 'insert' && $spam == false) {

		$sql = "INSERT INTO onde_comprar_online (nome,atuacao,link,cnpj,responsavel,email,fone,ativo) VALUES('".$nome."','".$atuacao."','".$link."','".$cnpj."','".$responsavel."','".$email."','".$fone."','".$ativo."')";
		$rs = $db->db_query($sql);

		if(isset($rs)) {
			header('Location: ?on=online');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	} 
	elseif($_POST['action'] == 'update' && $spam == false) {

		$sql = "UPDATE onde_comprar_online SET nome='".$nome."', atuacao='".$atuacao."', link='".$link."', cnpj='".$cnpj."', responsavel='".$responsavel."', email='".$email."', fone='".$fone."', ativo='".$ativo."' WHERE loja_id = ".$_REQUEST['loja_id']."";
		$rs = $db->db_query($sql);

		if(isset($rs)) {
			header('Location: ?on=online&in=editar&loja_id='.$_REQUEST['loja_id'].'&ok=1');
		} else {
			#@ monta retorno com erro com session
			$_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
		}
	}
}

function deletar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$sql = "SELECT * FROM onde_comprar_online WHERE loja_id = '".$_REQUEST['loja_id']."'";
	$rs = $db->db_query($sql);

	$sql = "DELETE FROM onde_comprar_online WHERE loja_id = '".$_REQUEST['loja_id']."'";
	$rs = $db->db_query($sql);

	echo "ok";
}

function salvaImportar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$arrExt = explode('.',$_FILES['file']['name']);
	$ext = $arrExt[count($arrExt)-1];

	$nome = 'online.'.$ext;
	$dir = "import/";
	chmod("import/", 0777);

	move_uploaded_file($_FILES['file']['tmp_name'], $dir . $nome);
	header('Location: ?on=online&in=dadosImport');
}

function dadosImport() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;
	
	$TPLV->newBlock('executarImportacao');
	
	include GLOBAL_PATH.'import/simplexlsx.class.php';

	$xlsx = new SimpleXLSX(GLOBAL_PATH.'import/online.xlsx');
	$cont = 0;
	foreach($xlsx->rows() as $registro){
		$cont++;
		if($cont > 1){
			$row['nome'] 		= $registro[0];
			$row['link'] 		= $registro[1];
			$row['atuacao']		= $registro[2];
			$row['cnpj']		= $registro[3];
			$row['responsavel']	= $registro[4];
			$row['email']		= $registro[5];
			$row['fone']		= $registro[6];
			$TPLV->newBlock('xls-dados');
			$TPLV->assign($row);
		}
	}
	$TPLV->printToScreen();
}

function importar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;

	$TPLV->newBlock('importar');
	$TPLV->printToScreen();
}

function gravaImportar() {
	global $db, $TPLV, $geral, $usuario, $urls, $log;
	
	include GLOBAL_PATH.'import/simplexlsx.class.php';

	$xlsx = new SimpleXLSX(GLOBAL_PATH.'import/online.xlsx');
	$cont = 0;
	
	//LIMPA DADOS TABELA
	$sql = 'DELETE FROM onde_comprar_online';
	$db->db_query($sql);
	foreach($xlsx->rows() as $registro){
		$cont++;
		if($cont > 1){
			$nome 			= $registro[0];
			$link 			= $registro[1];
			$atuacao		= $registro[2];
			$cnpj			= $registro[3];
			$responsavel	= $registro[4];
			$email			= $registro[5];
			$fone			= $registro[6];
			
			//CADASTRA REGISTRO
			$sql = 'INSERT INTO onde_comprar_online (nome,atuacao,link,cnpj,responsavel,email,fone,ativo) VALUES ("'.$nome.'","'.$atuacao.'","'.$link.'","'.$cnpj.'","'.$responsavel.'","'.$email.'","'.$fone.'","1")';
			$db->db_query($sql);
		}
	}
	
	$TPLV->newBlock('importar');
	$TPLV->assignGlobal('msg','Dados Atualizados com sucesso!');
	$TPLV->printToScreen();
}

?>
