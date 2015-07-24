<div class="lista_registros">
	<h1>Categorias do Blog</h1>
	<!-- START BLOCK : lista_registros -->
	<table width="100%">
		<tr class="cabecalho">
	  	<td width="50">ID</td>
		  <td>Categoria</td>
		  <td width="40">Editar</td>
		  <td width="40">Excluir</td>
		</tr>
		<!-- START BLOCK : lista -->
		<tr class="listagem" id="{categoria_id}">
			<td>{categoria_id}</td>
			<td>{categoria}</td>
			<td align="center">
				<a href="?on={on}&in=editar&categoria_id={categoria_id}">
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
		<form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data" method="POST">
			<input type="hidden" name="action" id="action" value="insert" />
			<ul>
				<li>
					<div class="titulo">Nova Categoria</div>
					<div class="dados">
						<label>Categoria:</label>
							<input type="text" name="categoria" id="categoria" value="" maxlength="255" class="frm w270 border" />
					</div>
				</li>
				<li>
					<p id="retorno_erro">
						<!-- START BLOCK : bloco_msg_1 -->
							{msg}
						<!-- END BLOCK : bloco_msg_1 -->
					</p>
                                            <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">
					<input type="button" class="{classe_botao_acao}" name="Submit" value=" "  onclick="validaCategoria();">
				</li>
			</ul>
		</form>
	<!-- END BLOCK : insere_registros -->

	<!-- START BLOCK : edita_registros -->
		<!-- START BLOCK : registro_salvo -->
			<div class="retorno"><b>Registro salvo com sucesso!</b></div>
		<!-- END BLOCK : registro_salvo -->
                 <!--BLOCO DE NAVEGACAO!-->
                <br class="clear"/>

                    <a style="float:left;margin-left:12px;color:#52AAC7;" href="?on={on}&in=editar&categoria_id={post_id_anterior}">< Anterior</a>
                    <a style="float:right;margin-right:12px;color:#52AAC7;" href="?on={on}&in=editar&categoria_id={post_id_proximo}">Próximo ></a>

                <br class="clear"/>
                <!--BLOCO DE NAVEGACAO!-->
		<form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data" method="POST">
			<input type="hidden" name="action" id="action" value="update" />
			<input type="hidden" name="categoria_id" id="categoria_id" value="{categoria_id}" />
			<ul>
				<li>
					<div class="titulo">Editar Categoria</div>
					<div class="dados">
						<label>Categoria:</label>
							<input type="text" name="categoria" id="categoria" value="{categoria}" maxlength="255" class="frm w270 border" />
					</div>
				</li>
				<li>
					<p id="retorno_erro">
						<!-- START BLOCK : bloco_msg_2 -->
							{msg}
						<!-- END BLOCK : bloco_msg_2 -->
					</p>
                                            <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">
					<input type="button" class="{classe_botao_acao}" name="Sub" value=" "  onclick="validaCategoria();">
				</li>
			</ul>
		</form>
	<!-- END BLOCK : edita_registros -->
</div>