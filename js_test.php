</html>
<head>
<script>
function onProxyEvent(type,msg){
  alert(msg);
}
function startConference(){
	alert(document.getElementById('agent').value);
	alert(document.getElementById('another').value);
	window.external.AgentNwayCallStart(document.getElementById('agent').value,document.getElementById('agent').value);

}
function inviteAnotherOne(){
	alert(document.getElementById('agent').value);
	alert(document.getElementById('another').value);
	window.external.AgentNwayCallAddOne(document.getElementById('agent').value,document.getElementById('another').value,document.getElementById('agent').value,"1183",60000)
}
</script>
</head>
<body>
agent:<input id='agent' type='text' value="1002"/>
anthor:<input id='another' type='text' value="1183"/>
<input type="button"  value='startConference' onClick="startConference()"/>
<input type="button" value="inviteAnotherOne" onClick="inviteAnotherOne()"/>
</body>
