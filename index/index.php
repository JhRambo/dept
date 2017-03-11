<html>
<head>
<title>  深信服科技内部论坛 - powered by phpwind.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="phpwind,forum,bbs,bulletin board,php,mysql,forums" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta http-equiv="Pragma" CONTENT="no-cache">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="深信服内部论坛." />
<base href="http://200.200.3.226/test/dept/index/" />
<style type="text/css">
body{
	scrollbar-base-color: ##2f5fa1;
	scrollbar-darkshadow-color: #ffffff;
	scrollbar-highlight-color: #ffffff;
	overflow:hidden;
	margin:0;
}
</style>
</head>
<script language=javascript>
function changewin(){
	var obj=document.getElementById('leftframe');
	var menu=document.getElementById('menuswitch');
	if(obj.style.display=='none'){
		obj.style.display='';
		menu.innerHTML = "<img src=\"img/left_close.gif\" style=\"cursor:pointer;\">";
	}else{
		obj.style.display='none';
		menu.innerHTML = "<img src=\"img/left_open.gif\" style=\"cursor:pointer;\">";
	}
}
</script>
<body vlink="#333333" link="#333333" style="MARGIN: 0px;scrolling=no;frameBorder=no noResize">
<table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0" align="center">
<tbody>
	<tr>
		<td align="middle" id="leftframe" nowrap valign="center" name="fmtitle">
			<iframe frameborder="0" id="left" name="left" src="left.php" style="height: 100%; visibility: inherit; width: 145px; z-index: 2"></iframe>
		</td>
		<td>
			<table height="100%" width="12" cellspacing="0" cellpadding="0" bgcolor="#2f5fa1">
			<tbody>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td align="center" id="menuswitch" onClick="changewin();" height="100%">
						<img src="img/left_close.gif" style="cursor:pointer;">
					</td>
				</tr>
			</tbody>
			</table>
		</td>
		<td style="width: 100%">
			<iframe frameborder="0" id="main" name="main" scrolling="yes" src="getItemsAll.php" style="height: 100%; visibility: inherit; width: 100%; z-index: 1"></iframe>
		</td>
	</tr>
</tbody>
</table>
</body>
</html>
