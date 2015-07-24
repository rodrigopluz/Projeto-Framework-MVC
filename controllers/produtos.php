<?php
error_reporting(0);
ini_set("display_errors", "0");

if($_GET['in'] != 'salva' && $_GET['in'] != 'deleta' && $_GET['in'] != 'salvar' && $_GET['in'] != 'deletar' && $_GET['in'] != 'download_deletar' && $_GET['in'] != 'deletarNutricional') {
    $HTML = new htmlStructure("structure.tpl");
    $HTML->configPage();
    $HTML->body->substituiValor("swfPath", "SWF_PATH");
    $HTML->setTitle($urls->title);
    $HTML->setDescription($urls->description);
    $HTML->setKeywords($urls->keywords);
    $HTML->makeLog = FALSE;
    $HTML->printPage();
} else
    Main();

function Main() {
    global $TPLV, $bottom, $urls, $db, $migalha;

    $TPLV = new TemplatePower(TEMPLATE_PATH . "modulos/produtos.tpl");
    $TPLV->assignGlobal("uploadPath", UPLOAD_PATH);
    $TPLV->assignGlobal("uploadPath", UPLOAD_PATH_SITE);
    $TPLV->assignGlobal("imagePath", IMAGE_PATH);
    $TPLV->assignGlobal("swfPath", SWF_PATH);
    $TPLV->assignGlobal("localPath", LOCAL_PATH);
    $TPLV->assignGlobal("localPath", LOCAL_PATH_SITE);
    $TPLV->assignGlobal('navBottom', $bottom);
    $TPLV->assignGlobal($urls->var);
    $TPLV->prepare();

    $in = $_GET['in'];

    switch ($in) {
        default:
        /**- LISTA DE CATEGORIAS -**/
        case 'lista':
            lista();
            break;
        case 'nova':
            nova();
            break;
        case 'edita':
            edita();
            break;
        case 'salva':
            salva();
            break;
        case 'apagaFoto':
            apagaFoto();
            break;
        case 'deleta':
            deleta();
            break;

        /**- LISTA DE PRODUTOS -**/
        case 'listar':
            listar();
            break;
        case 'novo':
            novo();
            break;
        case 'editar':
            editar();
            break;
        case 'download':
            download();
            break;
        case 'download_salvar':
            download_salvar();
            break;
        case 'download_deletar':
            download_deletar();
            break;
        case 'salvar':
            salvar();
            break;
        case 'deletar':
            deletar();
            break;
        case 'deletarNutricional':
            deletarNutricional();
            break;
        case 'apagarFoto':
            apagarFoto();
            break;
    }
}

/**- CATEGORIAS -**/
function tamanho_arquivo($tamanho) {
    $kb = 1024;
    $mb = 1048576;
    $gb = 1073741824;
    $tb = 1099511627776;
    if ($tamanho < $kb) {
        return ($tamanho . " bytes");
    } else if ($tamanho >= $kb && $tamanho < $mb) {
        $kilo = number_format($tamanho / $kb, 0);
        return ($kilo . " KB");
    } else if ($tamanho >= $mb && $tamanho < $gb) {
        $mega = number_format($tamanho / $mb, 0);
        return ($mega . " MB");
    } else if ($tamanho >= $gb && $tamanho < $tb) {
        $giga = number_format($tamanho / $gb, 0);
        return ($giga . " GB");
    }
}

function lista() {
    global $db, $TPLV, $geral;

    $TPLV->newBlock('lista_registros');

    $sql = "SELECT * FROM produtos_categorias ORDER BY categoria_id";
    $rs = $db->db_query($sql);
    foreach ($rs as $r) {
        $TPLV->newBlock('lista');
        $TPLV->assign($r);
    }

    $TPLV->printToScreen();
}

function nova() {
    global $db, $TPLV, $geral, $usuario;

    $TPLV->assignGlobal("classe_botao_acao", 'criar_conta');
    $TPLV->newBlock('insere_registros');

    if (isset($_SESSION['msg']['erro'])) {
        $TPLV->newBlock('bloco_msg_1');
        $TPLV->assign('msg', $_SESSION['msg']['erro']);
    }

    unset($_SESSION['msg']['erro']);
    $TPLV->printToScreen();
}

