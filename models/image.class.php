<?php
class Image {

    function aleatorio($caracteres) {
        return substr(md5(base_convert(time(), 10, 36)),10,$caracteres);
    }

    function resizeImage($originalImage, $newImage, $newWidth, $newHeight, $bgred=0xff,$bggreen=0xff,$bgblue=0xff, $interlace = 1, $jpegquality = 75) {
        //abre imagem original
        switch ($imageType = exif_imagetype($originalImage)) {
            case IMAGETYPE_GIF:
                if (imagetypes() & IMG_GIF)
                    $imOriginal = @imagecreatefromgif($originalImage);
                else
                    die('<P>Formato de imagem não suportado pelo PHP: '.$imageType.' '.image_type_to_mime_type($imageType).'.</P>');
                break;
            case IMAGETYPE_JPEG:
                if (imagetypes() & IMG_JPG)
                    $imOriginal = @imagecreatefromjpeg($originalImage);
                else
                    die('<P>Formato de imagem não suportado pelo PHP: '.$imageType.' '.image_type_to_mime_type($imageType).'.</P>');
                break;
            case IMAGETYPE_PNG:
                if (imagetypes() & IMG_PNG)
                    $imOriginal = @imagecreatefrompng($originalImage);
                else
                    die('<P>Formato de imagem não suportado pelo PHP: '.$imageType.' '.image_type_to_mime_type($imageType).'.</P>');
                break;
            default:
                die('<P>Formato de imagem não reconhecido pelo algoritmo: '.$imageType.' '.image_type_to_mime_type($imageType).'.</P>');
        } 
        if (!$imOriginal) return false;
        //cria a imagem nova
        $imThumb = @imagecreatetruecolor ($newWidth,$newHeight);
        if (!$imThumb) return false;
        imagefilledrectangle ($imThumb, 0, 0, $newWidth, $newHeight, imagecolorallocate ($imThumb, $bgred, $bggreen, $bgblue));
        //cuida do aspect ratio
        $xOrig = imagesx($imOriginal);
        $yOrig = imagesy($imOriginal);
        $xThumb = $newWidth;
        $yThumb = $newHeight;
        $ratioOrig = $xOrig / $yOrig;
        $ratioThumb = $xThumb / $yThumb;
        if ($ratioOrig > $ratioThumb) {
            $yThumb = round($xThumb / $ratioOrig);
        }
        elseif ($ratioOrig < $ratioThumb) {
            $xThumb = round($yThumb * $ratioOrig);
        }
        $xMargin = round(($newWidth - $xThumb)/2);
        $yMargin = round(($newHeight - $yThumb)/2);
        //modifica o tamanho
        imagecopyresampled($imThumb, $imOriginal, $xMargin ,$yMargin , 0, 0, $xThumb, $yThumb, $xOrig, $yOrig);
        ImageDestroy($imOriginal); 
        //entrelaça, se necessário
        if ($interlace) imageinterlace($imThumb, $interlace);
        //salva a imagem
        if (!$newImage) Header('Content-type: '.image_type_to_mime_type($imageType));
        switch ($imageType) {
            case IMAGETYPE_GIF:
                Imagegif($imThumb, $newImage);
                break;
            case IMAGETYPE_JPEG:
                Imagejpeg($imThumb, $newImage, $jpegquality);
                break;
            case IMAGETYPE_PNG:
                if ($newImage)
                    Imagepng($imThumb, $newImage);
                else
                    Imagepng($imThumb);
                break;
        } 
        ImageDestroy($imThumb);
        return true;
    }

    function supportedImgFormats() {
        // supportedImgFormats() : retorna a lista dos formatos suportados pelo PHP e pelo algoritmo de resampling 
        $arr = array();
        if (imagetypes() & IMG_GIF) $arr[] = 'GIF';
        if (imagetypes() & IMG_JPG) $arr[] = 'JPG';
        if (imagetypes() & IMG_PNG) $arr[] = 'PNG';
        return implode(', ', $arr);
    }

    function removeImage($id, $abbrev, $pasta, $fotoext) {
        //------------ FUNÇÃO DE REMOÇÃO DE IMAGEM -----------------------
        // parâmetros:
        // $id: id do objeto (utilizado no nome do arquivo)
        // $abbrev: abreviação (utilizada no nome do arquivo)
        // $idsub: sub-id da foto (caso haja + de uma por id)
        // $fotoext: extensão da foto a ser removida
        // retorno:
        // TRUE se a operação sucedeu em todos arquivos
        // FALSE se a operação não pôde ser realizada para algum arquivo (arquivo não existe, não há permissão de escrita etc)
        global $std;
        $ok = true;
        //calcula o nome do arquivo
        $txtImg = $this->photo_name($abbrev, $id, $fotoext, $pasta);
        //exclui o arquivo
        $ok &= unlink($txtImg);
        return $ok;
    }

