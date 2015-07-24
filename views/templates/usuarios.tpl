<div class="lista_registros">
	<h1>Usuários</h1>
	<!-- START BLOCK : lista_registros -->
		<table width="100%">
			<tr class="cabecalho">
	    	<td width="50">ID</td>
		   	<td>Nome</td>
		   	<td width="40">Editar</td>
		   	<td width="40">Excluir</td>
			</tr>
			<!-- START BLOCK : lista -->
			<tr class="listagem" id="{id}">
	    	<td>{id}</td>
		   	<td>{nome}</td>
		   	<td align="center">
					<a href="?on=usuarios&in=editar&id={id}">
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
	<!-- END BLOCK : lista_registros -->

	<!-- START BLOCK : insere_registros -->
		<form name="cadastro_usuario" id="cadastro_usuario" action="?on=usuarios&in=salvar" onsubmit="return validaCadastroUsuario();" method="POST">
			<input type="hidden" name="action" id="action" value="insert" />
			<ul>
				<li class="last">
					<div class="titulo">Módulos permitidos</div>
					<ul>
						<!-- START BLOCK : lista_modulos_1 -->
						<li class="modulos-user">
							<input type="checkbox" name="permissoes[]" id="modulo{modulo_id}" value="{modulo_id}" {check} />
							{nome}
						</li>
						<!-- START BLOCK : lista_modulos_1 -->
					</ul>
				</li>
				<li class="clear">&nbsp; </li>
				<li>
					<div class="titulo">Dados de pessoais</div>
					<div class="dados">
						<input type="text" name="nome_c" id="nome_c" value="Nome" maxlength="255" class="frm watermark w270 border" />
						<input type="text" name="email_c" id="email_c" value="Email" maxlength="255" class="frm watermark w270 border" />
						<!--input type="text" name="email_cc" id="email_cc" value="Email Confirmação" maxlength="255" class="watermark w270 border"/-->
						<input type="text" name="fone_c" id="fone_c" value="Telefone" onkeyup="coloca_mascara(this,'telefone')" maxlength="45" class="frm watermark w175 border" />
						<br/>senha
						<input type="password" name="senha_c" id="senha_c" value="" maxlength="25" class="frm watermark w175 border" />
						confirme a senha
						<input type="password" name="senha_c2" id="senha_c2" value="" maxlength="25" class="frm watermark w175 border" />
					</div>
				</li>
				<li>
					<p id="retorno_erro">
						<!-- START BLOCK : bloco_msg_1 -->
						{msg}
						<!-- END BLOCK : bloco_msg_1 -->
					</p>
                                        <a href="" onClick="javascript:history.back(-1);">
                                            <input type="button" class="btn_voltar">
                                        </a>
					<input type="submit" class="criar_conta" name="Submit" value=" ">
					<!--<input type="submit" class="{classe_botao_acao}" name="Submit" value=" ">-->
				</li>
			</ul>
		</form>
	<!-- END BLOCK : insere_registros -->

	<!-- START BLOCK : edita_registros -->
		<form name="cadastro_usuario" id="cadastro_usuario" action="?on=usuarios&in=salvar" onsubmit="return validaCadastroUsuario();" method="POST">
			<input type="hidden" name="action" id="action" value="update" />
			<input type="hidden" name="id_usuario" id="id_usuario" value="{id_usuario}" />
			<ul>
				<li class="last">
					<div class="titulo">Módulos permitidos</div>
					<ul>
						<!-- START BLOCK : lista_modulos_2 -->
						<li class="modulos-user">
							<input type="checkbox" name="permissoes[]" id="modulo{modulo_id}" value="{modulo_id}" {check} />
							{nome}
						</li>
						<!-- START BLOCK : lista_modulos_2 -->
					</ul>
				</li>
				<li class="clear">&nbsp; </li>
				<li>
					<div class="titulo">Dados de pessoais</div>
					<div class="dados">
						<input type="text" name="nome_c" id="nome_c" value="{nome}" maxlength="255" class="frm watermark w270 border" />
						<input type="text" name="email_c" id="email_c" value="{email}" maxlength="255" class="frm watermark w270 border" />
						<input type="text" name="fone_c" id="fone_c" value="{telefone}" onkeyup="coloca_mascara(this,'telefone')" maxlength="45" class="frm watermark w175 border" />
						<br />senha:
						<input type="password" name="senha_c" id="senha_c" value="" maxlength="25" class="frm watermark w175 border" />
						confirme a senha:
						<input type="password" name="senha_c2" id="senha_c2" value="" maxlength="25" class="frm watermark w175 border" />
					</div>
				</li>
				<li>
					<p id="retorno_erro">
						<!-- START BLOCK : bloco_msg_2 -->
						{msg}
						<!-- END BLOCK : bloco_msg_2 -->
					</p>
                                        <a href="" onClick="javascript:history.back(-1);">
                                            <input type="button" class="btn_voltar">
                                        </a>
					<input type="submit" class="criar_conta" name="Submit" value=" ">
					<!--<input type="submit" class="{classe_botao_acao}" name="Submit" value=" ">-->
				</li>
			</ul>
		</form>
	<!-- END BLOCK : edita_registros -->
</div>