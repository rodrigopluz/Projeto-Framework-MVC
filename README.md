# Projeto pessoal - Framework MVC.

![version](https://img.shields.io/badge/version-1.0.0-blue.svg) 
[![license](https://img.shields.io/apm/l/vim-mode.svg)](LICENSE)

# Instalação:
Para ter acesso ao CMS tem na raiz tem uma copia inicial da base de dados - db.sql, basta importar o arquivo no PhpMyAdmin ou diretamente no console mysql.

Reconfigurar os dados de acesso a banco no arquivo "cfg/cfg.main.php" adequando o seguinte trecho abaixo:

* BANCO DE DADOS
- define("DB_HOST", "");            // Localhost ou mysql.host.com.br.
- define("DB_USED", "mysql");       // Banco de Dados a ser usado.
- define("DB_USER", "");            // Nome do Usuario.
- define("DB_PASS", "");            // Senha do Usuario.
- define("DB_BASE", "");            // Banco de Dados.
- define("MYSQL_CHARSET", "utf8");  
- define("COMMON_PATH", GLOBAL_PATH . "common/");
- define("CURL_PATH", "/usr/bin/curl");

# Requisitos:
HTTP Server. Por exemplo: 
- Apache. Mod_rewrite ativado.
- PHP 5.3
- MySQL.

Para visualizar no browser, basta aplicar os arquivo no servidor Apache. 

E para ter acesso ao CMS o login e senha são: 
- login - desafio@teste.com.br 
- senha - qwe123qwe

Qualquer duvida que tiverem na configuração dos arquivos, entrem em contato: rodrigopluz@gmail.com que ajudarei a resolver.
E se tiverem alguma contribuição para deixar o framework melhor, estou a disposição.

## Browser Suportados

<img src="https://s3.amazonaws.com/creativetim_bucket/github/browser/chrome.png" width="64" height="64"> <img src="https://s3.amazonaws.com/creativetim_bucket/github/browser/firefox.png" width="64" height="64"> <img src="https://s3.amazonaws.com/creativetim_bucket/github/browser/edge.png" width="64" height="64"> <img src="https://s3.amazonaws.com/creativetim_bucket/github/browser/safari.png" width="64" height="64"> <img src="https://s3.amazonaws.com/creativetim_bucket/github/browser/opera.png" width="64" height="64">

## Autor

<table>
  <tr>
    <td>
      <img src="https://avatars2.githubusercontent.com/u/8739638?s=460&v=4" width="100">
    </td>
    <td>
      :octocat: Rodrigo Pereira<br />
      <a href="mailto:rodrigopluz@gmail.com">:point_right: rodrigopluz@gmail.com</a><br />
    </td>
  </tr>
</table>
