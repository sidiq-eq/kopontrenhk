<?php
//date_default_timezone_set("Asia/Bangkok");
 $tgl = date('dmy-Hsi');
 $extension = 'jpg';
 $filename = $tgl.'.'.$extension;
//$filename =  time() . '.jpg';
echo json_encode($filename);

$filepath = 'images/';
if(!is_dir($filepath))
	mkdir($filepath);
if(isset($_FILES['webcam'])){	
	move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);
	echo $filepath.$filename;
    echo json_encode($filename);
}
//echo json_encode($filename);
?>
