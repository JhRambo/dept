<?php
	require_once '../common/conn.php';
	require_once '../common/levelConfig.php';
	require_once '../common/function.php';
	require_once 'cookie.php';
	//部门列表
	$listSql = "SELECT id,deptName FROM `bbs_dept`";
	$deptList = mysql_query($listSql);
	//小组列表
	$listSql = "SELECT id,groupName FROM `bbs_group`";
	$groupList = mysql_query($listSql);
	
	$level = '';
	foreach ($itemLevelArr as $v){
		$level .= $v.',';
	}
	$level = substr($level, 0,-1);
	
	if ($_POST['param']=='1'){
		$deptId = $_POST['deptList'];
		if(empty($deptId)){
			echo "<script language=\"javascript\">alert('请选择部门');history.go(-1);</script>";
			return false;
		}
		
		$groupId = $_POST['groupList'];
		if(empty($groupId)){
			echo "<script language=\"javascript\">alert('请选择小组');history.go(-1);</script>";
			return false;
		}
		
		$itemName = $_POST['itemName'];
		if(empty($itemName)){
			echo "<script language=\"javascript\">alert('事项不能为空');history.go(-1);</script>";
			return false;
		}
		
		$itemLevel = $_POST['itemLevel'];
		if(!empty($itemLevel) && !in_array($itemLevel, $itemLevelArr)){
			echo "<script language=\"javascript\">alert('级别仅限:$level');history.go(-1);</script>";
			return false;
		}
			
		$linkMan = $_POST['linkMan'];
		$lks = '';
		foreach ($linkMan as $k=>$v){
			$lks .= $v; 
		}
		if(empty($lks)){
			echo "<script language=\"javascript\">alert('负责人不能为空');history.go(-1);</script>";
			return false;
		}
		
		$phones = $_POST['phones'];
		$ps = '';
		foreach ($phones as $k=>$v){
			$ps .= $v;
		}
		if(empty($ps)){
			echo "<script language=\"javascript\">alert('联系电话不能为空');history.go(-1);</script>";
			return false;
		}
		$itemArea = $_POST['itemArea'];
		$itemRemark = $_POST['itemRemark'];
		
		$newGuid = createGuid();	
		$date = date('Y-m-d H:i:s');
		
		foreach ($linkMan as $key => $value) {
			$linkMan[$key] = urlencode($value);
		}
		
		foreach ($phones as $key => $value) {
			$phones[$key] = urlencode($value);
		}
		
		//转换为json格式
		$linkManJSON = urldecode(json_encode($linkMan));	//解决中文乱码
		$phonesJSON = urldecode(json_encode($phones));
		
		$sql = "insert into `bbs_item` (newGuid,itemName,addDate,deptId,groupId,linkMan,phones,itemArea,itemLevel,itemRemark)
		values ('$newGuid','$itemName','$date','$deptId','$groupId','$linkManJSON','$phonesJSON','$itemArea','$itemLevel','$itemRemark')";
		$res = mysql_query($sql);
		if($res){
			echo "<script language=\"javascript\">alert('添加成功');window.location.href='itemList.php'</script>";
		}else{
			echo "<script language=\"javascript\">alert('添加失败');history.go(-1);</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>添加事项</title>
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
			
			var groupName = document.getElementById('groupList').value;
			if(groupName==null || groupName=='' || groupName=='undefined'){
				alert('请选择小组');
				document.getElementById('groupName').focus();
				return false;
			}

			var itemName = $('#itemName').val();
			if(itemName==null || itemName=='' || itemName=='undefined'){
				alert('事项不能为空');
				document.getElementById('itemName').focus();
				return false;
			}	

			var itemLevelArr = ['0','1'];
			var itemLevel = $('#itemLevel').val();
			if(itemLevel!=''){
				if($.inArray(itemLevel,itemLevelArr)==-1){
					alert('级别仅限0,1');
					document.getElementById('itemLevel').focus();
					return false;
				}
			}	
			
			$("#itemAdd").submit();
		});
	});
	
	function deptChange(){
		var deptId = document.getElementById('deptList').value;
		$.get('groupList2.php',{'deptId':deptId},function(data){
			$('#groupList').empty();
            $.each(data, function(i,r){
                if(data){
                	$('#groupList').append('<option value="' + r.id + '">' + r.groupName + '</option>');
                }
            });
		},'json');
		if(deptId==''){
			$('#groupList').empty();
		}
	}

	var i=2;
	function ct_add(){
		$("#ct").append("<li id=\"ct_"+i+"\"><input type=\"text\" name=\"linkMan[]\" placeholder=\"联系人\" /><input type=\"text\" name=\"phones[]\" placeholder=\"联系电话\"/> <input type=\"button\" onclick=\"ct_remove("+i+")\" value=\"移除\"/></li>");
		i++;
	}
	
	function ct_remove(i){
		$("#ct_"+i).remove();
	}
	
</script>
</head>
<body>
<?php require_once '../common/header.php';?>
<div class="main">
<form id="itemAdd" method="post" action="">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
            	<tr class="bg"><td colspan="8" align="center"><h3>基础信息&nbsp;</h3></td></tr>
					<tr>
						<td class="title" width="30%">部门</td>
						<td>
							<select id="deptList" name="deptList" onchange="deptChange()">
								<option value="">--请选择--</option>
								<?php while($row = mysql_fetch_array($deptList)){ ?>									
									<option value="<?=$row['id']?>"><?=$row['deptName']?></option>
								<?php }?>								
							</select>
						</td>
					</tr>
					<tr>
						<td class="title" width="30%">小组</td>
						<td>
							<select id="groupList" name="groupList">
								<option value="">--请选择--</option>							
							</select>
						</td>
					</tr>
					<tr>
						<td class="title" width="30%">区域</td>
						<td><textarea id="itemArea" name="itemArea" rows="10" cols="80"/></textarea></td>
					</tr>				
					<tr>
						<td class="title" width="30%">事项</td>
						<td><textarea id="itemName" name="itemName" rows="10" cols="80"/></textarea></td>
					</tr>
					<tr>
						<td class="title" width="30%">级别</td>
						<td><input id="itemLevel" name="itemLevel" type="text" placeholder="仅限<?php echo $level?>" />&nbsp;默认为0</td>
					</tr>
					<tr>
						<td class="title" width="30%">备注</td>
						<td><textarea id="itemRemark" name="itemRemark" rows="10" cols="80"/></textarea></td>
					</tr>										
					<tr>
						<td class="title" width="30%">负责人</td>
						<td>                
							<ul id="ct">
								<li id="ct_1">
									<input type="text" name="linkMan[]" placeholder="联系人"/>
									<input type="text" name="phones[]" placeholder="联系电话"/>
									<input type="button" onclick="ct_add()" value="添加"/>
								</li>
							</ul>
                    	</td>		
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