function edita() {
    global $db, $text, $TPLV, $geral, $usuario;

    $TPLV->assignGlobal("classe_botao_acao", 'salvar_conta');
    $TPLV->newBlock('edita_registros');

    if ($_REQUEST['ok'])
        $TPLV->newBlock('registro_salvo');

    if (isset($_SESSION['msg']['erro'])) {
        $TPLV->newBlock('bloco_msg_2');
        $TPLV->assign('msg', $_SESSION['msg']['erro']);
    }

    $sql = "SELECT * FROM produtos_categorias WHERE categoria_id = '" . $_REQUEST['categoria_id'] . "'";
    $rs = $db->db_query($sql);

    $TPLV->assignGlobal("categoria_id", $rs[0]['categoria_id']);
    $TPLV->assignGlobal("categoria", $rs[0]['categoria']);
    $TPLV->assignGlobal("ordem", $rs[0]['ordem']);
    $TPLV->assignGlobal("ext", $rs[0]['ext']);

    //INICIALIZA BLOCO DO TITULO DO SUBMENU
    if (isset($rs[0]['categoria'])) {
        $TPLV->newBlock('logo');
        $TPLV->assignGlobal('cat', str_replace(" ", "", strtolower($text->tira_acento($rs[0]['categoria']))));
    }

    unset($_SESSION['msg']['erro']);
    $TPLV->printToScreen();
}

function salva() {
    global $db, $TPLV, $geral, $usuario, $urls, $log;

    extract($_POST);

    if ($_POST['action'] == 'insert' && $spam == false) {
        $categoria = $_REQUEST['categoria'];
        if ($_FILES["file"]["name"]) {
            $ext = strtolower(basename($_FILES["file"]["name"]));
            $ext = array_pop(explode(".", $ext));
        }

        $sql = "INSERT INTO produtos_categorias (categoria,ordem,ext) VALUES('" . $categoria . "','','" . $ext . "')";
        $last = $db->db_query($sql);

        $nome = mysql_insert_id();
        mysql_insert_id();

        ### ARQUIVO
        if ($_FILES["file"]["size"] > 0) {
            $dir = GLOBAL_PATH_SITE . "upload/produtos/categoria/";
            chmod(GLOBAL_PATH_SITE . "upload/produtos/categoria/", 0777);
            move_uploaded_file($_FILES['file']['tmp_name'], $dir . $categoria . '.' . $ext);
        }

        ### CRIA URL PRODUTO
        $url = "produtos-" . str_replace(" ", "-", $geral->strtolower_br($geral->tira_acento(strtolower($categoria))));
        $title = "Produtos - " . $categoria;

        $url_old = 'on=produtos&categoria_id=' . $nome;
        $sql = "INSERT INTO url_control VALUES (NULL,'" . $url . "','" . $title . "','','','" . $url_old . "','')";
        $db->db_query($sql);
        
        if (isset($last)) {
            header('Location: ?on=produtos');
        } else {
            #@ monta retorno com erro com session
            $_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
        }
    } elseif ($_POST['action'] == 'update' && $spam == false) {

        ### ARQUIVO
        $ext = strtolower(basename($_FILES["file"]["name"]));
        $ext = array_pop(explode(".", $ext));

        if ($ext == "") {
            $sql = "SELECT * FROM produtos_categorias WHERE categoria_id = '" . $_REQUEST['categoria_id'] . "'";
            $rs = $db->db_query($sql);
            $ext = $rs[0]['ext'];
        }

        $sql = "UPDATE produtos_categorias SET categoria = '" . $categoria . "', ext = '" . $ext . "' WHERE categoria_id = " . $_REQUEST['categoria_id'] . "";
        $last = $db->db_query($sql);

        if ($_FILES['file']['name'] != "") {
            $nome = mysql_insert_id();
            copy($_FILES['file']['tmp_name'], "upload/produtos/categoria/" . $categoria . "." . $ext);
        }

        ### ALTERA URL PRODUTO
        $url = "produtos-" . str_replace(" ", "-", $geral->strtolower_br($geral->tira_acento(strtolower($categoria))));
        $title = "Produtos - " . $categoria;
        $url_old = 'on=produtos&categoria_id=' . $_REQUEST['categoria_id'];
        $sql = "UPDATE url_control SET url='" . $url . "', title='" . $title . "' WHERE url_old LIKE '" . $url_old . "'";
        $db->db_query($sql);
        
        if (isset($last)) {
            header('Location: ?on=produtos&in=edita&categoria_id=' . $_REQUEST['categoria_id'] . '&ok=1');
        } else {
            #@ monta retorno com erro com session
            $_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
        }
    }
}

