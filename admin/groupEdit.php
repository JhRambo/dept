<?php
	require_once '../common/conn.php';
	require_once '../common/levelConfig.php';
	require_once '../common/function.php';
	require_once 'cookie.php';
	$id = addslashes($_GET['id']);
	$newGuid = addslashes($_GET['newGuid']);
	if (!empty($id) && !empty($newGuid)){
	  	$sql = "SELECT id,newGuid,groupName,deptId,groupLevel FROM `bbs_group` where id = '$id' and newGuid = '$newGuid'";
	  	$res = mysql_query($sql);
	  	$row = mysql_fetch_array($res);
	}
	
	//获取部门列表
	$listSql = "SELECT id,deptName FROM `bbs_dept`";
	$deptList = mysql_query($listSql);
	
	$level = '';
	foreach ($groupLevelArr as $v){
		$level .= $v.',';
	}
	$level = substr($level, 0,-1);
	
	if ($_POST['param']=='1'){
		$deptId = $_POST['deptList'];
		if(empty($deptId)){
			echo "<script language=\"javascript\">alert('请选择部门');history.go(-1);</script>";
			return false;
		}
		
		$groupName = $_POST['groupName'];
		if(empty($groupName)){
			echo "<script language=\"javascript\">alert('小组不能为空');history.go(-1);</script>";
			return false;
		}
		
		$groupLevel = $_POST['groupLevel'];
		if(!empty($groupLevel) && !in_array($groupLevel, $groupLevelArr)){			
			echo "<script language=\"javascript\">alert('级别仅限:$level');history.go(-1);</script>";
			return false;
		}
		
		$date = date('Y-m-d H:i:s');
		$sql = "update `bbs_group` set deptId='$deptId',groupName='$groupName',groupLevel='$groupLevel',updateDate='$date' where id = '$id' and newGuid = '$newGuid'";
		$res = mysql_query($sql);
		if($res){
			echo "<script language=\"javascript\">alert('修改成功');window.location.href='groupList.php?keyword=$_GET[keyword]'</script>";
		}else{
			echo "<script language=\"javascript\">alert('修改失败');history.go(-1);</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>修改小组</title>
<base href="http://200.200.3.226/test/dept/admin/" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
<script type="text/javascript">
$(function(){
	$(':submit').click(function(){
		var deptName = document.getElementById('deptList').value;
		if(deptName==null || deptName=='' || deptName=='undefined'){
			alert('请选择部门');
			document.getElementById('deptList').focus();
			return false;
		}
		
		var groupName = $('#groupName').val();
		if(groupName==null || groupName=='' || groupName=='undefined'){
			alert('小组不能为空');
			document.getElementById('groupName').focus();
			return false;
		}

		var groupLevelArr = ['0','1'];
		var groupLevel = $('#groupLevel').val();
		if(groupLevel!=''){
			if($.inArray(groupLevel,groupLevelArr)==-1){
				alert('级别仅限0,1');
				document.getElementById('groupLevel').focus();
				return false;
			}
		}
				
// 		var reg = /[\u4E00-\u9FA5\uF900-\uFA2D]/;
// 		if (!reg.test(groupName)){
// 			alert('请输入中文');
// 			document.getElementById('groupName').focus();
// 			return false;
// 		}
		$("#groupEdit").submit();
	});
	
});		
</script>
</head>
<body>
<?php require_once '../common/header.php';?>
<div class="main">
<form id="groupEdit" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
            	<tr class="bg"><td colspan="8" align="center"><h3>基础信息&nbsp;</h3></td></tr>
					<tr>
						<td class="title" width="30%">部门</td>
						<td>
							<select id="deptList" name="deptList">
								<?php while($r = mysql_fetch_array($deptList)){
									$selected = ($row['deptId']==$r['id'])? "selected='selected'": "";
									echo "<option value='{$r['id']}' {$selected}>{$r['deptName']}</option>";
								}?>												
							</select>
						</td>
					</tr>
					<tr>
						<td class="title" width="30%">小组</td>
						<td><input id="groupName" name="groupName" type="text" value="<?=$row['groupName']?>"/></td>
					</tr>
					<tr>
						<td class="title" width="30%">级别</td>
						<td><input id="groupLevel" name="groupLevel" type="text"  value="<?=$row['groupLevel']?>" placeholder="仅限<?php echo $level?>"/>&nbsp;默认为0</td>					
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