 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Utility_func {
	 
	 function getClientBatchNumber(){
	 	return date("YmdHis");
	 }
	 
	 function creatHourMinOptions(){
		  for($i=0; $i<24; $i++){
			$value=$i;
			if($i<10)
				$value='0'.$i;
			$hourOptions[$value]=$value;
		  }
		  $minOptions= array();
		  for($i=0; $i<60; $i++){
			$value=$i;
			if($i<10)
				$value='0'.$i;
			$minOptions[$value]=$value;	
		  }
		 $options['hourOptions']=$hourOptions;
		 $options['minOptions']=$minOptions;
		 return $options;
	 }
	 
	function array_to_csv(&$array, $download = "") {
        if ($download != "")
        {    
           // header('Content-Type: application/csv');
            //header('Content-Disposition: attachement; filename="' . $download . '"');
        }        
	
        ob_start();
        $f = fopen($download, 'wb') or show_error("Can't open php://output");
        $n = 0;        
        foreach ($array as $line)
        {
            $n++;
            if ( ! fputcsv($f, $line))
            {
                show_error("Can't write line $n: $line");
            }
        }
        fclose($f) or show_error("Can't close php://output");
        $str = ob_get_contents();
        ob_end_clean();

        if ($download == "")
        {
            return $str;    
        }
        else
        {    
            echo $str;
        }  
		     
    }
 }