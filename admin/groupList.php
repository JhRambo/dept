<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8" />
<base href="http://200.200.3.226/test/dept/admin/" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="js/del.js"></script>
<script type="text/javascript">
	$().ready(function(){
		var ids = document.getElementsByName('ids');	//返回一个数组
		$('#allCk').click(function(){
			var allCk = document.getElementById('allCk');
			if(allCk.checked){	//如果选中全选
				for(i=0;i<ids.length;i++){
					ids[i].checked=true;
				}
				$('#ckValue').val('');
				var idsArr = getCheckVals("ids");
				var idsStr = idsArr.join(',')+',';
				$('#ckValue').val(idsStr);
			}else{
				for(i=0;i<ids.length;i++){
					ids[i].checked=false;
				}
				$('#ckValue').val('');
			}
		});
	
		$("input[name='ids']").click(function(){
			var str = $('#ckValue').val();
			var strArr = str.split(',');
			if($(this).prop('checked')){
				str += $(this).val()+',';	
			}else{
				str = str.replace($(this).val()+',', '');	
			}
			$('#ckValue').val(str);
			var ckArr = str.split(',');
			if((ckArr.length-1)<ids.length){
				$('#allCk').prop('checked',false);
			}else{
				$('#allCk').prop('checked',true);
				$('#ckValue').val('');
				var idsArr = getCheckVals("ids");
				var idsStr = idsArr.join(',')+',';
				$('#ckValue').val(idsStr);
			}
		});

		$('#batchup').click(function(){
			var idsv = getCheckVals("ids");
			if(!idsv || idsv.length==0) return 0;
			var level = prompt("修改级别：");
			if(level){
				alert("您刚输入的是："+ level);
			}
		});
	});

	function groupDel(id,guid){
		if(confirm('确认删除吗？')){
			$.ajax({
				url: 'groupDel.php',
				type: 'post',
				dataType: 'json',
				data: {'id': id, 'guid':guid},
				success: function(r){
					if(r.status==1){
						alert(r.msg);
						location.href="groupList.php";
					}else{
						alert(r.msg);
					}
				}
			});
		}
	}

	function getCheckVals2(name){
		var arr = new Array();
		$("input[name="+name+"]:checked").each(function(){
			arr.push($(this).val());
		});
		return arr;
	}
	
</script>
</head>
<body>
<?php
	require_once '../common/conn.php';
	require_once 'cookie.php';
	$keyword = $_GET['keyword'];
	if(!empty($keyword)){
		$listSql = "SELECT t1.id As groupId,t1.newGuid,t1.groupName,t1.groupLevel,t2.deptName FROM `bbs_group` t1 left join `bbs_dept` t2 on t1.deptId = t2.id where (t1.groupName like '%$keyword%' or t2.deptName like '%$keyword%') order by deptName,groupLevel";
	}else{
		$listSql = "SELECT t1.id As groupId,t1.newGuid,t1.groupName,t1.groupLevel,t2.deptName FROM `bbs_group` t1 left join `bbs_dept` t2 on t1.deptId = t2.id order by deptName,groupLevel";
	}
	$groupList = mysql_query($listSql);
	while ($row = mysql_fetch_array($groupList,MYSQL_ASSOC)){
		$rows[] = $row;
	}
?>
<?php require_once '../common/header.php';?>
<div id="main">
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
            <form id="" action="" method="get"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table1" style="padding-bottom: 4px;">
            <thead>
              <tr>
                <td style="width:40px;height:19px;"><div class="gif"><img src="img/tb.gif" width="14" height="14" /></div></td>
                <td width="80"><span class="title">小组列表</span></td>
                <td align="left">                    
                    <span class="title">关键字：</span>
                    <input type="text" id="keyword" name="keyword" value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword'];}?>" style="width: 130px;" placeholder="请输入关键字" >
                    <input type="submit" class="btn" value="搜索">
                </td>
                <td>
                    
                </td>
                <td><input class="btn" type="button" onclick="javascript:window.location.href='groupAdd.php'" style="float: right;margin-right: 10px;" value="添加小组">&nbsp;&nbsp;</td>
              </tr>
            </thead>
            </table>
            </form>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
        <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#a8c7ce" class="order_list chameleon" id="table2">
            <thead>
            <tr class="list_title">
            	<th width="30"><input type="checkbox" id="allCk"></th>
                <th width="30">序号</th>
                <th>部门</th>
                <th>小组</th>
                <th>操作</th> 
            </tr>
            </thead>
            <input id="batchup" type="button" value="批量更新"/>
            <input name="ckValue" id="ckValue" type="hidden" />
            <tbody>
            <?php if(!empty($rows)){?>
				<?php $i=1;?>
				<?php foreach ($rows as $row){?>
					<tr>
						<td><input type="checkbox" name="ids" value =<?=$row['groupId'] ?>></td>
						<td><?=$i++?></td>
						<td><?php echo $row['deptName'] ?></td>          
						<td><?php echo $row['groupName'] ?></td>
						<td><a href="groupEdit.php?id=<?=$row['groupId'] ?>&newGuid=<?=$row['newGuid'] ?>&keyword=<?=$_GET['keyword'] ?>">编辑</a>|<a href="javascript:void(0)" onclick="groupDel('<?=$row['groupId'] ?>','<?=$row['newGuid'] ?>')">删除</a></td>               
					</tr>
				<?php }?>
			<?php }else{?>
				<tr><td colspan='5'>未找到记录</td></tr>
			<?php }?>
            </tbody>
        </table>
    </td>
  </tr>
</table>
</div>

</body>
</html>

