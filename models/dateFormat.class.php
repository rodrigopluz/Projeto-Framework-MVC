<?php
class dateFormat{
	
	function isEuroDate($date, &$regs) {
		$date = trim($date);
		if (ereg("^([0-9]{1,2})(/|\-|\.)([0-9]{1,2})(/|\-|\.)([0-9]{4})([[:space:]]([0-9]{1,2}):([0-9]{1,2}):?([0-9]{1,2})?)?$", $date, $matches)) {
			$regs = array(
				$matches[0], 
				$matches[1], $matches[3], $matches[5], 
				$matches[6], $matches[7], $matches[8]
			);
			return TRUE;
		}
		return FALSE;
	}

	function isSqlDate($date, &$regs) {
		$date = trim($date);
		return (ereg("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})([[:space:]]([0-9]{1,2}):([0-9]{1,2}):?([0-9]{1,2})?)?$", $date, $regs));
	}

	function fromEuroToSqlDate($date) {
		if (dateFormat::isEuroDate($date, $regs)) {
			return "$regs[3]-$regs[2]-$regs[1]";
		} else {
			return $date;
		}
	}

	public function fromSqlToEuroDate($date) {
		if (dateFormat::isSqlDate($date, $regs)) {
			return "$regs[3]/$regs[2]/$regs[1]";
		} else {
			return $date;
		}
	}
}

function lastDay($data){
	$data = dateFormat::fromEuroToSqlDate($data);
	$ar = explode('-',$data);
	$ano = $ar[0];
	$mes = $ar[1];
	if (((fmod($ano,4)==0) and (fmod($ano,100)!=0)) or (fmod($ano,400)==0)) {
		$dias_fevereiro = 29;
	} else {
		$dias_fevereiro = 28;
	}
	switch($mes) {
		case 01: $dia = 31; break;
		case 02: $dia = $dias_fevereiro; break;
		case 03: $dia = 31; break;
		case 04: $dia = 30; break;
		case 05: $dia = 31; break;
		case 06: $dia = 30; break;
		case 07: $dia = 31; break;
		case 08: $dia = 31; break;
		case 09: $dia = 30; break;
		case 10: $dia = 31; break;
		case 11: $dia = 30; break;
		case 12: $dia = 31; break;
	}
	return "$ano-$mes-$dia";
}

?>