function apagaFoto() {
    global $db, $TPLV, $text, $geral, $usuario, $urls, $log;

    ### INICIALIZA BLOCO DO TITULO DO SUBMENU
    if (isset($rs[0]['categoria'])) {
        $TPLV->assignGlobal('cat', str_replace(" ", "", strtolower($text->tira_acento($rs[0]['categoria']))));
    }
    $sql = "SELECT * FROM produtos_categorias WHERE categoria = " . $rs[0]['categoria'] . "";
    $rs = $db->db_query($sql);
    $ext = $rs[0]['ext'];
    $categoria = $rs[0]['categoria'];

    $dir = GLOBAL_PATH_SITE . "upload/produtos/categoria/";
    if (is_file($dir . $_REQUEST['categoria'] . '.' . $ext)) {
        unlink($dir . $_REQUEST['categoria'] . '.' . $ext);

        $sql = "UPDATE produtos SET ext='' WHERE categoria_id = " . $_REQUEST['categoria_id'] . "";
        $rs = $db->db_query($sql);
    }
    header("Location: ?on=produtos&in=edita&categoria_id=" . $_REQUEST['categoria_id']);
}

function deleta() {
    global $db, $TPLV, $geral, $usuario, $urls, $log;

    $sql = "SELECT * FROM produtos_categorias WHERE categoria_id = '" . $_REQUEST['categoria_id'] . "'";
    $rs = $db->db_query($sql);

    $sql = "DELETE FROM produtos_categorias WHERE categoria_id = '" . $_REQUEST['categoria_id'] . "'";
    $rs = $db->db_query($sql);

    ### APAGA URL
    $url_old = "on=produtos&categoria_id=" . $_REQUEST['categoria_id'];

    $sql = "DELETE FROM url_control WHERE url_old LIKE '" . $url_old . "'";
    $rs = $db->db_query($sql);

    echo "ok";
}

/**- PRODUTOS -**/
function listar() {
    global $db, $TPLV, $geral;

    $TPLV->newBlock('lista_registros-prod');
    $sql = "SELECT p.*, a.categoria_id, a.categoria
			FROM produtos_categorias a
				INNER JOIN produtos p
					ON a.categoria_id = p.categoria_id
			WHERE a.categoria_id = '" . $_REQUEST['categoria_id'] . "'
			ORDER BY p.produto_id DESC";
    $rs = $db->db_query($sql);
    $cont = 0;

    ### PAGINACAO
    $navbar = new paginar;
    $navbar->numero = 10;
    $navbar->url = "on=produtos&in=" . $_REQUEST['in'] . $qBusca . "&categoria_id=" . $_REQUEST['categoria_id'];
    $navbar->paginas['PAGINA'] = ($_GET['pagina'] ? $_GET['pagina'] : 1);
    $navbar->processarSQL($sql);

    ### IMPRIME OS REGISTROS
    $rs = $db->db_query($navbar->mysql['QUERY']);

    $TPLV->assignGlobal("categoria", $rs[0]['categoria']);

    if (count($rs) > 0)
        foreach ($rs as $r) {
            $TPLV->newBlock('lista-prod');
            /* Conta quantos downloads existem para cada produto */
            $sql = "SELECT sum(num_downs) as num_downs FROM down_files WHERE product=" . $r['produto_id'];
            $result_downs = $db->db_query($sql);
            $r['num_downs'] = $result_downs[0]['num_downs'] ? $result_downs[0]['num_downs'] : 0;

            /* Conta quantos arquivos existem para cada produto */
            $sql = "SELECT product, COUNT(*) AS total FROM down_files WHERE product = ". $r['produto_id'] ." GROUP BY product";
            $result_arquivos = $db->db_query($sql);
            $r['num_arquivos'] = $result_arquivos[0]['total'] ? $result_arquivos[0]['total'] : 0;
            $r['edit_downs'] = is_null($result_arquivos[0]['total']) ? 'edit_off' : 'edit';
            

            $TPLV->assign($r);
        }
    ### TOTAL
    if ($navbar->paginas['TOTAL'] > 1) {
        $TPLV->newBlock('paginacao');
    }

    ## MOSTRA AS IMAGENS DE RETORNO E PROXIMO HABILITADAS OU DESABILITADAS
    $TPLV->assignGlobal("paginacao_anterior", $navbar->link_pagina_anterior());
    $TPLV->assignGlobal("paginacao_proxima", $navbar->link_pagina_proxima());
    $TPLV->assignGlobal("paginas", $navbar->imprimir_paginas());
    $TPLV->assignGlobal("pagina", $navbar->imprimir_pagina_atual());
    $TPLV->printToScreen();
}

