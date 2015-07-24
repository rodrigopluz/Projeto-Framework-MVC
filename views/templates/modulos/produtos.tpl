<div class="lista_registros">
    <!-- START BLOCK : lista_registros -->
    <h1>Categorias de Tarefas</h1>
    <table width="100%">
        <tr class="cabecalho">
            <td width="50">ID</td>
            <td>Categoria</td>
            <td width="50">Tarefa</td>
            <td width="40">Editar</td>
            <td width="40">Excluir</td>
        </tr>
        <!-- START BLOCK : lista -->
        <tr class="listagem" id="{categoria_id}">
            <td>{categoria_id}</td>
            <td>{categoria}</td>
            <td align="center">
                <a href="?on={on}&in=listar&categoria_id={categoria_id}">
                    <img src="{imagePath}visualizar.jpg" align="Lista Tarefas" title="Lista Tarefas" />
                </a>
            </td>
            <td align="center">
                <a href="?on={on}&in=edita&categoria_id={categoria_id}">
                    <img src="{imagePath}edit.jpg" alt="Editar" title="Editar">
                </a>
            </td>
            <td class="center del">
                <a href="javascript: void(0);" rel="{categoria_id}">
                    <img src="{imagePath}delete.jpg" alt="Apagar" title="Apagar">
                </a>
            </td>
        </tr>
        <!-- END BLOCK : lista -->
    </table>
    <!-- END BLOCK : lista_registros -->
	<!-- START BLOCK : insere_registros -->
    <h1>Categorias de Tarefas</h1>
    <form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salva" enctype="multipart/form-data"  method="POST">
        <input type="hidden" name="action" id="action" value="insert" />
        <ul>
            <li>
                <div class="titulo">Nova Categoria</div>
                <div class="dados">
                    <label>Nome da Categoria:</label>
                    <input type="text" name="categoria" id="categoria" value="" maxlength="255" class="frm w270 border" />
                    <br/>
                    <!--
                    <label>Logo da Categoria em PNG:</label>
                    <input type="file" name="file" id="file" />
                    -->
                </div>
            </li>
            <li>
                <p id="retorno_erro">
                    <!-- START BLOCK : bloco_msg_1-2 -->
                    {msg}
                    <!-- END BLOCK : bloco_msg_1-2 -->
                </p>
                <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">
                <input type="button" class="{classe_botao_acao}" name="Submit" value=" " onclick="validaCategoriaProduto();">
            </li>
        </ul>
    </form>
    <!-- END BLOCK : insere_registros -->
    <!-- START BLOCK : edita_registros -->
    <h1>Categorias de Tarefas</h1>
    <!-- START BLOCK : registro_salvo -->
    <div class="retorno"><b>Registro salvo com sucesso!</b></div>
    <!-- END BLOCK : registro_salvo -->
    <form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salva" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" name="categoria_id" id="categoria_id" value="{categoria_id}" />
        <ul>
            <li>
                <div class="titulo">Editar Categoria</div>
                <div class="dados">
                    <label>Nome da Categoria:</label>
                    <input type="text" name="categoria" id="categoria" value="{categoria}" maxlength="255" class="frm w270 border" />
                    <label>Imagem de sub-titulo da Categoria em PNG transparente:</label>
                    <input type="file" name="file" id="file" />
                    <br/><br/>
                    <!-- START BLOCK : logo -->
                    <div class="imgPrincipal">
                        <img src="{localPath}upload/produtos/categoria/{cat}.{ext}" class="left" id="titulo_in" />
                        <br/><br/>
                        <!--<a href="?on=produtosC&in=apagarFoto&categoria={cat}">Apagar Logo PNG [x]</a>-->
                    </div>
                    <!-- END BLOCK : logo -->
                </div>
            </li>
            <li>
                <p id="retorno_erro">
                    <!-- START BLOCK : bloco_msg_2 -->
                    {msg}
                    <!-- END BLOCK : bloco_msg_2 -->
                </p>
                <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">
                <input type="button" class="{classe_botao_acao}" name="Submit" value=" " onclick="validaCategoriaProduto();">
            </li>
        </ul>
    </form>
    <!-- END BLOCK : edita_registros -->
    <!-- START BLOCK : lista_registros-prod -->
    <h1>Tarefas da Categoria - {categoria}</h1>
    <table width="100%">
        <tr class="cabecalho">
            <td width="50">ID</td>
            <td>Nome do Tarefa</td>
            <td width="65">Imagens</td>
            <td width="65">Downloads</td>
            <td width="40">Editar</td>
            <td width="40">Excluir</td>
        </tr>
        <!-- START BLOCK : lista-prod -->
        <tr class="listagem" id="{produto_id}">
            <td>{produto_id}</td>
            <td>{nome}</td>
            <td align="center">
                <a href="?on={on}&in=download&produto_id={produto_id}">
                    <img src="{imagePath}{edit_downs}.jpg" alt="Editar" title="Downloads">
                </a>
                <span class="num_arq">{num_arquivos}</span>
            </td>
            <td align="center">
                <span>{num_downs}</span>
            </td>
            <td align="center">
                <a href="?on={on}&in=editar&produto_id={produto_id}">
                    <img src="{imagePath}edit.jpg" alt="Editar" title="Editar">
                </a>
            </td>
            <td class="center del">
                <a href="javascript: void(0);" rel="{produto_id}">
                    <img src="{imagePath}delete.jpg" alt="Apagar" title="Apagar">
                </a>
            </td>
        </tr>
        <!-- END BLOCK : lista-prod -->
    </table>
    <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">
    <!-- START BLOCK : paginacao -->
    <div class="paginacao">
        <ul class="pagination">
            <li class="anterior">
                <a href="{paginacao_anterior}#mais" class="lower"> < </a>&nbsp;
            </li>
            <li class="paginas"><b>{paginas}</b></li>
            <li class="proxima">
                <a href="{paginacao_proxima}#mais" class="lower"> > </a>
            </li>
        </ul>
    </div>
    <!-- END BLOCK : paginacao -->
    <!-- END BLOCK : lista_registros-prod -->
    <!-- START BLOCK : insere_registros-prod -->
    <h1>Tarefa</h1>
    <form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="action" id="action" value="insert" />
        <ul>
            <li>
                <div class="titulo">Nova Tarefa</div>
                <div class="dados">
                    <label>Nome Tarefa:</label>
                    <input type="text" name="nome" id="nome" value="" maxlength="255" class="frm w270 border" />
                    <label>Categorias:</label>
                    <select name="categoria_id" class="frm border" id="categoria_id">
                        <option value="">Selecione</option>
                        <!-- START BLOCK : categoria -->
                        <option value="{categoria_id}">{categoria}</option>
                        <!-- END BLOCK : categoria -->
                    </select>
                    <br/><br/>
                    <label>Status</label>
                    <input name="status" type="radio" value="A" checked="checked" />Ativo &nbsp;
                    <input name="status" type="radio" value="I" />Inativo
                    <br/><br/>	
                    <label>Descrição:</label>
                    <textarea name="descricao" id="descricao" rows="15" cols="125" class="frm"></textarea>
                    <label>Modo de Preparo do Produto:</label>
                    <textarea name="descricao_preparo" id="descricao2" rows="15" cols="125" class="frm"></textarea>
                    <label>Peso:</label>
                    <input type="text" name="peso" id="peso" value="" maxlength="255" class="frm w270 border" />
                    <label>EAN:</label>
                    <input type="text" name="ean" id="ean" value="" maxlength="255" class="frm w270 border" />
                    <label>DUN1:</label>
                    <input type="text" name="dun1" id="dun1" value="" maxlength="255" class="frm w270 border" />
                    <label>DUN2:</label>
                    <input type="text" name="dun2" id="dun2" value="" maxlength="255" class="frm w270 border" />
                    <label>DUN3:</label>
                    <input type="text" name="dun3" id="dun3" value="" maxlength="255" class="frm w270 border" />
                    <label>Classificação fiscal:</label>
                    <input type="text" name="classificacao_fiscal" id="classificacao_fiscal" value="" maxlength="255" class="frm w270 border" />
                    <label>Conteudo da Embalagem:</label>
                    <input type="text" name="conteudo_embalagem" id="conteudo_embalagem" value="" maxlength="255" class="frm w270 border" />
                    <label>Caixa de Embarque:</label>
                    <input type="text" name="caixa_embarque" id="caixa_embarque" value="" maxlength="255" class="frm w270 border" />
                    <label>Referência:</label>
                    <input type="text" name="referencia" id="referencia" value="" maxlength="255" class="frm w270 border" />
                    <label>Informações Nutricionais:</label>
                    <p>
                        <a href="#" onClick="addFormField();
                        return false;"><b>[+] Adicionar Campo</b></a>
                    </p>
                    <div id="divTxt"></div>
                    <!-- START BLOCK : valores -->
                    <div class="rows2" id="row{id}" style="height: 40px;">
                        <div class="left">
                            <label for='txt{id}a'>Titulo &nbsp;&nbsp;</label>
                            <input type='text' name='data[valoresEdt][{id}][titulo]' id='txt{id}b' value="" maxlength='255' class='frm w270 border'>&nbsp;&nbsp
                        </div>
                        <div class="left">
                            <label for='txt{id}c'>Valor &nbsp;&nbsp;</label>
                            <input type='text' name='data[valoresEdt][{id}][valor]' id='txt{id}d' value="" maxlength='255' class='frm w88 border'>&nbsp;&nbsp
                        </div>
                        <div class='left'>
                            <label for='txt{id}e'>Percentual &nbsp;&nbsp;</label>
                            <input type='text' name='data[valoresEdt][{id}][porcentagem]' id='txt{id}f' value="" maxlength='255' class='frm w54 border'>&nbsp;&nbsp
                        </div>
                        <input type='hidden' name='data[valoresEdt][{id}][id]' id='txt{id}g' value="">
                        <a href='#' onClick='removeFormFieldEdt({id});
                        return false;'>[-] Remove</a>
                    </div>
                    <!-- END BLOCK : valores -->
                    <label>Imagem da Tarefa:</label>
                    <input type="file" name="file" id="file" />
                </div>
            </li>
            <li>
                <p id="retorno_erro">
                    <!-- START BLOCK : bloco_msg_1-prod -->
                    {msg}
                    <!-- END BLOCK : bloco_msg_1-prod -->
                </p>
                <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">
                <input type="button" class="{classe_botao_acao}" name="Submit" value=" "  onclick="validaCadastroProdutos();" >
            </li>
        </ul>
    </form>
    <!-- END BLOCK : insere_registros-prod -->
    <!-- START BLOCK : edita_registros-prod -->
    <h1>Tarefa</h1>
    <!-- START BLOCK : registro_salvo -->
    <div class="retorno"><b>Registro salvo com sucesso!</b></div>
    <!-- END BLOCK : registro_salvo -->
    <br class="clear"/>
    <a style="float:left;margin-left:12px;color:#52AAC7;" href="?on={on}&in=editar&produto_id={post_id_anterior}">< Anterior</a>
    <a style="float:right;margin-right:12px;color:#52AAC7;" href="?on={on}&in=editar&produto_id={post_id_proximo}">Próximo ></a>
    <br class="clear"/>
    <form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" name="produto_id" id="produto_id" value="{produto_id}" />
        <ul>
            <li>
                <div class="titulo">Editar Tarefa</div>
                <div class="dados">
                    <label>Nome Tarefa:</label>
                    <input type="text" name="nome" id="nome" value="{nome}" maxlength="255" class="frm w270 border" />
                    <label>Categorias:</label>
                    <select name="categoria_id" class="frm border" id="categoria_id">
                        <option value="{categoria_id}">Selecione</option>
                        <!-- START BLOCK : categoriaEdit -->
                        <option value="{categoria_id}" {selected}>{categoria}</option>
                        <!-- END BLOCK : categoriaEdit -->
                    </select>
                    <br/><br/>
                    <label>Status</label>
                    <input name="status" type="radio" value="A" {achecked} />Ativo &nbsp;
                    <input name="status" type="radio" value="I" {ichecked} />Inativo
                    <br/><br/>
                    <label>Descrição:</label>
                    <textarea name="descricao" id="descricao" rows="15" cols="125" class="frm">{descricao}</textarea>
                    <br>
                    <label>Modo de Preparo do Produto:</label>
                    <textarea name="descricao_preparo" id="descricao2" rows="15" cols="125" class="frm">{descricao_preparo}</textarea>
                    <br/>
                    <label>Informações Comerciais:</label>
                    <label>Peso:</label>
                    <input type="text" name="peso" id="peso" value="{peso}" maxlength="255" class="frm w270 border" />
                    <label>EAN:</label>
                    <input type="text" name="ean" id="ean" value="{ean}" maxlength="255" class="frm w270 border" />
                    <label>DUN1:</label>
                    <input type="text" name="dun1" id="dun1" value="{dun1}" maxlength="255" class="frm w270 border" />
                    <label>DUN2:</label>
                    <input type="text" name="dun2" id="dun2" value="{dun2}" maxlength="255" class="frm w270 border" />
                    <label>DUN3:</label>
                    <input type="text" name="dun3" id="dun3" value="{dun3}" maxlength="255" class="frm w270 border" />
                    <label>Classificação fiscal:</label>
                    <input type="text" name="classificacao_fiscal" id="classificacao_fiscal" value="{classificacao_fiscal}" maxlength="255" class="frm w270 border" />
                    <label>Conteudo da Embalagem:</label>
                    <input type="text" name="conteudo_embalagem" id="conteudo_embalagem" value="{conteudo_embalagem}" maxlength="255" class="frm w270 border" />
                    <label>Caixa de Embarque:</label>
                    <input type="text" name="caixa_embarque" id="caixa_embarque" value="{caixa_embarque}" maxlength="255" class="frm w270 border" />
                    <label>Referência:</label>
                    <input type="text" name="referencia" id="referencia" value="{referencia}" maxlength="255" class="frm w270 border" />
                    <label>Informações Nutricionais:</label>
                    <p>
                        <a href="#" onClick="addFormField();
                        return false;"><b>[+] Adicionar Campo</b></a>
                    </p>
                    <div id="divTxt"></div>
                    <!-- START BLOCK : valores -->
                    <div class="rows2" id="row{id}" style="height: 40px;">
                        <div class="left">
                            <label for='txt{id}a'>Titulo &nbsp;&nbsp;</label>
                            <input type='text' name='data[valoresEdt][{id}][titulo]' id='txt{id}b' value="{titulo}" maxlength='255' class='frm w270 border' />&nbsp;&nbsp
                        </div>
                        <div class="left">
                            <label for='txt{id}c'>Valor &nbsp;&nbsp;</label>
                            <input type='text' name='data[valoresEdt][{id}][valor]' id='txt{id}d' value="{valor}" maxlength='255' class='frm w88 border'>&nbsp;&nbsp
                        </div>

                        <div class='left'><label for='txt{id}e'>Percentual &nbsp;&nbsp;</label>
                            <input type='text' name='data[valoresEdt][{id}][porcentagem]' id='txt{id}f' value="{porcentagem}" maxlength='255' class='frm w54 border'>&nbsp;&nbsp
                        </div>
                        <input type='hidden' name='data[valoresEdt][{id}][id]' id='txt{id}g' value="{id}">
                        <a href='#' onClick='removeFormFieldEdt({id});
                        return false;'>[-] Remove</a>
                    </div>
                    <!-- END BLOCK : valores -->
                    <br class="clear" />
                    <label>Imagem do Tarefa:</label>
                    <input type="file" name="file" id="file" />
                    <br/><br/>
                    <!-- START BLOCK : foto -->
                    <div class="imgPrincipal">
                        {imagem}
                        <br/>
                        <a href="javascript: confirmation('?on=produtos&in=apagarFoto&produto_id={produto_id}')">Apagar Imagem [x]</a>
                    </div>
                    <!-- END BLOCK : foto -->
                </div>
            </li>
            <li>
                <p id="retorno_erro">
                    <!-- START BLOCK : bloco_msg_2-prod -->
                    {msg}
                    <!-- END BLOCK : bloco_msg_2-prod -->
                </p>
                <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">
                <input type="button" class="{classe_botao_acao}" name="Submit" value=" " onclick="validaCadastroProdutos();" >
            </li>
        </ul>
    </form>
    <!-- END BLOCK : edita_registros-prod -->
    <!-- START BLOCK : edita_registros-prod-download -->
    <h1>Tarefa - Arquivos para Download</h1>
    <!-- START BLOCK : registro_salvo -->
    <div class="retorno"><b>Registro salvo com sucesso!</b></div>
    <!-- END BLOCK : registro_salvo -->
    <ul style="padding: 10px;">
        <li>
            <div class="titulo">Downloads Tarefa</div>
            <div class="dados">
                <p>Tarefa: {nome}</p>
                <br clear="all" />
                <fieldset style="border: 1px solid #CCCCCC; padding: 5px;">
                    <legend style="font-size: 12px; padding: 0px 10px; font-weight: bold;">Arquivos enviados</legend>
                    <table width="100%" cellpadding="4" cellspacing="1">
                        <tr bgcolor="#CCCCCC">
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Arquivo</th>
                            <th>Tamanho</th>
                            <th>Downloads</th>
                            <th>Status</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                        <!-- START BLOCK : produto-download-lista-files -->
                        <tr id="arquivo_download_{id}">
                            <td>{id}</td>
                            <td id="td_arquivo_nome_{id}">{name}</td>
                            <td><a href="{arquivo}" target="_blank">{nome_arquivo}</a></td>
                            <td align="right">{tamanho}</td>
                            <td align="center">{num_downs}</td>
                            <td align="center">{st}</td>
                            <td align="center">
                                <a href="javascript:;" class="down_edit_file" data-d="{id}" data-f="{file}">Editar</a>
                            </td>
                            <td align="center">
                                <a href="javascript:;" class="down_del_file" data-p="{produto_id}" data-d="{id}">Excluir</a>
                            </td>
                        </tr>
                        <!-- END BLOCK : produto-download-lista-files -->
                    </table>
                </fieldset>
                <br />
                <br />
                <form name="form_produto_download" id="form_produto_download" action="?on={on}&in=download_salvar" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="action" id="action" value="insert" />
                    <input type="hidden" name="produto_id" id="produto_id" value="{produto_id}" />
                    <input type="hidden" name="down_id" id="down_id" value="" />
                    <input type="hidden" name="arquivo_atual" id="arquivo_atual" value="" />
                    <fieldset style="border: 1px solid #CCCCCC; padding: 5px;">
                        <legend style="font-size: 12px; padding: 0px 10px; font-weight: bold;">Enviar Arquivo</legend>
                        <table>
                            <tr>
                                <td>Descrição:</td>
                                <td><input type="text" id="titulo_arq" name="titulo" value="" size="50" /> </td>
                            </tr>
                            <tr>
                                <td>Arquivo:</td>
                                <td><input type="file" name="arquivo" value="" /></td>
                            </tr>
                        </table>
                        <input type="button" class="btn_enviar" name="Submit" value="" onclick="validaDownloadSalvar();" />
                    </fieldset>
                </form>
            </div>
        </li>
        <li>
            <p id="retorno_erro">
                <!-- START BLOCK : bloco_msg_2-prod-download -->
                {msg}
                <!-- END BLOCK : bloco_msg_2-prod-download -->
            </p>
            <br />
            <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);" />
        </li>
    </ul>
    <!-- END BLOCK : edita_registros-prod-download -->
</div>