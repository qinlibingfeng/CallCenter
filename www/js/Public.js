
// JScript 文件
/*******************************************************
  名称：
********************************************************/
function onNotifyMessages(){
	$.jGrowl.defaults.position='bottom-right';	
	$.jGrowl("Hello world!");
}
/********************************************************
  名称:ChangeStyle(obj,Value)
  功能:改变class
  作者:dongqiliang@gmail.com
********************************************************/
function ChangeStyle(obj,Value){
    if(obj.select!="Y"){
        obj.className=Value;   
    } 
}

/********************************************************
  名称:RowClick(obj,Value1,Value2)
  功能:单击选中改背景颜色

  作者:dongqiliang@gmail.com
********************************************************/
function RowClick(obj,Value1,Value2){

    for(var i=0;i<obj.parentNode.rows.length;i++){
        obj.parentNode.rows[i].className=Value2;
        obj.parentNode.rows[i].select="N";
    }
    obj.className=Value1;
    obj.select="Y";        
       
}

/********************************************************
  名称:RowSelect(obj)
  功能:单击选中记录
  作者:dongqiliang@gmail.com
********************************************************/
function RowSelect(obj){
    document.getElementById("ctl00_Contentplaceholder3_selected").value=obj.cells[0].innerText;

}

/********************************************************
  名称:delCheck()
  功能:删除记录验证
  作者:dongqiliang@gmail.com
********************************************************/
function delCheck(){
    if(document.getElementById("ctl00_Contentplaceholder3_selected").value=="")
    {
        //alert("请选择要删除的记录!");
        //showPopup("请选择要删除的记录!");
        showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择要删除的记录！');
        return false;
    }
    else
    {
        return confirm("您确认要删除此记录?");
    }
}

/********************************************************
  名称:editCheck()
  功能:修改记录验证
  作者:dongqiliang@gmail.com
********************************************************/
function editCheck(){
    if(document.getElementById("ctl00_Contentplaceholder3_selected").value=="")
    {
        alert("请选择要修改的记录!");
        return false;
    }
    else
    {
        return true;
    }
}

/********************************************************
  名称:SubmitCheck()
  功能:提交记录验证
  作者:dongqiliang@gmail.com
********************************************************/
function SubmitCheck(){
    if(document.getElementById("ctl00_Contentplaceholder3_selected").value=="")
    {
        showInfo('ctl00_Contentplaceholder2_ValidationSummary1', 1, '请选择要提交的记录！');
        return false;
    }
    else
    {
        return true;
    }
}

/********************************************************
  名称:DoCheck()
  功能:处理记录验证
  作者:dongqiliang@gmail.com
********************************************************/
function DoCheck(){
    if(document.getElementById("ctl00_Contentplaceholder3_selected").value=="")
    {
        alert("请选择要操作的记录!");
        return false;
    }
    else
    {
        return true;
    }
}

/********************************************************
  名称:popHelpTable(Tbl,BHColu,MCColu,sqlWhere)
  功能:弹出帮助表格选项
  作者:dongqiliang@gmail.com
********************************************************/
function popHelpTable(obj, Tbl, BHColu, MCColu, sqlWhere, type, root) {
    if (type == 3) {
        var vsURL = "../../Public/MHelpTable.aspx?TBL=" + Tbl + "&BHCOLU=" + BHColu + "&MCCOLU=" + MCColu + "&WHERE=" + sqlWhere + "&TYPE=" + type + "&root=" + root;
        //alert(vsURL);
        var vsMSG = window.showModalDialog(vsURL, "", "dialogWidth=320px;dialogHeight=400px;center=yes;status=no;scroll=no;");
        if (!vsMSG) return false;

        if (typeof (vsMSG).x2 == "undefined") return false;
        var x2Str = vsMSG.x2;
    }
    else {
        var vsURL = "../../Public/HelpTable.aspx?TBL=" + Tbl + "&BHCOLU=" + BHColu + "&MCCOLU=" + MCColu + "&WHERE=" + sqlWhere + "&TYPE=" + type + "&root=" + root;
        //alert(vsURL);
        var vsMSG = window.showModalDialog(vsURL, "", "dialogWidth=320px;dialogHeight=400px;center=yes;status=no;scroll=no;");
        if (!vsMSG) return false;
      
        if (typeof (vsMSG).x2 == "undefined") return false;
        var x2Str = vsMSG.x2;
        x2Str = x2Str.substring(x2Str.lastIndexOf("├") + 1, x2Str.length);
        x2Str = x2Str.substring(x2Str.lastIndexOf("─") + 1, x2Str.length);
    }
	document.getElementById(obj+"1").value=vsMSG.x1;
    document.getElementById(obj).value=x2Str;
}

/********************************************************
  名称:popHelpTable_p(Tbl,BHColu,MCColu,sqlWhere)
  功能:弹出帮助表格选项
  作者:dongqiliang@gmail.com
********************************************************/
function popHelpTable_p(obj,Tbl,BHColu,MCColu,sqlWhere,type){
    var vsURL="../../Public/PersonTable.aspx?TBL="+Tbl+"&BHCOLU="+BHColu+"&MCCOLU="+MCColu+"&WHERE="+sqlWhere+"&TYPE="+type;
	//alert(vsURL);
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=320px;dialogHeight=400px;center=yes;status=no;scroll=no;");
	if (!vsMSG) return false;
	if(typeof(vsMSG).x2=="undefined") return false;
	document.getElementById(obj+"1").value=vsMSG.x1
    document.getElementById(obj).value=vsMSG.x2
}
/********************************************************
名称:popFileUpload(Tbl,BHColu,MCColu,sqlWhere)
功能:弹出上传页面
作者:dongqiliang@gmail.com
********************************************************/
function popFileUpload(obj) {
    var vsURL = "/Public/SwfUpload/Default.aspx";
    //alert(vsURL);
    var vsMSG = window.showModelessDialog(vsURL, "", "dialogWidth=320px;dialogHeight=50px;center=yes;status=no;scroll=no;");
    if (!vsMSG) return false;
    if (typeof (vsMSG).x2 == "undefined") return false;
//    document.getElementById(obj + "1").value = vsMSG.x1
//    document.getElementById(obj).value = vsMSG.x2
}
/********************************************************
  名称:popHelpTree(Tbl,BHColu,MCColu,sqlWhere)
  功能:弹出帮助树形选项
  作者:dongqiliang@gmail.com
********************************************************/
function popHelpTree(obj,Tbl,BHColu,MCColu,sqlWhere,type){
    var vsURL="../../Public/HelpTree.aspx?TBL="+Tbl+"&BHCOLU="+BHColu+"&MCCOLU="+MCColu+"&WHERE="+sqlWhere+"&TYPE="+type;
	alert(vsURL);
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=320px;dialogHeight=400px;center=yes;status=no;scroll=no;");
	if (!vsMSG) return false;
	if(typeof(vsMSG).x2=="undefined") return false;
	document.getElementById(obj+"1").value=vsMSG.x1
    document.getElementById(obj).value=vsMSG.x2
}

