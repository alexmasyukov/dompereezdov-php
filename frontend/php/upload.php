<?php 
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$server =  $_SERVER['HTTP_HOST'];

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip', 'rar', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'gif', 'jpeg', );

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

        $new_file_name = date('Y_m_d_H_i_s').rand(1, 50000);
        
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], $root.'/uploads/'.$new_file_name.'.'.$extension)){
            $fn = $new_file_name.'.'.$extension.'';
		echo $fn;
		exit;
	}
}



echo '{"status":"error"}';
exit;
?>