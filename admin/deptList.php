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

	function deptDel(id,guid){
		if(confirm('确认删除吗？')){
			$.ajax({
				url: 'deptDel.php',
				type: 'post',
				dataType: 'json',
				data: {'id': id, 'guid':guid},
				success: function(r){
					if(r.status==1){
						alert(r.msg);
						location.href="deptList.php";
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
		$listSql = "SELECT id AS deptId,newGuid,deptName FROM `bbs_dept` where deptName like '%$keyword%' order by deptId desc";
	}else{
		$listSql = "SELECT id AS deptId,newGuid,deptName FROM `bbs_dept` order by deptId desc";
	}
	$deptList = mysql_query($listSql);	
	while ($row = mysql_fetch_array($deptList,MYSQL_ASSOC)){
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
                <td width="80"><span class="title">部门列表</span></td>
                <td align="left">                    
                    <span class="title">关键字：</span>
                    <input type="text" id="keyword" name="keyword" value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword'];}?>" style="width: 130px;" placeholder="请输入关键字" >
                    <input type="submit" class="btn" value="搜索">
                </td>
                <td>
                    
                </td>
                <td><input class="btn" type="button" onclick="javascript:window.location.href='deptAdd.php'" style="float: right;margin-right: 10px;" value="添加部门">&nbsp;&nbsp;</td>
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
                <th>操作</th> 
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($rows)){?>
				<?php $i=1;?>
				<?php foreach ($rows as $row){?>
				<tr>
					<td><?=$i++?></td>             
					<td><?php echo $row['deptName'] ?></td>
					<td><a href="deptEdit.php?id=<?=$row['deptId'] ?>&newGuid=<?=$row['newGuid'] ?>&keyword=<?=$_GET['keyword'] ?>">编辑</a>|<a href="javascript:void(0)" onclick="deptDel('<?=$row['deptId'] ?>','<?=$row['newGuid'] ?>')">删除</a></td>               
				</tr>
				<?php }?>
			<?php }else{?>
				<tr><td colspan='3'>未找到记录</td></tr>
			<?php }?>
            </tbody>
        </table>
    </td>
  </tr>
</table>
</div>

</body>
</html>

