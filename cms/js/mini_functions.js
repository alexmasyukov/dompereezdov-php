function change_visibility (block_close, block_open) {
	//Функция показа/скрыания блоков Читать далее (обычно на Отзывах клиентов)
	$(document).ready(function() {
    	$('#'+block_close).fadeOut(0);
    	$('#'+block_open).fadeIn(400);
    	//document.getElementById(block_close).style.display='none';
    	//document.getElementById(block_open).style.display='';
    });
}


