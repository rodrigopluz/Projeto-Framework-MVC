<?php
/*
 *  CFG - PHP 5
 */
if (eregi("cfg.main.php", $PHP_SELF)) {
    Header("Location: /404.php");
    die();
}

/*
 * CONFIGURACOES BASICAS
 */
define("DOMINIO", ""); // DOMINIO
define("DIRETORIO", "/mvc"); // DIRETORIO
define('TITLE', 'CMS MVC'); // Titulo do site
define("SITE", "mvc"); // DIRETORIO

/*
 * META-TAGS
 */
define('META_TITLE', 'CMS MVC'); // Titulo para a tag meta
define('AUTOR', 'Rodrigo Pereira'); // Nome do autor do site
define('KEYWORDS', 'CMS MVC');
define('IDENTIFIER', ''); // URL do site
define('WEBTOOLS', 'r+jjtJH9LnqoDiArmjg4fzO6gwQjatimzQXtVyQJK8s=');
define('DATECREATION', '23/07/2015'); // Data de criação do site
define('ROBOTS', 'all, follow'); // Serviços utilizados pelo site
define('CATEGORY', 'Internet');  // Categoria do site
define('DESCRIPTION', 'CMS MVC');
define('SPAM', 'CMS MVC');

/*
 * FOLDERS
 */
define("GLOBAL_PATH", $_SERVER['DOCUMENT_ROOT'] . DIRETORIO . '/');
define("GLOBAL_PATH_SITE", $_SERVER['DOCUMENT_ROOT'] .'/'. SITE);
define("LOCAL_PATH", "http://" . $_SERVER["HTTP_HOST"] . DIRETORIO . '/');
define("LOCAL_PATH_SITE", "http://" . $_SERVER["HTTP_HOST"] .'/'. SITE . '/');
define("BASE_URL", "http://" . DOMINIO . "/");

/*
 * BANCO DE DADOS
 */
define("DB_HOST", "localhost"); // Localhost ou mysql.host.com.br
define("DB_USED", "mysql"); // Banco de Dados a ser usado
define("DB_USER", "root");  // Nome do Usuario
define("DB_PASS", "");      // Senha do Usuario
define("DB_BASE", "mvc_cms"); // Banco de Dados
define("MYSQL_CHARSET", "utf8"); // Banco de Dadoss
define("COMMON_PATH", GLOBAL_PATH . "common/");
define("CURL_PATH", "/usr/bin/curl");

/*
 * DADOS TECNICOS
 */
define("PAGINA_INICIAL", "login");
define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT']);
define("CLASSE_PATH", GLOBAL_PATH . "models/");
define("PLUGINS_PATH", GLOBAL_PATH . "plugins/");
define("CFG_PATH", GLOBAL_PATH . "cfg/");
define('MODS_PATH', GLOBAL_PATH . "controllers/");

define("RESOURCE_PATH", LOCAL_PATH . "views/");
define('LIB_PATH', GLOBAL_PATH . "views/libs/");
define("XML_PATH", GLOBAL_PATH . "views/xml/");
define("TEMPLATE_PATH", GLOBAL_PATH . "views/templates/");
define("SCRIPT_SERVER_PATH", GLOBAL_PATH . "views/js/");
define("IMAGE_SERVER_PATH", GLOBAL_PATH . "views/img/");
define("SWF_SERVER_PATH", GLOBAL_PATH . "views/swf/");
define("STYLE_SERVER_PATH", GLOBAL_PATH . "views/css/");

define("SCRIPT_PATH", RESOURCE_PATH . "js/");
define("IMAGE_PATH", RESOURCE_PATH . "img/");
define("SWF_PATH", RESOURCE_PATH . "swf/");
define("STYLE_PATH", RESOURCE_PATH . "css/");
define("COMMON_LIB_PATH", COMMON_PATH . "libs/");
define("COMMON_SCRIPT_PATH", COMMON_PATH . "js/");

define('UPLOAD_DIR', LOCAL_PATH . "upload/");
define('UPLOAD_DIR_SITE', LOCAL_PATH_SITE . "upload/");
define('UPLOAD_DIRS', GLOBAL_PATH_SITE . "upload/");
define('UPLOAD_PATH', LOCAL_PATH . 'upload/');
define('UPLOAD_PATH_SITE', LOCAL_PATH_SITE . 'upload/');

define("CLASSE_HTML_STRUCTURE", CLASSE_PATH . "htmlStructure.class.php");
define("CLASSE_HTML", CLASSE_PATH . "html.class.php");
define("CLASSE_POWER_TEMPLATE", CLASSE_PATH . "powerTemplate.class.php");
define("CLASSE_HTML_TEMPLATE", CLASSE_PATH . "htmlTemplate.class.php");
define("LIB_MAIN", COMMON_LIB_PATH . "main.lib");
define("CLASSE_TEXTO", CLASSE_PATH . "textHandler.class.php");
define("CLASSE_PAGINACAO", CLASSE_PATH . "paginacao.class.php");
define("CLASSE_GERAL", CLASSE_PATH . "geral.class.php");

/*
 * CONTATO
 */
define('EMAIL_ADMIN', 'rodrigopluz@gmail.com'); // Email para qual vão os logs de cadastro
define('EMAIL_CONTATO', 'rodrigopluz@gmail.com'); //
define("IMG_MAIL_PATH", "");

?>
