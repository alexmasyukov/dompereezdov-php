<?php
/***********************************************************************************
Функция img_resize(): генерация thumbnails
Параметры:
  $src             - имя исходного файла
  $dest            - имя генерируемого файла
  $width, $height  - ширина и высота генерируемого изображения, в пикселях
Необязательные параметры:
  $rgb             - цвет фона, по умолчанию - белый
  $quality         - качество генерируемого JPEG, по умолчанию - максимальное (100)
***********************************************************************************/
function img_resize($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100)
{
	$root = realpath($_SERVER['DOCUMENT_ROOT']);

  if (!file_exists($src)) return false;

  $size = getimagesize($src);

  if ($size === false) return false;

  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;

  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];

  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);

 

	if ($size[0]<$width) {

		$new_width   = $size[0];
		$new_height  = $size[1];
		$new_left    = !$use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
		$new_top     = !$use_x_ratio ? 0 : floor(($height / 2)-($new_height / 2));
		  
	} else {
		$new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
		$new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
		$new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
		$new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
	}
	
	
	  
	  
	$isrc = $icfunc($src);
 
	$idest = imagecreatetruecolor($new_width, $new_height);

	imagefill($idest, 0, 0, $rgb);
 
	// -----------------------------
		$watermark = $root.'/frontend/template/images/watermark.png';
		$wDetails = getimagesize($watermark);
		
		$newWater = imagecreatefrompng($watermark);
		imagealphablending($newWater, false);
		imagesavealpha($newWater,true);
		
		imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
		

		if ($width>300) {
			$im = $idest;
			imagecopyresampled($im, $newWater, 0, 0, 0, 0, $wDetails[0], $wDetails[1], $wDetails[0], $wDetails[1]); 
			imagejpeg($im, $dest, 80);
		} else {
			imagejpeg($idest, $dest, 80);
		}
		
		
	

  //imagejpeg($idest, $dest, $quality);

  imagedestroy($isrc);
  imagedestroy($idest);

  return true;

}
?>