<?php
	$error = "";
	$msg = "";
	$fileElementName = 'fileToUpload';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'Файл для загрузки не выбран!';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
		//	$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
		//	$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
			
			
			
			
			
			
			
			
			   	  
		 $folder =  '..//catalog_images/';
		
		$extension = strtolower(substr(strrchr($_FILES['fileToUpload']['name'], '.'), 1));
		
		$filename1 = md5(microtime()).rand(0,99999);
		

		$uploadedFile =  $folder.$filename1.".".$extension; 
		
		
		/* Загрузка файла */	
		// if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'])){  
		
			//ПОДКЛЮЧАЕМ ФУНКЦИЮ РЕСАЙЗ
			require ('..//resizer/imgresize.php');
				if (img_resize($_FILES['fileToUpload']['tmp_name'], $folder.$filename1.".".$extension, 600, 450)) 
					{ 
						// Создание большого изображения прошло успешно
						$msg .=$folder.$filename1.".".$extension.';'; } else { $msg .='NO;';	 };
				if (img_resize($_FILES['fileToUpload']['tmp_name'], $folder.$filename1."_small.".$extension, 70, 70)) 
					{ 
						// Создание малого изображения прошло успешно
					$msg .=$folder.$filename1."_small.".$extension; } else { $msg .='NO';	 };
				//} 
		/* Перемещение файла */			
		//if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$uploadedFile)){ $msg .= 'Успешно сохранён';} 
		// Делаем 2 изображения - 1 стандартное, 2 - уменьшенное
		
		
			
			//for security reason, we force to remove all uploaded file
			@unlink($_FILES['fileToUpload']);		
	}		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "'\n";
	echo "}";
?>