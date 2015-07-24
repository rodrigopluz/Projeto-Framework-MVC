<!-- START BLOCK : cadastro -->
	<input type="hidden" id="ac" name="ac" value="{ac}" />
	<div class="bx_cad" rel="{on=restrito}">
		<p style="font-weight:900;color:#32CD32">{msg}</p>
		<form action="" method="POST" onsubmit="return false">
			<div class="clear">
				<label>Nome :</label><input class="frm" type="text" name="nome" id="nome" value="" />
			</div>
			<div class="clear">
				<label>Email :</label><input class="frm" type="text" name="email" id="email" value="" />
			</div>
			<div class="clear">
				<label>Fone :</label><input class="frm" type="text" name="fone" id="fone" value="" mask="phone-br" />
			</div>
			<div class="clear">
				<label>Senha :</label><input class="frm" type="password" name="senha" id="senha" value="" />
				<!--a href="javascript: validaCadastroUsuario();" class="btn_entrar right mr20">entrar</a-->
				<button type="submit" onclick="validaCadastroUsuario()" class="btn_entrar right mr20">entrar</button>
			</div>
		</form>
		<br  class="clear"/>
		<p class="clear" id="result_cad">&nbsp;</p>
		<a href="javascript: login_cadastro();" class="v9 bold orange">Já sou cadastrado</a>
	</div>
	
	<div class="login hide" rel="{on=restrito}">
		<form action="" method="POST" onsubmit="return false">
			<div class="clear">
				<label>Email :</label><input class="frm" type="text" name="email_login" id="email_login" value="" />
			</div>
			<div class="clear">
				<label>Senha :</label><input class="frm" type="password" name="senha_login" id="senha_login" value="" />
				<!--a href="javascript: logar('{ac}');" class="btn_entrar right mr20">entrar</a-->
				<button type="submit" onclick="logar('{ac}')" class="btn_entrar right mr20">entrar</button>
			</div>
		</form>
		<br  class="clear"/>
		<p class="clear" id="result_login">&nbsp;</p>
		<a href="javascript: login_cadastro();" class="v9 bold orange">Faça seu cadastro</a>
	</div>
	
	<script>
	$('input:text').setMask();
	if($('#nome_p').val() != 'seu nome')
		$('#nome').val($('#nome_p').val());
	if($('#email_p').val() != 'seu e-mail'){
		$('#email').val($('#email_p').val());
		$('#email_login').val($('#email_p').val());
	}
	function login_cadastro() {
		$('.bx_cad').toggle();
		$('.login').toggle();
		if($('.login').css('display') == 'none')
		$('#containerModal .title').html('Faça seu Cadastro');
		else
		$('#containerModal .title').html('Faça seu Login');
	}

	</script>
<!-- END BLOCK : cadastro -->

<!-- START BLOCK : recupera_senha -->
	<div class="bx_senha">
		<div class="clear">
			<label>Email :</label><input class="frm" type="text" name="email_senha" id="email_senha" value="" /><a href="javascript: envia_senha();" class="btn_entrar right mr20">entrar</a>
		</div>
		<br  class="clear"/>
		<p class="clear" id="result_login">&nbsp;</p>
	</div>
<!-- END BLOCK : recupera_senha -->