function novo() {
    global $db, $TPLV, $geral, $usuario;

    $TPLV->assignGlobal("classe_botao_acao", 'criar_conta');
    $TPLV->newBlock('insere_registros-prod');

    if (isset($_SESSION['msg']['erro'])) {
        $TPLV->newBlock('bloco_msg_1-prod');
        $TPLV->assign('msg', $_SESSION['msg']['erro']);
    }

    ### CATEGORIA
    $sql = "SELECT * FROM produtos_categorias ORDER BY categoria ASC";
    $rows = $db->db_query($sql);
    foreach ($rows as $row) {
        $TPLV->newBlock('categoria');
        $TPLV->assign($row);
    }

    unset($_SESSION['msg']['erro']);
    $TPLV->printToScreen();
}

function editar() {
    global $db, $TPLV, $geral, $usuario;

    $TPLV->assignGlobal("classe_botao_acao", 'salvar_conta');
    $TPLV->newBlock('edita_registros-prod');

    if ($_REQUEST['ok'])
        $TPLV->newBlock('registro_salvo-prod');

    if (isset($_SESSION['msg']['erro'])) {
        $TPLV->newBlock('bloco_msg_2-prod');
        $TPLV->assign('msg', $_SESSION['msg']['erro']);
    }

    //BLOCO DE NAVEGACAO - ANTERIOR E PROXIMO
    $sqlNavegaAnterior = "SELECT produto_id FROM produtos WHERE produto_id = (SELECT MAX(produto_id) FROM produtos WHERE produto_id < " . $_REQUEST['produto_id'] . ")";
    $navegaAnterior = $db->db_query($sqlNavegaAnterior);
    
	if ($navegaAnterior[0]['produto_id'] == '')
        $navegaAnterior[0]['produto_id'] = $_REQUEST['produto_id'];
		
    $TPLV->assignGlobal("post_id_anterior", $navegaAnterior[0]['produto_id']);
    $sqlNavegaProximo = "SELECT produto_id FROM produtos WHERE produto_id = (SELECT MIN(produto_id) FROM produtos WHERE produto_id > " . $_REQUEST['produto_id'] . ")";
    $navegaProximo = $db->db_query($sqlNavegaProximo);
    
	if ($navegaProximo[0]['produto_id'] == '')
        $navegaProximo[0]['produto_id'] = $_REQUEST['produto_id'];
		
    $TPLV->assignGlobal("post_id_proximo", $navegaProximo[0]['produto_id']);
    //BLOCO DE NAVEGACAO - ANTERIOR E PROXIMO

    $sql = "SELECT * FROM produtos WHERE produto_id = '" . $_REQUEST['produto_id'] . "'";
    $rs = $db->db_query($sql);

    $TPLV->assignGlobal("produto_id", $rs[0]['produto_id']);
    $TPLV->assignGlobal("categoria_id", $rs[0]['categoria_id']);
    $TPLV->assignGlobal("nome", $rs[0]['nome']);
    $TPLV->assignGlobal("referencia", $rs[0]['referencia']);
    $TPLV->assignGlobal("descricao", $rs[0]['descricao']);
    $TPLV->assignGlobal("descricao_preparo", $rs[0]['descricao_preparo']);
    $TPLV->assignGlobal("peso", $rs[0]['peso']);
    $TPLV->assignGlobal("ean", $rs[0]['ean']);
    $TPLV->assignGlobal("classificacao_fiscal", $rs[0]['classificacao_fiscal']);
    $TPLV->assignGlobal("conteudo_embalagem", $rs[0]['conteudo_embalagem']);
    $TPLV->assignGlobal("caixa_embarque", $rs[0]['caixa_embarque']);
    $TPLV->assignGlobal("valor", $rs[0]['valor']);
    $TPLV->assignGlobal("ext", $rs[0]['ext']);
    $TPLV->assignGlobal("dun1", $rs[0]['dun1']);
    $TPLV->assignGlobal("dun2", $rs[0]['dun2']);
    $TPLV->assignGlobal("dun3", $rs[0]['dun3']);

    if ($rs[0]['status'] == "A")
        $TPLV->assignGlobal("achecked", "checked");
    else
        $TPLV->assignGlobal("ichecked", "checked");

    ### INFORMACAO NUTRICIONAL
    $sql = "SELECT * FROM produtos_valores WHERE produto_id = '" . $rs[0]['produto_id'] . "' ORDER BY titulo";
    $rows = $db->db_query($sql);
    foreach ($rows as $row) {
        $TPLV->newBlock('valores');
        $TPLV->assign($row);
    }

    ### IMAGEM
    if ($rs[0]['ext']) {
        $TPLV->newBlock("foto");
        $TPLV->assign("imagem", "<img src=" . LOCAL_PATH_SITE . "tb.php?img=upload/produtos/" . $rs[0]['produto_id'] . "." . $rs[0]['ext'] . "&x=110&y=110>");
    }

    ### CATEGORIA
    $sql = "SELECT * FROM produtos_categorias ORDER BY categoria ASC";
    $rows = $db->db_query($sql);
    foreach ($rows as $row) {
        $TPLV->newBlock('categoriaEdit');

        if ($rs[0]['categoria_id'] == $row['categoria_id'])
            $row['selected'] = ' selected';
        else
            $row['selected'] = '';

        $TPLV->assign($row);
    }

    unset($_SESSION['msg']['erro']);
    $TPLV->printToScreen();
}

