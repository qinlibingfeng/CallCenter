<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/" />
<style>
html,body { scrollbar-arrow-color: #6688AA;scrollbar-3dlight-color: #AACCDD;scrollbar-shadow-color: #99BBCC;scrollbar-face-color: #DDEEFF;scrollbar-darkshadow-color: #DDEEFF;scrollbar-highlight-color: #FFFFFF;scrollbar-track-color: #EEEEEE;}
html{filter:expression(document.execCommand("BackgroundImageCache", false, true))}
body,input,textarea,select,button{margin: 0; font-size: 12px; font-family:"Tahoma","Arial","微软雅黑","宋体","Hei","黑体";}
body,div,span,h1,h2,h3,h4,ul,li,img,p,b,textarea,input,select,form,a,table,tr,td{margin:0;padding:0;font-family:verdana,Arial, Helvetica, sans-serif;list-style-type:none;font-size:inherit;color:inherit;z-index:inherit;font-size:12px}
a{text-decoration:none;color:#333;font-size:12px}
a:hover{text-decoration:none;font-size:12px}
.gMenu{border-color:#81A4C2}
.gSipt{border-color:#617993}
.bgF1,.spl,a.srhBtn,a.EptFd,.gFdBdy li.on{background:url(../images/f1.gif) no-repeat}
body.gb{background-image:url(../images/f1.gif)}
.bgF1png,.gMbtn a,.gfTit,.gNav li a.on,.icoIfo{background:url(../images/f1png.png) no-repeat left bottom;} img,table{border:0;border-collapse:collapse}
body.gb{background-color:#FFF;background-position:-1424px 0;background-repeat:repeat-y;min-width:680px}
.gMbtn{width:164px;height:30px;background: url(../images/left_top_bg.jpg) no-repeat left top;cursor:pointer;position: relative;}
.gMbtn a{display:block;height:36px}
.gLe{width:172px;padding-bottom:15px;float:left;margin-right:-3px;}
#divMain{margin:0px 0px 0px 189px!important;margin:0px 0px 0px 186px;}
.gFd{width:168px;margin:0px 0 0 2px;position: relative;}.gfTit{height:29px;position:relative;background-position:-198px -1px;margin-bottom:2px;font-weight: bold;}a.gfName{position:absolute;top:10px;*top:12px;left:21px;font-weight:bold;font-size: 12px;}a.gfName:hover{text-decoration:none}a.clsFd{position:absolute;top:12px;left:3px;display:block;width:14px;height:14px;background-position:-532px -26px}a.clsFd:hover{background-position:-549px -26px}a.opnFd{position:absolute;top:12px;left:3px;display:block;width:14px;height:14px;background-position:-532px -40px}a.opnFd:hover{background-position:-549px -40px}.addFd{position:absolute;top:12px;right:10px;display:block;width:14px;height:14px;background-position:-568px -25px}a.addFd:hover{background-position:-588px -25px}
a.gfNm,span.gfNm{display: block;position: absolute;left:30px;top:4px;*top:6px;}
*:lang(zh) a.gfNm,*:lang(zh) span.gfNm{top:4px;left:33px}
span.gfNm{left:24px}
a.gfNm:hover{text-decoration:none}
.hide{display:none}
.clear{clear:both;font-size:0;height:0;background-color:transparent}
.gMenu{position:absolute;z-index:99;background-color:#FFF;overflow:hidden;text-overflow:ellipsis}.gMenu .bdy{border-color:#FFF;height:100%}
.gMenuOpt a{display:block;margin:1px;padding:4px;width:100%;overflow:hidden;text-overflow:ellipsis}*:lang(zh) .gMenuOpt a{width:auto}
.gMenuOpt a:hover{text-decoration:none}
.spline{height:1px;font-size:1px}
.gLe{width:164px;padding-bottom:15px;float:left;margin-right:-3px;}
#divMain{margin:0px 0px 0px 189px !important;margin:0px 0px 0px 186px;}
.gFdBdy li{height:24px;position:relative; line-height:16px}
.gFdBdy li a.gfNm{width:130px;height:17px;white-space:nowrap;display:block;overflow:hidden}
.gFdBdy li.on{background-position:-356px -3px}
.load_layer{right:6px;position: absolute;top:6px;background:#FFFF99;border:1px solid #999;line-height:20px;height: 20px;padding:2px 4px 0 4px;z-index:200;display:none}
.icon{background: url(../images/menu_icon.png) no-repeat;position:relative;left:8px;top:4px;display:block;width:16px;height:16px;font-size:1px;float:left;}
.icon_1{background-position:0px -9px}
.icon_2{background-position:0px -38px}
.icon_3{background-position:0px -68px}
.icon_4{background-position:-1px -94px}
.icon_5{background-position:-1px -123px}
.icon_6{background-position:-1px -150px}
.icon_7{background-position:-1px -178px}
.icon_8{background-position:-1px -206px}
.icon_9{background-position:-1px -235px}
.icon_10{background-position:-1px -265px}
.icon_11{background-position:-1px -294px}
.icon_12{background-position:-1px -323px}
.icon_13{background-position:-1px -353px}
.icon_14{background-position:-1px -382px}
.icon_15{background-position:-1px -412px}
.icon_16{background-position:-1px -441px}
.icon_17{background-position:-1px -468px}
.icon_19{background-position:-1px -498px}
.icon_18{background-position:-1px -527px}
.icon_20{background-position:-1px -555px}
.icon_21{background-position:-1px -583px}
.icon_22{background-position:-1px -613px}
.icon_23{background-position:0px -640px}
.icon_24{background-position:-1px -667px}
.icon_25{background-position:-1px -694px}
.icon_26{background-position:-1px -715px}
.icon_27{background-position:-1px -763px}
.icon_28{background-position:-1px -790px}
.icon_29{background-position:-1px -817px}
.icon_30{background-position:-1px -840px}
.icon_31{background-position:-1px -864px}
.icon_32{background-position:-1px -892px}
.icon_33{background-position:-1px -915px}
</style>

<script src="js/jquery-1.6.4.js" 		type="text/javascript"></script>
<script src="js/left_view.js"  			type="text/javascript"></script>
<script src="js/jquery.idTabs.min.js" 	type="text/javascript"></script>

<script>
function on_make_busy_click(obj)
{
	alert(obj.className);
	//忙
	if(obj.className == 'agent_busy' || obj.className == 'agent_busy_hover')
	{
			//更改界面显示	
		window.parent.frames['TopFrame'].make_busy(false);
		obj.className='agent_busy_false';
	}
	else
	{
		window.parent.frames['TopFrame'].make_busy(true);
		obj.className='agent_busy';
	}	
}

function on_transfer(obj)
{
	parent.on_transfer_prompt();
}
function nav(title,url){
	window.parent.frames['mainFrame'].iAddTab(title,url);
}
</script>
</head>
<!--body>
<div class="work-list" style="margin-top:0px;">

    <!--div class='tabs' style="margin-left:16px;">		
        <ul class="idTabs"> 
            <li ><a href="#panel">系统</a></li> 
            <li><a href="#Phone_Main">通话</a></li> 			
        </ul> 
    </div>
    <br>
    <br-->
    <div id="panel" class="gMain" style="width:179px">
            <div class="panel_top" width="100%" >
                                 操作菜单
            </div>                 
		<?php foreach ($items as $item){?> 
                <div class="gLe">
                    <div id="<?php echo $item["item_id"]?>" class="panel_item">
                        <img  class="item_logo" src="<?php echo $item["item_logo"];?>">
                        <span class="item_text"><?php echo $item["item_text"];?></span>
                        <img  align="right" class="item_bt" src="images/zhankai.png">
                    </div>    		
                        <?php foreach($item["sub_items"] as $sub_item){?>
                             <div id="<?php echo $sub_item["item_id"] ?>" class="gMbtn" onMouseOver="this.className='panel_item2_hover'" onMouseOut="this.className='panel_item2'">
                                <img  class="item_logo2" src="<?php echo  $sub_item["item_logo"];?>">
                                <a onClick="nav('<?php echo $sub_item["item_text"]?>','<?php echo $sub_item["item_url"]?> ')" href="javascript:void" target="mainFrame"><span class="item_text2"><?php echo $sub_item["item_text"];?></span></a>
                             </div>    
                        <?php } ?> 
                 </div> 		
            <?php } ?> 
    </div>
           
</div>
</body-->
</html>
