<?php
	require_once '../common/conn.php';
	require_once '../common/function.php';
	require_once 'cookie.php';
	$id = addslashes($_GET['id']);
	$newGuid = addslashes($_GET['newGuid']);
	if (!empty($id) && !empty($newGuid)){
	  	$sql = "select id,newGuid,deptName from `bbs_dept` where id = '$id' and newGuid = '$newGuid'";
	  	$res = mysql_query($sql);
	  	$row = mysql_fetch_array($res);
	}
	
	if ($_POST['param']=='1'){
		$deptName = trim($_POST['deptName']);
		if(empty($deptName)){
			echo "<script language=\"javascript\">alert('部门不能为空');history.go(-1);</script>";
			return false;
		}
		$date = date('Y-m-d H:i:s');
		$sql = "update `bbs_dept` set deptName='$deptName',updateDate='$date' where id = '$id' and newGuid = '$newGuid'";
		$res = mysql_query($sql);
		if($res){
			echo "<script language=\"javascript\">alert('修改成功');window.location.href='deptList.php?keyword=$_GET[keyword]'</script>";
		}else{
			echo "<script language=\"javascript\">alert('修改失败');history.go(-1);</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>修改部门</title>
<base href="http://200.200.3.226/test/dept/admin/" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
<script type="text/javascript">
$(function(){
	$(':submit').click(function(){
		var deptName = $('#deptName').val();
		if(deptName==null || deptName=='' || deptName=='undefined'){
			alert('部门不能为空');
			document.getElementById('deptName').focus();
			return false;
		}
// 		var reg = /[\u4E00-\u9FA5\uF900-\uFA2D]/;
// 		if (!reg.test(deptName)){
// 			alert('请输入中文');
// 			document.getElementById('deptName').focus();
// 			return false;
// 		}
		$("#deptEdit").submit();
	});
	
});	
</script>
</head>
<body>
<?php require_once '../common/header.php';?>
<div class="main">
<form id="deptEdit" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
            	<tr class="bg"><td colspan="8" align="center"><h3>基础信息&nbsp;</h3></td></tr>
					<tr>
						<td class="title" width="30%">部门</td>
						<td><input id="deptName" name="deptName" type="text" value="<?php echo $row['deptName']?>" /></td>
					</tr>
					
			</table>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
		<tr>
			<td colspan="4" style="text-align: center;border: 0;">
				<input name="param" value="1" type="hidden" />
				<input type="submit" value="提交" />
				<input type="button" value="返回" onclick="window.history.back()" />
			</td>
		</tr>
</table>
</form>
</div>
</body>
</html>