/********************************************************
  名称:popRoleTree()
  功能:弹出权限树形选项
  作者:dongqiliang@gmail.com
********************************************************/
function popRoleTree(obj1,obj2,strMENU,strMK){
    var vsURL="../../Public/RoleTree.aspx?menu=" + strMENU + "&mk=" + strMK;
    //alert(vsURL);
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=320px;dialogHeight=400px;center=yes;status=no;scroll=no;");
	if (!vsMSG) return false;
	if(typeof(vsMSG).x2=="undefined") return false;
	document.getElementById(obj1).value=vsMSG.x1
    document.getElementById(obj2).value=vsMSG.x2
}

/********************************************************
  名称:popRoleTree()
  功能:弹出部门树形选项
  作者:dongqiliang@gmail.com
********************************************************/
function popUserTree(obj1,obj2,personId,personName){
    var vsURL="../../Public/UserTree.aspx?pname=" + personId + "&pid=" + personName;
    //alert(vsURL);
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=430px;dialogHeight=260px;center=yes;status=no;scroll=auto;");
	if (!vsMSG) return false;
	if(typeof(vsMSG).x2=="undefined") return false;
	document.getElementById(obj1).value=vsMSG.x1
    document.getElementById(obj2).value=vsMSG.x2
}

/********************************************************
  名称:Exit()
  功能:系统退出

  作者:dongqiliang@gmail.com
********************************************************/
function Exit(){
    if( confirm('真的要退出?') ){
       
        parent.location.href='Login.aspx'
        return false;
    }
    else
    {
        return false;
    }
}

/********************************************************
  名称:RowClick_M(obj,Value1,Value2)
  功能:单击选中改背景颜色

  作者:dongqiliang@gmail.com
********************************************************/
function RowClick_M(obj,Value1,Value2){

    if(obj.select!="Y")
    {
    obj.className=Value1;
    obj.select="Y";        
    }
    else
    {
    obj.className=Value2;
    obj.select="N";        
    }
    for(var i=0;i<obj.parentNode.rows.length;i++){
    if(obj.parentNode.rows[i].select=="N")
    {
        obj.parentNode.rows[i].className=Value2;
        obj.parentNode.rows[i].select="N";
    }
    }

       
}
/********************************************************
名称:RowSelect_M_H(obj)
功能:单击选中记录
作者:dongqiliang@gmail.com
********************************************************/
function RowSelect_M_H(obj) {
    document.getElementById("selected").value = "";
    document.getElementById("selectedMC").value = "";
    for (var i = 0; i < obj.parentNode.rows.length; i++) {
        var cb = obj.parentNode.rows[i].cells[0].getElementsByTagName("input");
        var cb2 = obj.parentNode.rows[i].cells[2];

        if (obj.parentNode.rows[i].select == "Y") {
            document.getElementById("selected").value = document.getElementById("selected").value + cb[0].value + "|";
            document.getElementById("selectedMC").value = document.getElementById("selectedMC").value + cb2.innerHTML + ",";
            cb[0].checked = true;

        }
        else {
            if (cb[0] != null) {
                cb[0].checked = false;
            }
//            //    document.getElementById("Checkbox1").checked=false;
        }
    }
    var tmpStr = document.getElementById("selected").value;
    document.getElementById("selected").value = tmpStr.substring(0, tmpStr.length - 1);
    var tmpStrMC = document.getElementById("selectedMC").value;
    document.getElementById("selectedMC").value = tmpStrMC.substring(0, tmpStrMC.length - 1);

}
/********************************************************
  名称:RowSelect_M(obj)
  功能:单击选中记录
  作者:dongqiliang@gmail.com
********************************************************/
function RowSelect_M(obj){
document.getElementById("ctl00_Contentplaceholder3_selected").value="";
   for(var i=0;i<obj.parentNode.rows.length;i++){
   var cb=obj.parentNode.rows[i].cells[0].getElementsByTagName("input");
   
    if(obj.parentNode.rows[i].select=="Y")
    {
        document.getElementById("ctl00_Contentplaceholder3_selected").value=document.getElementById("ctl00_Contentplaceholder3_selected").value+cb[0].value+",";
        cb[0].checked=true;

    }
    else
    {
    cb[0].checked=false;
//    document.getElementById("Checkbox1").checked=false;
    }
    }
    var tmpStr=document.getElementById("ctl00_Contentplaceholder3_selected").value;
    document.getElementById("ctl00_Contentplaceholder3_selected").value=tmpStr.substring(0,tmpStr.length-1);
    
}

/********************************************************
  名称:RowSelect_ALL(obj)
  功能:单击选中记录
  作者:dongqiliang@gmail.com
********************************************************/
function RowSelect_ALL(obj){
document.getElementById("ctl00_Contentplaceholder3_selected").value="";

if(document.getElementById("cbSelectAll").checked!=true)
{
   for(var i=1;i<obj.parentNode.parentNode.rows.length;i++)
   {
        var cb=obj.parentNode.parentNode.rows[i].cells[0].getElementsByTagName("input");
        cb[0].checked=true;
        document.getElementById("ctl00_Contentplaceholder3_selected").value=document.getElementById("ctl00_Contentplaceholder3_selected").value+cb[0].value+",";
        obj.parentNode.parentNode.rows[i].className="c3";
        obj.parentNode.parentNode.rows[i].select="Y";
        document.getElementById("cbSelectAll").checked=true;

    }
        var tmpStr=document.getElementById("ctl00_Contentplaceholder3_selected").value;
    document.getElementById("ctl00_Contentplaceholder3_selected").value=tmpStr.substring(0,tmpStr.length-1);
}
else
{
   for(var i=1;i<obj.parentNode.parentNode.rows.length;i++)
   {
        var cb=obj.parentNode.parentNode.rows[i].cells[0].getElementsByTagName("input");

        document.getElementById("ctl00_Contentplaceholder3_selected").value=document.getElementById("ctl00_Contentplaceholder3_selected").value+cb[0].value+",";
        cb[0].checked=false;
        document.getElementById("cbSelectAll").checked=false;
        obj.parentNode.parentNode.rows[i].className="c1";
        obj.parentNode.parentNode.rows[i].select="N";
    }
    document.getElementById("ctl00_Contentplaceholder3_selected").value="";
}

}

/********************************************************
  名称:popUpload(obj)
  功能:弹出上传页面
  作者:dongqiliang@gmail.com
********************************************************/
function popUpload(obj){
    var vsURL="../../Public/popUpload.aspx?picPath=" + document.getElementById(obj).value;
	//alert(vsURL);
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=320px;dialogHeight=140px;center=yes;status=no;scroll=no;");
	if (!vsMSG) return false;
	if(typeof(vsMSG)=="undefined") return false;
    document.getElementById(obj).value=vsMSG.trim();
}

