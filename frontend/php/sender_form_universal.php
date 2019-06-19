<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server = $_SERVER['HTTP_HOST'];
//Конфигурация
include_once($root . '/configuration.php');
$code = $_POST['code'];
$form_type = $_POST['form_type'];
$site = $_POST['site'];

//

if (isset($_POST['code'])) {

    // Получаем дату и время:
    $msg_order_date = date("d.m.y"); // присвоено 03.12.01
    $msg_order_time = (date("H")) . ':' . date("i"); //($hours_difference_with_Moscow-1)

    // todo: fix it Ошибка: parsererror, SyntaxError: Unexpected token < in JSON at position 0 Данные:
    // todo Notice: Undefined offset: 1 in /Users/alekseymasukov/projects/dom_pereezdov/frontend/php/sender_form_universal.php on line 33
    // todo это из любых форм заявок


    $List_values = '';
    $files_links_html = '';
    $trs = explode(";;", $code);
    for ($i = 0; $i <= count($trs) - 1; $i++) {
        $tds = explode("**", $trs[$i]);
        //    if ($i == count($trs)-2) {
        //        $files = explode("####", $tds[1]);
        //        for ($s=0; $s <= count($files)-1; $s++) {
        //            $files_links_html .= '<a href="'.'http://'.$server.'/uploads/'.trim($files[$s]).'">'.trim($files[$s]).'</a><br/>';
        //        }
        //        $List_values .= '<tr><td style="border: 1px dashed #ddd; padding:10px; font-weight: bold;">'.$tds[0].'</td><td style="border: 1px dashed #ddd; padding:10px;">'.$files_links_html.'</td></tr>';
        //        break;
        //    } else {
        //        $List_values .= '<tr><td style="border: 1px dashed #ddd; padding:10px; font-weight: bold;">'.$tds[0].'</td><td style="border: 1px dashed #ddd; padding:10px;">'.$tds[1].'</td></tr>';
        //    }
        $List_values .= '<tr><td style="border: 1px dashed #ddd; padding:10px; font-weight: bold;">' . $tds[0] . '</td><td style="border: 1px dashed #ddd; padding:10px;">' . $tds[1] . '</td></tr>';

    }

    $message_to_the_owner = "
    Заявка сформирована: <b>$msg_order_time</b> по Московскому времени, 
    <b>$msg_order_date</b>.<br/>
    <br/>
    <table>
            $List_values
    </table>
";

    // Дополнительные параметры:
    $mailheaders = "From: $form_type с $site <$mail_organization> \r\n";
    $mailheaders .= "Reply-To: $mail_organization \r\n";
    $mailheaders .= "X-Mailer: PHP/" . phpversion() . " \r\n";
    $mailheaders .= "Content-Type: text/html; charset=\"windows-1251\"";

    $subject_to_the_owner = iconv("utf-8", "windows-1251", $form_type);
    $message_to_the_owner = iconv("utf-8", "windows-1251", $message_to_the_owner);
    $mailheaders = iconv("utf-8", "windows-1251", $mailheaders);

    for ($i = 0; $i <= count($mail_array) - 1; $i++) {
        $result = mail($mail_array[$i], $subject_to_the_owner, $message_to_the_owner, $mailheaders);
    }
    //$result = $List_values;
    //json_encode(
    echo '{
    "result": ' . $result . ' 
}';
};


?>
