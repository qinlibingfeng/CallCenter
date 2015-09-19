<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>
<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />


<script src="www/js/jquery-1.6.4.js"              type="text/javascript"></script>
<script src="www/js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="www/js/Public.js"                    type="text/javascript"></script>
<script src="www/js/work.js"                      type="text/javascript"></script>
<script>
	$(document).ready(function(){
		var weekday=new Array(7);
		weekday[0]="sun";
		weekday[1]="mon";
		weekday[2]="tue";
		weekday[3]="wed";
		weekday[4]="thu";
		weekday[5]="fri";
		weekday[6]="sat";
		
		function setAllWeekDayCheckBox(f){
			for (var i in weekday){
				$('input[name="'+weekday[i]+'"]').attr('checked',f);			
			}			
		}
		$("input[name='"+weekday[new Date().getDay()]+"']").attr('checked',true);
		
		$('#allCheck').click(function(){
			if($('#allCheck').attr('checked')){
				setAllWeekDayCheckBox(true);			
			}
			else{
				setAllWeekDayCheckBox(false);
			}
		});
	});
</script>
</head>
<body>
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 时钟</div>
         <div class="nav_other"></div>
	</div>
    <div class="layout-middle" style="height:32px"> </div>
    
	<div class="work-list">
    	<div class='panelOne' style='margin-top:3px;'>
				<div class='title'>&nbsp;&nbsp;&nbsp;&nbsp;<a id='panelOneTitle'></a></div>
				<div class='content' style="width:100%">
                <center><p><?php echo validation_errors();?></p></center>
                <?php echo form_open(site_url('plan/'.$dst))?>
                	<table width="100%">
        				<tr><td align="right" width="300px" >启用</td><td width="auto"><?php echo form_checkbox('enable', '0', isset($enableChecked)?$enableChecked:false);?></td></tr>
                        <tr><td align="right" >标题</td><td><input type="text" name='title' value='<?php echo isset($clockTitle)?$clockTitle:"";?>' style="width:300px"/></td></tr>
                        <tr><td align="right" >时间</td><td >
                       	<?php function echoTimeSelect($hourId, $minId,$defaltTime)
							  {
								  $hourOptions= array();
								  $hour='00';
								  $minute='00';
								  if(isset($defaltTime))
									 list($hour,$minute)=split(':',$defaltTime);
								  for($i=0; $i<24; $i++){
									$value=$i;
									if($i<10)
										$value='0'.$i;
									$hourOptions[$value]=$value;
								  }
								  echo form_dropdown($hourId, $hourOptions,$hour);
								  $minOptions= array();
								  for($i=0; $i<60; $i++){
									$value=$i;
									if($i<10)
										$value='0'.$i;
									$minOptions[$value]=$value;	
								  }
								  echo form_dropdown($minId,$minOptions, $minute);
							  }
							  
							  echoTimeSelect('s_hour','s_min',isset($time)?$time:date('H:i:s'));
							  ?>
                        </td></tr>  
						<tr><td align="right" >重复</td>
                        	<td>
                       	 		周一<?php echo form_checkbox('mon', '0', isset($monChecked)?$monChecked:false);?>周二<?php echo form_checkbox('tue', '0', isset($tueChecked)?$tueChecked:false);?>
                                周三<?php echo form_checkbox('wed', '0', isset($wedChecked)?$wedChecked:false);?>周四<?php echo form_checkbox('thu', '0', isset($thuChecked)?$thuChecked:false);?>
                                周五<?php echo form_checkbox('fri', '0', isset($friChecked)?$friChecked:false);?>周六<?php echo form_checkbox('sat', '0', isset($satChecked)?$satChecked:false);?>
                                周日<?php echo form_checkbox('sun', '0', isset($sunChecked)?$sunChecked:false);?>全部<input id="allCheck" type="checkbox"/>
                        	</td>
                      	</tr>
                       <tr><td></td><td><input type="submit" class="btn" value="确定">&nbsp;&nbsp;
                       					<input type="button" class="btn" onClick="javascript:location.href= '<?php echo site_url("plan/clock")?>'" value="返回"></td></tr>
        				
                    </table>
                    <?php echo form_close()?>
        		</div>
        </div>
    	
	</div>
</div>
</body>
</html>