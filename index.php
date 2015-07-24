<?php
ini_set('display_errors','0');
error_reporting(0);

ob_start();
Header("Content-type: text/html; charset=utf-8");
session_start();

require_once("cfg/cfg.main.php");
require_once(CLASSE_PATH.'geral.class.php');
require_once(CLASSE_PATH."class.phpmailer.php");

$geral 		= new Geral();

/**********************************************************************/
/// CONFIGURA O BANCO DE ACORDO COM O SERVIDOR E CRIA O OBJETO
$db = new edz_db(DB_HOST, DB_USER, DB_PASS, DB_BASE);
/**********************************************************************/

$text 	= new TextHandler();

$usuario 	= new usuario();
$log	 	= new log();

if((!$usuario->isLogado() || $_GET['on'] == "" || $_GET['on'] == "login") && $_GET['on'] != "ajax") {
	$on = PAGINA_INICIAL;
	$_GET['on'] = $on;
} elseif($_GET['on'] == "robots.txt") { die();
} else
	$on = $_GET['on'];

$in = $_GET['in'];

$include = MODS_PATH."$on.php";

//CONTEUDO
if(!is_file($include)) $include = MODS_PATH.PAGINA_INICIAL.".php";

include($include);

#### ENCERRA A CONEXAO COM O DB
$db->db_close();

?>
