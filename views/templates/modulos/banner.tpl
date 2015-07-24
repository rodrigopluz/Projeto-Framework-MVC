<div class="lista_registros">
	<h1>Lista Tarefas</h1>
	<!-- START BLOCK : lista_registros -->
    <form id="buscar" method="POST" action="?on=banner">
        <table width="100%">
            <tr>
                <td>Filtrar - Tarefa:</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width="150" valign="top">
                    <input name="busca" id="busca" size="50" class="frm mt3" value="{busca}" />
                </td>
                <td>
                    <input name="Busca" class="buscar" value="Buscar" type="submit" />
                </td>
            </tr>
        </table>
    </form>
    <table width="100%">
        <tr class="cabecalho">
            <td width="50">&nbsp;</td>
            <td>Titulo</td>
            <td width="40">Editar</td>
            <td width="40">Excluir</td>
        </tr>
        <!-- START BLOCK : lista -->
        <tr class="listagem" id="{id}">
            <td>{imagem}</td>
            <td>{title}</td>
            <td align="center">
                <a href="?on={on}&in=editar&id={id}">
                    <img src="{imagePath}edit.jpg" alt="Editar" title="Editar">
                </a>
            </td>
            <td class="center del">
                <a href="javascript: void(0);" rel="{id}">
                    <img src="{imagePath}delete.jpg" alt="Apagar" title="Apagar">
                </a>
            </td>
        </tr>
        <!-- END BLOCK : lista -->
    </table>
	<!-- END BLOCK : lista_registros -->
	
	<!-- START BLOCK : insere_registros -->
    <form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data" onsubmit="return validaCadastro();" method="POST">
        <input type="hidden" name="action" id="action" value="insert" />
        <ul>
            <li>
                <div class="titulo">Nova tarefa</div> 
                <div class="dados">
                    <div class="dados">
                        <label>Titulo:</label>
                        <input type="text" name="title" id="title" value="" maxlength="255" class="frm w270 border" />
                    </div>
                    <div class="dados">
                        <label>Link:</label>
                        <input type="text" name="link" id="link" value="" maxlength="255" class="frm w270 border" />
                    </div>
                    <div class="dados">
                        <label>Status:</label>
                        <input name="status" type="radio" value="A" /> Ativo &nbsp;
                        <input name="status" type="radio" value="I" /> Inativo
                        <br/><br/>
                    </div>
                </div>
            </li>
            <li>	
                <p id="retorno_erro">
                    <!-- START BLOCK : bloco_msg_1 -->
                    {msg}
                    <!-- END BLOCK : bloco_msg_1 -->
                </p>
                <a>
                    <input type="button" class="btn_voltar" onclick="voltar();">
                </a>
                <input type="submit" class="criar_conta" name="Submit" value=" ">
            </li>
        </ul>
    </form>
	<!-- END BLOCK : insere_registros -->
	
	<!-- START BLOCK : edita_registros -->
    <!-- START BLOCK : registro_salvo -->
    <div class="retorno"><b>Registro salvo com sucesso!</b></div>
    <!-- END BLOCK : registro_salvo -->
    <form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data" onsubmit="return validaCadastro();" method="POST">
        <input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" name="id" id="id" value="{id}" />
        <ul>
            <li>
                <div class="titulo">Editar Tarefa</div> 
                <div class="dados">
                    <label>Titulo:</label>
                    <input type="text" name="title" id="title" value="{title}" maxlength="255" class="frm w270 border" />
                </div>
                <div class="dados">
                    <label>Link:</label>
                    <input type="text" name="link" id="link" value="{link}" maxlength="255" class="frm w270 border" />
                </div>
                <div class="dados">
                    <label>Status:</label>
                    <input name="status" type="radio" value="A" {achecked} />Ativo &nbsp;
                    <input name="status" type="radio" value="I" {ichecked} />Inativo
                    <br/><br/>
                </div>
                <!-- START BLOCK : foto -->
                <div class="imgPrincipal">
                    {imagem}
                    <br/>
                    <a href="?on=banner&in=apagar_foto&id={id}">Apagar Imagem [x]</a>
                </div>
                <!-- END BLOCK : foto -->					
            </li>
            <li>	
                <p id="retorno_erro">
                    <!-- START BLOCK : bloco_msg_2 -->
                    {msg}
                    <!-- END BLOCK : bloco_msg_2 -->
                </p>
                <a>
                    <input type="button" class="btn_voltar" onclick="voltar();">
                </a>
                <input type="submit" class="salvar_conta" name="Submit" value=" ">
            </li>
        </ul>
    </form>
	<!-- END BLOCK : edita_registros -->
</div>