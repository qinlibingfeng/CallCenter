$(document).ready(function(){
	$('#process').click(function(){
		var data={'upload_file':''};
		data.upload_file=$('#upload_file').html();
		$.post('/CallCenter/index.php/client/process', data,function(res){
			alert(res.ok);
		});
	});
});


