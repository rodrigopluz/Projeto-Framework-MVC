<?php
class Geral {

	public function __construct() {
		//----------------------------------------------------------------	
		// CONSTRUTORA DA CLASSE
		//----------------------------------------------------------------
		if (!function_exists('__autoload')) {
			function __autoload($class_name) {
				if (is_file(CLASSE_PATH . $class_name . '.class.php'))
					require_once CLASSE_PATH . $class_name . '.class.php';
				if (is_file(CLASSE_PATH . 'app/' . $class_name . '.class.php'))
					require_once CLASSE_PATH . 'app/' . $class_name . '.class.php';
				if (is_file(CLASSE_PATH . $class_name . '.php'))
					require_once CLASSE_PATH . $class_name . '.php';
				if (is_file(CLASSE_PATH . 'app/' . $class_name . '.php'))
					require_once CLASSE_PATH . 'app/' . $class_name . '.php';
			}
		}
		
		require_once(CLASSE_POWER_TEMPLATE);
		require_once(LIB_MAIN);
		require_once(CLASSE_TEXTO);
		require_once(CLASSE_HTML_STRUCTURE);
		require_once(CLASSE_PAGINACAO);
		require_once(CLASSE_PATH.'formatacao.class.php');
		require_once(CLASSE_PATH.'error.class.php');
		require_once(CLASSE_PATH.'db.class.php');
		
		$this->dateFormat = new dateFormat();
	}
}

?>