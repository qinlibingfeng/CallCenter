<?php
require("./inc/pub_func.php");
$record_path=trim($_REQUEST["record_path"]);
$is_exit=0;
$call_date_type=trim($_REQUEST["call_date_type"]);
$comments_des=trim($_REQUEST["comments_des"]);


switch($action){
	 
    //录音详单查询
	case "get_record_list":
	
	
		$sql1=" and d.start_time between '".$start_date."' and '".$end_date."'";
  		
		if($agent_list<>""){ 
			if(strpos($agent_list,",")>-1){
 				$agent_list=str_replace(",","','",$agent_list);
				$agent_list="'".$agent_list."'";
				$sql2=" and d.user in(".$agent_list.")";
			}else{
				$sql2=" and d.user ='".$agent_list."'";
			}
			
		}else{
			
			if($_SESSION["allow_users"]=="none"){
				$sql2=" ";
				
			}elseif($_SESSION["allow_users"]=="self"){
				
				$sql2="  and d.user ='".$_SESSION["username"]."' ";
				
			}elseif($_SESSION["session_users_list"]!=""){
				
				if(strpos($_SESSION["session_users_list"],",")>-1){
					 
					$sql2=" and d.user in(".$_SESSION["session_users_list"].")";
				}else{
					$sql2=" and d.user =".$_SESSION["session_users_list"];
				}	
			}
				
		}
 		
		if($phone_number<>""){
   				
			if ($search_accuracy=="="){
				$exist_sql=" = '".$phone_number."'";
			}elseif($search_accuracy=="in"){
				$phone_number=str_replace(",","','",$phone_number);
				$exist_sql="in('".$phone_number."')";
			}elseif($search_accuracy=="not in"){
				$phone_number=str_replace(",","','",$phone_number);
				$exist_sql="not in('".$phone_number."')";
			}elseif($search_accuracy=="like_top"){
				$exist_sql="like '".$phone_number."%'";
			}elseif($search_accuracy=="like_end"){
				$exist_sql="like '%".$phone_number."'";
			}elseif($search_accuracy=="like"){
				$exist_sql="like '%".$phone_number."%'";
			}
 			$sql4=" and a.phone_number ".$exist_sql;
		}
  		
		if($comments<>""){
 			$sql5=" and a.comments='".$comments."'";
 		}
 		
		if($time_zone<>""&&$time_len<>""){
			$sql6=" and d.length_in_sec ".$time_zone.$time_len. "";
		}
		
		if($campaign_id<>""){
			if(strpos($campaign_id,",")>-1){
				$campaign_id=str_replace(",","','",$campaign_id);
				$campaign_id="'".$campaign_id."'";
				$sql7=" and a.campaign_id in(".$campaign_id.") ";
			}else{
				$sql7=" and a.campaign_id ='".$campaign_id."' ";
			}
		}else{
			
			if($_SESSION["allow_campaigns"]=="none"){
				$sql7=" ";
				
			}elseif($_SESSION["session_campaigns_list"]!=""){
				
				if(strpos($_SESSION["session_campaigns_list"],",")>-1){
					 
					$sql7=" and a.campaign_id in(".$_SESSION["session_campaigns_list"].")";
				}else{
					$sql7=" and a.campaign_id =".$_SESSION["session_campaigns_list"];
				}	
			}
				
		}
		
		if($is_exit==1){
			
			$json_data="{";
			$json_data.="\"counts\":".json_encode(0).",";
			$json_data.="\"des\":".json_encode($des).",";
 			$json_data.="\"datalist\":".json_encode($list_arr)."";
			$json_data.="}";
			
			echo $json_data;
			
			die();
				
		}
		
		$wheres=$sql1.$sql2.$sql3.$sql4.$sql5.$sql6.$sql7;

		

		;
		
		//获取记录集个数
		if($do_actions=="count"){
			
			$sql="select count(*) from recording_log".$archive." d left join vicidial_users b on d.user=b.user inner join vicidial_log".$archive." a on d.vicidial_id=a.uniqueid and d.lead_id=a.lead_id left join vicidial_list".$archive." c on d.lead_id=c.lead_id  left join data_sys_status e on c.status=e.status and e.status_type='call_status' where 1=1 ".$wheres." ";

			//echo $sql;
			//$sql="select count(*) from recording_log";

			$rows=mysqli_fetch_row(mysqli_query($db_conn,$sql));
			
			$counts=$rows[0];
			

			if(!$counts){$counts="0";} 

			$des="d";
			$list_arr=array('id'=>'none');
			
		}else if($do_actions=="list"){
		
			$offset=($pages-1)*$pagesize;
			
 			$sql="select d.start_time,IFNULL(d.length_in_sec,0) as length_in_sec,IFNULL(d.length_in_min,0) as length_in_min,".$record_location." as locations,d.user,b.full_name,b.phone_login,c.phone_number,case when a.comments='auto' then '自动' else '手动' end as comments,concat(c.province,'-',c.city) as citys,e.status_name from recording_log".$archive." d left join vicidial_users b on d.user=b.user inner join vicidial_log".$archive." a on d.vicidial_id=a.uniqueid and d.lead_id=a.lead_id left join vicidial_list".$archive." c on d.lead_id=c.lead_id left join data_sys_status e on c.status=e.status and e.status_type='call_status' where 1=1 ".$wheres." ".$sort_sql." limit ".$offset.",".$pagesize." ";
			
			//echo $sql;
			$rows=mysqli_query($db_conn,$sql);
			$row_counts_list=mysqli_num_rows($rows);
			
			$list_arr=array();
			$lists_arr=array();
			if ($row_counts_list!=0) {
				while($rs= mysqli_fetch_array($rows)){ 
				 
					$list=array("start_time"=>$rs['start_time'],"length_in_sec"=>$rs['length_in_sec'],"length_in_min"=>$rs['length_in_min'],"locations"=>$rs['locations'],"user"=>$rs['user'],"full_name"=>$rs['full_name'],"phone_login"=>$rs['phone_login'],"phone_number"=>$rs['phone_number'],"comments"=>$rs['comments'],"title"=>$rs['title'],"citys"=>$rs['citys'],"status_name"=>$rs['status_name']);
					 
					array_push($list_arr,$list);
				}
				$counts="1";
				$des="succ!";
			}else {
				$counts="0";
				$des="未找到符合条件的数据!";
				$list_arr=array('id'=>'none');
			}
			
 			
		}else if($do_actions=="excel"){
			
  			$sql="select a.phone_number as '被叫号码',concat(c.province,'-',c.city) as '省份城市',d.user as '工号',b.full_name as '工号姓名',b.phone_login as '分机号',d.start_time as '呼叫时间',IFNULL(d.length_in_sec,0) as '时长（秒）',IFNULL(d.length_in_min,0) as '时长（分）',case when a.comments='auto' then '自动' else '手动' end as '呼叫方式',e.status_name as '呼叫结果',".$record_location." as '录音地址' from recording_log".$archive." d left join vicidial_users b on d.user=b.user inner join vicidial_log".$archive." a on d.vicidial_id=a.uniqueid and d.lead_id=a.lead_id left join vicidial_list".$archive." c on d.lead_id=c.lead_id  left join data_sys_status e on c.status=e.status and e.status_type='call_status' where 1=1 ".$wheres." and d.vicidial_id is not null ".$sort_sql." ";
  			//echo $sql;
 			echo json_encode(save_detail_excel($sql,"通话录音详单",$file_type));
 		}
		
  		if($do_actions<>"excel"){
			mysqli_free_result($rows);
			
			$json_data="{";
			$json_data.="\"counts\":".json_encode($counts).",";
			$json_data.="\"des\":".json_encode($des).",";
 			$json_data.="\"datalist\":".json_encode($list_arr)."";
			$json_data.="}";
			
			echo $json_data;
		}
  		
	break;
	 
     
	//创建录音备份文件夹
	case "create_record_job":
  		
		if($job_name<>""){
			if($phones<>""){
				if($job_id==""){
					$sql="insert into data_record_job(job_name,userid) values('".$job_name."','".$_SESSION["username"]."')";
					mysqli_query($db_conn,$sql);
					
					$job_id=mysqli_insert_id($db_conn);
  					
				}else{
					
					$sql="update data_record_job set job_name='".$job_name."' where id='".$job_id."'";
					mysqli_query($db_conn,$sql);
 					
					$sql="delete from data_record_job_log where job_id='".$job_id."'";
					mysqli_query($db_conn,$sql);
 					 
 				}
				
				 
				if($job_id!=""){
					//$dir=create_record_dir($job_id,$job_name);
					
					//if($dir<>""){
						//$phones=ereg_replace("\n{1,}","\n",str_replace("\r","\n",$phones)); 
						//$phones=str_replace("\r","\n",$phones); 
						$phones=eregi_replace("[^0-9\n]","",$phones);
						$phones_ary = explode("\n",$phones); 
   						$pcount1=count($phones_ary);
 						
						$phones_ary2=array_unique($phones_ary);
						//$pcount2=count(array_flip($phones_ary));
						$pcount2=count($phones_ary2);
						
 						$phone_bad=0;
						if($pcount2>0){
							foreach($phones_ary2 as $phone){ 
								
								if($phone<>"" and preg_match("/^\d*$/",$phone)){
 									$phone=trim(eregi_replace("[^0-9]","",$phone));
  									$sql_phone.="('".$phone."','".$job_id."'),";
									
								}else{
									$phone_bad++;
								};
 								
							} 	
							$pcount2=$pcount2-$phone_bad;
							
							if($sql_phone!=""){
								$sql="insert into data_record_job_log(phone_number,job_id) values ".substr($sql_phone, 0, -1)."";
								if(!mysqli_query($db_conn,$sql)){
									$pcount2=0;
								}
							}
    							
							if($pcount2<1){
								$counts="0";
								$des="填写号码:".$pcount1." 个\n有效号码:0 个!\n\n请重新填写被叫号码!";
							}else{
								$counts="1";
								$des="创建录音备份任务完成!\n\n填写号码:".$pcount1."个\n清除重复、空格后，有效号码:".$pcount2."个";
							}
							
						}else{
							$counts="0";
							$des="创建录音备份任务出错!被叫号码不能为空!";
						}
					//}else{
						//$counts="-1";
						//$des="创建录音存放目录出错，请检查后重试或联系管理员!";
					//}
				}else{
					$counts="-1";
					$des="创建录音备份任务出错，请检查后重试或联系管理员!";
				}
   				
			}else{
				$counts="-1";
				$des="创建录音备份任务失败，被叫号码不能为空!";
			}
			
		}else{
			$counts="-1";
			$des="创建录音备份任务失败，请填写任务名称!";
		}
 	
		$json_data="{";
 		$json_data.="\"counts\":".json_encode($counts).",";
 		$json_data.="\"des\":".json_encode($des).",";
		$json_data.="\"job_id\":".json_encode($job_id).",";
	 	$json_data.="\"job_name\":".json_encode(gb2utf8($job_name)).",";
		//$json_data.="\"job_dir\":".json_encode(gb2utf8(str_replace("./data/","/data/",$dir))).",";
		$json_data.="\"pcount1\":".json_encode($pcount1).",";
	 	$json_data.="\"pcount2\":".json_encode($pcount2)."";
		
  		$json_data.="}";
		
		echo $json_data;
  	
  	break;
 
 	//执行录音文件拷贝
	case "do_record_job":
	
		//$phone_prefix=trim($_REQUEST["phone_prefix"]);
		$record_type=trim($_REQUEST["record_type"]);
		$job_dir=trim($_REQUEST["job_dir"]);
  		$job_name=trim($_REQUEST["job_name"]);
		
		$skip_day=(strtotime($s_date)-strtotime($e_date))/86400;
			
		if($skip_day>$skip_days||$skip_day<-$skip_days){
		 
			$field_name_list=array("查询时间跨度超过$skip_days天");
			$list_arr=array('id'=>'none');
			$des="本功能只可查询时间跨度为 ".$skip_days." 天内数据!";
 			$is_exit=1;
		}
		
		$sql1=" and a.call_date between '".$start_date."' and '".$end_date."'";
 		
		if($agent_list<>""){
			if(strpos($agent_list,",")>-1){
 				$agent_list=str_replace(",","','",$agent_list);
				$agent_list="'".$agent_list."'";
				$sql2=" and a.user in(".$agent_list.")";
			}else{
				$sql2=" and a.user ='".$agent_list."'";
			}
		}else{
			
			if($_SESSION["allow_users"]=="none"){
				$sql2=" ";
				
			}elseif($_SESSION["allow_users"]=="self"){
				
				$sql2="  and a.user ='".$_SESSION["username"]."' ";
				
			}elseif($_SESSION["session_users_list"]!=""){
				
				if(strpos($_SESSION["session_users_list"],",")>-1){
					 
					$sql2=" and a.user in(".$_SESSION["session_users_list"].")";
				}else{
					$sql2=" and a.user =".$_SESSION["session_users_list"];
				}	
			}
				
		}
  		
		if($campaign_id<>""){
			if(strpos($campaign_id,",")>-1){
 				$campaign_id=str_replace(",","','",$campaign_id);
				$campaign_id="'".$campaign_id."'";
				$sql3=" and a.campaign_id in(".$campaign_id.")";
			}else{
				$sql3=" and a.campaign_id ='".$campaign_id."'";
			}
		}else{
			
			if($_SESSION["allow_campaigns"]=="none"){
				$sql3=" ";
				
			}elseif($_SESSION["session_campaigns_list"]!=""){
				
				if(strpos($_SESSION["session_campaigns_list"],",")>-1){
					 
					$sql3=" and a.campaign_id in(".$_SESSION["session_campaigns_list"].")";
				}else{
					$sql3=" and a.campaign_id =".$_SESSION["session_campaigns_list"];
				}	
			}
				
		}
  		
		if($status<>""){
			if(strpos($status,",")>-1){
 				$status=str_replace(",","','",$status);
				$status="'".$status."'";
				$sql4=" and a.status in(".$status.")";
			}else{
				$sql4=" and a.status ='".$status."'";
			}
		}
 		
		//if($phone_prefix<>""){
 			//$field_phone_number=",right(datas.phone_number,length(datas.phone_number)-".$phone_prefix.") as 'phone_number'";
		//}else{
 			$field_phone_number=",datas.phone_number";
		//}
		
 		if($comments<>""){
 			$sql5=" and a.comments='".$comments."'";
 		}
		
		if($quality_status<>""){
			if(strpos($quality_status,",")>-1){
				$quality_status=str_replace(",","','",$quality_status);
				$quality_status="'".$quality_status."'";
				$sql6=" and a.quality_status in(".$quality_status.") ";
			}else{
				$sql6=" and a.quality_status ='".$quality_status."' ";
			}
		}
		
		if($is_exit==1){
			
			$json_data="{";
			$json_data.="\"counts\":".json_encode(0).",";
			$json_data.="\"des\":".json_encode($des).",";
 			$json_data.="\"datalist\":".json_encode($list_arr)."";
			$json_data.="}";
			
			echo $json_data;
			
			die();
				
		}
		
		$wheres=$sql1.$sql2.$sql3.$sql4.$sql5.$sql6;
		
		//获取记录集个数
		if($do_actions=="count"){
			
			$sql="select count(*) from data_record_job_log datas inner join vicidial_log".$archive." a on datas.phone_number=a.phone_number ".$wheres." left join vicidial_users b on a.user=b.user left join recording_log".$archive." c on a.uniqueid=c.vicidial_id and a.lead_id=c.lead_id left join vicidial_campaigns d on a.campaign_id=d.campaign_id left join data_sys_status e on a.status=e.status and e.status_type='call_status' left join data_record_job f on datas.job_id=f.id where datas.job_id='".$job_id."' ";
			//echo $sql;
			$rows=mysqli_fetch_row(mysqli_query($db_conn,$sql));
			$counts=$rows[0];
			if(!$counts){$counts="0";} 
			 
			$des="d";
			 
			
		}else if($do_actions=="list"){
		
			$offset=($pages-1)*$pagesize;
			
 			$sql="select datas.id".$field_phone_number.",a.call_date,a.user,b.full_name,IFNULL(c.length_in_sec,0) as length_in_sec,d.campaign_name,e.status_name,f.zip_path,datas.record_name,datas.result from data_record_job_log datas inner join vicidial_log".$archive." a on datas.phone_number=a.phone_number ".$wheres." left join vicidial_users b on a.user=b.user left join recording_log".$archive." c on a.uniqueid=c.vicidial_id and a.lead_id=c.lead_id left join vicidial_campaigns d on a.campaign_id=d.campaign_id left join data_sys_status e on a.status=e.status and e.status_type='call_status' left join data_record_job f on datas.job_id=f.id where datas.job_id='".$job_id."' ".$sort_sql."  limit ".$offset.",".$pagesize." ";
			
 			//echo $sql;
 			$rows=mysqli_query($db_conn,$sql);
			$row_counts_list=mysqli_num_rows($rows);			
			
			$list_arr=array();
			 
			if ($row_counts_list!=0) {
				while($rs= mysqli_fetch_array($rows)){ 
				 
					$list=array("id"=>$rs['id'],"phone_number"=>$rs['phone_number'],"call_date"=>$rs['call_date'],"user"=>$rs['user'],"full_name"=>$rs['full_name'],"length_in_sec"=>$rs['length_in_sec'],"campaign_name"=>$rs['campaign_name'],"status_name"=>$rs['status_name'],"zip_path"=>$rs['zip_path'],"record_name"=>$rs['record_name'],"result"=>$rs['result'],"locations"=>str_replace("./data/","/data/",$rs['zip_path'])."/".$rs['record_name']);
					 
					array_push($list_arr,$list);
				}
				$counts="1";
				$des="succ!";
			}else {
				$counts="0";
				$des="未找到符合条件的数据!";
				 
			}
  			
		}else if($do_actions=="copy"){
			
  			//$job_dir=create_record_dir($job_id,$job_name);
 			//$sql="select datas.id".$field_phone_number.",a.call_date,a.user,d.location from data_record_job_log datas left join vicidial_log a on datas.phone_number=a.phone_number ".$wheres." left join recording_log d on a.uniqueid=d.vicidial_id and a.lead_id=d.lead_id where 1=1 and datas.job_id='".$job_id."' ";
			
			$job_dir=create_record_dir($job_id,$job_name);
			
			if($record_type=="DDDuser-phone-yyyymmdd"){
			
				$sql="select datas.id".$field_phone_number.",a.call_date,e.user_id as user,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,c.campaign_cid from data_record_job_log datas left join vicidial_log".$archive." a on datas.phone_number=a.phone_number ".$wheres." left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log".$archive." d on a.uniqueid=d.vicidial_id and a.lead_id=d.lead_id left join data_user_list e on a.user=e.user where datas.job_id='".$job_id."' ";			
 			//echo $sql;
			}else{
				
				$sql="select datas.id".$field_phone_number.",a.call_date,a.user,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,c.campaign_cid,e.first_name from data_record_job_log datas left join vicidial_log".$archive." a on datas.phone_number=a.phone_number ".$wheres." left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log".$archive." d on a.uniqueid=d.vicidial_id and a.lead_id=d.lead_id left join vicidial_list".$archive." e on a.lead_id=e.lead_id where datas.job_id='".$job_id."' ";	
			}
 			//echo $sql;
			
			$rows=mysqli_query($db_conn,$sql);
			$row_counts_list=mysqli_num_rows($rows);			
			
			$sum_count=$row_counts_list;
			$true_count=0;
			$sb_count=0;
			$bcz_count=0;
			$wly_count=0;
			
			$fp = fopen($job_dir."/".utf82gb("说明").".txt","w"); 
			
			if ($row_counts_list!=0) {
				
				set_time_limit(0); 
				ini_set('memory_limit','600M');
				$wav_file_list="";
				
				while($rs= mysqli_fetch_array($rows)){ 
					$result="";
					$call_date=$rs["call_date"];
					$user=$rs["user"];
					if($call_date==""){$call_date=date("Y-m-d H:i:s");$user="1001";}
					$phone_number=$rs["phone_number"];
					$location=$rs["location"];
					$campaign_name=utf82gb(str_replace(array("\r\n","\r","\n","\\","/","\"","'","*","?","<",">"), "",$rs["campaign_name"]));
					$campaign_cid=$rs["campaign_cid"];
					$first_name=utf82gb(str_replace(array("\r\n","\r","\n","\\","/","\"","'","*","?","<",">"), "",$rs["first_name"]));
					
					$wav_name=record_type($phone_number,$user,$call_date,$campaign_cid,$first_name,$record_type);
					
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
										
					$up_sql="update data_record_job_log set record_name='".$wav_name."',result='".$result."' where id=".$rs["id"]."";
					mysqli_query($db_conn,$up_sql);
					
					$copy_log=$phone_number."\t".$cam_dir2."/".$wav_name."\t".utf82gb($result)."\r\n";
					//$copy_logs.=$copy_log;
					fwrite($fp,$copy_log);
 				}
				
 				$false_count=$sb_count+$bcz_count+$wly_count;
				//echo $up_job_sql;
				
				$copy_logs=utf82gb("\r\n\r\n共:".$sum_count."个，成功:".$true_count."个，失败:".$false_count."个(处理失败:".$sb_count.",文件不存在:".$bcz_count.",无录音:".$wly_count.")");
				
				fwrite($fp,$copy_logs); 
				//fclose($fp);
				
				$up_job_sql="update data_record_job set job_name='".$job_name."',zip_path='".gb2utf8($job_dir)."',result='".$sum_count."|".$true_count."|".$sb_count."|".$bcz_count."|".$wly_count."' where id=".$job_id."";
				mysqli_query($db_conn,$up_job_sql);
 				
				$wav_file_list="";
				$counts="1";
				if($true_count>0){
					$des="录音文件拷贝完成,请执行压缩!";
				}else{
					$des="录音文件查找完成,未找到符合条件的数据,请检查重试!";	
				}
				
				$result="共:<span class=\"red\">".$sum_count."</span>个,成功:<span class=\"red\">".$true_count."</span>个,失败:<span class=\"red\">".$false_count."</span> 个(处理失败:<span class=\"red\">".$sb_count."</span>,文件不存在:<span class=\"red\">".$bcz_count."</span>,无录音:<span class=\"red\">".$wly_count."</span>)";
				
			}else {
				$counts="0";
				$des="未找到符合条件的数据!";
 				
				fwrite($fp,$des); 
 			}
			 
			fclose($fp);
		}
 		mysqli_free_result($rows);
		//echo $sql."<br>";
		
		$json_data="{";
 		$json_data.="\"counts\":".json_encode($counts).",";
 		$json_data.="\"des\":".json_encode($des).",";
		$json_data.="\"copy_result\":".json_encode($result).",";
 		$json_data.="\"job_dir\":".json_encode(gb2utf8(str_replace("./data/","/data/",$job_dir))).",";
		$json_data.="\"zip_name\":".json_encode($job_name).",";
 		$json_data.="\"datalist\":".json_encode($list_arr)."";
 		$json_data.="}";
		
		echo $json_data;
		
	break;
		
	//执行压缩
	case "do_record_job2zip":
		$job_id=trim($_REQUEST["job_id"]);
		$job_dir=trim($_REQUEST["job_dir"]);
		$zip_name=trim($_REQUEST["zip_name"]);
		$job_dir=utf82gb($job_dir);
		$zip_name=utf82gb($zip_name);
		$endtime=date("Y-m-d H:i:s");
		//echo $job_dir."/";
		//echo file_exists("")."<br>";

		if($job_dir<>""){
			set_time_limit(0); 
			ini_set('memory_limit','600M');

			
			
			//echo $job_dir."\n####\n";
			if(is_dir($job_dir)){
				if($zip_name<>""){
					$zip_dir=str_replace("/".$zip_name,"",$job_dir);
					$zips=$job_dir."/".$zip_name.".zip";
					if(is_file($zips)){
						unlink($zips);
 					}
					

					//加载ZIP类库
					include("./inc/pclzip.lib.php");
					$zip_files = array($job_dir); 
 			   		$zip_f_name="./".$zip_dir."/".$zip_name.".zip";
					$archive = new PclZip($zip_f_name);
					$v_list = $archive->create($zip_files,PCLZIP_OPT_REMOVE_PATH,"".$job_dir."");
					if ($v_list == 0) {
						
 						$counts="0";
						$des="压缩失败!".$archive->errorInfo(true);
						
					}else{
						$counts="1";
						$des="压缩成功!请点击下载!";
						$zip_path=$zip_f_name;
						
						$del_sql="delete from data_record_job_log where job_id='".$job_id."'";
						mysqli_query($db_conn,$del_sql);
						
						$up_sql="update data_record_job set is_zip='1',endtime='".$endtime."' where id='".$job_id."'";
						mysqli_query($db_conn,$up_sql);
						
   					}
					
				}else{
					$counts="0";
					$des="压缩失败!任务名称为空，请检查重试!";
				}
 				
			}else{
				$counts="0";
				$des="压缩失败!录音备份目录不存在，请重新点击“开始处理”按钮!";
			}
			
		}else{
			$counts="-1";
			$des="压缩失败!录音备份目录不能为空!";
		}
		
		$json_data="{";
 		$json_data.="\"counts\":".json_encode($counts).",";
 		$json_data.="\"des\":".json_encode($des).",";
		$json_data.="\"endtime\":".json_encode($endtime).",";
		//$json_data.="\"zip_dir\":".json_encode($zip_dir).",";
 		$json_data.="\"zip_path\":".json_encode(gb2utf8(str_replace("./data/","/data/",$zip_path)))."";
   		$json_data.="}";
		
		echo $json_data;
	
	break;
	
	//删除录音处理文件夹
	case "del_zip_dir":
		$job_dir=trim($_REQUEST["job_dir"]);
		//echo gb2utf8($job_dir);
		 
		if ($do_actions=="job_dir"){
			
			if(deldir(utf82gb($job_dir))){
				$counts="1";
				$des="临时文件删除成功!";
			}else{
				$counts="0";
				$des="临时文件删除失败!";
			}
			
		}else{
 			//$is_file=$job_dir.".zip";
			if(is_file($job_dir.".zip")){
 				unlink($job_dir.".zip");
			}
			deldir($job_dir);
			
			$sql1="delete from data_record_job_log where job_id='".$job_id."';";
			$sql2="delete from data_record_job where id='".$job_id."';";
 			
			if(mysqli_query($db_conn,$sql1)&&mysqli_query($db_conn,$sql2)){
				$counts="1";
				$des="文件删除成功!";
			}else{
				$counts="0";
				$des="文件删除失败!";
			}
		}
		
		$json_data="{";
 		$json_data.="\"counts\":".json_encode($counts).",";
 		$json_data.="\"des\":".json_encode($des)."";
		$json_data.="}";
		
		echo $json_data;
 			
	break;
	
	//删除处理日志及录音文件
	case "delete_record_log_file":
		if($cid<>""){
			
			if(strpos($cid,",")>-1){
				$cid=str_replace(",","','",$cid);
				$cid="'".$cid."'";
				$where_sql=" in(".$cid.") ";
			}else{
				$where_sql=" ='".$cid."' ";
			}
			
			$sql="select a.record_name,b.zip_path from data_record_job_log a left join data_record_job b on a.job_id=b.id where a.id ".$where_sql." ";
			
 			//echo $sql;
 			$rows=mysqli_query($db_conn,$sql);
			$row_counts_list=mysqli_num_rows($rows);			
			
 			if ($row_counts_list!=0) {
				while($rs= mysqli_fetch_array($rows)){
					if($rs["record_name"]<>"" and $rs["zip_path"]<>""){
						if(is_file(utf82gb($rs["zip_path"]."/".$rs["record_name"]))){
							unlink(utf82gb($rs["zip_path"]."/".$rs["record_name"]));
						}
					}
 				}
				$del_sql="delete from data_record_job_log where id ".$where_sql." ";
				if(mysqli_query($db_conn,$del_sql)){
 					$counts="1";
					$des="删除成功!";
				}else{
 					$counts="-1";
					$des="删除失败!请检查重试!";
				}
 			}else {
				$counts="0";
				$des="未找到符合条件的数据!";
				$list_arr=array('id'=>'none');
			}
			mysqli_free_result($rows);
  			
		}else{
			$counts="-1";
			$des="删除失败!参数获取失败!";
		}
		
		//echo $des;
		
		$json_data="{";
 		$json_data.="\"counts\":".json_encode($counts).",";
 		$json_data.="\"des\":".json_encode($des)."";
		$json_data.="}";
		
		echo $json_data;
		
	break;
	
	//获取录音处理记录
	case "reocrd_job_list":
	
		$job_name=trim($_REQUEST["job_name"]);
		
		if($s_date!=""&&$e_date!=""){
			$sql1=" and b.addtime between '".$start_date."' and '".$end_date."'";
		}
		 
		if($job_name<>""){
 			$sql2=" and b.job_name like '%".$job_name."%'";
		}
		
		$wheres=$sql1.$sql2;
		
		if($do_actions=="count"){
			
			$sql="select count(*) from data_record_job b where 1=1 ".$wheres." ";
			//echo $sql;
			$rows=mysqli_fetch_row(mysqli_query($db_conn,$sql));
			$counts=$rows[0];
			if(!$counts){$counts="0";} 

			$des="d";
			$list_arr=array('id'=>'none');
			
		}else if($do_actions=="list"){
		
			$offset=($pages-1)*$pagesize;
			
 			$sql="select b.id as job_id,b.job_name, b.is_zip,b.zip_path,b.addtime,b.endtime,b.userid,c.full_name,b.result from data_record_job b  left join vicidial_users c on b.userid=c.user where 1=1 ".$wheres." ".$sort_sql."  limit ".$offset.",".$pagesize." ";
			
 			//echo $sql;
 			$rows=mysqli_query($db_conn,$sql);
			$row_counts_list=mysqli_num_rows($rows);			
			
			$list_arr=array();
			 
			if ($row_counts_list!=0) {
				while($rs= mysqli_fetch_array($rows)){ 
				
					$result=explode("|",$rs["result"]);
					$sum_c=$result[0];
					$cg_c=$result[1];
					$sb_c=$result[2];
					$bcz_c=$result[3];
					$wly_c=$result[4];
				 	
					$list=array("job_id"=>$rs['job_id'],"CG"=>$cg_c,"SB"=>$sb_c,"BCZ"=>$bcz_c,"WLY"=>$wly_c,"ZS"=>$sum_c,"job_name"=>$rs['job_name'],"is_zip"=>$rs['is_zip'],"zip_path"=>$rs["zip_path"],"addtime"=>$rs['addtime'],"endtime"=>$rs['endtime'],"userid"=>$rs['userid'],"full_name"=>$rs['full_name']);
					 
					array_push($list_arr,$list);
				}
				$counts="1";
				$des="succ!";
			}else {
				$counts="0";
				$des="未找到符合条件的数据!";
				$list_arr=array('id'=>'none');
			}
 		}	
 		mysqli_free_result($rows);
		//echo $sql."<br>";
		
		$json_data="{";
 		$json_data.="\"counts\":".json_encode($counts).",";
 		$json_data.="\"des\":".json_encode($des).",";
		$json_data.="\"datalist\":".json_encode($list_arr)."";
 		$json_data.="}";
		
		echo $json_data;
	break;
	
	//清空录音处理日志
	case "truncate_reocrd_log":
		
		deldir("./data/record");
		deldir("./data/down");
		//deldir("./data/tmp");
		//deldir("./data/cache/eaccelerator");
		
		if(!is_dir("./data/record")){
			mkdir("./data/record",0777);	
		}
		
		if(!is_dir("./data/down")){
			mkdir("./data/down",0777);	
		}
		
		/*if(!file_exists("./data/tmp")){
			mkdir("./data/tmp",0777);	
		}
		
		if(!file_exists("./data/cache/eaccelerator")){
			mkdir("./data/cache/eaccelerator",0777);	
		}*/
		
		$sql1="truncate table data_record_job_log";
		$sql2="truncate table data_record_job";
		if(mysqli_query($db_conn,$sql1)&&mysqli_query($db_conn,$sql2)){
			$counts="1";
			$des="初始化完成!";
		}else{
			$counts="0";
			$des="初始化失败!请检查重试!";
		}
		
		$json_data="{";
 		$json_data.="\"counts\":".json_encode($counts).",";
 		$json_data.="\"des\":".json_encode($des)."";
 	 
  		$json_data.="}";
		
		echo $json_data;
		
  	break;
 	 
	//录音备份呼叫统计
	case "get_record_count_list":
		
		$time_len_type=trim($_REQUEST["time_len_type"]);
		

		$sql1=" call_date between '".$start_date."' and '".$end_date."'";

		
		$agent_list=$_REQUEST["agent_name_list"];
		if($agent_list<>""){
			if(strpos($agent_list,",")>-1){
 				$agent_list=str_replace(",","','",$agent_list);
				$agent_list="'".$agent_list."'";
				$sql2=" and a.user in(".$agent_list.")";
			}else{
				$sql2=" and a.user ='".$agent_list."'";
			}
		}else{
			
			if($_SESSION["allow_users"]=="none"){
				$sql2=" ";
				
			}elseif($_SESSION["allow_users"]=="self"){
				
				$sql2="  and a.user ='".$_SESSION["username"]."' ";
				
			}elseif($_SESSION["session_users_list"]!=""){
				
				if(strpos($_SESSION["session_users_list"],",")>-1){
					 
					$sql2=" and a.user in(".$_SESSION["session_users_list"].")";
				}else{
					$sql2=" and a.user =".$_SESSION["session_users_list"];
				}	
			}
				
		}
		
		
		
		$phone_count=0;
		if($phone_number<>""){
			
			$phone_number=eregi_replace("[^0-9\n]","",$phone_number);
			$phone_number_ary=array_unique(explode("\n",$phone_number));
			 
			$phone_count=count($phone_number_ary); 
		}
		
		
		if($call_date_type=="no_call_date"){
			
			if($phone_count>0){ 
			 	$i=0;
 				foreach($phone_number_ary as $phone){ 
					if($phone<>"" && preg_match("/^\d*$/",$phone) && $i<1001){
						$phone=trim(eregi_replace("[^0-9]","",$phone));
						$sql_phone.="'".$phone."',";
						$i++;
					} 
				}
				
				if($sql_phone!=""){
					$sql_phone=substr($sql_phone, 0, -1);
				}else{
					$is_exit=1;
					$des="请输入有效的被叫号码重试!";
				}
 				
			}else{
				$is_exit=1;
				$des="请输入有效的被叫号码重试!";
			}
			
			$sql1=" a.phone_number in(".$sql_phone.")";
			
 		}else{
 			
			if($phone_count>0){
  				 
				$i=0;
				foreach($phone_number_ary as $phone){ 
					if($phone<>"" && preg_match("/^\d*$/",$phone) && $i<1001){
						$phone=trim(eregi_replace("[^0-9]","",$phone));
						$sql_phone.="'".$phone."',";
						$i++;
					} 
				}
				
				if($sql_phone!=""){
					$sql_phone=substr($sql_phone,0,-1);
					$exist_sql="in(".$sql_phone.")";
				} 
				
			 
				if($exist_sql){
					$sql3=" and a.phone_number ".$exist_sql;
				}
			}
			
		}
  
		if($campaign_id<>""){
			if(strpos($campaign_id,",")>-1){
				$campaign_id=str_replace(",","','",$campaign_id);
				$campaign_id="'".$campaign_id."'";
				$sql4=" and campaign_id in(".$campaign_id.") ";
			}else{
				$sql4=" and campaign_id ='".$campaign_id."' ";
			}
		}else{
			
			if($_SESSION["allow_campaigns"]=="none"){
				$sql4=" ";
				
			}elseif($_SESSION["session_campaigns_list"]!=""){
				
				if(strpos($_SESSION["session_campaigns_list"],",")>-1){
					 
					$sql4=" and campaign_id in(".$_SESSION["session_campaigns_list"].")";
				}else{
					$sql4=" and campaign_id =".$_SESSION["session_campaigns_list"];
				}	
			}
				
		}
		
  		
		if($call_des<>""){
 			$sql5=" and a.call_des like '%".$call_des."%'";
		}
 		
 		if($quality_status<>""){
			if(strpos($quality_status,",")>-1){
				$quality_status=str_replace(",","','",$quality_status);
				$quality_status="'".$quality_status."'";
				$sql6=" and a.quality_status in(".$quality_status.") ";
			}else{
				$sql6=" and a.quality_status ='".$quality_status."' ";
			}
		}
		
		if($status<>""){
			if(strpos($status,",")>-1){
				$status=str_replace(",","','",$status);
				$status="'".$status."'";
				$sql7=" and a.status in(".$status.") ";
			}else{
				$sql7=" and a.status ='".$status."' ";
 			}
		}else{
			$sql7=" and a.status in(select status from (select status from data_sys_status where status_type='call_status' and selectable='y')temp_tbl) ";
		}
		
		if($phone_lists<>""){
			if(strpos($phone_lists,",")>-1){
				$phone_lists=str_replace(",","','",$phone_lists);
				$phone_lists="'".$phone_lists."'";
				$sql8=" and a.list_id in(".$phone_lists.") ";
			}else{
				$sql8=" and a.list_id = '".$phone_lists."' ";
			}
		}
		
		if($comments<>""){
 			$sql9=" and a.comments='".$comments."'";
 		}
		
		
 		if($is_exit==1){
			
			$json_data="{";
			$json_data.="\"counts\":".json_encode(0).",";
			$json_data.="\"des\":".json_encode($des).",";
 			$json_data.="\"datalist\":".json_encode($list_arr)."";
			$json_data.="}";
			
			echo $json_data;
			
			die();
				
		}
		
		
		$wheres=$sql1.$sql2.$sql3.$sql4;
		//$wheres=$sql1;
		//echo $wheres."\n";

		if($campaign_id=="vicitest" || $campaign_id=="edu")
		{
			$sql="select ifnull(datas.campaign_id,'') as campaign_id,case when datas.campaign_id is null and datas.status is null then '总计' else ifnull(b.campaign_name,concat('未知业务 [',datas.campaign_id,']')) end campaign_name,case when datas.campaign_id is not null and datas.status is null then '合计' else ifnull(datas.status,'') end as status,ifnull(c.status_name,'') as status_name,counts from(select campaign_id,a.status,count(*) as counts from vicidial_log a left join vicidial_list b on a.lead_id=b.lead_id  where ".$wheres." group by campaign_id,a.status with rollup )datas left join vicidial_campaigns b on b.campaign_id=datas.campaign_id left join data_sys_status c on datas.status=c.status and c.status_type='call_status' ";
		}
		else
		{
			$sql="select ifnull(datas.campaign_id,'') as campaign_id,case when datas.campaign_id is null and datas.status is null then '总计' else ifnull(b.campaign_name,concat('未知业务 [',datas.campaign_id,']')) end campaign_name,case when datas.campaign_id is not null and datas.status is null then '合计' else ifnull(datas.status,'') end as status,ifnull(c.status_name,'') as status_name,counts from(select campaign_id,a.status,count(*) as counts from vicidial_closer_log a left join vicidial_list b on a.lead_id=b.lead_id  where ".$wheres." group by campaign_id,a.status with rollup)datas left join vicidial_campaigns b on b.campaign_id=datas.campaign_id left join data_sys_status c on datas.status=c.status and c.status_type='call_status' ";
		
		}
			
		//echo $sql."\n$$$\n";

		$rows=mysqli_query($db_conn,$sql);

		$row_counts_list=mysqli_num_rows($rows);
		//echo $row_counts_list;

		
		
		
		$list_arr=array();
		 
		if ($row_counts_list!=0) {
			while($rs= mysqli_fetch_array($rows)){ 
			 
				$list=array("campaign_id"=>$rs['campaign_id'],"campaign_name"=>$rs['campaign_name'],"status"=>$rs['status'],"status_name"=>$rs['status_name'],"counts"=>$rs['counts']);
				 
				array_push($list_arr,$list);
			}
			$counts="1";
			$des="succ!";
		}else {
			$counts="0";
			$des="未找到符合条件的数据!";
			$list_arr=array('id'=>'none');
		}
	 
		mysqli_free_result($rows);
	
		
		

		$json_data="{";
		$json_data.="\"counts\":".json_encode($counts).",";
		$json_data.="\"des\":".json_encode($des).",";
	 
		$json_data.="\"datalist\":".json_encode($list_arr)."";
		$json_data.="}";
		
		echo $json_data;
  		
	break;	
 	
	case "record_copy_zip":
		
		$do_campaign_id=trim($_REQUEST["do_campaign_id"]);
		$do_status=trim($_REQUEST["do_status"]);
 		$record_type=trim($_REQUEST["record_type"]);
		$job_name=trim($_REQUEST["job_name"]);

		//echo $_REQUEST["agent_name_list"]."\nrrrrrrrrrrrrr\n";

		
		if($job_name==""){
  			$job_name="录音处理-".date("YmdHis");
		}else{
			$job_name=$job_name."-".date("His");			
		}
		
		$sql="insert into data_record_job(job_name,userid) values('".$job_name."','".$_SESSION["username"]."')";
		
		mysqli_query($db_conn,$sql);		
		$job_id=mysqli_insert_id($db_conn);

	

		if($job_id<>""){

			$sql1=" a.call_date between '".$start_date."' and '".$end_date."' ";
			
			$agent_list=$_REQUEST["agent_name_list"];
			
			if($agent_list<>""){
				if(strpos($agent_list,",")>-1){
					$agent_list=str_replace(",","','",$agent_list);
					$agent_list="'".$agent_list."'";
					$sql2=" and a.user in(".$agent_list.")";
				}else{
					$sql2=" and a.user ='".$agent_list."'";
				}
			}else{
			
				if($_SESSION["allow_users"]=="none"){
					$sql2=" ";
					
				}elseif($_SESSION["allow_users"]=="self"){
					
					$sql2="  and a.user ='".$_SESSION["username"]."' ";
					
				}elseif($_SESSION["session_users_list"]!=""){
					
					if(strpos($_SESSION["session_users_list"],",")>-1){
						 
						$sql2=" and a.user in(".$_SESSION["session_users_list"].")";
					}else{
						$sql2=" and a.user =".$_SESSION["session_users_list"];
					}	
				}
					
			}
			
			$phone_count=0;
			if($phone_number<>""){
				
				$phone_number=eregi_replace("[^0-9\n]","",$phone_number);
				$phone_number_ary=array_unique(explode("\n",$phone_number));
				 
				$phone_count=count($phone_number_ary); 
			}
 			
			if($call_date_type=="no_call_date"){
				
				if($phone_count>0){ 
					$i=0;
					foreach($phone_number_ary as $phone){ 
						if($phone<>"" && preg_match("/^\d*$/",$phone) && $i<1001){
							$phone=trim(eregi_replace("[^0-9]","",$phone));
							$sql_phone.="'".$phone."',";
							$i++;
						} 
					}
					
					if($sql_phone!=""){
						$sql_phone=substr($sql_phone, 0, -1);
					}else{
						$is_exit=1;
						$des="请输入有效的被叫号码重试!";
					}
					
				}else{
					$is_exit=1;
					$des="请输入有效的被叫号码重试!";
				}
				
				$sql1=" a.phone_number in(".$sql_phone.")";
				
			}else{
				
				if($phone_count>0){
					 
					$i=0;
					foreach($phone_number_ary as $phone){ 
						if($phone<>"" && preg_match("/^\d*$/",$phone) && $i<1001){
							$phone=trim(eregi_replace("[^0-9]","",$phone));
							$sql_phone.="'".$phone."',";
							$i++;
						} 
					}
					
					if($sql_phone!=""){
						$sql_phone=substr($sql_phone,0,-1);
						$exist_sql="in(".$sql_phone.")";
					} 
					
				 
					if($exist_sql){
						$sql3=" and a.phone_number ".$exist_sql;
					}
				}
				
			}
				
			if($do_campaign_id==""){
				if($campaign_id<>""){
					if(strpos($campaign_id,",")>-1){
						$campaign_id=str_replace(",","','",$campaign_id);
						$campaign_id="'".$campaign_id."'";
						$sql4=" and a.campaign_id in(".$campaign_id.") ";
					}else{
						$sql4=" and a.campaign_id ='".$campaign_id."' ";
					}
				}else{
			
					if($_SESSION["allow_campaigns"]=="none"){
						$sql4=" ";
						
					}elseif($_SESSION["session_campaigns_list"]!=""){
						
						if(strpos($_SESSION["session_campaigns_list"],",")>-1){
							 
							$sql4=" and a.campaign_id in(".$_SESSION["session_campaigns_list"].")";
						}else{
							$sql4=" and a.campaign_id =".$_SESSION["session_campaigns_list"];
						}	
					}
						
				}
				
			}else{
				$sql4=" and a.campaign_id ='".$do_campaign_id."' ";
			}
			
			if($call_des<>""){
				$sql5=" and a.call_des like '%".$call_des."%'";
			}
			
			if($quality_status<>""){
				if(strpos($quality_status,",")>-1){
					$quality_status=str_replace(",","','",$quality_status);
					$quality_status="'".$quality_status."'";
					$sql6=" and a.quality_status in(".$quality_status.") ";
				}else{
					$sql6=" and a.quality_status ='".$quality_status."' ";
				}
			}
			
			if($do_status=="合计"||$do_status==""){
				
				if($status<>""){
					if(strpos($status,",")>-1){
						$status=str_replace(",","','",$status);
						$status="'".$status."'";
						$sql7=" and a.status in(".$status.") ";
					}else{
						$sql7=" and a.status ='".$status."' ";
					}
				}else{
					$sql7=" ";
				}
				
			}else{
				$sql7=" and a.status ='".$do_status."' ";
			}
			
			if($phone_lists<>""){
				if(strpos($phone_lists,",")>-1){
					$phone_lists=str_replace(",","','",$phone_lists);
					$phone_lists="'".$phone_lists."'";
					$sql8=" and a.list_id in(".$phone_lists.") ";
				}else{
					$sql8=" and a.list_id = '".$phone_lists."' ";
				}
			}
			
			if($comments<>""){
				$sql9=" and a.comments='".$comments."' ";
			}
			
			$wheres=$sql1.$sql2.$sql3.$sql4.$sql7;
			//$wheres=$sql1.$sql2.$sql3.$sql4;
 	  		//echo $wheres."\n########\n";

			if($record_type=="DDDuser-phone-yyyymmdd"){
			 
				$copy_sql="select a.campaign_id,a.phone_number,a.call_date,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,e.user_id as user,c.campaign_cid from vicidial_log".$archive." a left join vicidial_list".$archive." b on a.lead_id=b.lead_id left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log".$archive." d on a.uniqueid=d.vicidial_id and a.lead_id=d.lead_id left join data_user_list e on a.user=e.user where ".$wheres." ";
				
			}else{

				if($campaign_id=='IVR_AIA')
				{
					$copy_sql="select a.campaign_id,a.phone_number,a.call_date,a.user,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,c.campaign_cid,b.first_name from vicidial_closer_log a left join vicidial_list b on a.lead_id=b.lead_id left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log d on a.closecallid=d.vicidial_id and a.lead_id=d.lead_id where ".$wheres." ";
				}
				else
				{
					$copy_sql="select a.campaign_id,a.phone_number,a.call_date,a.user,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,c.campaign_cid,b.first_name from vicidial_log a left join vicidial_list b on a.lead_id=b.lead_id left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log d on a.uniqueid=d.vicidial_id and a.lead_id=d.lead_id where ".$wheres." ";
				}

				//$copy_sql="select a.campaign_id,a.phone_number,a.call_date,a.user,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,c.campaign_cid,b.first_name from vicidial_closer_log a left join vicidial_list b on a.lead_id=b.lead_id left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log d on a.closecallid=d.vicidial_id and a.lead_id=d.lead_id UNION select a.campaign_id,a.phone_number,a.call_date,a.user,ifnull(c.campaign_name,concat('未知业务_',a.campaign_id)) as campaign_name,d.location,c.campaign_cid,b.first_name from vicidial_log a left join vicidial_list b on a.lead_id=b.lead_id left join vicidial_campaigns c on a.campaign_id=c.campaign_id left join recording_log d on a.uniqueid=d.vicidial_id and a.lead_id=d.lead_id where ".$wheres." ";
			}
			//echo $copy_sql."\n##\n";
			
			$job_dir=create_record_dir($job_id,$job_name);
			//echo $sql;
			 
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
					$campaign_name=utf82gb(str_replace(array("\r\n","\r","\n","\\","/","\"","'","*","?","<",">"), "",$rs["campaign_name"]));
					$location=$rs["location"];
					$phone_number=$rs["phone_number"];
					$campaign_cid=$rs["campaign_cid"];
					$first_name=utf82gb(str_replace(array("\r\n","\r","\n","\\","/","\"","'","*","?","<",">"), "",$rs["first_name"]));
					
					
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
					
					//$wav_name=record_type($phone_number,$user,$call_date,$campaign_cid,$first_name,$record_type);
					//$wav_name=$location;
					//echo $location."**************";
					
					if($location<>""){
						
						$wav_extens = explode("-all.",$location);
						$wav_exten=$wav_extens[1];
						unset($wav_extens);

						
						//echo "ssh1:".$ssh1[0]."\n";
						//echo "wav_extens:".$wav_extens."\n";
						
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
							$ssh = explode("/monitorDONE/",$location_first);
							$ssh1= explode("-all",$ssh[1]);
							$wav_name="$ssh1[0].$wav_exten";

							/*$wav_file_list.="$phone_number,";
							$wav_exist_count=substr_count($wav_file_list,$phone_number);
							if($wav_exist_count>1){
								$wav_name.="($wav_exist_count).$wav_exten";
							}else{
								$wav_name.=".$wav_exten";	
							}*/
							
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
					$copy_log=$phone_number."\t".$cam_dir2."/".$wav_name."\t".utf82gb($result)."\r\n";
					fwrite($fp,$copy_log);
				}
				
				//if($result_sql!=""){
					//$in_sql="insert into data_record_job_log(record_name,result,addtime,job_id) values ".substr($result_sql,0,-1)." ";
					//mysqli_query($db_conn,$in_sql);
				//}
				
								
				$false_count=$sb_count+$bcz_count+$wly_count;
				//echo $up_job_sql;
				
				$copy_logs="\r\n\r\n共:".$sum_count."个，成功:".$true_count."个，失败:".$false_count."个(处理失败:".$sb_count.",文件不存在:".$bcz_count.",无录音:".$wly_count.")";
				 
				// echo $copy_logs."\n##############\n";

				fwrite($fp,utf82gb($copy_logs)); 
				//fclose($fp);
			 
				$up_job_sql="update data_record_job set job_name='".$job_name."',zip_path='".gb2utf8($job_dir)."',result='".$sum_count."|".$true_count."|".$sb_count."|".$bcz_count."|".$wly_count."' where id=".$job_id."";
				mysqli_query($db_conn,$up_job_sql);
				
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
		
		}else{
			$counts="0";
			$des="创建处理任务失败，请检查重试!";
			 
			$result="";
			$job_dir="";
			$job_name="";
			$list_arr="";
		}
		
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