/********************************************************
  名称:showForm(id,imgID)
  功能:显示/隐藏菜单
  作者:dongqiliang@gmail.com
********************************************************/
function showForm(id,imgID)
{
    var len= arguments.length
    if(len==1)
    {
    if(document.getElementById(id).style.display=="none")
	{
		document.getElementById(id).style.display="";
		document.getElementById("pic").src="../../images/down.gif";		
	}
	else
	{
		document.getElementById(id).style.display="none";	
		document.getElementById("pic").src="../../images/up.gif";
	}
	}
	else
	{
	if(document.getElementById(id).style.display=="none")
	{
		document.getElementById(id).style.display="";
		document.getElementById(imgID).src="../../images/down.gif";		
	}
	else
	{
		document.getElementById(id).style.display="none";	
		document.getElementById(imgID).src="../../images/up.gif";
	}
	}
}
/********************************************************
  名称:showFormN(id)
  功能:显示/隐藏菜单
  作者:dongqiliang@gmail.com
********************************************************/
function showFormN(id,img)
{
	if(document.getElementById(id).style.display=="none")
	{
		document.getElementById(id).style.display="";
		document.getElementById(img).src="../../images/down.gif";		
	}
	else
	{
		document.getElementById(id).style.display="none";	
		document.getElementById(img).src="../../images/up.gif";
	}
	
}
/********************************************************
  名称:showForm_pop(id)
  功能:显示/隐藏菜单
  作者:dongqiliang@gmail.com
********************************************************/
function showForm_pop(id,img)
{
	if(document.getElementById(id).style.display=="none")
	{
		document.getElementById(id).style.display="";
		document.getElementById(img).src="../images/down.gif";		
	}
	else
	{
		document.getElementById(id).style.display="none";	
		document.getElementById(img).src="../images/up.gif";
	}
	
}

/********************************************************
  名称:popSchool(obj)
  功能:显示选择学校弹出框

  作者:dongqiliang@gmail.com
********************************************************/
function popSchool(obj)
{
     var vsURL="../../Public/popSchool.aspx";
	//alert(vsURL);
//	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=500px;dialogHeight=400px;center=yes;status=no;scroll=no;");
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=510px;dialogHeight=435px;center=yes;status=no;scroll=no;");

	if (!vsMSG) return false;
	if(typeof(vsMSG).x2=="undefined") return false;
	var x2Str = vsMSG.x2;
	x2Str = x2Str.substring(x2Str.lastIndexOf("├")+1, x2Str.length);
	x2Str = x2Str.substring(x2Str.lastIndexOf("─")+1, x2Str.length);
	document.getElementById(obj+"1").value=vsMSG.x1;
    document.getElementById(obj).value=x2Str;
}

/********************************************************
  名称:popClass(obj)
  功能:显示选择学校弹出框

  作者:dongqiliang@gmail.com
********************************************************/
function popClass(obj1,id,grade)
{
     var vsURL="../../Public/popClass.aspx";
     if(id!="")
     {
        vsURL="../../Public/popClass.aspx?id=" + id;
     }
     if(grade != "")
     {
        vsURL= vsURL+"&grade=" + grade;
     }
     
	//alert(vsURL);
//	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=500px;dialogHeight=400px;center=yes;status=no;scroll=no;");
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=510px;dialogHeight=435px;center=yes;status=no;scroll=no;");

	if (!vsMSG) return false;
	if(typeof(vsMSG).x2=="undefined") return false;
	var x2Str = vsMSG.x2;
	x2Str = x2Str.substring(x2Str.lastIndexOf("├")+1, x2Str.length);
	x2Str = x2Str.substring(x2Str.lastIndexOf("─")+1, x2Str.length);
	document.getElementById(obj1+"1").value=vsMSG.x1;
    document.getElementById(obj1).value=x2Str;
}
/********************************************************
  名称:popOSS(obj)
  功能:显示选择学校弹出框

  作者:dongqiliang@gmail.com
********************************************************/
function popOSS(obj)
{
     var vsURL="../../Public/popOSS.aspx";
	//alert(vsURL);
//	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=500px;dialogHeight=400px;center=yes;status=no;scroll=no;");
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=510px;dialogHeight=435px;center=yes;status=no;scroll=no;");

	if (!vsMSG) return false;
	if(typeof(vsMSG).x2=="undefined") return false;
	var x2Str = vsMSG.x2;
	x2Str = x2Str.substring(x2Str.lastIndexOf("├")+1, x2Str.length);
	x2Str = x2Str.substring(x2Str.lastIndexOf("─")+1, x2Str.length);
	document.getElementById(obj+"1").value=vsMSG.x1;
    document.getElementById(obj).value=x2Str;
}

/********************************************************
  名称:showInfo(obj,type,info)
  功能:显示操作信息

  作者:dongqiliang@gmail.com
********************************************************/
function showInfo(obj,type,info)
{

if(type==1)
{
    document.getElementById(obj).style.display='';
    document.getElementById(obj).innerHTML=info;
    document.getElementById(obj).style.backgroundImage ="url(../../images/i_warn.png)";
    }
    else
    {
    document.getElementById(obj).style.display='';
    document.getElementById(obj).innerHTML=info;
    document.getElementById(obj).style.backgroundImage = "url(../../images/ok.png)";
    dd=setInterval("document.getElementById('" +obj+ "').style.backgroundImage = 'url(../../images/i_warn.png)';document.getElementById('" + obj +"').style.display='none';clearInterval(dd);",2000);
    }
}
/********************************************************
  名称:popUsers(obj)
  功能:弹出部门树形选项
  作者:dongqiliang@gmail.com
********************************************************/
function popUsers(obj){
    var vsURL="../../Public/popUser.aspx";
    //alert(vsURL);
//	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=360px;dialogHeight=330px;center=yes;status=no;scroll=auto;");
	var vsMSG = window.showModalDialog(vsURL,"","dialogWidth=390px;dialogHeight=390px;center=yes;status=no;scroll=auto;");
	if (!vsMSG) return false;
	//alert(vsMSG.x2);
	if(typeof(vsMSG).x2=="undefined") return false;
	document.getElementById(obj+"1").value=vsMSG.x1;
    document.getElementById(obj).value=vsMSG.x2;
}

