<div class="lista_registros">
	<h1>Categorias de Produtos</h1>
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
		<form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data"  method="POST">
			<input type="hidden" name="action" id="action" value="insert" />
			<ul>
				<li>
					<div class="titulo">Nova Categoria</div>
					<div class="dados">
						<label>Nome da Categoria:</label>
							<input type="text" name="categoria" id="categoria" value="" maxlength="255" class="frm w270 border" />
						<br/>
						<label>Logo da Categoria em PNG:</label>
							<input type="file" name="file" id="file" />
					</div>
				</li>
				<li>
					<p id="retorno_erro">
						<!-- START BLOCK : bloco_msg_1 -->
							{msg}
						<!-- END BLOCK : bloco_msg_1 -->
					</p>

                                            <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">

					<input type="button" class="{classe_botao_acao}" name="Submit" value=" " onclick="validaCategoriaProduto();">
				</li>
			</ul>
		</form>
	<!-- END BLOCK : insere_registros -->

	<!-- START BLOCK : edita_registros -->
		<!-- START BLOCK : registro_salvo -->
			<div class="retorno"><b>Registro salvo com sucesso!</b></div>
		<!-- END BLOCK : registro_salvo -->
		<form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" enctype="multipart/form-data" method="POST">
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
</div>