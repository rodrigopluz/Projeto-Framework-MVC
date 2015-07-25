<?php
global $geral;

class paginar {

	var $variaveis 	= array();
	var $paginas 	= array();
	var $mysql 		= array();
	var $mensagens 	= array();
	var $totalReg 	= array();
	
	//NUMERO DE RESULTADOS POR P�GINA
	var $numero; 
	//variavel passada por url para o link das p�ginas. Ex: localhost/teste.php?pagina=1 -> 'pagina'
	var $url;    
	// ANCORA PARA O RETORNO
	var $ancora; 
		
	function paginar() {
		$this->variaveis['SEPARADOR'] = " | "; // separador da barra de nave��o das p�ginas
		if(!$this->paginas['PAGINA']) 
			$this->paginas['PAGINA'] = 1; // p�gina atual, caso n�o informada o padr�o � 1
		
		// MENSAGENS
		$this->mensagens['SEM_RESULTADOS'] = "";
		$this->mensagens['MYSQL_ERRO_LINK'] = "<b>ERRO NO MYSQL</b>";
	}
	
	/*
	processar()
	@param string $query 
	
	faz uma consultado com $query e define os resultados para constru��o da barra
	*/
	function processar($strTable, $strFields, $strWhere='', $strOrderBy = '', $intLimit = '', $strGroupBy = '') {
		// n�mero m�ximo de resultados exibidos por p�gina
		$this->paginas['POR_PAGINA'] = $this->numero; 
		$strQuery = 'SELECT '.$strFields; 
		if ($strTable) {
	      $strQuery .= ' FROM ';
	      if (is_array($strTable))
	        foreach ($strTable as $tbl)
	          $strQuery .= $this->tblprefix.$tbl.' ';
	      else                        
	        $strQuery .= $this->tblprefix.$strTable;
	    }
	    
	    if ($strWhere) $strQuery   .= ' WHERE '.$strWhere;
	    if ($strGroupBy) $strQuery .= ' GROUP BY '.$strGroupBy;
	    if ($strOrderBy) $strQuery .= ' ORDER BY '.$strOrderBy;
	    if ($intLimit) $strQuery   .= ' LIMIT '.$intLimit;
		
	    $query = $strQuery;
	    /// RETORNA O VALOR TOTAL, SEM LIMIT
		$this->mysql['TOTAL'] = ($this->mysql['LINK'] ? pg_num_rows(pg_query($query,$this->mysql['LINK'])) : pg_num_rows(pg_query($query))); 
		/// RETORNA A CONSULTA J� COM O LIMIT
		$this->mysql['QUERY'] = $query." LIMIT ".$this->paginas['POR_PAGINA']." OFFSET ".(($this->paginas['PAGINA']-1)*$this->paginas['POR_PAGINA']); 
		/// TOTAL DE P�GINAS BASEADAS NO TOTAL DE RESULTADOS E NO M�XIMO DE RESULTADOS POR P�GINA
		$this->paginas['TOTAL'] = ceil($this->mysql['TOTAL']/$this->paginas['POR_PAGINA']); 	
	}

	function processarSQL($strQuery) {
		// n�mero m�ximo de resultados exibidos por p�gina
		$this->paginas['POR_PAGINA'] = $this->numero; 
	    $query = $strQuery;
	    /// RETORNA O VALOR TOTAL, SEM LIMIT
		$this->mysql['TOTAL'] = ($this->mysql['LINK'] ? @mysql_num_rows(mysql_query($query,$this->mysql['LINK'])) : @mysql_num_rows(mysql_query($query))); 
		/// TIRA O LIMIT DA CONSULTA, SE J� EXISTE
		if (ereg("LIMIT",$query)) {
			$limit_pos = strpos($query,"LIMIT");
			$query = substr($query,0,$limit_pos);
		}
		/// RETORNA A CONSULTA J� COM O LIMIT
		//$this->mysql['QUERY'] = $query." LIMIT ".$this->paginas['POR_PAGINA']." OFFSET ".(($this->paginas['PAGINA']-1)*$this->paginas['POR_PAGINA']); 
		$this->mysql['QUERY'] = $query." LIMIT ".(($this->paginas['PAGINA']-1)*$this->paginas['POR_PAGINA']).",".$this->paginas['POR_PAGINA']; 
		/// TOTAL DE P�GINAS BASEADAS NO TOTAL DE RESULTADOS E NO M�XIMO DE RESULTADOS POR P�GINA
		$this->paginas['TOTAL'] = ceil($this->mysql['TOTAL']/$this->paginas['POR_PAGINA']); 
	}
	