/********************************************************
  名称:setConnct(value)
  功能:设置是否接通

  作者:dongqiliang@gmail.com
********************************************************/
function setConnct(value){
	document.getElementById("ctl00_Contentplaceholder3_isConnect").value=value;
	document.getElementById("ctl00_Contentplaceholder3_isAccept").value="-1";
	document.getElementById("ctl00_Contentplaceholder3_NoConReason").value="-1";
	document.getElementById("ctl00_Contentplaceholder3_NoAccReason").value="-1";
	document.getElementById("ctl00_Contentplaceholder3_rblAccept_0").parentNode.disabled=false;
	document.getElementById("ctl00_Contentplaceholder3_rblAccept_1").parentNode.disabled=false;
	document.getElementById("ctl00_Contentplaceholder3_rblAccept_0").checked=false;
	document.getElementById("ctl00_Contentplaceholder3_rblAccept_1").checked=false;
	document.getElementById("ctl00_Contentplaceholder3_ddNoAcceptReason").options[0].selected = true ;
	document.getElementById("ctl00_Contentplaceholder3_ddNoAcceptReason").disabled=true;
	//alert(value);
    document.getElementById("ctl00_Contentplaceholder3_panelErrPhone").style.display='none';
    document.getElementById("ctl00_Contentplaceholder3_panelYY").style.display='none';

	if(value=="1")
	{
	    //未接通原因不可选

	    document.getElementById("ctl00_Contentplaceholder3_ddNoConnectReason").disabled=true;
	    document.getElementById("ctl00_Contentplaceholder3_ddNoConnectReason").options[0].selected = true ;
	    document.getElementById("ctl00_Contentplaceholder3_rblAccept_0").parentNode.disabled=false;
	    document.getElementById("ctl00_Contentplaceholder3_rblAccept_1").parentNode.disabled=false;
	    
	}
	else
	{   
	    //未接通原因可选

	    document.getElementById("ctl00_Contentplaceholder3_ddNoConnectReason").disabled=false;
	    document.getElementById("ctl00_Contentplaceholder3_rblAccept_0").parentNode.disabled=true;
	    document.getElementById("ctl00_Contentplaceholder3_rblAccept_1").parentNode.disabled=true;
	}
}

/********************************************************
  名称:setAccept(value)
  功能:设置是否接受
  作者:dongqiliang@gmail.com
********************************************************/
function setAccept(value){

	document.getElementById("ctl00_Contentplaceholder3_isAccept").value=value;
    document.getElementById("ctl00_Contentplaceholder3_NoAccReason").value="-1";
	//alert(value);
    document.getElementById("ctl00_Contentplaceholder3_panelErrPhone").style.display='none';
    document.getElementById("ctl00_Contentplaceholder3_panelYY").style.display='none';

	if(value=="1")
	{
	    //未接受原因不可选

        document.getElementById("ctl00_Contentplaceholder3_ddNoAcceptReason").disabled=true;
        document.getElementById("ctl00_Contentplaceholder3_ddNoAcceptReason").options[0].selected = true ;
	}
	else
	{   
	    //未接受原因可选

	    document.getElementById("ctl00_Contentplaceholder3_ddNoAcceptReason").disabled=false;
	}
}

/********************************************************
  名称:setNoConnectReason(value)
  功能:设置是否接受
  作者:dongqiliang@gmail.com
********************************************************/
function setNoConnectReason(value){

    document.getElementById("ctl00_Contentplaceholder3_NoConReason").value=value;

}

/********************************************************
  名称:setNoAcceptReason(value)
  功能:设置是否接受
  作者:dongqiliang@gmail.com
********************************************************/
function setNoAcceptReason(value){

    document.getElementById("ctl00_Contentplaceholder3_NoAccReason").value=value;
    

}

/********************************************************
  名称:ShowOtherPanel(value)
  功能:设置错号原因 及其预约时间的显示情况

  作者:dongqiliang@gmail.com
********************************************************/
function ShowOtherPanel(value)
{
    if(value == 0)
    {
        //panelErrPhone
        document.getElementById("ctl00_Contentplaceholder3_panelErrPhone").style.display='';
        document.getElementById("ctl00_Contentplaceholder3_panelYY").style.display="none";
        
    }
    else if (value == 2)
    {
        //panelYY
        document.getElementById("ctl00_Contentplaceholder3_panelErrPhone").style.display='none';
        document.getElementById("ctl00_Contentplaceholder3_panelYY").style.display='';

    }
    else
    {
        document.getElementById("ctl00_Contentplaceholder3_panelErrPhone").style.display='none';
        document.getElementById("ctl00_Contentplaceholder3_panelYY").style.display='none';
    }
}

/********************************************************
  名称:CallBillClientValidate(sender, args)
  功能:判断工单是否可以提交
  作者:dongqiliang@gmail.com
********************************************************/
function  CallBillClientValidate()
    {
        
        var value = "";
        var Conn = document.getElementsByName('ctl00$Contentplaceholder3$rblConnect');
        var Acce = document.getElementsByName('ctl00$Contentplaceholder3$rblAccept');
        var CallPhone=document.getElementById('ctl00_ContentPlaceHolder5_lbPhone').innerText;
        //alert(CallPhone);
        
        //检查电话

        if(CallPhone=="")
        {
            showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请填写拨打电话！');
            return false;
        }
        



        //检查接听状态

        for (var i =0; i< Conn.length ; i++)
        {
            if (Conn.item(i).checked)
            {
                value = Conn.item(i).value;
            }
        }
        if (value == "")
        {
            showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请填写接听状态！');
            return false;
        }
        else if (value == "0")//未接通

        {
            var ConnReason = document.getElementById('ctl00_Contentplaceholder3_ddNoConnectReason');
            if(ConnReason.options[ConnReason.selectedIndex].value == -1)
            {
                showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择未接通原因！');
                return false;
            }
            else
            {
                document.getElementById('ctl00_Contentplaceholder2_ValidationSummary1').style.display='none';
                return true;
            }
        }
        else//接通

        {
        
            //检查签字人 接听对象 
            var customer = document.getElementsByName('ctl00$Contentplaceholder3$rblCustomer');
            var cusValue = "";

            for (var i =0; i< customer.length ; i++)
            {
                if (customer.item(i).checked)
                {
                    cusValue = customer.item(i).value;
                }
            }
            if (cusValue == "")
            {
                showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择接听对象！');
                return false;
            }
            
            value ="";
            
            for (var i =0; i< Acce.length ; i++)
            {
                if (Acce.item(i).checked)
                {
                    value = Acce.item(i).value;
                }
            }
            
            if (value == "")
            {
                showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择是否接受话访！');
                return false;
            }
            else if(value == "0")//未接受

            {
                var AcceReason = document.getElementById('ctl00_Contentplaceholder3_ddNoAcceptReason');
                
                //未选择
                if(AcceReason.options[AcceReason.selectedIndex].value == -1)
                {
                    showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择未接受话访的原因！');
                    return false;
                }
                //错号
                else if(AcceReason.options[AcceReason.selectedIndex].value == 0)
                {
                    var ErrPhoneReason = document.getElementById('ctl00_Contentplaceholder3_ddlErrPhone');
                    if(ErrPhoneReason.value == -1)
                    {
                        showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择错号的原因！');
                        return false;
                    }
                }
                //预约 
                else if(AcceReason.value == 2)
                {
                    var YYtime = document.getElementsByName('ctl00$Contentplaceholder3$rblYYtime');
                    var yyValue = "";
                    
                    for (var i =0; i< YYtime.length ; i++)
                    {
                        if (YYtime.item(i).checked)
                        {
                            yyValue = YYtime.item(i).value;
                        }
                    }
                    
                    if(yyValue == "")
                    {
                        showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择预约时间！');
                        return false;
                        
                    }
                    
                }
                //其他
                else
                {
                    document.getElementById('ctl00_Contentplaceholder2_ValidationSummary1').style.display='none';
                    
                }
                
            }
            else//接受
            {
                    var BusinessType = document.getElementsByName('ctl00$Contentplaceholder3$rblHFMadeType');
                    var BTValue = "";
                    
                    for (var i =0; i< BusinessType.length ; i++)
                    {
                        if (BusinessType.item(i).checked)
                        {
                            BTValue = BusinessType.item(i).value;
                        }
                    }
                    
                    if(BTValue == "")
                    {
                        showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择订制业务类型！');
                        return false;
                        
                    }
                    else if (BTValue == "4") //不定制

                    {
                        var NomadeReason = document.getElementById('ctl00_Contentplaceholder3_ddlHFnoMadeType');
                        if(NomadeReason.value == -1)
                        {
                            showInfo('ctl00_Contentplaceholder2_ValidationSummary1',1,'请选择不定制的原因！');
                            return false;
                        }
                    }
                    else
                    {
                        document.getElementById('ctl00_Contentplaceholder2_ValidationSummary1').style.display='none';
                    }
                    
            }
            
            return true;
        } 
    }
    
    
