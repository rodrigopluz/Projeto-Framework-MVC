<?php

class Error {

	var $erros = array();
	var $emailSuporte = "suporte@reweb.com.br";
	
	public function __construct() {
		
		
	}

	public function geraErro($code,$msg="Erro inesperado.") {
		
		/// SE TEM C�DIGO, PEGA O ERRO PR�-FORMATADO
		if ($code != 0)
			$msg = self::errorMessage($code);
	
		$this->erros[] = $msg;
		
	}

	public function errorMessage ($err) {
		/// TESTA SE AS VARI�VEIS OBRIGAT�RIAS (required) EST�O PREENCHIDAS NO POST
		
		switch ($err) {
			
			default:
				$msg = "Erro indefinido.";
			break;
			
			case 1:
				$msg = "P�gina n�o encontrada.";
			break;
			
			case 2:
				$msg = "Sua sess�o expirou. Fa�a o login novamente.";
			break;
			
			case 3:
				$msg = "ACESSO NEGADO<br><br>Voc� n�o tem permiss�o para acessar esta �rea do sistema.";
			break;
			
			case 4:
				$msg = "Login inv�lido ou usu�rio bloqueado. Verifique seu usu�rio e senha.";
			break;
			
			case 404:
				$msg = "P�gina n�o encontrada.";
			break;
			
			
			
		}
			
		return $msg;
		
	}
	
	public function mostrarErros ($template) {
		/// MOSTRA OS ERROS NA TELA PARA O TEMPLATE PASSADO
		// $template = TEMPLATE PASSADO
		
		$msg = implode("<br>",$this->erros);
		if ($msg) {
			$template->newBlock("bloco_erro");
			
			$template->assign('erro',$msg."<BR><BR>");/// IMPRIME A MENSAGEM DE ERRO
			
			
			foreach ($_POST as $input=>$valor) {/// REPOPULA OS CAMPOS DO FORM
				$template->assignGlobal($input,$valor);
			}
			
			$template->assign("voltar",'<div class="classe_dia" style="color:#999999; padding-top:10px;"><a href="#" style="color:#999999;" onclick="window.history.go(-2);"><b>&laquo; &laquo; voltar</b></a></div>');
			
		}
		
	}
	
	public function enviaErro ($url,$erro,$strQuery) {
		
		$msg = '<p><b>ERRO DE BANCO DE DADOS:</b>';
		
		$msg .= '<p>Erro: '.$erro;
		$msg .= '<p>SQL: '.$strQuery;
		$msg .= '<p>URL: '.$url;
		$msg .= '<b><p>Timestamp:</b> '.date("F j, Y, g:i a");
		
		$headers = "MIME-Version: 1.0\n";
		
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		
		$headers .= "From: MARPA SISTEMA <erro@marpa.com.br>\n";
		
		@mail("suporte@reweb.com.br",'ERRO DE BANCO DE DADOS',$msg,$headers);

		
	}
	
    public function debug() {
    	echo "<PRE>";
	   print_r($this->erros);
    }
	
}

$error = new Error();

?>