function download_deletar() {
    global $db, $geral;
    extract($_POST);
    $sql = 'SELECT file FROM down_files WHERE id=\'' . $download_id . '\' LIMIT 1';
    $file = $db->db_query($sql);

    $dir = GLOBAL_PATH_SITE . "upload/produtos/download/" . $produto_id . '/';

    $sql = 'DELETE FROM down_files WHERE id=\'' . $download_id . '\' LIMIT 1';
    $db->db_query($sql);
    unlink($dir . $file [0]['file']);
    die('ok');
}

function download_salvar() {
    global $db, $geral;
    extract($_POST);

    $dir = GLOBAL_PATH_SITE . "/upload/produtos/download/" . $produto_id . '/';
    if ($_FILES['arquivo']['name']) {
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        chmod($dir, 0777);
        $ext = strtolower(basename($_FILES["arquivo"]["name"]));
        $ext = array_pop(explode(".", $ext));

        $nome_arq = md5($_FILES["arquivo"]["name"]) . '.' . $ext;
        if (!move_uploaded_file($_FILES['arquivo'] ['tmp_name'], $dir . $nome_arq)) {
            echo 'erro ao enviar arquivo <br>' . $dir . $nome_arq;
            exit;
        }
    } else {
        $nome_arq = $arquivo_atual;
    }
    $size = filesize($dir . $nome_arq);

    if ($action == 'insert') {
        $sql = 'INSERT down_files (name, product, file, size, status) VALUES (\'' . $titulo . '\',\'' . $produto_id . '\',\'' . $nome_arq . '\', \'' . $size . '\', \'A\')';
    } elseif ($action == 'update') {
        $sql = 'UPDATE down_files SET name=\'' . $titulo . '\', file = \'' . $nome_arq . '\', size=\'' . $size . '\' WHERE id = \'' . $down_id . '\' ';
    }
    $db->db_query($sql);
    die(header('Location: ?on=produtos&in=download&produto_id=' . $_REQUEST['produto_id']));
}