/********************************************************
  名称:BusinessControl(obj,str)
  功能:修改现有业务
  作者:dongqiliang@gmail.com
********************************************************/
    function BusinessControl(obj,str)
    {
    try{
        if(obj.value=="退订")
        {
            for(var i=0;i<obj.parentNode.parentNode.cells.length-1;i++)
            {
                obj.parentNode.parentNode.cells[i].disabled=true;
            }
            obj.value="取消";
            obj.parentNode.parentNode.title=str+",0";
        }
        else
        {
            for(var i=0;i<obj.parentNode.parentNode.cells.length-1;i++)
            {
                obj.parentNode.parentNode.cells[i].disabled=false;
            }
            obj.value="退订";
            obj.parentNode.parentNode.title="";
        }
        
        //构建sql语句
        document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value="";
        for(var i=0;i<obj.parentNode.parentNode.parentNode.rows.length;i++)
        {
            if(obj.parentNode.parentNode.parentNode.rows[i].title!="")
            {
                document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value+obj.parentNode.parentNode.parentNode.rows[i].title+"|"
            }
        
        }
        if(document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.length>0)
        {
            var l=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.lenght;
            document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.substring(0,l-1);
        }
        
      }
      finally
      {
        
        return false;
        
      }
    }
    
  /********************************************************
  名称:BusinessAdd()
  功能:添加业务
  作者:dongqiliang@gmail.com
********************************************************/
  function BusinessAdd()
  {
        //验证是否选择签字人和定制类型
        var CallTypeValue = "";
        var Conn = document.getElementsByName('ctl00$Contentplaceholder3$rblCustomer');
        for (var i =0; i< Conn.length ; i++)
        {
            if (Conn.item(i).checked)
            {
                CallTypeValue = Conn.item(i).value;
            }
        }
        if(CallTypeValue == "")
        {
            alert("请选择接听对象！");
            return;
        }
        
        var MadeTypeValue = "";
        var objMadeType = document.getElementsByName('ctl00$Contentplaceholder3$rblHFMadeType');
        for (var i =0; i< objMadeType.length ; i++)
        {
            if (objMadeType.item(i).checked)
            {
                MadeTypeValue = objMadeType.item(i).value;
            }
        }
        if(MadeTypeValue == "")
        {
            alert("请选择定制类型！");
            return;
        }

        
//   20080927 肖坤修改
//        if( document.getElementById('ctl00_Contentplaceholder3_rblCustomer').value == "-1")
//        {
//            alert("请选择接听对象！");
//            return ;
//        }

//    rblHFMadeType    
//        if( document.getElementById('ctl00_Contentplaceholder3_ddMadeType').value == "-1")
//        {
//            alert("请选择订制类型！");
//            return ;
//        }       
        document.getElementById("ctl00_Contentplaceholder3_hidB1").value="";
        popHelpTable('ctl00_Contentplaceholder3_hidB','BUSINESSINFO','BUSINESSINFO_ID','BUSINESSINFO_NAME','','0');
        if(document.getElementById("ctl00_Contentplaceholder3_hidB1").value!="")
        {
            var newTr = document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").insertRow();
            var newTd0 = newTr.insertCell();
            var newTd1 = newTr.insertCell();
            var newTd2 = newTr.insertCell();
            var newTd3 = newTr.insertCell();
            var newTd4 = newTr.insertCell();
            newTr.title=document.getElementById("ctl00_Contentplaceholder3_hidB1").value+",1";
            newTd0.innerText = document.getElementById("ctl00_Contentplaceholder3_hidB").value; 
            newTd1.innerText= '提交时生成';
            newTd2.innerText = document.getElementById("hidUserid").value; 
            newTd3.innerText= date2str(new   Date());
            newTd4.innerHTML= "<input type='button' value='删除' onclick='BusinessDel(this);' class='btn'/>";     
            //构建sql语句
            document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value="";
            for(var i=0;i<document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows.length;i++)
            {
                if(document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows[i].title!="")
                {
                    document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value+document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows[i].title+"|"
                }
            
            }
            
            if(document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.length>0)
            {
                var l=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.length;
                document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.substring(0,l-1);
            }
            
            if(document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows[0].cells[0].colSpan=="5")
            {
                document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows[0].removeNode(true);
            }
            
             //alert(document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value);
        }
  }
  
