<?php
//-----------------------------------------------------------------------------------------------------------
// CLASSE..................: htmlTemplate
// CRIADO..................: 15/05/2002
// ÚLTIMA MODIFICAÇÃO......: 16/05/2002
// PROGRAMADOR.............: Marcos Pont
//-----------------------------------------------------------------------------------------------------------

class htmlTemplate
{
  var $templatePath;            // caminho para o arquivo TPL
  var $templateFile;            // nome do arquivo TPL
  var $content = "";            // conteúdo do arquivo TPL
  var $rawContent = "";         // conteúdo cru (sem substituições) do template

  //-----------------------------------------
  // htmlTemplate($file*,$path**)
  // construtor da classe
  // * $file (arquivo template)
  // ** $path (caminho para o template)
  //-----------------------------------------
  function htmlTemplate($file="",$path="")
  {
    $this->templateFile = $file;
    $this->templatePath = $path;
  }

  //-----------------------------------------
  // loadTemplate()
  // carrega o template para a classe
  //-----------------------------------------
  function loadTemplate()
  {
    if ($this->templateFile != "") {
      if (file_exists($this->templatePath.$this->templateFile)) {
        $file = file($this->templatePath.$this->templateFile);
      }
      else {
        $this->_error("Erro na leitura do arquivo TPL ".$this->templateFile."!");
      }
      $result = "";
      while(list($line,$value) = each($file)) {
        $value = ereg_replace("(\r|\n)","",$value);
        $result .= $value."\r\n";
      }
      $this->content = $result;
	  $this->rawContent = $result;
    }
  }

  //-----------------------------------------
  // resetTemplate()
  // retorna ao conteúdo cru inicial da classe
  //-----------------------------------------
  function resetTemplate()
  {
    $this->content = $this->rawContent;
  }

  //-----------------------------------------
  // substituiValor($chave*,$valor**)
  // substitui chave por valor no template
  //-----------------------------------------
  function substituiValor($chave,$valor)
  {
    $this->content = str_replace("{".$chave."}",$valor,$this->content);
  }

  //-----------------------------------------
  // getContents()
  // retorna o conteúdo do template
  //-----------------------------------------
  function getContents()
  {
    if ($this->content == "") {
      $this->loadTemplate();
    }
    return $this->content;
  }

  //-----------------------------------------
  // printTemplate()
  // exibe o conteúdo do template
  //-----------------------------------------
  function printTemplate()
  {
    echo $this->content;
  }

  //-----------------------------------------
  // _error($msg*)
  // mensagem de erro da classe
  // * $msg (mensagem de erro)
  //-----------------------------------------
  function _error($msg)
  {
    echo "<B>Erro na classe htmlTemplate :</B> ".$msg;
    exit;
  }
}
?>