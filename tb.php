<?

header("Pragma: no-cache");
header("Cache: no-cahce");

error_reporting(E_ALL);

define('MAX_WIDTH', $_REQUEST['x']);
define('MAX_HEIGHT', $_REQUEST['y']);

$image_file = str_replace('..', '', $_REQUEST['img']);
$image_path = $image_file;

$img = null;

$extensao = explode('.',$image_path);
$extensao = strtolower($extensao[1]);

if ($extensao == 'jpg' || $extensao == 'jpeg') {
    $img = @imagecreatefromjpeg($image_path);
} else if ($extensao == 'png') {
    $img = @imagecreatefrompng($image_path);
    // Se a vers�o do GD incluir suporte a GIF, mostra...
} elseif ($extensao == 'gif') {
    $img = @imagecreatefromgif($image_path);
}
// Se a imagem foi carregada com sucesso, testa o tamanho da mesma
if ($img) {
	$width = imageSX($img);
	$height = imageSY($img);
	
	// Build the thumbnail
	$target_width 	= MAX_WIDTH;
	$target_height 	= MAX_HEIGHT;
	$target_ratio 	= $target_width / $target_height;

	$img_ratio 		= $width / $height;

	if ($target_ratio > $img_ratio) {
		$new_height = $target_height;
		$new_width = $img_ratio * $target_height;
	} else {
		$new_height = $target_width / $img_ratio;
		$new_width = $target_width;
	}

	if ($new_height > $target_height) {
		$new_height = $target_height;
	}
	if ($new_width > $target_width) {
		$new_height = $target_width;
	}

	$new_img = ImageCreateTrueColor(MAX_WIDTH, MAX_HEIGHT);
	$white 	 = imagecolorallocate($new_img, 255, 255, 255);
	
	if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, $white)) {	// Fill the image white
		echo "ERROR:Could not fill new image";
		exit(0);
	}

	if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
		echo "ERROR:Could not resize image";
		exit(0);
	}
} 


// Cria uma imagem de erro se necess�rio
if (!$img) {
	   $logo 		= imagecreatefromjpeg("assets/site/img/bg/img.jpg");
   	$new_img 	= imagecreate(MAX_WIDTH, MAX_HEIGHT);
    imagecopymerge($new_img,$logo, ((MAX_WIDTH-50)/2), ((MAX_HEIGHT-50)/2), 0, 0, 50, 50, 100);
}
//exit();
// Mostra a imagem
header('Content-type: image/jpeg');
imagejpeg($new_img,null,'100');
//exit();
?>
<!-- END arquivo thumb.php -->