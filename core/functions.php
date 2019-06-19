<?php

if (!function_exists("mb_str_replace")) {
    function mb_str_replace($needle, $replacement, $haystack)
    {
        return implode($replacement, mb_split($needle, $haystack));
    }
}

/**
 * проверяем, что функция mb_ucfirst не объявлена
 * и включено расширение mbstring (Multibyte String Functions)
 */
if (!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {

    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding = 'UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }

}



function get_UTF8_text($text) {
    $search  = array ('/"/');
    $replace = array ('');
    return preg_replace($search, $replace, html_entity_decode(htmlspecialchars_decode($text), ENT_NOQUOTES, 'UTF-8'));
}


function pluralForm($n, $form1, $form2, $form5) {
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $form5;
    if ($n1 > 1 && $n1 < 5) return $form2;
    if ($n1 == 1) return $form1;
    return $form5;
}



function str_replace_once($search, $replace, $text)
{
    $pos = strpos($text, $search);
    return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
}




function fixed_lgd($string, $origChars, $preStr = '...') {
    // Функция отрезает строку по количеству символов
    //$stroka = htmlspecialchars_decode(nl2br($string));
    $stroka = htmlspecialchars_decode($string);


    //$stroka = iconv('UTF-8','CP1251//IGNORE',$stroka ); //Меняем кодировку на windows-1251
    //$stroka = mb_substr($stroka ,0,$origChars); //Обрезаем строку
    //$stroka = iconv('CP1251','UTF-8',$stroka ); //Возвращаем кодировку в utf-8



    if ($origChars >= mb_strlen($string)) {
        return $stroka;
    } else {
        $text = '';
        $i = 0;
        $count = mb_strlen($stroka);
        for ($i = 0; $i <= $origChars; $i++) {
            $text .= $stroka[$i];
        }

        //$text = iconv('UTF-8','CP1251//IGNORE',$text ); //Меняем кодировку на windows-1251
        $text = iconv('UTF-8', 'UTF-8', $text); //Возвращаем кодировку в utf-8

        return $text . '...';
    }
}

function russain_date($date) {
    # Переменная с датой из базы
    # Перевод даты из базы  в формат времени Unix 
    # получается примерно такое 1307719080
    $time = strtotime($date);

    # Создаем ассоциативный массив где каждому числу месяца присваем название месяца
    $month_name = array(1 => 'января', 2 => 'февраля', 3 => 'марта',
        4 => 'апреля', 5 => 'мая', 6 => 'июня',
        7 => 'июля', 8 => 'августа', 9 => 'сентября',
        10 => 'октября', 11 => 'ноября', 12 => 'декабря'
    );

    #Получаем название месяца, здесь используется наш созданный массив
    $month = $month_name[date('n', $time)];

    $day = date('j', $time); # С помощью функции date() получаем число дня
    $year = date('Y', $time); # Получаем год

    $date = "$day $month $year";  # Собираем пазл из переменных

    return $date; #Выводим преобразованную дату на экран
}


function russain_date_kavichki($date) {
    # Переменная с датой из базы
    # Перевод даты из базы  в формат времени Unix 
    # получается примерно такое 1307719080
    $time = strtotime($date);

    # Создаем ассоциативный массив где каждому числу месяца присваем название месяца
    $month_name = array(1 => 'Января', 2 => 'Февраля', 3 => 'Марта',
        4 => 'Апреля', 5 => 'Мая', 6 => 'Июня',
        7 => 'Июля', 8 => 'Августа', 9 => 'Сентября',
        10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
    );

    #Получаем название месяца, здесь используется наш созданный массив
    $month = $month_name[date('n', $time)];

    $day = date('j', $time); # С помощью функции date() получаем число дня
    $year = date('Y', $time); # Получаем год

    $date = '«'.$day.'»'.' '.$month.' '.$year;  # Собираем пазл из переменных

    return $date; #Выводим преобразованную дату на экран
}


function russain_date_no_year($date) {
    # Переменная с датой из базы
    # Перевод даты из базы  в формат времени Unix 
    # получается примерно такое 1307719080
    $time = strtotime($date);

    # Создаем ассоциативный массив где каждому числу месяца присваем название месяца
    $month_name = array(1 => 'января', 2 => 'февраля', 3 => 'марта',
        4 => 'апреля', 5 => 'мая', 6 => 'июня',
        7 => 'июля', 8 => 'августа', 9 => 'сентября',
        10 => 'октября', 11 => 'ноября', 12 => 'декабря'
    );

    #Получаем название месяца, здесь используется наш созданный массив
    $month = $month_name[date('n', $time)];

    $day = date('j', $time); # С помощью функции date() получаем число дня
    $year = date('Y', $time); # Получаем год

    $date = "$day $month";  # Собираем пазл из переменных

    return $date; #Выводим преобразованную дату на экран
}

$dalee_block_id = 0;

function add_view_text_full($text, $count_sumbol, $dalee_chars, $dalee_open_text, $dalee_close_text, $dalee_link_classes) {
    global $dalee_block_id;
    $resul_text = '';

    $dalee_block_id++;
    $dalee_block_name_id1 = 'hidden_div' . $dalee_block_id;
    $dalee_block_id++;
    $dalee_block_name_id2 = 'hidden_div' . $dalee_block_id;

    if ($count_sumbol >= mb_strlen(htmlspecialchars_decode($text))) {
        $resul_text .= htmlspecialchars_decode($text);
    } else {
        $resul_text .= '<div id="' . $dalee_block_name_id1 . '" style="display: none;">' . htmlspecialchars_decode($text) . ''
                . '<a class="' . $dalee_link_classes . '" style="margin-left: 5px;" href="javascript:change_visibility (&#39;' . $dalee_block_name_id1 . '&#39;, &#39;' . $dalee_block_name_id2 . '&#39;)">' . $dalee_close_text . '</a>'
                . '</div>';


        $resul_text .= '<div id="' . $dalee_block_name_id2 . '">' . fixed_lgd(htmlspecialchars_decode($text), $count_sumbol, $dalee_chars) . ''
                . '<a class="' . $dalee_link_classes . '"  style="margin-left: 10px;" href="javascript:change_visibility (&#39;' . $dalee_block_name_id2 . '&#39;, &#39;' . $dalee_block_name_id1 . '&#39;)">' . $dalee_open_text . '</a>'
                . '</div>';
    }
    return $resul_text;
}

function add_view_text_full_no_hide($text, $count_sumbol, $dalee_chars, $dalee_open_text, $dalee_link_classes) {
    global $dalee_block_id;
    $resul_text = '';

    $dalee_block_id++;
    $dalee_block_name_id1 = 'hidden_div' . $dalee_block_id;
    $dalee_block_id++;
    $dalee_block_name_id2 = 'hidden_div' . $dalee_block_id;

    if ($count_sumbol >= mb_strlen(htmlspecialchars_decode($text))) {
        $resul_text .= htmlspecialchars_decode($text);
    } else {
        $resul_text .= '<div id="' . $dalee_block_name_id1 . '"  class="h_d_f" style="display: none;">' . htmlspecialchars_decode($text) . ''
                . '</div>';


        $resul_text .= '<div id="' . $dalee_block_name_id2 . '" class="h_d_f">' . fixed_lgd(htmlspecialchars_decode($text), $count_sumbol, $dalee_chars) . ' &nbsp;'
                . '<a class="' . $dalee_link_classes . '"  href="javascript:change_visibility (&#39;' . $dalee_block_name_id2 . '&#39;, &#39;' . $dalee_block_name_id1 . '&#39;)">' . $dalee_open_text . '</a>'
                . '</div>';
    }
    return $resul_text;
}

/*

  function add_view_text_full($text, $count_sumbol, $dalee_chars, $dalee_open_text, $dalee_close_text, $dalee_link_classes) {
  global $dalee_block_id;
  $resul_text = '';

  $dalee_block_id++;
  $dalee_block_name_id1 = 'hidden_div'.$dalee_block_id;
  $dalee_block_id++;
  $dalee_block_name_id2 = 'hidden_div'.$dalee_block_id;

  if ($count_sumbol>=mb_strlen(htmlspecialchars_decode($text))) {
  $resul_text .=	htmlspecialchars_decode($text);
  } else {
  $resul_text .= '<div id="'.$dalee_block_name_id1.'" style="display: none;">'.htmlspecialchars_decode($text).''
  .'<a class="'.$dalee_link_classes.'" style="margin-left: 5px;" href="javascript:change_visibility (\''.$dalee_block_name_id1.'\', \''.$dalee_block_name_id2.'\')">'.$dalee_close_text.'</a>'
  .'</div>';


  $resul_text .= '<div id="'.$dalee_block_name_id2.'">'.fixed_lgd(htmlspecialchars_decode($text), $count_sumbol, $dalee_chars).''
  .'<a class="'.$dalee_link_classes.'"  style="margin-left: 10px;" href="javascript:change_visibility (\''.$dalee_block_name_id2.'\', \''.$dalee_block_name_id1.'\')">'.$dalee_open_text.'</a>'
  .'</div>';
  }



  return $resul_text;
  }

 */

//	
//	function get_pages_links($sql_query, $limit_elements_of_page, $link_of_page, $current_number_page, $additional_params) {
//		// Функция создает строку с постраничной навигацией. Например: Страница 1 2 3 4
//		
//		$count_get_content = mysql_query($sql_query);
//		$kolvo = mysql_num_rows($count_get_content);
//		
//		// Если количество равно 0 или его нет, то нужно что-бы с базы всё-таки что-то считалось, поэтому выводим начальный элемент = 0
//		if ($kolvo==0 || $kolvo=='' || isset($kolvo)==false) {
//			$array['result']['limit_start'] = 0;
//			return $array;
//		}
//		
//		// Полученное количество делим на доступный лимит и округляем в большую сторону
//		$kolvo_stranic = ceil($kolvo/$limit_elements_of_page);
//		$kolvo_stranic_html = '';
//		$i = 1;
//		while ($i <= $kolvo_stranic) {
//			// Выделяем текущую ссылку
//			if ($i == $current_number_page) {
//				$kolvo_stranic_html .= '&nbsp;&nbsp;&nbsp;<a href="#" class="active_page_link">'.$i.'</a>';
//			} else {
//				$kolvo_stranic_html .= '&nbsp;&nbsp;&nbsp;<a href="../?link='.$link_of_page.'&page='.$i.'&'.$additional_params.'" class="page_link">'.$i.'</a>';
//			}
//			$i++;
//		}
//		
//		// Задаем начальный елемент для базы
//		if ($current_number_page==1) {
//			$limit_start = 0;
//		} else {
//			$limit_start = $limit_elements_of_page*($current_number_page-1);
//		}
//	
//	$array['result']['limit_start']= $limit_start;
//	$array['result']['kolvo_stranic_html']= '<center><div class="clear"></div><p class="page_navigation">Страница&nbsp;&nbsp;'.$kolvo_stranic_html.'</p></center>';
//	
//	
//	return $array;
//	}
//	
//        



function add_pagination($sql_query, $limit, $url_path, $page, $additional_params) {
// Функция создает строку с постраничной навигацией. Например: Страница 1 2 3 4
    $html = '';

    if ($page == '') {
        $page = 1;
    }

    $array = array();
    $query = Database::query($sql_query, 'asResult');
    $count = $query->fetchColumn();
//    echo $count;
// Если количество равно 0 или его нет, то нужно что-бы с базы всё-таки что-то считалось, поэтому выводим начальный элемент = 0
    if ($count <= 0) {
        $array['start'] = 0;
        return $array;
    }


//    echo $count;
//    $count = 40;

// Полученное количество делим на доступный лимит и округляем в большую сторону
    $page_count = ceil($count / $limit);
    $i = 1;

//    echo $page_count;

    $html .= '<div id="pagination"> <span>Страница </span><ul class="pagination">';
    if ($page == 1) { // Если это 1 страница
        $class_left = ' class="disabled" ';
        $href_left = '';
    }
//    if ($page > 1) {
//        $additional_params != '' ? $ap = $additional_params : $ap = '';
//        $href_left = ' href="' . $url_path . '?page=' . ($page - 1) . $ap . '" ';
//    }
//    $html .= '<li ' . $class_left . '><a ' . $href_left . ' >«</a></li>'; // Кнопка «

    $i = 1;
    while ($i <= $page_count) {
        // Выделяем текущую ссылку
        if ($i == $page) {
            $html .= '<li class="active"><a href="#">' . $i . '</a></li>';
        } else {
            $additional_params != '' ? $ap = $additional_params : $ap = '';
            $html .= '<li><a href="' . $url_path . '?page=' . $i . $ap . '">' . $i . '</a></li>';
        }
        $i++;
    }

//    if ($page == $page_count) { // Если это последняя страница
//        $class_right = ' class="disabled" ';
//        $href_right = '';
//    }
//    if ($page < $page_count) {
//        $additional_params != '' ? $ap = $additional_params : $ap = '';
//        $href_right = ' href="' . $url_path . '?page=' . ($page + 1) . $ap . '" ';
//    }
//    $html .= '<li ' . $class_right . '><a ' . $href_right . ' >»</a></li>'; // Кнопка «
    $html .= '</ul></div>';

// Задаем начальный елемент для базы
    if ($page == 1) {
        $start = 0;
    } else {
        $start = $limit * ($page - 1);
    }

//    echo $page;

    $array['start'] = $start;
    $array['html'] = $html;
    $array['count'] = $count;
    return $array;
};



function add_pagination_in_ajax_table($count, $limit, $link, $page, $additional_params) {
// Функция создает строку с постраничной навигацией. Например: Страница 1 2 3 4

//    global $db;

    if ($page == '') {
        $page = 1;
    }

//    $query = $db->query($sql_query);
//    $count = $query->rowCount();
// Если количество равно 0 или его нет, то нужно что-бы с базы всё-таки что-то считалось, поэтому выводим начальный элемент = 0
    if ($count <= 0) {
        $array['start'] = 0;
        return $array;
    }

// Полученное количество делим на доступный лимит и округляем в большую сторону
    $page_count = ceil($count / $limit);
    $i = 1;

    $html .= '<ul class="pagination"><li class="label">Страницы</li>';
    if ($page == 1) { // Если это 1 страница
        $class_left = ' class="disabled" ';
        $href_left = '';
    }
    if ($page > 1) {
        $additional_params != '' ? $ap = $additional_params : $ap = '';
        $href_left = ' data-page="' . ($page - 1) . $ap . '" ';
    }
    $html .= '<li ' . $class_left . '><span ' . $href_left . ' >«</span></li>'; // Кнопка «


    while ($i <= $page_count) {
        // Выделяем текущую ссылку
        if ($i == $page) {
            $html .= '<li class="active"><span data-page="'.$i.'">' . $i . '</span></li>';
        } else {
            $additional_params != '' ? $ap = $additional_params : $ap = '';
            $html .= '<li><span data-page="' . $i . $ap . '">' . $i . '</span></li>';
        }
        $i++;
    }

    if ($page == $page_count) { // Если это последняя страница
        $class_right = ' class="disabled" ';
        $href_right = '';
    }
    if ($page < $page_count) {
        $additional_params != '' ? $ap = $additional_params : $ap = '';
        $href_right = ' data-page="' . ($page + 1) . $ap . '" ';
    }
    $html .= '<li ' . $class_right . '><span ' . $href_right . ' >»</span></li>'; // Кнопка «
    $html .= '</ul>';

// Задаем начальный елемент для базы
    if ($page == 1) {
        $start = 0;
    } else {
        $start = $limit * ($page - 1);
    }

    $array['start'] = $start;
    $array['html'] = $html;
    $array['count'] = $count;
    return $array;
};


function eng_name($name) {
    $name_atrib = preg_replace('/\(\((.*)\)\)/', '', $name);
    $t = preg_replace('/\-\-\-/', '-', str2url($name_atrib));
    $t = preg_replace('/\\-\-/', '-', str2url($t)); //;
    return $t;
};


function get_in_translate_to_en($string, $gost=false)
{
    if($gost)
    {
        $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i", "ий"=>"iy",
                "Й"=>"I","й"=>"y", "ий"=>"iy", "ый"=>"yy", "К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
                "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
                "Х"=>"H","х"=>"h","Ц"=>"C","ц"=>"c","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
                "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"");
    }
    else
    {
//        $arStrES = array("ае","уе","ое","ие","эе","яе","юе","ёе","ее","ье","ъе");
//        $arStrOS = array("аё","уё","оё","иё","эё","яё","юё","ёё","её","ьё","ъё");
        $arStrRS = array("а$","у$","о$","и$","э$","я$","ю$","ё$","е$","ь$","ъ$");
                    
        $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                "Е"=>"Ye","е"=>"e","Ё"=>"Yo","ё"=>"yo","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                "Й"=>"Y","й"=>"y","ий"=>"iy", "ый"=>"yy", "ые"=>"ye", "К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n",
                "О"=>"O","о"=>"o","П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t",
                "У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f","Х"=>"H","х"=>"h","Ц"=>"C","ц"=>"c","Ч"=>"Ch","ч"=>"ch",
                "Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch","Ъ"=>"","ъ"=>"","Ы"=>"Y","ы"=>"y","Ь"=>"","ь"=>"",
                "Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","@"=>"y","$"=>"ye", " "=>"-", "."=>"", ","=>"", "-"=>"-");
                
//        $string = str_replace($arStrES, $arStrRS, $string);
//        $string = str_replace($arStrOS, $arStrRS, $string);
    }
        
    return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}




function str2url($str) {
    // переводим в транслит
    $str = get_in_translate_to_en($str);
//    echo $str.'<br>';
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}


function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}






function get_time($text) {
        $no_text_html = 'x';
        if ($text == '') { return $no_text_html;} else {return $text;};
    }
    
    
    function getDayRus(){
        // массив с названиями дней недели
         $days = array(
         'Вс' , 'Пн' ,
        'Вт' , 'Ср' ,
         'Чт' , 'Пт' , 'Сб'
         );
        // номер дня недели
        // с 0 до 6, 0 - воскресенье, 6 - суббота
        $num_day = (date('w'));
        // получаем название дня из массива
        $name_day = $days[$num_day];
        // вернем название дня
         return $name_day;
    }
    
    
    
function addFilterCondition($where, $add, $and = true) {
    if ($where) {
            if ($and) $where .= " AND $add";
            else $where .= " OR $add";
    }
    else $where = $add;
    return $where;
}

//if (!empty($_POST["filter"])) {
//    if ($_POST["vendors"]) {
//            $ids=$_POST["vendors"];
//            $inQuery = implode(',', array_fill(0, count($ids), '?'));
//            $where = addFilterCondition($where, 'vendors.attribute_id IN ('. $inQuery .')');
//    }

?>