	function imprimir_paginas($url=false) {///// IMPRIME A LISTAGEM DE P�GINAS
		$this->variaveis['PAGINA'] = $this->url."&amp;pagina"; 
		$paginas = "";
		if($this->paginas['TOTAL'] > 1) {
			for($i=0;$i<$this->paginas['TOTAL'];$i++) { 
				
				/// TESTA SE � A P�GINA ATUAL
				if ($i+1 != $this->paginas['PAGINA']) 
					$link = "<span><a href=\"".(strstr($url,'?') ? $url."&amp;".$this->variaveis['PAGINA']."=".($i+1) : "?".$this->variaveis['PAGINA']."=".($i+1))."\" onclick=\"paginacao('".(strstr($url,'?') ? $url."&amp;".$this->variaveis['PAGINA']."=".($i+1) : "?".$this->variaveis['PAGINA']."=".($i+1))."'); return false;\">";
				else 
					$link = "<span class='selected'><a href='#' onclick='return false;'>";
				if ($i >= $this->paginas['PAGINA'] - 6 && $i <= $this->paginas['PAGINA'] + 6)
					$paginas .= "$link".($i+1 == $this->paginas['PAGINA'] ? "<b><u>".($i+1)."</u></b>" : ($i+1))."</a>&nbsp;</span>".($i < $this->paginas['TOTAL']-1 ? '&nbsp;' : false);
			}
		}
		else 
			$paginas = $this->mensagens['SEM_RESULTADOS'];
		return $paginas;
	}
	
	function imprimir_pagina_atual() { ///// IMPRIME QUAL P�GINA EST�
		if($this->paginas['TOTAL'] > 1) 
			$pagina = "<font class='selected'>".$this->paginas['PAGINA']."</font>";
		else 
			$pagina = $this->mensagens['SEM_RESULTADOS'];
		return $pagina;	
	}

	function link_pagina_anterior() {
		// RETORNA UM LINK EM AJAX PARA A P�GINA ANTERIOR
		if ($this->paginas['PAGINA'] > 1) {
			$linkpaginas = "pagina=".($this->paginas['PAGINA']-1);
			$link = "?$this->url&amp;$linkpaginas";
		}
		else return '#';
		return $link;
	}
	
	function link_pagina_proxima() {
		if ($this->paginas['PAGINA'] < $this->paginas['TOTAL']) {	
			$linkpaginas = "pagina=".($this->paginas['PAGINA']+1);
			$link = "?$this->url&amp;$linkpaginas";
		}
		else return '#';
		return $link;
	}
	
	function link_pagina_primeira() {	
		//if ($this->paginas['PAGINA'] > 1) {
			$linkpaginas = "pagina=1";	
			$link = "?$this->url&amp;$linkpaginas";
		//}
		//else return '#';
		return $link;
	}
	
	function link_pagina_ultima() {
		//if ($this->paginas['PAGINA'] < $this->paginas['TOTAL']) {
			$linkpaginas = "pagina=".$this->paginas['TOTAL'];
			$link = "?$this->url&amp;$linkpaginas";
		//}
		//else 
			//return '#';
		return $link;
	}
	
	function assign ($TPLV) {
		//// CRIA O BLOCO DE PAGINACAO		
	    if ($this->paginas['TOTAL'] > 1)
	    	$TPLV->newBlock('paginacao');
	    
		$TPLV->assign("paginacao_anterior",$this->link_pagina_anterior());
		$TPLV->assign("paginacao_proxima",$this->link_pagina_proxima());
		$TPLV->assign("paginacao_primeira",$this->link_pagina_primeira());
		$TPLV->assign("paginacao_ultima",$this->link_pagina_ultima());
		$TPLV->assign("paginas",$this->imprimir_paginas());
		$TPLV->assign("pagina",$this->imprimir_pagina_atual());
	}
}

?>
