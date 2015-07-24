<div class="capa">
	<div class="login" rel="on=capa">
		<form action="" method="POST" onsubmit="return false">
			<div class="clear">
				<label>Email :</label><input class="frm" type="text" name="email_login" id="email_login" value="" />
			</div>
			<div class="clear">
				<label>Senha :</label><input class="frm" type="password" name="senha_login" id="senha_login" value="" />
				<!--a href="javascript: logar();" class="btn_entrar right mr20">entrar</a-->
				<button type="submit" onclick="logar()" class="btn_entrar right mr20">entrar</button>
			</div>
		</form>
		<br  class="clear"/>
		<p class="clear" id="result_login">&nbsp;</p>
		<a href="javascript: getBoxSenha();" class="v9 bold orange">Esqueceu sua senha?</a>
	</div>
</div>