    function photo_name ($nome, $id, $txtFotoExtensao, $pasta='', $sem_root_dir=0,$caminho='') {
        if ($pasta)
            $pasta = $pasta ."/";
            $nome = $pasta.$nome.'_'.$id.'.'.$txtFotoExtensao;
        if ($sem_root_dir)
            $nome = $nome;
        else $nome = UPLOAD_DIR . $nome;
        return $nome;
    }

    function get_photo($nome, $texto_alt, $idSub = 0, $intWidth=0, $intHeight=0, $intBorder = 0, $align = 0) {
        /// MONTA A TAG DE FOTO PARA A IMAGEM;
        if ($nome)
        return '<img src="'.ROOT_DIR.'b2b/upload/'.$nome.'" alt="'.($texto_alt?$texto_alt:'').'" border="'.$intBorder.'"'.($intWidth?' width='.$intWidth:'').($intHeight?' height='.$intHeight:'').($align?' align='.$align:'').'>';
        else return '';
    }

    function uploadImage($id,$abbrev,$nomecampo,$pasta='',$dims=false,$fotoextantigas=false,$nomearray=false,$removeoriginal=false) {
        //------------ FUNÇÃO DE UPLOAD DE IMAGEM -----------------------
        // $id: id do objeto (utilizado no nome do arquivo)
        // $abbrev: abreviação (utilizada no nome do arquivo)
        // $pasta é o diretorio interno (e.g. fotos, imoveis, clientes)
        // $nomecampo: nome do campo <INPUT TYPE=FILE NAME=
        // $dims: array cuja chave é o sub-id de cada foto e o valor é um array com as dimensões de cada imagem (por exemplo array(1=>array(120,160),'1b'=>array(400,400))
        // $fotoextantigas: array cuja chave é o sub-id de cada foto e o valor é um array com a extensão da foto antiga a ser removida (opcional) (por exemplo array(1=>'jpeg','1b'=>'jpg')
        // $nomearray: array onde está o campo com informações do arquivo (ex.: $arrayprod[nomearq] >> $nomecampo=nomearq, $nomearray=arrayprod)
        // $removeoriginal: remove a foto original caso se queira upload somente a miniatura
        global $std;
        if ($nomearray===false) {
            $arrayfile = $_FILES[$nomecampo];
        } else {
            //trata array de arquivo
            $arraymod = array('name','type','tmp_name','error','size');
            foreach ($arraymod as $mod) {
                $arrayfile[$mod] = $_FILES[$nomearray][$mod][$nomecampo];
            }
        }
        //FAZ O UPLOAD
        if (is_uploaded_file($arrayfile['tmp_name'])) {
            //exclui imagens antigas (se houver)
            if ($fotoextantigas!==false && is_array($fotoextantigas))
                foreach ($fotoextantigas as $idsub => $fotoextantiga)
                    $this->removeImage($id, $abbrev, $idsub, $fotoextantiga);
                    //calcula o nome do arquivo
                    $path_parts = pathinfo($arrayfile['name']);
                    $intFotoExtensao = $path_parts['extension'];
            if ($intFotoExtensao) {
                $txtImg = $this->photo_name ($abbrev, $id, $intFotoExtensao,$pasta);
                //sobe a imagem
                $bOKfot = move_uploaded_file($arrayfile['tmp_name'], $txtImg);
            }
            else {
                //erro no upload
                return false;
            }
            //VERIFICA SE A IMAGEM É SUPORTADA, se não for, cancela o upload
            if (!(imagetypes() & exif_imagetype($txtImg))) {
                unlink($txtImg);
                return false;
            }
            else {
                //redimensiona se for o caso
                foreach($dims as $idsub => $dim) {
                    $txtImg2 = $this->photo_name($idsub.$abbrev, $id, $intFotoExtensao, $pasta);          
                    $bOKfot &= $this->resizeImage($txtImg, $txtImg2, $dim[0], $dim[1]);
                    if ($txtImg==$txtImg2) $removeoriginal = false;
                }
                if ($removeoriginal) unlink($txtImg);
                return $bOKfot;
            }
        }
    }
}

$image = new Image();

?>