<!-- START BLOCK : area_usuario -->
	<div class="conteudo">
		{migalha}
		
		<!-- START BLOCK : msg -->
			<p class="v12 verm clear">{msg}</p>
		<!-- END BLOCK : msg -->
		
		<div class="box boxPerfil">
			<ul>
				<li class="last">
					<div class="right">
						<span class="blue bold">Bem Vindo {nome}</span> <br />
						
						<a href="{on=restrito}|in=formPerfil&id={id}" class="btn_editar_perfil">editar perfil</a>
						
						<ul class="lista_perfil_dado">
							<li>Telefone: <b>{telefone}</b></li>
							<li>Email: <b>{email}</b></li>
							<!-- START BLOCK : cnpj -->
							<li>CNPJ: <b>{cnpj}</b></li>
							<!-- END BLOCK : cnpj -->
							<!-- START BLOCK : cpf -->
							<li>CPF: <b>{cpf}</b></li>
							<!-- END BLOCK : cpf -->
							<!-- START BLOCK : creci -->
							<li>CRECI: <b>{creci}</b></li>
							<!-- END BLOCK : creci -->
							<li>Site: <b><a href="{site}">{site}</a></b></li>
							<li>Endereço: <b>{endereco}</b></li>
							<li>Cidade: <b>{cidade} - {estado}</b></li>
						</ul>
						
					</div>
					<!-- START BLOCK : imagem_usuario -->
					<div class="img"><img src="{uploadPath}usuarios/{id}.jpg" alt="{nome}" title="{nome}" /></div>
					<!-- END BLOCK : imagem_usuario -->
					<!-- START BLOCK : imagem_padrao -->
					<div class="img"><img src="{uploadPath}usuarios/{tipo_usuario}.jpg" alt="{nome}" title="{nome}" /></div>
					<!-- END BLOCK : imagem_padrao -->
					
					<!-- START BLOCK : dados_responsavel -->
					<div class="line claer"></div>
					
					<ul class="lista_perfil_dado">
						<li>Responsável: <b>{contato}</b></li>
						<li>Telefone: <b>{contato_telefone}</b></li>
						<li>Email: <b>{contato_email}</b></li>
						<li>Celular: <b>{contato_celular}</b></li>
					</ul>
					<!-- END BLOCK : dados_responsavel -->
					<br class="clear" />
				</li>
			</ul>
		</div>
		
		<p class="clear">&nbsp;</p>
		
		{lista_ferramentas_usuarios}
		
	</div>
<!-- END BLOCK : area_usuario -->

<!-- START BLOCK : form -->
	<div class="conteudo">
		{migalha}
		
		<br class="clear" />
		{form}
	</div>
<!-- END BLOCK : form -->

