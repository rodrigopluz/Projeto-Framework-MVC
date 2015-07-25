<?php

// *******************************************************************************************************************************
// edz_dbmy v.1.13
// *******************************************************************************************************************************
// :: fun��es de acesso � base de dados MYSQL
// *******************************************************************************************************************************

class edz_db {
    var $tblprefix = '';
    var $intests = false;
    var $begin;
    var $idLink = null;
    var $strErrorDescription = null;
    var $intErrorNumber = null;
    var $intRows = null;
    var $intInsertId = null;
    var $strHostUser = null;
    var $debug = false;
    var $emailSuporte = "augusto@reweb.com.br";

    function edz_db($strHost, $strUserName, $strPassword, $strDatabase) {
        $this->strHostUser = $strHost.'/'.$strUserName;
        $this->idLink = mysql_connect($strHost, $strUserName, $strPassword);
        $this->db_handle_error();
        mysql_select_db($strDatabase);
        mysql_set_charset(MYSQL_CHARSET,$this->idLink);
        $this->db_handle_error();
        return $this->idLink;
    }

    function db_handle_error($strQuery = '') {
        //$error_html = file_get_contents(COMMON_PATH."../reweb/erro/index.htm");
        //$error_html = file_get_contents(RESOURCE_PATH."templates/erroDB.tpl");
        $error_msg = "";
        if (!$this->idLink || ($this->strErrorDescription = mysql_error($this->idLink)) || ($this->intErrorNumber = mysql_errno($this->idLink))) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $msg .= '<p><b>Erro:</b> '.$this->strErrorDescription;
            $msg .= '<p><b>SQL:</b> '.$strQuery;
            $msg .= '<p><b>Filename:</b> '.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
            $msg .= '<b><p>Timestamp:</b> '.date("F j, Y, g:i a");
            $msg .= '<p><b>Server/User:</b>'.$this->strHostUser;
            $msg .= '<p><b>IP:</b>'.$ip;
            $headers = "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            $headers .= "From: Web Control <webcontrol@reweb.com.br>\n";
            @mail($this->emailSuporte,'ERRO: '.$_SERVER['PHP_SELF'],$msg,$headers);
            $error_msg .= '<p><b>Erro de Acesso ao Banco de Dados</b><br><br>Confira os dados digitados e tente novamente.<br>Relat�rio de erro enviado para a Reweb.</p><br><a href="javascript:history.back();">&laquo; Voltar</a>';
            $error_html = str_replace("{imagePath}",IMAGE_PATH,$error_html);
            $error_html = str_replace("{modulo}",'Erro',$error_html);
            $error_html = str_replace("{erro}",$error_msg,$error_html);
            echo $error_html . "<BR>" . $msg;
            die();
        }
        else return 1;
    }  

    function db_select($strTable, $strFields, $strWhere, $strOrderBy = '', $intLimit = '', $bNumRows = 0, $strGroupBy = '', $debug = '', $shallow = 0) {
        $strQuery = 'SELECT '.$strFields; 
        if ($strTable) {
            $strQuery .= ' FROM ';
            if (is_array($strTable))
                foreach ($strTable as $tbl)
                    $strQuery .= $this->tblprefix.$tbl.' ';
            else                        
                $strQuery .= $this->tblprefix.$strTable;
        }
        if ($strWhere) $strQuery .= ' WHERE '.$strWhere;
        if ($strGroupBy) $strQuery .= ' GROUP BY '.$strGroupBy;
        if ($strOrderBy) $strQuery .= ' ORDER BY '.$strOrderBy;
        if ($intLimit) $strQuery .= ' LIMIT '.$intLimit;
        if ($debug || $this->debug) echo "<p style=color:#008080>$strQuery</p>";
        $aReturn = array();
        $idResult = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if ($bNumRows)
            $this->intRows = mysql_num_rows($idResult);
        else
            $this->intRows = null;
        if ($shallow == 0xff) {
            while ($row = mysql_fetch_array($idResult,MYSQL_BOTH))
                $aReturn[$row[0]] = $row;
        }
        elseif (mysql_num_fields($idResult) == 1 && $shallow) {
            while ($row = mysql_fetch_row($idResult))
                $aReturn[] = $row[0];
        }
        else {
            while ($aReturn[] = mysql_fetch_assoc($idResult));
            unset($aReturn[count($aReturn)-1]);  //remove o �ltimo item, que sempre ia em branco
        }
        mysql_free_result($idResult);
        //print($strQuery);die();
        if (!is_array($aReturn)) 
            $aReturn = 0;
        /*
        if (count($aReturn) == 1)
            $aReturn = $aReturn[0];
        */
        return $aReturn;
    }                       

    function db_insert($strTable, $strSetList, $bNumRows = 0, $bInsertId = 0, $debug = '') {
        $strQuery = 'INSERT '.$this->tblprefix.$strTable.' SET '.$strSetList;
        if ($debug || $this->debug) echo "<p style=color:#008080>$strQuery</p>";
        $intReturn = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if ($bNumRows)
            $this->intRows = mysql_affected_rows($this->idLink);
            $this->intInsertId = mysql_insert_id($this->idLink);
        return $this->intInsertId;
    } 

    function db_insertmulti($strTable, $strFieldList, $aValuesList, $bNumRows = 0, $bInsertId = 0, $debug = '') {
        $strQuery = 'INSERT '.$this->tblprefix.$strTable.' ('.$strFieldList.') ';
        $strQuery .= 'VALUES ('.implode('),(',$aValuesList).')';
        if ($debug || $this->debug) echo "<p style=color:#008080>$strQuery</p>";
        $intReturn = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if ($bNumRows)
            $this->intRows = mysql_affected_rows($this->idLink);
        if ($bInsertId)
            $this->intInsertId = mysql_insert_id($this->idLink);
        return $intReturn;
    } 

    function db_update($strTable, $strSetList, $strWhere, $intLimit = 0, $bNumRows = 0, $debug = '') {
        $strQuery = 'UPDATE '.$this->tblprefix.$strTable.' SET '.$strSetList.' WHERE '.$strWhere;
        if ($intLimit) $strQuery .= ' LIMIT '.$intLimit;
        if ($debug || $this->debug) echo "<p style=color:#008080>$strQuery</p>";
        $intReturn = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if ($bNumRows)
            $this->intRows = mysql_affected_rows($this->idLink);
        return $intReturn;
    }       

    function db_fields_name ($tabela) {	
        $res = mysql_query("DESCRIBE $tabela");
        $fields = array();
        while ($ar = mysql_fetch_array($res)) {
            $field = $ar['Field'];
            $fields[] = $field;
        }
        return $fields;
    }

    function db_field_info ($tabela,$campo='') {	
        $res = mysql_query("DESCRIBE $tabela");
        $fields = array();
        $campo = strtoupper($campo);
        while ($ar = mysql_fetch_array($res)) {
            $field = strtoupper($ar['Field']);
            $tipo = $ar['Type'];
            $max = ($tipo!='text'?255:'');
            if (strpos($tipo,'(') > 0) {
                $pos = strpos($tipo,"(");
                $pos2 = strpos($tipo,")");
                $max = substr($tipo,$pos+1,$pos2-$pos-1);
                $tipo = substr($tipo,0,$pos);
            }
            $fields[$field]['tipo'] = $tipo;
            $fields[$field]['max'] = ($max?$max:255);
            $fields[$field]['obrigatorio'] = ($ar['Null']=='NO'?1:0);
        }
        if ($campo != '')
            return $fields[$campo];
        else 
            return $fields;
    }

    function db_replace($strTable, $strSetList, $bNumRows = 0, $bInsertId = 0, $debug = '') {
        $strQuery = 'REPLACE '.$this->tblprefix.$strTable.' SET '.$strSetList;
        if ($debug || $this->debug) echo "<p style=color:#008080>$strQuery</p>";
        $intReturn = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if ($bNumRows)
            $this->intRows = mysql_affected_rows($this->idLink);
        if ($bInsertId)
            $this->intInsertId = mysql_insert_id($this->idLink);
        return $intReturn;
    }     

    function db_delete($strTable, $strWhere, $strOrderBy = '', $intLimit = 0, $bNumRows = 0) {
        $strQuery = 'DELETE FROM '.$this->tblprefix.$strTable.' WHERE '.$strWhere;
        if ($strOrderBy) $strQuery .= ' ORDER BY '.$strOrderBy;
        if ($intLimit) $strQuery .= ' LIMIT '.$intLimit;
        $intReturn = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if ($bNumRows)
            $this->intRows = mysql_affected_rows($this->idLink);
        return $intReturn;
    }
    
    function db_truncate($strTable) {
        $strQuery = 'TRUNCATE TABLE '.$this->tblprefix.$strTable;
        $intReturn = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        return $intReturn;
    }

    function db_updins($strTable, $strSetListPrimary, $strSetList, $bNumRows = 0, $bInsertId = 0) {
        $strWhere = str_replace(',',' AND ', $strSetListPrimary);
        $strQuery = 'SELECT 1 FROM '.$this->tblprefix.$strTable.' WHERE '.$strWhere;
        $idResult = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if (mysql_num_rows($idResult))
            return $this->db_update($strTable, $strSetList, $strWhere, 0, $bNumRows);
        else
            return $this->db_insert($strTable, ($strSetListPrimary?$strSetListPrimary.',':'').$strSetList, $bNumRows = 0, $bInsertId = 0);
    }

    function db_selins($strTable,$strSearch,$strPrimaryField) {
        //se existe $strSearch em $strTable, retorna o valor de $strPrimaryField
        //se n�o existe, insere e retorna o valor de $strPrimaryField rec�m inserido
        $strQuery = 'SELECT '.$strPrimaryField.' FROM '.$this->tblprefix.$strTable.' WHERE '.$strSearch;
        $idResult = mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
        if (mysql_num_rows($idResult)) {
            $row = mysql_fetch_row ($idResult);
            return $row[0];
        }
        else {
            $this->db_insert($strTable, $strSearch, 0, 1);
            return $this->intInsertId;
        }
    }

    function db_lock($strTable, $strMode) {
        $strQuery = 'LOCK TABLES '.$this->tblprefix.$strTable.' '.$strMode;
        mysql_query($strQuery, $this->idLink);
        return $this->db_handle_error($strQuery);
    }

    function db_unlock() {
        $strQuery = 'UNLOCK TABLES';
        mysql_query($strQuery, $this->idLink);
        return $this->db_handle_error($strQuery);
    }

    function db_begin() {
        $this->begin = 1;
        $strQuery = 'begin';
        echo $this->begin; exit;
        mysql_query($strQuery, $this->idLink);
        // $this->db_handle_error($strQuery);
    }

    function db_rollback() {
        $strQuery = 'rollback';
        mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
    }

    function db_commit() {
        $strQuery = 'commit';
        mysql_query($strQuery, $this->idLink);
        $this->db_handle_error($strQuery);
    }

    function db_query($strQuery) {
        /////// EXECUTA A QUERY, � S� PASSAR O SQL
        $idResult = mysql_query($strQuery);
        $this->db_handle_error($strQuery);
        if ($bNumRows)
            $this->intRows = mysql_num_rows($idResult);
        else
            $this->intRows = null;
        if ($shallow == 0xff) {
            while ($row = mysql_fetch_array($idResult,MYSQL_BOTH))
                $aReturn[$row[0]] = $row;
        }
        elseif (@mysql_num_fields($idResult) == 1 && $shallow) {
            while ($row = @mysql_fetch_row($idResult))
                $aReturn[] = $row[0];
        }
        else {
            while ($aReturn[] = @mysql_fetch_assoc($idResult));
            unset($aReturn[count($aReturn)-1]);  //remove o �ltimo item, que sempre ia em branco
        }
        @mysql_free_result($idResult);
        //print($strQuery);die();
        if (!is_array($aReturn)) 
            $aReturn = 0;
        /*
        if (count($aReturn) == 1)
            $aReturn = $aReturn[0];
        */
        return $aReturn;
    }

    function db_query2($strQuery) {
        /////// SEM FRESCURA, pra insert...
        if (mysql_query($strQuery))
            return mysql_insert_id();
        else 
            return mysql_error();
    }

    function db_enumvalues($table, $enumfield) {
        $result = mysql_query('SHOW COLUMNS FROM '.$this->tblprefix.$table.' LIKE \''.$enumfield.'\'', $this->idLink);
        if ($row = mysql_fetch_row($result))
            return explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));
        else
            return false;
    }

    function db_close() {
        mysql_close($this->idLink);
    }

    // *******************************************************************************************************************************
    // subst: subtitui��o para ser usada em strings sql
    // *******************************************************************************************************************************
    // $dataType= 1 is_int(), 2 is_string(), 3 is_bool(), 4 is_float(), 5 date
    // *******************************************************************************************************************************
    function asubst($sql, $avalue, $aisnull = 0, $adataType = 0, $atrimValue = 1, $aapostrophes = 1) {
        $params = preg_split('/\W+/',$sql);
        //print_r($params);
        //transforma :a em a=:a
        $sql = preg_replace('/:(\w+)\b/i','$1=:$1',$sql);
        //echo $sql;
        //substitui todos :a por $avalue['a']
        foreach ($params as $param) 
            if ($param)
                $sql = $this->subst($sql,$param,$avalue[$param]);
                //retorna a string
                return $sql;
    }

    function subst($sql, $param, $value, $isnull = 0, $dataType = 0, $trimValue = 1, $apostrophes = 1) {
        if ($dataType == 0) {
            if (is_null($value) or $isnull) $dataType = 6;
            elseif (is_int($value)) $dataType = 1;
            elseif ($this->is_date($value)) $dataType = 5;  //tem que vir antes de is_string
            elseif (is_bool($value)) $dataType = 3;
            elseif (is_numeric(str_replace(',','.',$value))) $dataType = 4;  //pode pegar algum long ou inteiro string, mas n�o tem problema
            elseif (is_string($value)) $dataType = 2;
        }
        switch ($dataType) {
            case 1: //Numeros Inteiros
                $strValor = $value;
                break;
            case 2: //Strings
                if ($apostrophes) {
                    $strValor = "'".$this->fixApostrophe($value, $trimValue)."'";
                }
                else $strValor = $value;
                break;
            case 3: //Booleano
                $strValor = ($value?1:0);
                break;
            case 4: //Numeros Fracionarios
                //troca v�rgula por ponto
                $strValor = str_replace(',', '.', $value);
                break;
            case 5: //Datas
                $temp = preg_split('/\/|-|\s|:/', $value);
                $strValor = str_pad($temp[2],4,'20',STR_PAD_LEFT).'-'.str_pad($temp[1],2,'0',STR_PAD_LEFT).'-'.str_pad($temp[0],2,'0',STR_PAD_LEFT);
                if (isset($temp[3])) $strValor .= ' '.str_pad($temp[3],2,'0',STR_PAD_LEFT).':'.str_pad($temp[4],2,'0',STR_PAD_LEFT);
                if (isset($temp[5])) $strValor .= ':'.str_pad($temp[5],2,'0',STR_PAD_LEFT);
                $strValor = '\''.$strValor.'\'';
                break;
            case 6: //null
                $isNull = true;
                $strValor = 'null';
                break;
            default: //Valor nao previsto
                echo 'Tipo de dados nao previsto - '.gettype($value).' - inserindo como texto';
                $strValor = "'".$this->fixApostrophe($value, $trimValue)."'";
        }
        $sql = preg_replace('/:'.strtolower($param).'\b/i',$strValor,$sql);
        return $sql;
    }

    function is_date($value) {
        if (!$value) return false; //n�o aceita valor nulo, sen�o qualquer string vazia ou 0 vira data
        $erDataHora = '/^((0?[1-9])|([1-2]\d)|(3[0-1]))(\/|\-)((0?[1-9])|(1[0-2]))(\/|\-)((20)?[0-5]\d)((\s+(([0-1]?\d)|(2[0-3])):([0-5]?\d)(:([0-5]?\d))?))?/';
        //testa sintaxe
        if (preg_match($erDataHora, $value)) {
            $arr = preg_split('/\/|\-|\s/', $value);
            //dependendo do m�s, n�mero de dias pode ser diferente
            if ($arr[1]==1||$arr[1]==3||$arr[1]==5||$arr[1]==7||$arr[1]==8||$arr[1]==10||$arr[1]==12)
                $intCeiling = 31;
            else
                if ($arr[1]==4||$arr[1]==6||$arr[1]==9||$arr[1]==11)
                    $intCeiling = 30;
                else {
                    if (($arr[2]%4==0) && !(($arr[2]%100==0) || ($arr[2]%400==0)))
                        $intCeiling = 29;  //ano bissexto
                    else
                        $intCeiling = 28;
                }
                if ($arr[0] > $intCeiling) return false;
                else return true;
        }
        else return false;
    }
    
    function fixApostrophe ($value, $trimValue) {
        $value = str_replace('\\"','', $value);
        $value = str_replace("\\'",'', $value);
        $value = str_replace('`','', $value);
        $value = str_replace('�','', $value);
        $value = str_replace("'",'', $value);
        if ($trimValue) $value = trim($value);
        return $value;
    }
}

?>