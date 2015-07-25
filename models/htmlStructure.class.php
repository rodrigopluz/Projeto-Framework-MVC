<?php
//----- classes utilizadas -----------
require_once(CLASSE_HTML);
//------------------------------------

global $geral;

class htmlStructure extends html {

    var $AUTENTICACAO_ID;
    var $superadmin;
    var $db;

    function htmlStructure($pageLayout = DEFAULT_PAGE_LAYOUT, $pageAlign = DEFAULT_PAGE_ALIGN, $pageSize = PAGE_SIZE) {

        global $db, $geral, $urls;

        parent::html($pageLayout, $pageAlign, $pageSize);

        $db = new edz_db(DB_HOST, DB_USER, DB_PASS, DB_BASE);

        $this->setTitle($urls->title);
        $this->setDescription($urls->description);
        $this->setKeywords($urls->keywords);
    }

    function configPage($header = TRUE, $menu = TRUE) {
        global $db, $geral, $usuario;
        //-----------------------------------------
        //	 configPage($header*,$menu**,$footer***
        //            $right_menu****)
        // adiciona e processa os objetos basicos
        // das paginas dentro do FLORES
        // * $header (flag de existencia do header)
        // ** $menu (flag de existencia do menu)
        // *** $footer (flag de existencia do footer)
        // **** $right_menu (flag do menu direito)
        //-----------------------------------------
        $pageHeader = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";

        $on = $_GET['on'] == '' ? 'login' : $_GET['on'];
        $in = $_GET['in'];

        parent::addScript("jquery.js", FALSE);
        parent::addScript("common.js", FALSE);

        parent::addScript("jquery.autocomplete.js", FALSE);
        parent::addScript("functions.js", FALSE);
		
        if (is_file(SCRIPT_SERVER_PATH . "modulos/" . $_GET['on'] . ".js"))
            parent::addScript("modulos/" . $_GET['on'] . ".js", FALSE);
        	parent::addScript("plugins-jquery/scripts/tiny_mce/tiny_mce.js", FALSE);
	        parent::addScript("plugins-jquery/colorbox/jquery.colorbox-min.js", FALSE);
    		parent::addStyle(SCRIPT_PATH . "plugins-jquery/colorbox/colorbox.css", FALSE);

        if ($_GET['on'] == "produtos") {
            parent::addScript("plugins-jquery/jquery.highlightFade.js", FALSE);
        }
        
        parent::addStyle("styles.css");
        parent::addStyle("styles_ie.css");
        parent::addStyle("pagination.css");
        parent::addStyle("jquery.autocomplete.css");

        if (is_file(STYLE_SERVER_PATH . "modulos/" . $_GET['on'] . ".css"))
            parent::addStyle("modulos/" . $_GET['on'] . ".css");

        parent::makePage();

        $this->body->substituiValor("imagePath", IMAGE_PATH);
        $this->body->substituiValor("fontPath", FONTTRUETYPE_PATH);
        $this->body->substituiValor("swfPath", SWF_PATH);
        $this->body->substituiValor("localPath", LOCAL_PATH);
        $this->body->substituiValor("uploadPath", UPLOAD_PATH);
        $this->body->substituiValor("on", $on);
        $this->body->substituiValor("in", $in);

        $this->_topo();
        $this->_menu();
        $this->_navBottom();
        $this->_rodape();
    }

    function _topo() {
        global $db, $geral, $usuario;

        $TOPO = new templatePower(TEMPLATE_PATH . "/includes/topo.tpl");
        $TOPO->prepare();
        $TOPO->assignGlobal("imagePath", IMAGE_PATH);
        $TOPO->assignGlobal("swfPath", SWF_PATH);
        $TOPO->assignGlobal("localPath", LOCAL_PATH);

        if ($usuario->isLogado()) {
            $TOPO->newBlock('dados');
            $TOPO->assignGlobal("usuario", $_COOKIE['login']['nome']);
        }

        $this->body->substituiValor("topo", $TOPO->getOutputContent());
    }

    function _menu() {
        global $db, $geral, $usuario;

        $MENU = new templatePower(TEMPLATE_PATH . "/includes/menu.tpl");
        $MENU->prepare();
        $MENU->assignGlobal("imagePath", IMAGE_PATH);
        $MENU->assignGlobal("swfPath", SWF_PATH);
        $MENU->assignGlobal("localPath", LOCAL_PATH);

        if ($usuario->isLogado()) {
            #### MONTA O MENU DO USUARIO
            $rows = $usuario->getUserPermissions($usuario->id);

            foreach ($rows as $row) {
                $MENU->newBlock('menu');
                $MENU->assign($row);

                $sql = "SELECT link, nome as sub FROM app_modulos_links WHERE modulo_id = '" . $row['modulo_id'] . "' ORDER BY modulo_id";
                $r = $db->db_query($sql);
                foreach ($r as $rs) {
                    if ($_GET['on'] == $row['arquivo'])
                        $MENU->newBlock('submenu');
                    $MENU->assign($rs);
                }
            }
            #### MONTA O MENU DO USUARIO
        }
        $this->body->substituiValor("menu", $MENU->getOutputContent());
    }

    function _navBottom() {
        global $db, $geral, $urls;

        $NAV = new templatePower(TEMPLATE_PATH . "includes/navBottom.tpl");
        $NAV->prepare();
        $NAV->assignGlobal("imagePath", IMAGE_PATH);
        $NAV->assignGlobal("swfPath", SWF_PATH);
        $NAV->assignGlobal("localPath", LOCAL_PATH);
        $NAV->assignGlobal($urls->var);

        $on = $_GET['on'] == '' ? 'capa' : $_GET['on'];

        if ($on != 'capa')
            $this->body->substituiValor("navBottom", $NAV->getOutputContent());
        else
            $this->body->substituiValor("navBottom", '');
    }

    function _rodape() {
        global $db, $geral, $urls;

        $RODAPE = new templatePower(TEMPLATE_PATH . "includes/rodape.tpl");
        $RODAPE->prepare();
        $RODAPE->assignGlobal("imagePath", IMAGE_PATH);
        $RODAPE->assignGlobal("swfPath", SWF_PATH);
        $RODAPE->assignGlobal("localPath", LOCAL_PATH);
        $RODAPE->assignGlobal("spam", $urls->spam);
        $RODAPE->assignGlobal($urls->var);

        $this->body->substituiValor("rodape", $RODAPE->getOutputContent());
    }
}

?>