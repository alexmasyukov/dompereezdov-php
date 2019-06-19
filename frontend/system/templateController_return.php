<?
/*
  Модуль управления шаблонами
  Автор: Немиро Алексей
  04 марта 2007 года
  mailto:admin@kbyte.ru
  Copyright (c) Nemiro AS, 2007
*/
 
class templateController_return {
 
  public $content;       // для хранения контента
  public $templateName;  // имя файла шаблона
  public $errorMessage;  // сообщение об ошибке
  public $title;         // заголовок <title></tile>
      
  // инициализация
  function templateController_return() {
    $content = array();
    $templateName = "";
    $errorMessage = "";
    $title = "";
  }
 
  // вывод данных
  function Fill() {
    // загрузка шаблона
    $result = file_get_contents($this->templateName);
    if (!$result) {
      $errorMessage = "<span style=\"color: Red\">
      Ошибка: Файл шаблона
      <strong>".$this->templateName."</strong>
      не найден.</span><br />";
      return $errorMessage;
    } else {
      // ищем <title></title>
      $titleTemplate = '';
      if (preg_match("(\<\title\>(.*)\</title\>)", $result, $ss)) {
        if ($this->title != NULL) {
          $newTitle = $this->title;
          $result = ereg_replace($titleTemplate, "<title>$newTitle</title>", $result);
        }
      }
 
      // поиск и замена блоков контента самим контентом
      while ($s = current($this->content)) {
        $result = str_replace("<php:".key($this->content).">", $s, $result);
        next($this->content);
      }
                   
      return $result;
    }       
  }   
}
 
?>