function download() {
    global $db, $TPLV,
    $geral, $usuario;
    $TPLV->assignGlobal("classe_botao_acao", 'salvar_conta');
    $TPLV->newBlock('edita_registros-prod-download');

    if ($_REQUEST['ok']) {
        $TPLV->newBlock('registro_salvo-prod-download');
    }

    $sql = "SELECT produto_id, nome FROM produtos WHERE produto_id = '" . $_REQUEST['produto_id'] . "'";
    $rs = $db->db_query($sql);

    $TPLV->assignGlobal("produto_id", $rs[0]['produto_id']);
    $TPLV->assignGlobal("nome", $rs[0]['nome']);

    ### arquivos para download já enviados
    $sqlf = 'SELECT id, name, file, num_downs, size, status FROM down_files WHERE product=\'' . $_REQUEST['produto_id'] . '\' ';
    $files = $db->db_query($sqlf);

    foreach ($files as $i => $f) {
        $f['arquivo'] = LOCAL_PATH_SITE . "upload/produtos/download/" . $_REQUEST['produto_id'] . "/" . $f['file'];
        $f['tamanho'] = tamanho_arquivo($f['size']);
        $explode_file = explode('.',$f['file']);
        $f['nome_arquivo'] = $f['name'].'-'.($i+1).'.'.$explode_file[1];
        $f['st'] = ($f['status'] == 'A') ? "Ativo" : "Inativo";
        $TPLV->newBlock('produto-download-lista-files');
        $TPLV->assign($f);
    }

    $TPLV->printToScreen();
}

function salvar() {
    global $db, $TPLV, $geral, $usuario, $urls, $log;

    extract($_POST);

    if ($_POST ['action'] == 'insert' && $spam == false) {
        ### ARQUIVO
        $ext = strtolower(basename($_FILES["file"] ["name"]));
        $ext = array_pop(explode(".", $ext));

        $sql = "INSERT INTO produtos (categoria_id,nome,descricao,descricao_preparo,peso,ean,classificacao_fiscal,conteudo_embalagem,caixa_embarque,valor,ext,referencia,status,dun1,dun2,dun3) 
				VALUES( '" . $categoria_id . "','" . $nome . "','" . $descricao . "','" . $descricao_preparo . "','" . $peso . "','" . $ean . "','" . $classificacao_fiscal . "','" . $conteudo_embalagem . "','" . $caixa_embarque . "','" . $valor . "','" . $ext . "','" . $referencia . "','" . $status . "','" . $dun1 . "','" . $dun2 . "','" . $dun3 . "')";
        $rs = $db->db_query($sql);

        $nome = mysql_insert_id();
        $dir = GLOBAL_PATH_SITE . "upload/produtos/";
        chmod(GLOBAL_PATH_SITE . "upload/produtos/", 0777);
        move_uploaded_file($_FILES ['file']['tmp_name'], $dir . $nome . '.' . $ext);

        if (isset($rs)) {
            header('Location: ?on=produtos&in=listar');
        } else {
            #@ monta retorno com erro com session
            $_SESSION['msg']['erro'] = 'Erro no cadastro tente novamente';
        }

        $_REQUEST['produto_id'] = mysql_insert_id();
        /* - - */
    } elseif ($_POST['action'] == 'update' && $spam == false) {

        ### ARQUIVO
        $ext = strtolower(basename($_FILES["file"] ["name"]));
        $ext = array_pop(explode(".", $ext));

        if ($ext == "") {
            $sql = "SELECT * FROM produtos WHERE produto_id = '" . $_REQUEST['produto_id'] . "'";
            $rs = $db->db_query($sql);
            $ext = $rs[0] ['ext'];
        }

        $sql = "UPDATE produtos SET categoria_id='" . $categoria_id . "', nome = '" . $nome . "', 
					descricao = '" . $descricao . "', descricao_preparo = '" . $descricao_preparo . "', 
					peso = '" . $peso . "', ean='" . $ean . "', classificacao_fiscal = '" . $classificacao_fiscal . "', 
					conteudo_embalagem = '" . $conteudo_embalagem . "', caixa_embarque = '" . $caixa_embarque . "', 
					valor = '" . $valor . "', ext = '" . $ext . "', referencia = '" . $referencia . "' , 
					status = '" . $status . "', dun1 = '" . $dun1 . "', dun2 = '" . $dun2 . "', dun3 = '" . $dun3 . "'
				WHERE produto_id = " . $_REQUEST['produto_id'] . "";
        $rs = $db->db_query($sql);

        if ($_FILES ['file']['name'] != "") {
            $nome = $_REQUEST['produto_id'];
            copy($_FILES['file']['tmp_name'], GLOBAL_PATH_SITE . "upload/produtos/" . $nome . "." . $ext);
        }

        if (isset($rs)) {
            header('Location: ?on=produtos&in=editar&produto_id=' . $_REQUEST['produto_id'] . '&ok=1');
        } else {
			#@ monta retorno com erro com session
            $_SESSION['msg'] ['erro'] = 'Erro no cadastro tente novamente';
        }
    }

    //ATUALIZA TABELA DE INFORMACOES NUTRICIONAIS
    if (count($data['valoresEdt'] > 0)) {
        foreach ($data['valoresEdt'] as $dt) {
            $sql = "UPDATE produtos_valores SET titulo = '" . $dt ['titulo'] . "', 
                    valor = '" . $dt['valor'] . "', porcentagem = '" . $dt['porcentagem'] ."' 
                    WHERE id = " . $dt['id'] . "";
            $rs = $db->db_query($sql);
        }
    }

    //INSERE TABELA DE INFORMACOES NUTRICIONAIS
    if (count($data['valores'] > 0)) {
        foreach ($data['valores'] as $dt) {
            $sql = "INSERT INTO produtos_valores (produto_id, titulo, valor, porcentagem)
					VALUES('" . $_REQUEST ['produto_id'] . "','" . $dt['titulo'] . "','" . $dt['valor'] . "','" . $dt['porcentagem'] . "')";
            $rs = $db->db_query($sql);
        }
    }
}