/********************************************************
  名称:BusinessDel(obj)
  功能:删除业务
  作者:dongqiliang@gmail.com
********************************************************/
  function BusinessDel(obj)
  {
    //document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").deleteRow(obj.parentNode.parentNode.index);
    obj.parentNode.parentNode.removeNode(true);
    //构建sql语句
    document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value="";
    for(var i=0;i<document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows.length;i++)
    {
        if(document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows[i].title!="")
        {
            document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value+document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows[i].title+"|"
        }

    }

    if(document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.length>0)
        {
            var l=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.length;
            document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value=document.getElementById("ctl00_Contentplaceholder3_hidBusinessSql").value.substring(0,l-1);
        }
        
    if(document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").rows.length==0)
    {
        var newTr = document.getElementById("ctl00_Contentplaceholder3_gvOrderInfo").insertRow();
        var newTd0 = newTr.insertCell();
        newTd0.innerText="没有订制任何服务。。。";
        newTd0.colSpan="5";
    }    
  }
  
/********************************************************
  名称:date2str(d)
  功能:获取当前的时间

  作者:dongqiliang@gmail.com
********************************************************/
  function date2str(d){   
      var ret=d.getFullYear()+"-"   
          ret+=("00"+(d.getMonth()+1)).slice(-2)+"-"   
          ret+=("00"+d.getDate()).slice(-2)+" "   
          ret+=("00"+d.getHours()).slice(-2)+":"   
          ret+=("00"+d.getMinutes()).slice(-2)+":"   
          ret+=("00"+d.getSeconds()).slice(-2)   
      return   ret
  }

  function checkRadioList(name) {
      var vRbtid = document.getElementById(name);
      //得到所有radio

      var vRbtidList = vRbtid.getElementsByTagName("INPUT");
      for (var i = 0; i < vRbtidList.length; i++) {
          if (vRbtidList[i].checked) {
              var text = vRbtid.cells[i].Url;
              var value = vRbtidList[i].value;
              CheckUrl(value);
          }
      }
  }
     
 

      function checkRadioListU(name) {
          var vRbtid = document.getElementById(name);
          //得到所有radio

          var vRbtidList = vRbtid.getElementsByTagName("INPUT");
          for (var i = 0; i < vRbtidList.length; i++) {
              if (vRbtidList[i].checked) {
                  var text = vRbtid.cells[i].Url;
                  var value = vRbtidList[i].value;
                  checkUser(value);
              }
          }
      }
  
  
  function veiw_notice(n_id){var diag=new Dialog("diag_Info_"+n_id);diag.Width=620;diag.Height=360;diag.Title="查看公告";diag.isModal=false;diag.URL="/document/notice/view_notice.php?action=&cid="+n_id;diag.show();diag.onLoad = function(){};diag.OKButton.hide();diag.CancelButton.value="关 闭";};

function c_field_list(file_type){$("#file_type").val(file_type);var diag=new Dialog("diag_get_fields_list");diag.Width=480;diag.Height=240;diag.Title="选择详单导出字段";diag.URL="/document/report/list.php?action=get_fields_list&tits="+encodeURIComponent("选择详单导出字段");diag.onLoad = function(){};diag.OKEvent=set_fields_list;diag.show()}function set_fields_list(){Zd_DW.do_set_fields_list()}

function c_agent_list(actions){var diag=new Dialog("diag_agent_list");diag.Width=680;diag.Height=360;diag.Title="选择坐席工号";diag.URL="/document/report/list.php?action=get_agent_list&tits="+encodeURIComponent("选择坐席工号");diag.onLoad = function(){};diag.OKEvent=set_agent_list;diag.show()}function set_agent_list(){Zd_DW.do_set_agent_list()}
  
function c_task_list(){var diag=new Dialog("diag_campaign_id");diag.Width=680;diag.Height=360;diag.Title="选择业务活动";diag.URL="/document/report/list.php?action=get_task_list&tits="+encodeURIComponent("选择业务活动");diag.onLoad = function(){};diag.OKEvent=set_task_list;diag.show()}function set_task_list(){Zd_DW.do_set_task_list()}
 
function c_status_list(){var diag=new Dialog("diag_status_list");diag.Width=540;diag.Height=280;diag.Title="选择营销结果";diag.URL="/document/report/list.php?action=get_status_list&tits="+encodeURIComponent("选择营销结果");diag.onLoad = function(){};diag.OKEvent=set_status_list;diag.show()}function set_status_list(){Zd_DW.do_set_status_list()}

function c_call_status_list(){var diag=new Dialog("diag_call_status_list");diag.Width=540;diag.Height=280;diag.Title="选择呼叫结果";diag.URL="/document/report/list.php?action=get_call_status_list&tits="+encodeURIComponent("选择呼叫结果");diag.onLoad = function(){};diag.OKEvent=set_call_status_list;diag.show()}function set_call_status_list(){Zd_DW.do_set_call_status_list()}

function c_quality_status_list(){var diag=new Dialog("diag_quality_status_list");diag.Width=460;diag.Height=220;diag.Title="选择质检结果";diag.URL="/document/report/list.php?action=get_quality_status_list&tits="+encodeURIComponent("选择质检结果");diag.onLoad = function(){};diag.OKEvent=set_quality_status_list;diag.show()}function set_quality_status_list(){Zd_DW.do_set_quality_status_list()}

function c_quality_user_list(){var diag=new Dialog("diag_quality_user_list");diag.Width=540;diag.Height=280;diag.Title="选择质检人员";diag.URL="/document/report/list.php?action=get_quality_user_list&tits="+encodeURIComponent("选择质检人员");diag.onLoad = function(){};diag.OKEvent=set_quality_user_list;diag.show()}function set_quality_user_list(){Zd_DW.do_set_quality_user_list()}

jQuery.fn.floatdiv=function(location){var isIE6=false;var Sys={};var ua=navigator.userAgent.toLowerCase();var s;(s=ua.match(/msie ([\d.]+)/))?Sys.ie=s[1]:0;if(Sys.ie&&Sys.ie=="6.0"){isIE6=true}var windowWidth,windowHeight;if(self.innerHeight){windowWidth=self.innerWidth;windowHeight=self.innerHeight}else if(document.documentElement&&document.documentElement.clientHeight){windowWidth=document.documentElement.clientWidth;windowHeight=document.documentElement.clientHeight}else if(document.body){windowWidth=document.body.clientWidth;windowHeight=document.body.clientHeight}return this.each(function(){var loc;var wrap=$("<div></div>");var top=-1;loc=location;var str=loc.top;if(typeof(str)!='undefined'){str=str.replace("px","");top=str}if(isIE6){if(top>=0){wrap=$("<div style=\"top:expression(documentElement.scrollTop+"+top+");\"></div>")}else{wrap=$("<div style=\"top:expression(documentElement.scrollTop+documentElement.clientHeight-this.offsetHeight);\"></div>")}}$("body").append(wrap);wrap.css(loc).css({position:"fixed",z_index:"999"});if(isIE6){wrap.css("position","absolute");$("body").css("background-attachment","fixed").css("background-image","url(1.txt)")}$(this).appendTo(wrap)})};
  
$(document).ready(function(){$(".dataTable tbody tr").hover(function(){$(this).addClass("over")},function(){$(this).removeClass("over")});$(".dataTable tbody tr:odd").addClass("alt");$("#page").removeClass("over");$(":input[type='text'],:input[type='password']").addClass("inputText").hover(function(){if($(this).hasClass("input_focus")==false){$(this).addClass("inputTextHover")}},function(){$(this).removeClass("inputTextHover")}).focus(function(){$(this).removeClass("inputText inputTextHover input_focus").addClass("input_focus")}).blur(function(){$(this).addClass("inputText").removeClass("input_focus inputTextHover")});$(":input[type='file']").addClass("inputFile");$(":input[type='image']").addClass("inputImage");$(":input[type='submit'],:input[type='reset'],:input[type='button']").addClass("inputButton").attr("hidefocus","true").wrap("<a href='javascript:void(0);' class='zInputBtn' hidefocus='true' tabindex='-1'></a>").bind('focus',function(){if(this.blur){this.blur();};});});
  
function d_table_i(){$(".dataTable tbody tr").removeClass().hover(function(){$(this).addClass("over")},function(){$(this).removeClass("over")});$(".dataTable tbody tr:odd").addClass("alt");$("[name=c_id]:checkbox:enabled").bind("click",function(){var parent=$(this).parent().parent();if($(this).attr("checked")==true){$(parent).addClass("click")}else{$(parent).removeClass("click")}})};
 
function show_div(elm){$("#"+elm).toggle();};

function file_down(url,names){location.href="/document/plugin/down.php?paths="+encodeURIComponent(url)+"&names="+encodeURIComponent(names);}
//多选框级联
function CheckItemsAll(forms,pid){$('#'+forms+' :checkbox[parentId^='+pid+']').each(function(i){$(this).attr("checked",$('#'+pid).attr("checked"))})};function CheckItems(forms,pid,pid2){var ischecked=1;$('#'+forms+' :checkbox[parentId='+pid2+']').each(function(i){if(this.checked){ischecked+=1}});if($('#'+forms+' :checkbox[parentId^='+pid2+']').attr("checked")==true){ischecked+=1}else{ischecked-=1}if(ischecked>=1){ischecked=true}else{ischecked=false}$('#'+forms+' :checkbox[parentId='+pid+']').attr("checked",ischecked)};
//replace
String.prototype.replaceAll=function(s1,s2){return this.replace(new RegExp(s1,"gm"),s2);};
//日历层初始化
function days_ready(){var evt=window.event;Calendar.setup({inputField:"begintime",ifFormat:"%Y-%m-%d",timeFormat:"24"});Calendar.setup({inputField:"endtime",ifFormat:"%Y-%m-%d",timeFormat:"24"});};

function set_Calendar(){if($("#begintime").val()!=""&&$("#endtime").val()==""){$("#endtime").val($("#begintime").val())}if($("#begintime").val()==""&&$("#endtime").val()!=""){$("#begintime").val($("#endtime").val())}}
 
function ietruebody(){return(document.compatMode&&document.compatMode!="BackCompat")?document.documentElement:document.body};
function drag_(layer){$(layer+" div[drag='y']").mousedown(function(event){var offset=$(this).offset();_x=event.clientX-offset.left;_y=event.clientY-offset.top;$(layer).css({"top":offset.top+"px"});$(layer).mousemove(function(event){_xx=event.clientX-_x;_yy=event.clientY-_y;$(this).css({left:_xx+"px",top:_yy+"px"});return false});return false}).find("a:eq(0)").unbind("mouseup");$(layer).mouseup(function(){$(this).unbind("mousemove");return false});}
 
function play_wav(e,layer,wav){$("#"+layer).remove();var player_="",wav_src="";if(isIE){player_='<object classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95" name="wav_player" width="100%" height="44" align="absmiddle" id="wav_player"><param name="FileName" value="" /><param name="Volume" value="0"></object>';wav_src="FileName";}else{player_='<audio src="" controls="true" id="wav_player" type="audio/mpeg" autoplay="true" volume="0" width="100%" height="44"></audio>';wav_src="src";};$('<div class="pop_layer" id="'+layer+'" style="width:320px;"><div class="t_iframe"><iframe src="about:blank"></iframe></div><table border="0" cellpadding="0" cellspacing="0" class="pop_tb" id="pop_tb"><tr><td class="pop_t_l"></td><td class="pop_bor_t"><div class="tit_left" drag="y">收听录音&nbsp;&nbsp;<a href="" target="_blank" id="down_wav">下载</a></div><div class="tit_right"><a href="javascript:void(0);"title="关闭" onclick="stop_wav(\''+layer+'\');"></a></div></td><td class="pop_t_r"></td></tr><tr><td class="pop_bor_l"></td><td class="pop_con">'+player_+'</td><td class="pop_bor_r"></td></tr><tr><td class="pop_b_l"></td><td class="pop_bor_b"></td><td class="pop_b_r"></td></tr></table></div>').appendTo("body");$("#wav_player").attr(wav_src,wav);$("#down_wav").attr("href",wav);drag_("#"+layer);var offsetxpoint=16,offsetypoint=-10,ie=document.all,ns6=document.getElementById&&!document.all,enabletip=true;if(ie||ns6){var tipobj=document.all?document.all[layer]:document.getElementById?document.getElementById(layer):"";}if(enabletip){var curX=(ns6)?e.pageX:event.clientX+ietruebody().scrollLeft;var curY=(ns6)?e.pageY:event.clientY+ietruebody().scrollTop;var rightedge=ie&&!window.opera?ietruebody().clientWidth-event.clientX-offsetxpoint:window.innerWidth-e.clientX-offsetxpoint-20;var bottomedge=ie&&!window.opera?ietruebody().clientHeight-event.clientY-offsetypoint:window.innerHeight-e.clientY-offsetypoint;var leftedge=(offsetxpoint<0)?offsetxpoint*(-1):-1000;if(rightedge<tipobj.offsetWidth){tipobj.style.left=ie?ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px":window.pageXOffset+e.clientX-tipobj.offsetWidth+"px";}else if(curX<leftedge){tipobj.style.left="5px";}else{tipobj.style.left=curX+offsetxpoint+"px";}if(bottomedge<tipobj.offsetHeight){tipobj.style.top=ie?ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px":window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px";}else{tipobj.style.top=curY+offsetypoint+"px";tipobj.style.visibility="visible";}}};
function show_now(objN){$(".shows").css("display","none");$("#"+objN).toggle()};
function stop_wav(layer){if(isIE){$("#wav_player").attr("FileName","");}$("#"+layer).remove();};
//保存结果提示
function request_tip(tip,is_yes,times){if(times==""||times==null){times=4300}$('#auto_save_res').html(tip).css({top:$(document).scrollTop(),right:($(document).width()-$('#auto_save_res').outerWidth())/2}).fadeIn("slow");if(is_yes=="1"){$('#auto_save_res').removeClass("red_layer").addClass("green_layer")}else{$('#auto_save_res').removeClass("green_layer").addClass("red_layer")}setTimeout("$('#auto_save_res').fadeOut('fast');",times)};

function goto_anchor(rel){if($("#"+rel).length>0){var _pos=$("#"+rel).offset().top-10;$("html,body").animate({scrollTop:_pos},800)}} 
//显示知识库
function ShowHelp(){if(parent.document.getElementById("MainFrame").getAttribute("cols")!="174,8,*,260"){window.parent.parent.window.frames['faq'].location.href='/help.asp';parent.document.getElementById("MainFrame").setAttribute("cols","174,8,*,260");document.all["helplink"].innerHTML="关闭知识库"}else{parent.document.getElementById("MainFrame").setAttribute("cols","174,8,*,0");document.all["helplink"].innerHTML="查看知识库"}};
//动态分页
function Gotopage(page,pagesize){page=parseInt(page);if(page){get_datalist(page,$("#a_ctions").val(),"list",pagesize)}};function max_pages(pagesize){var counts=$("#recounts").val(),pagesize=$("#pagesize").val(),pages="";if(pagesize==counts){pages=Math.ceil(counts/pagesize)}else if(Math.ceil(counts/pagesize)==0&&counts>0){pages=Math.ceil(counts/pagesize)+1}else{pages=Math.ceil(counts/pagesize)}$("#pagecounts").val(pages)};
function OutputHtml(page,pagesize){if(pagesize==""){pagesize=$("#pagesize").val()}if(page=="")page=1;var counts=$("#recounts").val(),pages=$("#pagecounts").val();if(parseInt(page)<1||parseInt(page)=="")page=1;if(parseInt(page)>parseInt(pages)){page=pages};if(!(parseInt(page)<=parseInt(pages)))page=pages;var Temp="",BeginNO="";if(pagesize==counts){BeginNO=(page-1)*pagesize}else{BeginNO=(page-1)*pagesize+1}var EndNO=page*pagesize;if(EndNO>counts)EndNO=counts;if(EndNO==0)BeginNO=0;$("#total").html("总数:<strong >"+counts+"</strong>&nbsp;&nbsp;显示:<strong >"+BeginNO+"-"+EndNO+"</strong>&nbsp;&nbsp;共:<strong >"+pages+"</strong>页");if(page>1&&page!==1){Temp="<a href='javascript:void(0)' onclick='Gotopage(1,"+pagesize+")'>第一页</a> <a href='javascript:void(0)' onclick='Gotopage("+(page-1)+","+pagesize+")'>上一页</a>&nbsp;"}else{Temp="第一页 上一页&nbsp;"};var pageFrontSum=3,pageBackSum=3;var pageFront=parseInt(pageFrontSum)-parseInt(parseInt(page)-1);var pageBack=parseInt(pageBackSum)-parseInt(parseInt(pages)-parseInt(page));if(parseInt(pageFront)>0&&parseInt(pageBack)<0)pageBackSum+=parseInt(pageFront);if(parseInt(pageBack)>0&&parseInt(pageFront)<0)pageFrontSum+=parseInt(pageBack);var pageFrontBegin=parseInt(page)-parseInt(pageFrontSum);if(parseInt(pageFrontBegin)<1)pageFrontBegin=1;var pageFrontEnd=parseInt(page)+parseInt(pageBackSum);pageFrontEnd=parseInt(pageFrontEnd);pages=parseInt(pages);page=parseInt(page);pageFrontBegin=parseInt(pageFrontBegin);if(pageFrontEnd>pages)pageFrontEnd=pages;if(pageFrontBegin!=1)Temp+='<a href="javascript:void(0)" onclick="Gotopage('+(page-10)+','+pagesize+')" title="前10页">..</a>';for(var i=pageFrontBegin;i<page;i++){Temp+=" <a href='javascript:void(0)' onclick='Gotopage("+i+","+pagesize+")'>"+i+"</a>"}Temp+="<strong>&nbsp;"+page+"</strong>";for(var i=page+1;i<=pageFrontEnd;i++){Temp+=" <a href='javascript:void(0)' onclick='Gotopage("+i+","+pagesize+")'>"+i+"</a>"}if(pageFrontEnd!=pages)Temp+=" <a href='javascript:void(0)' onclick='Gotopage("+(page+10)+","+pagesize+")' title='后10页'>..</a>";if(page!=pages){Temp+="&nbsp;&nbsp;<a href='javascript:void(0)' onclick='Gotopage("+(page+1)+","+pagesize+");'>下一页</a> <a href='javascript:void(0)' onclick='Gotopage("+pages+","+pagesize+")'>最末页</a>"}else{Temp+="&nbsp;&nbsp;下一页 最末页"}$("#pagelist").html(Temp+"&nbsp;&nbsp;转到第：<input type='text' name='goto_page' id='goto_page' maxlength='16' size='2' onKeyUp=\"if(isNaN(value))execCommand('undo')\" onafterpaste=\"if(isNaN(value))execCommand('undo')\"/> 页 <a class='zInputBtn' hidefocus='true' href='javascript:void(0);'><input type=\"button\" name=\"goto_page_do\" id=\"goto_page_do\" value=\"跳转\"  onclick=\"Gotopage($('#goto_page').val(),"+pagesize+");\" class='inputButton'/></a>");if(EndNO==0){$("#pagelist").html("");return}document.onkeydown=function(e){var theEvent=window.event||e;var code=theEvent.keyCode||theEvent.which;if(code==37){if(page>1&&page!==1){Gotopage(page-1,pagesize)}}if(code==39){if(page!=pages){Gotopage(page+1,pagesize)}}};$("#pages").val(page);$("#goto_page").addClass("inputText").hover(function(){if($(this).hasClass("input_focus")==false){$(this).addClass("inputTextHover")}},function(){$(this).removeClass("inputTextHover")}).focus(function(){$(this).removeClass("inputText inputTextHover input_focus").addClass("input_focus")}).blur(function(){$(this).addClass("inputText").removeClass("input_focus inputTextHover")});};
 
//数据表排序
function Sorts_new(Tableid,id,pagesize){$("#sorts").val($("#"+id).attr("sort"));var cls=$("#"+id+" span")[0].className;if(cls.indexOf("_")>-1){$("#"+Tableid+" .dataHead th span").addClass("sorting");$("#"+id).addClass("thOver");$("#"+Tableid+" .dataHead th span").removeClass("sorting_asc sorting_desc");if(cls.indexOf("_asc")>-1){$("#"+id+" span").addClass("sorting_desc");$("#"+id+" span").removeClass("sorting_asc sorting");$("#order").val("desc")}else if(cls.indexOf("_desc")>-1){$("#"+id+" span").removeClass("sorting_desc sorting");$("#"+id+" span").addClass("sorting_asc");$("#order").val("asc")}else{$("#"+id+" span").addClass("sorting_asc");$("#"+id+" span").removeClass("sorting_desc sorting");$("#"+id).addClass("thOver");$("#order").val("asc")}}else{$("#"+Tableid+" .dataHead th span").removeClass("sorting_asc sorting_desc");$("#"+Tableid+" .dataHead th ").removeClass("thOver");$("#"+Tableid+" .dataHead th span").addClass("sorting");$("#"+id+" span").removeClass("sorting");$("#"+id+" span").addClass("sorting_asc");$("#"+id).addClass("thOver");$("#order").val("asc")}get_datalist(parseInt($("#pages").val()),$("#a_ctions").val(),"list",pagesize);};

$(document).ready(function(){
$('#cbSelectAll').toggle(function(){
		$(':checkbox[name="cbData"]').attr('checked',true);//打勾 
		$('td:parent').removeClass('c1');
		$('td:parent').addClass('c2');
	},function(){
		$('td>input:checkbox[name != "cbAll"]').attr('checked',false);
		$("td:parent").removeClass('c2');
		$('td:parent').addClass('c1');	
	});
	
	$('#bt_del').click(function(){
		var txt = '确定要删除吗?';	
		if(confirm(txt)){
			var data={};
					var i=0;
					//取要删除的列的Code数据
					$('input:checkbox[name="cbData"][checked=true]').each(function(){				
						//data.push($(this).parent().next().text());		
						data[i]=$(this).parent().next().html();
						i++;	
					});	
					
				  	//ajax清除后台数据
				  	$.post($('#bt_del_post_url').attr('value'), data,function(res){
						var json_data=(res);   
					});
				  	//删除选中的checkbox
					$('input:checkbox[name="cbData"][checked=true]').each(function(){				
						//data.push($(this).parent().next().text());		
						$(this).parent().parent().remove();	
					});
		}else{
		}	
	});
});