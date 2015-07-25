<?php
class Formatacao {
	
	function desformata ($c) {
		$c = str_replace("/","",$c);
		$c = str_replace("\\","",$c);
		$c = str_replace(".","",$c);
		$c = str_replace("-","",$c);		
		return $c;
	}
	
	function mascaraCPF($cpf) {
		$str = $cpf;
		$novo_cpf = "";
		for ($i = 0 ; $i < strlen($str) ; $i ++ ) {
			if ($i == 2)
			   	$caracter = $str[$i] . '.';
			elseif ($i == 5)
				$caracter = $str[$i] . '.';
			elseif ($i == 8)
				$caracter = $str[$i] . '-';
			else 
				$caracter = $str[$i];				
			$novo_cpf .= $caracter;
		}
		return $novo_cpf;
	}
	
	function mascaraCNPJ($cnpj) {
		$str = $cnpj;
		$novo_cnpj = "";
		for ($i = 0 ; $i < strlen($str) ; $i ++ ) {
			if ($i == 1)
			   	$caracter = $str[$i] . '.';
			elseif ($i == 4)
				$caracter = $str[$i] . '.';
			elseif ($i == 7)
				$caracter = $str[$i] . '/';
			elseif ($i == 11)
				$caracter = $str[$i] . '-';
			else 
				$caracter = $str[$i];
			$novo_cnpj .= $caracter;
		}
		return $novo_cnpj;
	}
}

$formata = new Formatacao();

?>