<!-- START BLOCK : form_perfil -->
	<script type="text/javascript">
	function validaFormPerfil() {
		msg = "";
		
		disabledFormButton("input[type='submit']");

		if($("#nome").val() == "")				msg += "Nome não preenchido.\r\n";
		//if($("#telefone").val() == "")			msg += "<span>Telefone não preenchido.</span><br />";
		if($("#estado").val() == "")			msg += "Estado não preenchido.\r\n";
		if($("#cidade").val() == "")			msg += "Cidade não preenchido.\r\n";
		//if($("#endereco").val() == "")			msg += "<span>Endereço não preenchido.</span><br />";
		
		var file = $('#imagem').val();
		var ext  = file.split('.');
		ext		 = ext.reverse();
		
		if((ext[0].toLowerCase() != "jpg" && ext[0].toLowerCase() != "jpeg") && file != '')											
			msg += "O formato da imagem deve ser .jpg\r\n";
			//msg += "Erro no arquivo de imagem. (formato deve ser .jpg)\r\n";
	
		
		
		if($("#senha").val() != $("#senha1").val())			msg += "Confirmação se senha não confere.\r\n";
		
		if(msg != ""){
			
			msg = "Os seguintes campos encontram-se com problemas:\r\n\r\n" + msg;
			
			//jQuery.facebox(msg);
			alert(msg);
			enabledFormButton("input[type='submit']");

			return false;
		} else {
			return true;
		}
	}

	</script>
	<form class="form_cad" id="formPerfil" name="formPerfil" action="{on=restrito}|&in=savePerfil" onsubmit="return validaFormPerfil();" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id" id="id" value="{id}" />
		<h1>Ediçao de Perfil</h1>
		<div class="line">&nbsp;</div>
		
		<fieldset id="endereco_dados">
			<p class="v15 bold">dados gerais</p>
			<label class="inp"> email : </label><b>{email}</b> <br class="clear" />
			<!-- START BLOCK : com_creci -->
			<label class="inp"> CRECI :  </label><b>{creci}</b> <p class="clear">&nbsp;</p>
			<input type="hidden" name="creci" id="creci" value="{creci}"/>
			<!-- END BLOCK : com_creci -->
			<!-- START BLOCK : com_cnpj -->
			<label class="inp"> CNPJ :  </label><b>{cnpj}</b> <p class="clear">&nbsp;</p>
			<input type="hidden" name="cnpj" id="cnpj" value="{cnpj}"/>
			<!-- END BLOCK : com_cnpj -->
			<!-- START BLOCK : com_cpf -->
			<label class="inp"> CPF :  </label><b>{cpf}</b> <p class="clear">&nbsp;</p>
			<input type="hidden" name="cpf" id="cpf" value="{cpf}"/>
			<!-- END BLOCK : com_cpf -->
			
			<!-- START BLOCK : sem_cnpj -->
			<p class="clear">&nbsp;</p>
			<label class="inp"> CNPJ</label> <input type="text" name="cnpj" id="cnpj" value="{cnpj}" class="inp w385" maxlength="255" alt="cnpj"/> <br class="clear" />
			<!-- START BLOCK : sem_cnpj -->
			<!-- START BLOCK : sem_cpf -->
			<p class="clear">&nbsp;</p>
			<label class="inp"> CPF</label> <input type="text" name="cpf" id="cpf" value="{cpf}" class="inp w385" maxlength="255" alt="cpf"/> <br class="clear" />
			<!-- START BLOCK : sem_cpf -->
			
			<label class="inp"> nome</label> <input type="text" name="nome" id="nome" value="{nome}" class="inp w385" maxlength="255"/> <br class="clear" />
			<label class="inp"> telefone</label> <input type="text" name="telefone" id="telefone" value="{telefone}" class="inp w130" maxlength="45" alt="phone"/> <br class="clear" />
			<label class="inp"> celular</label> <input type="text" name="celular" id="celular" value="{celular}" class="inp w130" maxlength="45" alt="phone"/> <br class="clear" />
			<label class="inp"> estado</label> <input type="text" name="estado" id="estado" value="{estado}" class="inp w130" maxlength="2"/> <br class="clear" />
			<label class="inp"> cidade</label> <input type="text" name="cidade" id="cidade" value="{cidade}" class="inp w385" maxlength="255"/> <br class="clear" />
			<label class="inp"> bairro</label> <input type="text" name="bairro" id="bairro" value="{bairro}" class="inp w385" maxlength="255"/> <br class="clear" />
			<label class="inp"> endereço</label> <input type="text" name="endereco" id="endereco" value="{endereco}" class="inp w385" maxlength="255"/> <br class="clear" />
			
			<label class="inp"> site  <span>http://</span></label> <input type="text" name="site" id="site" value="{site}" class="inp w385"  maxlength="255"/> <br class="clear" />
			
			<label class="inp"> descrição</label> <textarea class="inp" name="descricao" id="descricao">{descricao}</textarea><br class="clear" />
			<!--label class="inp"> perfil</label> <textarea class="inp" name="perfil" id="perfil">{perfil}</textarea><br class="clear" /-->
			
			<!-- START BLOCK : perfil_creci -->
			<label class="inp"> creci</label> <input type="text" name="creci" id="creci" value="{creci}" class="inp w130" maxlength="20"/> <br class="clear" />
			<!-- END BLOCK : perfil_creci -->
		</fieldset>
			
			
		<div class="line">&nbsp;</div
		<fieldset id="endereco_dados">
			<p class="v15 bold">arquivo de imagem <small style="font-weight:100">(Formato permitido: JPG)</small></p>
			<input type="file" name="imagem" id="imagem" class="inp w" style="width:525px"/> <br class="clear" />
		</fieldset>
		
		<!-- START BLOCK : perfil_contato -->
		<div class="line">&nbsp;</div>
		<fieldset id="dados">
			<p class="v15 bold">dados do contato</p>
			<label class="inp"> nome</label> <input type="text" name="contato" id="contato" value="{contato}" class="inp w385"  maxlength="255"/> <br class="clear" />
			<label class="inp"> email</label> <input type="text" name="contato_email" id="contato_email" value="{contato_email}" class="inp w385"  maxlength="255"/> <br class="clear" />		
			<label class="inp"> telefone</label> <input type="text" name="contato_telefone" id="contato_telefone" value="{contato_telefone}" class="inp w130" alt="phone" maxlength="45"/> <br class="clear" />
			<label class="inp"> celular</label> <input type="text" name="contato_celular" id="contato_celular" value="{contato_celular}" class="inp w130" alt="phone"  maxlength="25"/> <br class="clear" />	
		</fieldset>
		<!-- END BLOCK : perfil_contato -->
		
		<div class="line">&nbsp;</div>
		<fieldset id="dados">
			<p class="v15 bold">senha</p>
			<label class="inp"> nova senha</label> <input type="password" name="senha" id="senha" value="" class="inp w130"  maxlength="55"/> <br class="clear" />
			<label class="inp"> confirme nova senha</label> <input type="password" name="senha1" id="senha1" value="" class="inp w130"  maxlength="55"/> <br class="clear" />
		</fieldset>
			
		<p class="clear">&nbsp;</p>
		<input type="submit" class="btn_finalizar" name="Submit" value=" " />
		
	</form>
<!-- END BLOCK : form_perfil -->