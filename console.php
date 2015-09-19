<!--<?php
	//注册一个shutdown函数，如果不这么做的话记得在程序最后echo Console_log::fetch_output();
	register_shutdown_function('my_shutdown');
	function my_shutdown(){	
		echo Console_log::fetch_output();
	}
	class Console_log {
		private static $output = '';
		static function log($data){ 
			if (is_array($data) || is_object($data)){
				$data = json_encode($data);
			}
			ob_start(); 
?>
<?php	if (self::$output === ''):?>
				<script>
<?php	endif;?>
			console.log('<?=$data;?>');
<?php
			self::$output .= ob_get_contents();
			ob_end_clean();    
		}    
  	static function fetch_output(){
			if (self::$output !== ''){
				self::$output .= '</script>';    	
			}
			return self::$output;
		}
	}
?>
-->

<?php
function console_log($file, $line, $data){
	if (is_array($data) || is_object($data)){		
		echo("<script>console.log('".$file.":".$line.": ".json_encode($data)."');</script>");	
	}	else	{
		echo("<script>console.log('".$file.":".$line.": ".$data."');</script>");	
		}
	}