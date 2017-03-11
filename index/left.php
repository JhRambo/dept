<html>
<head>
<title>  深信服科技内部论坛 - powered by phpwind.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="phpwind,forum,bbs,bulletin board,php,mysql,forums" />
<meta name="description" content="深信服内部论坛." />
<base href="http://200.200.3.226/test/dept/index/" />
<style type="text/css">
body {font-family: verdana;font-size: 12px;margin: 0;color: #000;background: #F4FBFF ;
	scrollbar-face-color: #84aace ; 
	scrollbar-highlight-color: #ffffff; 
	scrollbar-shadow-color: #2f5fa1; 
	scrollbar-3dlight-color: #2f5fa1; 
	scrollbar-arrow-color: #84aace; 
	scrollbar-track-color: #ffffff;
	scrollbar-darkshadow-color: #ffffff;
	scrollbar-base-color: #2f5fa1;
}
td {font-family:arial;font-size: 12px;}
a { text-decoration: none;color: #000;}
a:hover{text-decoration: underline;}
img {border:0;}
.f_one {background: #ffffff;}
.f_two {background: #F4FBFF;}
.t{margin:0px auto 8px;width:100%}
.t table{border:1px solid #fff;margin:0 auto;width:99.98%;}
.h{border-bottom:1px solid #fff;background:#84aace;text-align:left;color:#ffffff;padding-left:5px}
.h a{font-family:Arial;color:#ffffff}
.tr3 td{border-bottom:1px solid #e4e8eb;padding:5px 8px}
.hideGroup .tr3{
	display:none;
}
</style>
<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
<script language=javascript>
	$(function(){
		$.ajax({
			type: 'GET',
			url: 'getDeptList.php',
			data: {},
			dataType: 'json',
			success: function(data){
				$.each(data,function(i,r){
					$("<tbody id=\"deptId_"+r.deptId+"\" class=\"hideGroup\"><tr><td class=\"h\"><a style=\"cursor:pointer;\" href=\"getItems.php?deptId="+r.deptId+"\" onClick=\"Show("+r.deptId+")\" target=\"main\"><img id=\"img_"+r.deptId+"\" src=\"img/cate_on.gif\" border=\"0\" align=\"absmiddle\" />"+r.deptName+"</a><font color=\"#000000\"></font></td></tr></tbody>").appendTo("#deptList");
					var groupIds = r.groupIds.split(',');
					var groupNames = r.groupNames.split(',');
					for(i=0; i<groupIds.length;i++){
						$("<tr class=\"tr3 f_one\" onMouseOver=\"this.className='tr3 f_two'\" onMouseOut=\"this.className='tr3 f_one'\"><td><a href=\"groupView.php?groupId="+groupIds[i]+"&key="+r.newGuid+"\" target=\"main\">"+groupNames[i]+"</a></td></tr>").appendTo("#deptId_"+r.deptId);
					}
				});
			}
		});
	});
	
	function Show(id){
		var obj=document.getElementById('deptId_'+id);
		var img=document.getElementById('img_'+id);
		if(obj.className=="hideGroup"){
			obj.className="";
			img_re=new RegExp("_on\.gif$");
			img.src=img.src.replace(img_re,'_off.gif');
		}else{
			obj.className="hideGroup";
			img_re=new RegExp("_off\.gif$");
			img.src=img.src.replace(img_re,'_on.gif');
		}
	}

</script>

</head>
<body vlink="#333333" link="#333333">
<div style="width:145px">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr><td style=" background:url(img/columns-t.gif) no-repeat; height:30px"></td></tr>
				<tr><td align="center" style="padding:5px 0">
					<a href="index.php" target="main">论坛首页</a> | &nbsp;<a href="profile.php" target="main">控制面板</a> <br />
					<a href="search.php?sch_time=all&orderway=lastpost&asc=desc&newatc=1" target="main">查看新帖</a> | &nbsp;<a href="faq.php" target="main">论坛帮助</a>
				</td></tr>
			</table>
			<div class="t">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" id="deptList">
			</table>
			</div>
		</div>
</body>
</html>
