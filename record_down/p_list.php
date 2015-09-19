<?php
require("../inc/pub_func.php");
$record_path=trim($_REQUEST["record_path"]);
 
switch($action){
	 
 	case "record_copy_zip":
		
		$do_campaign_id=trim($_REQUEST["do_campaign_id"]);
		$do_status=trim($_REQUEST["do_status"]);
 		$record_type=trim($_REQUEST["record_type"]);
		$job_name=trim($_REQUEST["job_name"]);
 		 
  			$job_name="数据清洗-".date("YmdHis");
 		
 
			$sql1=" a.call_date between '".$start_date."' and '".$end_date."' ";
			
 			$sql4=" and a.campaign_id ='".$do_campaign_id."' ";
  			
 			$sql6=" and a.quality_status ='".$quality_status."' ";
 			 
			$sql7=" and a.status ='".$do_status."' ";
 		 
			$sql8=" and a.list_id in(".$phone_lists.") ";
 			
			$wheres=$sql1.$sql2.$sql3.$sql4.$sql5.$sql6.$sql7.$sql8.$sql9;
  	  		 
			$copy_sql="select a.campaign_id,dd.telno as phone_number,dd.s1,a.call_date,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,c.campaign_cid from vicidial_log a  left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log d on a.uniqueid=d.vicidial_id and a.lead_id=d.lead_id left join  tmp_13101 dd on a.phone_number=dd.telno where ".$wheres." ";
			
			$job_dir=create_record_dir($job_id,$job_name);
			echo $sql."<br/>";
			 
			$rows=mysqli_query($db_conn,$copy_sql);
			$row_counts_list=mysqli_num_rows($rows);			
			
			$sum_count=$row_counts_list;
			$true_count=0;
			$sb_count=0;
			$bcz_count=0;
			$wly_count=0;
			
			$fp = fopen($job_dir."/".utf82gb("说明").".txt","w"); 
			$wav_file_list="";
			if ($row_counts_list!=0) {
				
				set_time_limit(0); 
				ini_set('memory_limit','600M');
				
				while($rs= mysqli_fetch_array($rows)){ 
				
					$result="";
					$call_date=$rs["call_date"];
					$user=$rs["user"];
					$campaign_name=utf82gb($rs["campaign_name"]);
					$location=$rs["location"];
					$phone_number=$rs["phone_number"];
					$campaign_cid=$rs["campaign_cid"];
					
					if($call_date==""){$call_date=date("Y-m-d H:i:s");$user="1001";}
					 
					if($record_path=="path_cam"){
						$cam_dir=$job_dir."/".$campaign_name;
						$cam_dir2=$campaign_name;
						
					}elseif($record_path=="path_cam_date"){
						if(!is_dir($job_dir."/".$campaign_name)){
							mkdir($job_dir."/".$campaign_name,0777);	
						}
						$cam_dir=$job_dir."/".$campaign_name."/".substr($call_date,0,10);
						$cam_dir2=$campaign_name."/".substr($call_date,0,10);
					}elseif($record_path=="path_date"){
						
						$cam_dir=$job_dir."/".substr($call_date,0,10);
						$cam_dir2=substr($call_date,0,10);
					}else{
						$cam_dir=$job_dir;
						$cam_dir2=".";
					}
					
					if(!is_dir($cam_dir)){
						mkdir($cam_dir,0777);	
					}
					
					$wav_name=record_type($phone_number,$user,$call_date,$campaign_cid,$record_type);
					
					if($location<>""){
						
						$wav_extens = explode("-all.",$location);
						$wav_exten=$wav_extens[1];
						unset($wav_extens);
						
						if($sys_os=="centos"){
							$location_first=str_replace($record_ip,$record_dir_first,$location);
							if($record_dir_second!=""){
								$location_second=str_replace($record_ip,$record_dir_second,$location);
							}
						}else{
							$location_first=str_replace('/','\\',str_replace($record_ip,$record_dir_first,$location));
							
							if($record_dir_second!=""){
								$location_second=str_replace('/','\\',str_replace($record_ip,$record_dir_second,$location));
							}
						}
						
						if(is_file($location_first)){
							
							$wav_file_list.="$phone_number,";
							$wav_exist_count=substr_count($wav_file_list,$phone_number);
							if($wav_exist_count>1){
								$wav_name.="($wav_exist_count).$wav_exten";
							}else{
								$wav_name.=".$wav_exten";	
							}
							
							if(copy($location_first,$cam_dir."/".$wav_name)){
								$result="处理成功";
								$true_count+=1;
							}else{
								$result="处理失败";
								$sb_count+=1;
							}
							
						}elseif($record_dir_second!=""){
							
							if(is_file($location_second)){
							 
								$wav_file_list.="$phone_number,";
								$wav_exist_count=substr_count($wav_file_list,$phone_number);
								if($wav_exist_count>1){
									$wav_name.="($wav_exist_count).$wav_exten";
								}else{
									$wav_name.=".$wav_exten";	
								}
								
								if(copy($location_second,$cam_dir."/".$wav_name)){
									$result="处理成功";
									$true_count+=1;
								}else{
									$result="处理失败";
									$sb_count+=1;
								}
							
							}else{
								$wav_name.=".$wav_exten";
								$result="不存在";
								$bcz_count+=1;	
							}
							 
						}else{
							$wav_name.=".$wav_exten";
							$result="不存在";
							$bcz_count+=1;	
						}
						
					}else{
						$wav_name.=".wav";
						$result="无录音";
						$wly_count+=1;
					}					
					//$result_sql.="('".$wav_name."','".$result."','','".$job_id."'),";
					
					$copy_log=$phone_number."\t".$cam_dir2."/".$wav_name."\t".utf82gb($result)."\r\n";
					fwrite($fp,$copy_log);
				}
 								
				$false_count=$sb_count+$bcz_count+$wly_count;
				//echo $up_job_sql;
				
				$copy_logs="\r\n\r\n共:".$sum_count."个，成功:".$true_count."个，失败:".$false_count."个(处理失败:".$sb_count.",文件不存在:".$bcz_count.",无录音:".$wly_count.")";
				
				fwrite($fp,utf82gb($copy_logs)); 
				//fclose($fp);
			 
 				
				$wav_file_list="";
				$counts="1";
				$des="拷贝完成，即将开始压缩处理，请稍后...";
				
				$result="共:<span class=\"red\">".$sum_count."</span>个,成功:<span class=\"red\">".$true_count."</span>个,失败:<span class=\"red\">".$false_count."</span> 个(处理失败:<span class=\"red\">".$sb_count."</span>,文件不存在:<span class=\"red\">".$bcz_count."</span>,无录音:<span class=\"red\">".$wly_count."</span>)";
				
			}else {
				$counts="0";
				$des="未找到符合条件的数据!";
 				
				fwrite($fp,$des); 
			}
			 
			fclose($fp);
 			mysqli_free_result($rows);
		
 		
		$json_data="{";
		$json_data.="\"counts\":".json_encode($counts).",";
		$json_data.="\"des\":".json_encode($des).",";
		$json_data.="\"copy_result\":".json_encode($result).",";
		$json_data.="\"job_id\":".json_encode($job_id).",";
		$json_data.="\"job_dir\":".json_encode(gb2utf8($job_dir)).",";
		$json_data.="\"zip_name\":".json_encode($job_name)."";
		 
		$json_data.="}";
		
		echo $json_data;
	
 	
	break;
	 	
	default :
 
}

unset($list_arr);
unset($lists_arr); 
unset($json_data);
unset($sql); 
mysqli_close($db_conn);
 
?>