function apagarFoto() {
    global $db, $TPLV, $geral, $usuario, $urls,
    $log;

    $sql = "SELECT * FROM produtos WHERE produto_id = " . $_REQUEST['produto_id'] . "";
    $rs = $db->db_query($sql);
    $ext = $rs[0]['ext'];

    $dir = GLOBAL_PATH_SITE . "upload/produtos/";
    if (is_file($dir . $_REQUEST['produto_id'] . '.' . $ext)) {
        unlink($dir . $_REQUEST ['produto_id'] . '.' . $ext);
        $sql = "UPDATE produtos SET ext='' WHERE produto_id = " . $_REQUEST['produto_id'] . "";
        $rs = $db->db_query($sql);
    }

    header("Location: ?on=produtos&in=editar&produto_id=" . $_REQUEST['produto_id'] . '&ok=1');
}

function deletar() {
    global $db, $TPLV, $geral, $usuario, $urls, $log;

    $sql = "SELECT * FROM produtos WHERE produto_id = " . $_REQUEST ['produto_id'] . "";
    $rs = $db->db_query($sql);
    $ext = $rs[0]['ext'];

    $dir = GLOBAL_PATH_SITE . "upload/produtos/";

    if (is_file($dir . $_REQUEST['produtos_id'] . '.' . $ext)) {
        unlink($dir . $_REQUEST['produtos_id'] . '.' . $ext);
    }

    $sql = "DELETE FROM produtos WHERE produto_id = '" . $_REQUEST['produto_id'] . "'";
    $rs = $db->db_query($sql);

    echo "ok";
}

function deletarNutricional() {
    global $db, $TPLV, $geral, $usuario, $urls, $log;

    $sql = "DELETE FROM produtos_valores WHERE id = '" . $_REQUEST['id'] . "'";
    $rs = $db->db_query($sql);

    echo "ok";
}

?>
