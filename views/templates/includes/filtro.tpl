<div class="filtro_direita">
	<!--a href="javascript: {fn_busca};" class="btn_salva_busca">Salvar Busca</a-->
	<div class="box">
		<ul>
			<li>
				<span class="arrow2">Localização</span>
				<a id="topo_localizacao" name="topo_localizacao"></a>
				<div id="filtro_result_localizacao">
					<!-- START BLOCK : filtro_lista_cidade -->
						<p><a value="{id}" rel="cidade_id" class="filter">[excluir]</a> {nome}, {estado_sigla}</p>
					<!-- END BLOCK : filtro_lista_cidade -->
				</div>
				<input type="text" name="qi" id="qi" value="cidade e estado" autocomplete="off" class="query" />
				
				<br /><br /><a href="javascript: void(0);" id="showBairrosOpcoes" style="display:block;border-radius:5px;-moz-border-radius:5px;height:30px;line-height:30px;background-color:#52AAC7;text-align:center;color:#fff"><b>Selecione os bairros aqui</b></a>
			</li>	
			<li class="filtro_select" rel="tipo_imovel">
				<span class="arrow2">Tipo de Imóvel</span>
				<a id="topo_tipo_imovel" name="topo_localizacao"></a>
				
				<div id="filtro_result_tipo_imovel">
					<!-- START BLOCK : filtro_lista_tipo_imovel -->
						<p><a value="{id}" rel="tipo_imovel" class="filter">[excluir]</a> {nome}</p>
					<!-- END BLOCK : filtro_lista_tipo_imovel -->
				</div>
				
				<select name="filtro_tipo_imovel" id="filtro_tipo_imovel" class="sel150">
					<option value="">selecione +</option>
					{search_tipo_imovel}
				</select>
			</li>	
			<li>
				<span class="arrow2">Preço</span><br class="clear" />
				<div class="left">
					mínimo R$<br />
					<input type="text" name="filtro_valor_ini" value="{valor_ini}" id="filtro_valor_ini" mask="decimal" class="preco" />
				</div>
				
				<div class="left ml5">
					máximo R$<br />
					<input type="text" name="filtro_valor_fim" value="{valor_fim}" id="filtro_valor_fim" mask="decimal" class="preco" />
				</div>
				<br class="clear" />
			</li>
			<li class="filtro_select" rel="dormitorios">
				<span class="arrow2">Dormitórios</span>
				<div id="filtro_result_dormitorios">
					<!-- START BLOCK : filtro_lista_dormitorios -->
						<p><a value="{id}" rel="dormitorios" class="filter">[excluir]</a> {titulo}</p>
					<!-- END BLOCK : filtro_lista_dormitorios -->
				</div>
				<select name="filtro_dormitorios" id="filtro_dormitorios" class="sel150">
					<option value="">selecione +</option>
					<option value="1">1 dormitório</option>
					<option value="2">2 dormitórios</option>
					<option value="3">3 dormitórios</option>
					<option value="4">4 dormitórios</option>
					<option value="5">5 dormitórios</option>
					<option value="6">6 dormitórios</option>
					<option value="7">7 dormitórios</option>
					<option value="8">Acima de 7</option>
				</select>
			</li>
			<li class="filtro_select" rel="vagas">
				<span class="arrow2">Vagas de Garagem</span>
				<div id="filtro_result_vagas">
					<!-- START BLOCK : filtro_lista_vagas -->
						<p><a value="{id}" rel="vagas" class="filter">[excluir]</a> {titulo}</p>
					<!-- END BLOCK : filtro_lista_vagas -->
				</div>
				<select name="filtro_vagas" id="filtro_vagas" class="sel150">
					<option value="">selecione +</option>
					<option value="1">1 vaga</option>
					<option value="2">2 vagas</option>
					<option value="3">3 vagas</option>
					<option value="4">4 vagas</option>
					<option value="5">Acima de 4</option>
				</select>
			</li>
			<li class="filtro_select" rel="banheiros">
				<span class="arrow2">Banheiros</span>
				<div id="filtro_result_banheiros">
					<!-- START BLOCK : filtro_lista_banheiros -->
						<p><a value="{id}" rel="banheiros" class="filter">[excluir]</a> {titulo}</p>
					<!-- END BLOCK : filtro_lista_banheiros -->
				</div>
				<select name="filtro_banheiros" id="filtro_banheiros" class="sel150">
					<option value="">selecione +</option>
					<option value="1">1 banheiro</option>
					<option value="2">2 banheiros</option>
					<option value="3">3 banheiros</option>
					<option value="4">4 banheiros</option>
					<option value="5">Acima de 4</option>
				</select>
			</li>
			<li class="filtro_select" rel="contrato_id">
				<span class="arrow2">Anunciantes</span>
				
				<div id="filtro_result_contrato_id">
					<!-- START BLOCK : filtro_lista_anunciantes -->
					<p><a value="{contrato_id}" rel="contrato_id" class="filter">[excluir]</a> {nome}</p>
					<!-- END BLOCK : filtro_lista_anunciantes -->
				</div>
				
				<select name="filtro_contrato_id" id="filtro_contrato_id" class="sel150">
					<option value="">selecione +</option>
					{search_contrato_id}
				</select>
			</li>
		</ul>
		
	</div>
</div>