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
	
	});

	function itemDel(id,guid){
		if(confirm('确认删除吗？')){
			$.ajax({
				url: 'itemDel.php',
				type: 'post',
				dataType: 'json',
				data: {'id': id, 'guid':guid},
				success: function(r){
					if(r.status==1){
						alert(r.msg);
						location.href="itemList.php";
					}else{
						alert(r.msg);
					}
				}
			});
		}
	}
	
</script>
</head>
<body>
<?php
	require_once '../common/conn.php';
	require_once 'cookie.php';
	$keyword = $_GET['keyword'];
	if(!empty($keyword)){
		$listSql = "SELECT t1.groupId,t1.deptId,t1.id AS itemId,t1.newGuid,t1.itemName,t1.itemLevel,t1.linkMan,t1.phones,t1.itemArea,t2.groupName,t2.groupLevel,t3.deptName FROM `bbs_item` t1 LEFT JOIN `bbs_group` t2 ON t1.groupId = t2.id LEFT JOIN `bbs_dept` t3 ON t1.deptId = t3.id where (t1.itemName like '%$keyword%' or t2.groupName like '%$keyword%' or t3.deptName like '%$keyword%' or t1.linkMan like '%$keyword%' or t1.phones like '%$keyword%') ORDER BY deptName,groupLevel,groupId,itemLevel,itemId";
	}else{
		$listSql = "SELECT t1.groupId,t1.deptId,t1.id AS itemId,t1.newGuid,t1.itemName,t1.itemLevel,t1.linkMan,t1.phones,t1.itemArea,t2.groupName,t2.groupLevel,t3.deptName FROM `bbs_item` t1 LEFT JOIN `bbs_group` t2 ON t1.groupId = t2.id LEFT JOIN `bbs_dept` t3 ON t1.deptId = t3.id ORDER BY deptName,groupLevel,groupId,itemLevel,itemId";
	}
	$itemList = mysql_query($listSql);
	while ($row = mysql_fetch_array($itemList,MYSQL_ASSOC)){
		if(!empty($row)){
			$linkManArr = json_decode($row['linkMan']);
			$phonesArr = json_decode($row['phones']);
			$linkMans = '';
			for ($i=0; $i<count($linkManArr); $i++){
				$linkMans .= $linkManArr[$i]."(".$phonesArr[$i].")"." | ";
			}
			$linkMans = substr($linkMans,0,strlen($linkMans)-2);
			$row['linkMans'] = $linkMans;
			$rows[] = $row;
		}
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
                <td width="80"><span class="title">事项列表</span></td>
                <td align="left">                    
                    <span class="title">关键字：</span>
                    <input type="text" id="keyword" name="keyword" value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword'];}?>" style="width: 130px;" placeholder="请输入关键字" >
                    <input type="submit" class="btn" value="搜索">
                </td>
                <td>
                    
                </td>
                <td><input class="btn" type="button" onclick="javascript:window.location.href='itemAdd.php'" style="float: right;margin-right: 10px;" value="添加事项">&nbsp;&nbsp;</td>
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
                <th width="30">序号</th>
                <th>部门</th>
                <th>小组</th>
                <th width="300">事项</th>
                <th width="300">负责人</th>
                <th width="200">负责区域</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($rows)){?>
				<?php $i=1;?>
				<?php foreach ($rows as $row){?>
					<tr>
						<td><?=$i++?></td>
						<td><?php echo $row['deptName'] ?></td>          
						<td><?php echo $row['groupName'] ?></td>
						<td><?php echo $row['itemName'] ?></td>          
						<td><?php echo $row['linkMans'] ?></td>
						<td><?php echo $row['itemArea'] ?></td>
						<td><a href="itemEdit.php?id=<?=$row['itemId'] ?>&newGuid=<?=$row['newGuid'] ?>&keyword=<?=$_GET['keyword'] ?>">编辑</a>|<a href="javascript:void(0)" onclick="itemDel('<?=$row['itemId'] ?>','<?=$row['newGuid']?>')">删除</a></td>               
					</tr>
				<?php }?>
			<?php }else{?>
				<tr><td colspan='7'>未找到记录</td></tr>
			<?php }?>
            </tbody>
        </table>
    </td>
  </tr>
</table>
</div>

</body>
</html>

