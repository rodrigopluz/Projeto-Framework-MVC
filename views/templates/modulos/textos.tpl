<div class="lista_registros">
	<h1>Textos Empresa</h1>
	<!-- START BLOCK : lista_registros -->
		<table width="100%">
			<tr class="cabecalho">
				<td width="50">ID</td>
				<td>Seção</td>
				<td width="50">Editar</td>
			</tr>
			<!-- START BLOCK : lista -->
			<tr class="listagem">
				<td>{texto_id}</td>
				<td>{titulo}</td>
				<td align="center">
					<a href="?on={on}&in=editar&texto_id={texto_id}">
						<img src="{imagePath}edit.jpg" alt="Editar" title="Editar">
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
					<div class="titulo">Novo Texto</div>
					<div class="dados">
						<label>Titulo da seção:</label>
						<input type="text" name="titulo" id="titulo" value="" maxlength="255" class="frm w270 border" />
						<br/><br/>
						<label>Texto:</label>
						<textarea name="texto" id="texto" rows="15" cols="125" class="frm"></textarea>
					</div>
				</li>
				<li>
					<p id="retorno_erro">
						<!-- START BLOCK : bloco_msg_1 -->
							{msg}
						<!-- END BLOCK : bloco_msg_1 -->
					</p>

                                            <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">

					<input type="button" class="{classe_botao_acao}" name="Submit" value=" "  onclick='validaCadastroTexto()'>
				</li>
			</ul>
		</form>
	<!-- END BLOCK : insere_registros -->

	<!-- START BLOCK : edita_registros -->
		<!-- START BLOCK : registro_salvo -->
			<div class="retorno"><b>Registro salvo com sucesso!</b></div>
		<!-- END BLOCK : registro_salvo -->
		<form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvar" onsubmit="return validaCadastroTexto();" method="POST">
			<input type="hidden" name="action" id="action" value="update" />
			<input type="hidden" name="texto_id" id="texto_id" value="{texto_id}" />
			<ul>
				<li class="clear">&nbsp; </li>
				<li>
					<div class="titulo">Titulo da seção</div>
					<div class="dados">
						<input type="text" name="titulo" id="titulo" value="{titulo}" maxlength="255" class="frm w270 border" disabled="disabled" />
					</div>
				</li>
				<li>
					<div class="titulo">Texto</div>
					<textarea name="texto" id="texto" rows="15" cols="125" class="frm">{texto}</textarea>
				</li>
				<li>
					<p id="retorno_erro">
						<!-- START BLOCK : bloco_msg_2 -->
							{msg}
						<!-- END BLOCK : bloco_msg_2 -->
					</p>

                                            <input type="button" class="btn_voltar" onClick="javascript:history.back(-1);">

					<input type="submit" class="{classe_botao_acao}" name="Submit" value="">
				</li>
			</ul>
		</form>
	<!-- END BLOCK : edita_registros -->

        <!-- LISTA DE PEÇAS MULTIMIDIAS -->
		<!-- START BLOCK : lista_registros-multi -->
			<h1>Peças Multimidias</h1>
			<form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvarMulti" enctype="multipart/form-data" method="POST">
				<input type="hidden" name="action" id="action" value="insert" />
				<ul>
					<li>
						<div class="titulo">Novo Arquivo</div>
						<div class="dados">
							<label>Tipo:</label>
								<input type="text" name="tipo" id="tipo" value="" class="frm border w270" />
							<label>Titulo:</label>
								<input type="text" name="titulo" id="titulo" value="" rows="15" cols="125" class="frm w270 border" />
							<br/>
							<label>Imagem:</label>
								<input type="file" name="file" id="file" />
							<br/><br/>
							<label>Video - embed:</label>
								<textarea name="embed" id="embed" rows="15" cols="125" class="frm"></textarea>
						</div>
					</li>
					<li>
						<p id="retorno_erro">
							<!-- START BLOCK : bloco_msg_1-multi -->
								{msg}
							<!-- END BLOCK : bloco_msg_1-multi -->
						</p>
						<input type="submit" class="criar_conta" name="Submit" value=" ">
					</li>
				</ul>
			</form>
			<table width="100%">
				<tr class="cabecalho">
					<td width="50">ID</td>
					<td>Tipo</td>
					<td>Titulo</td>
					<td width="40">Editar</td>
					<td width="40">Excluir</td>
				</tr>
				<!-- START BLOCK : lista-multi -->
					<tr class="listagem" id="{id}">
						<td>{id}</td>
						<td>{tipo}</td>
						<td>{titulo}</td>
						<td align="center">
							<a href="?on={on}&in=editarMulti&id={id}">
								<img src="{imagePath}edit.jpg" alt="Editar" title="Editar">
							</a>
						</td>
						<td class="center delMulti">
							<a href="javascript: void(0);" rel="{id}">
								<img src="{imagePath}delete.jpg" alt="Apagar" title="Apagar">
							</a>
						</td>
					</tr>
				<!-- END BLOCK : lista-multi -->
			</table>
		<!-- END BLOCK : lista_registros-multi -->
		<!-- START BLOCK : insere_registros-multi -->

		<!-- END BLOCK : insere_registros-multi -->
		<!-- START BLOCK : edita_registros-multi -->
			<!-- START BLOCK : registro_salvo-multi -->
				<div class="retorno"><b>Registro salvo com sucesso!</b></div>
			<!-- END BLOCK : registro_salvo-multi -->
			<form name="cadastro_usuario" id="cadastro_usuario" action="?on={on}&in=salvarMulti" enctype="multipart/form-data"  method="POST">
				<input type="hidden" name="action" id="action" value="update" />
				<input type="hidden" name="id" id="id" value="{id}" />
				<ul>
					<li>
						<div class="titulo">Editar multimidia</div>
						<div class="dados">
							<label>Tipo:</label>
								<input type="text" name="tipo" id="tipo" value="{tipo}" class="frm w270 border" />
							<label>Titulo:</label>
								<input type="text" name="titulo" id="titulo" value="{titulo}" rows="15" cols="125" class="frm w270 border" />
								<br/>
							<label>Imagem:</label>
								<input type="file" name="file" id="file" />
								<br/><br/>
								<!-- START BLOCK : foto-multi -->
									<div class="imgPrincipal">
										{imagem}
										<br/>
										<a href="javascript: confirmation('?on=gourmet&in=apagarFotoMulti&id={id}')">Apagar Imagem [x]</a>
									</div>
								<!-- END BLOCK : foto-multi -->
								<br/>
							<label>Video - embed:</label>
								<textarea name="embed" id="embed" rows="15" cols="125" class="frm">{embed}</textarea>
						</div>
					</li>
					<li>
						<p id="retorno_erro">
							<!-- START BLOCK : bloco_msg_2-multi -->
								{msg}
							<!-- END BLOCK : bloco_msg_2-multi -->
						</p>
						<input type="submit" class="criar_conta" name="Submit" value=" ">
					</li>
				</ul>
			</form>
		<!-- END BLOCK : edita_registros-multi -->
	<!-- -->
</div>