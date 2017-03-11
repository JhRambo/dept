<?php
	require_once '../common/conn.php';
	require_once '../common/levelConfig.php';
	require_once '../common/function.php';
	require_once 'cookie.php';
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
		
		$newGuid = createGuid();		
		$date = date('Y-m-d H:i:s');		
		$sql = "insert into `bbs_group` (newGuid,groupName,groupLevel,addDate,deptId)
		values ('$newGuid','$groupName','$groupLevel','$date','$deptId')";
		$res = mysql_query($sql);
		if($res){
			echo "<script language=\"javascript\">alert('添加成功');window.location.href='groupList.php'</script>";
		}else {
			echo "<script language=\"javascript\">alert('添加失败');history.go(-1);</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>添加小组</title>
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
		$("#groupAdd").submit();
	});
	
});	
</script>
</head>
<body>
<?php require_once '../common/header.php';?>
<div class="main">
<form id="groupAdd" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
            	<tr class="bg"><td colspan="8" align="center"><h3>基础信息&nbsp;</h3></td></tr>
					<tr>
						<td class="title" width="30%">部门</td>
						<td>
							<select id="deptList" name="deptList">
								<option value="">--请选择--</option>
								<?php while($row = mysql_fetch_array($deptList)){ ?>
									<option value="<?=$row['id']?>"><?=$row['deptName']?></option>
								<?php }?>				
							</select>
						</td>
					</tr>
					<tr>
						<td class="title" width="30%">小组</td>
						<td><input id="groupName" name="groupName" type="text" /></td>
					</tr>
					<tr>
						<td class="title" width="30%">级别</td>
						<td><input id="groupLevel" name="groupLevel" type="text" placeholder="仅限<?php echo $level?>" />&nbsp;默认为0</td>			
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