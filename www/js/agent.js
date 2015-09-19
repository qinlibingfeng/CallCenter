
$(document).ready(function(){
	
 $('#add').click(function(){
 	 /*
 	 *ajax 保持agent设置
 	 */	
	var data={'code':'','passwd':'','group_id':0,'role_id':0,'name':'','sex':'','email':'','qq':''};
	
	data.code=$('#code').attr('value');
	data.passwd=$('#passwd').attr('value');
	data.group_id=$('#group').attr('value');
	data.role_id=$('#role').attr('value');
	data.name=$('#name').attr('value');
	data.sex=$('#sex').attr('value');
	data.email=$('#email').attr('value');
	data.qq=$('qq').attr('value');
	
 	$.post("/CallCenter/index.php/agent/ajax_add", data,function(res){		
			
			if (res.res == 1) {
				alert('添加成功');
			}else{
				alert('添加失败');
			}
		 });
 });	
 $(".add_agent").click(function(){
	 	var nodeView=$(this).prev('td').children('.view_data'); 
		var nodeData=$(this).prev('td').children('.post_data'); 
		var from_url=$(this).children('.target_url').attr('value');
		var statesdemo = {
		state0: {
			html:'<iframe id="cimport_frame" name="cimport_frame"   style="width:260px;height:250px" src="'+from_url+'" frameborder=auto></iframe>',
			buttons:{确定:true,取消:false},
			submit:function(v,m,f){ 
				if(v){ //提交			
					var data=document.getElementById("cimport_frame").contentWindow.getSelectedAgentsName();
					nodeView.attr('value', data.toString());
					nodeData.attr('value', document.getElementById("cimport_frame").contentWindow.getSelectedAgents());
					//更新后台数据 role_id connect_type //agent_json
					var post_data={'role_id':'','con_type':'','agents':''}
					post_data.role_id=document.getElementById("cimport_frame").contentWindow.getRoleId();
					post_data.con_type=document.getElementById("cimport_frame").contentWindow.getConType();
					post_data.agents=$.toJSON(document.getElementById("cimport_frame").contentWindow.getSelectedAgents());
					
					//更新数据
					$.post(document.getElementById("cimport_frame").contentWindow.getAajxUrl(), post_data,function(res){
						var json_data=(res);   
					});	
							
				}			
			}
		}
	};
	
	$.prompt(statesdemo);
		
 });
});
