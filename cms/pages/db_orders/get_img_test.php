<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
$small_img_width = 230;
$big_img_width = 1000;
$out_folder = $root . '/sync/';

$filename = $_FILES['filename']['name'];
//$filepath = preg_split('#([\n\r]+)#Usi',$filepath);
$filename = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $filename);

$temp_file_name = $_FILES['filename']['tmp_name'];
//$original_file_name = $_FILES['filename']['name'];
        
$extension = strtolower(substr(strrchr($filename, '.'), 1));
$uploadedFile = $out_folder . $filename; // 


if ($extension != '') {
    $size = getimagesize($temp_file_name); // если это изображение и у него определён размер, то продолжаем
    if ($size){
            
            //copy($temp_file_name,$uploadedFile);
            //copy($temp_file_name,$out_folder.'small_'.$filename);

        
       $image = new Imagick($temp_file_name);
       $image->thumbnailImage($big_img_width, 0);
       $image->setImageCompressionQuality(70); 
       $image->stripimage();
       $image->writeImages($uploadedFile, true);
       $image->destroy();
       set_thumbal_img($temp_file_name, $filename, $out_folder, $small_img_width, 90);
        
        print $uploadedFile;
        //print $send_filename;
    }
}


function set_thumbal_img($temp_file_name, $src, $dest_folder, $small_img_width,  $quality) {
   // $filename = substr($src, 0, strrchr($filename, '.'));
    
    $extension = strtolower(substr(strrchr($src, '.'), 1));
    $uploadedFile = $dest_folder . 'small_'.$src;

    if ($extension != '') {
        $size = getimagesize($temp_file_name); // если это изображение и у него определён размер, то продолжаем
        if ($size){
            $image = new Imagick($temp_file_name);
            $image->thumbnailImage($small_img_width, 0);
            $image->setImageCompressionQuality($quality); 
            $image->stripimage();
            $image->writeImages($uploadedFile, true);
            $image->destroy();
        }
    }
 }


exit;


$filename1 = $out_folder.$_FILES['filename']['name'];
if (move_uploaded_file($_FILES['filename']['tmp_name'], $filename1)) {
    print "Ok load";

    //
    
   // print "Ok crop and save";
    //
//    @unlink($filename1);


} else {
print "Error!";
} 









?>
