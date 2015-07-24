<div class="boxSearch">
	<form action="" method="post" onsubmit="return false">
		<ul class="search">
			<!-- START BLOCK : verao_off -->
			<li><a href="#" class="busca">busque seu imóvel</a></li>
			<li><a href="{on=imovelLista}|&cidade_id=4364,4115,3994,3934,4408,4363,5562&clear=all&modalidade_id=1,3&campanha=verao" class="verao">Verão 2011, litoral norte RS</a></li>
			<!-- END BLOCK : verao_off -->
			<!-- START BLOCK : verao_on -->
			<li><a href="{on=imovelLista}|&clear=all&modalidade_id=1,3" class="busque">busque seu imóvel</a></li>
			<li><a href="{on=imovelLista}|&cidade_id=4364,4115,3994,3934,4408,4363,5562&clear=all&modalidade_id=1,3&campanha=verao" class="verao2">Verão 2011, litoral norte RS</a></li>
			<!-- END BLOCK : verao_on -->
			<li><a href="{on=imovelLista}|&clear=all&modalidade_id=2" class="lancamentos">lançamentos</a></li>
			<li style="width: 200px;">&nbsp;<!--a href="#" class="venda">venda seu imóvel</a--></li>
			<li class="sep"><!--a href="#" class="alugue">alugue seu imóvel</a--></li>
			<!--li><a href="{on=cadastro}" class="corretor">central de corretores</a></li>
			<li><a href="{on=cadastro}" class="construtora">central de construtoras</a></li>
			<li><a href="{on=cadastro}" class="imobiliaria">central de imobiliárias</a></li-->
			<li style="float:right"><a href="javascript: anunciar();" class="anuncie2">anuncie aqui seu imóvel</a></li>
		</ul>
		
		<div class="{box_search} clear">
			<div class="arrow_r blue v18 left">eu quero</div>
			<div class="left select_modalidade">
				<!-- START BLOCK : lista_modalidade -->
					<!--a href="#mid{id}" class="fakecheck orange" id="fakemid{id}" >{nome}</a>
					<input name="modalidade_id" id="mid{id}" value="{id}" type="radio" class="hide" {checked} onclick="setPreco('mid{id}')" /-->
					<a href="javascript://" class="fakecheck orange">{nome}</a>
					<input name="modalidade_id[]" value="{id}" type="checkbox" class="hide" {checked} onclick="setPreco('mid{id}')" />
				<!-- END BLOCK : lista_modalidade -->
			</div>
			<div class="boxCode">
				<label for="cod" class="arrow_r blue v18 left">código do imóvel</label>
				<input type="text" name="cod" id="cod"/>
			</div>
			<br class="clear" />
			
			<!-- START BLOCK : search_home -->
				<input type="text" name="q" id="q" value="cidade e estado" autocomplete="off" class="query" />
				<input type="hidden" name="cidade_id" id="cidade_id"  value="" />
				<input type="hidden" name="clear"  value="all" />
				
				<select name="tipo_imovel" id="tipo_imovel" class="tipo_imovel">
					<option value="">tipo do imóvel</option>
					{search_tipo_imovel}
				</select>
				
				<p class="clear exception">&nbsp;Ex. Porto Alegre, RS</p>
				
				<label>faixa de valor</label>
				<input type="text" class="valor" name="valor_ini" id="valor_ini" value="" mask="decimal" />
				<label> a </label>
				<input type="text" class="valor" name="valor_fim" id="valor_fim" value="" mask="decimal" />
				
				<label class="pl32">dormitórios</label>
				<div class="boxSelect">
					<select id="dormitorios" name="dormitorios">
						<option value=""> </option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8+</option>
					</select>
				</div>
				
				<label class="pl39">vagas</label>
				<div class="boxSelect">
					<select id="vagas" name="vagas">
						<option value=""> </option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5+</option>
					</select>
				</div>
				
				<br class="clear" />
				
				<div class="nav_query">
					<!--a href="javascript: querySearch('{on=imovelLista}')" class="btn_busca hide-text">buscar imóveis</a-->
					<button onclick="querySearch('{on=imovelLista}')" class="btn_busca hide-text">buscar imóveis</button>
					<!--input name="salvar_busca" id="salvar_busca" class="left v18 ml15" value="S" type="checkbox" />
					<label for="salvar_busca">salvar busca</label>
					<span class="v18 pl55">se preferir faça uma </span>
					<a href="#" class="arrow_f v18 bold">busca avançada</a-->
				</div>
			<!-- END BLOCK : search_home -->
			
			<!-- START BLOCK : search_interna -->
				<input type="text" name="q" id="q" value="cidade e estado" autocomplete="off" class="query" />
				<input type="hidden" name="cidade_id" id="cidade_id"  value="" />
				<input type="hidden" name="clear"  value="all" />
				
				<select name="tipo_imovel" id="tipo_imovel" class="tipo_imovel">
					<option value="">tipo do imóvel</option>
					{search_tipo_imovel}
				</select>
				
				<label> valor</label>
				<input type="text" class="valor" name="valor_ini" id="valor_ini" value="" mask="decimal" />
				<label> a </label>
				<input type="text" class="valor" name="valor_fim" id="valor_fim" value="" mask="decimal" />
				
				<!--a href="javascript: querySearch('{on=imovelLista}')" class="btn_busca hide-text">buscar imóveis</a-->
				<button onclick="querySearch('{on=imovelLista}')" class="btn_busca hide-text">buscar imóveis</button>
				
				<p class="clear">&nbsp;Ex. Porto Alegre, RS</p>
		<!-- END BLOCK : search_interna -->
		</div>
	</form>
</div>