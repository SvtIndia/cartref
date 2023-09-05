<?php
	$file_url_TLD = "https://data.iana.org/TLD/tlds-alpha-by-domain.txt";
	$file_name_TLD = "TLD.txt";
    $file_contents_TLD = file_get_contents($file_url_TLD);
    $write_file_TLD = file_put_contents($file_name_TLD, $file_contents_TLD);
    date_default_timezone_set('Asia/Kolkata');
    $date_time = date('d-m-y h:i:s');
    $flie_log_TLD = fopen('./downloadTLDFileLog.txt', 'a');
    $string_log = "";
	if($write_file_TLD) {
        $string_log = $date_time . " Success : TLD File was downloaded.\n"; 
        echo $string_log;
        fwrite($flie_log_TLD, $string_log) ;  
	}
	else {
        unlink('TLD.txt'); 
        $string_log = $date_time . " Failure : TLD File downloading was failed. \n";
        echo $string_log;
        fwrite($flie_log_TLD, $string_log);
	}
    fclose($flie_log_TLD);  
?>

