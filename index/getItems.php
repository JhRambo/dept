<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8" />
<base href="http://200.200.3.226/test/dept/index/" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="js/del.js"></script>
<script type="text/javascript">
	$().ready(function(){
		
	});
</script>
</head>
<body>
<?php
	require_once '../common/conn.php';
	$deptId = $_GET['deptId'];
	$keyword = $_GET['keyword'];
	if(!empty($keyword)){
		$listSql = "SELECT t1.groupId,t1.deptId,t1.id AS itemId,t1.itemName,t1.itemLevel,t1.linkMan,t1.phones,t1.itemArea,t2.groupName,t2.groupLevel,t3.deptName FROM `bbs_item` t1 LEFT JOIN `bbs_group` t2 ON t1.groupId = t2.id LEFT JOIN `bbs_dept` t3 ON t1.deptId = t3.id WHERE t1.deptId='$deptId' AND (t1.itemName LIKE '%$keyword%' OR t3.deptName LIKE '%$keyword%' OR t2.groupName LIKE '%$keyword%' OR t1.linkMan LIKE '%$keyword%' OR t1.phones LIKE '%$keyword%') ORDER BY groupLevel,groupId,itemLevel,itemId";				
	}else{
		$listSql = "SELECT t1.groupId,t1.deptId,t1.id AS itemId,t1.itemName,t1.itemLevel,t1.linkMan,t1.phones,t1.itemArea,t2.groupName,t2.groupLevel,t3.deptName FROM `bbs_item` t1 LEFT JOIN `bbs_group` t2 ON t1.groupId = t2.id LEFT JOIN `bbs_dept` t3 ON t1.deptId = t3.id WHERE t1.deptId='$deptId' ORDER BY groupLevel,groupId,itemLevel,itemId";
	}
	
	$itemList = mysql_query($listSql);
	while($row = mysql_fetch_array($itemList,MYSQL_ASSOC)){
		$linkManArr = json_decode($row['linkMan']);
		$phonesArr = json_decode($row['phones']);
		if(is_array($linkManArr)){
			foreach ($linkManArr as $key=>$value){
				$row['linkMan'] = $value;
				$row['phones'] = $phonesArr[$key];
				$rows[] = $row;
			}
		}
	}
	
	for($x=0;$x<count($rows);$x++){
		$deptNameArr[] = $rows[$x]['deptId'];
	}
	for($y=0;$y<count($rows);$y++){
		$groupNameArr[] = $rows[$y]['groupId'];
	}
	for($z=0;$z<count($rows);$z++){
		$itemNameArr[] = $rows[$z]['itemId'];
	}
	if(is_array($deptNameArr)){
		$rows[] = array_count_values($deptNameArr);		//计算部门个数
	}
	if(is_array($groupNameArr)){
		$rows[] = array_count_values($groupNameArr);	//计算各小组个数
	}
	if(is_array($itemNameArr)){
		$rows[] = array_count_values($itemNameArr);		//计算各事项个数
	}
	
	$deptArr = array();
	for ($i=0;$i<count($rows);$i++){
		if(!in_array($rows[$i]['deptId'], $deptArr)){
			$deptArr[] = $rows[$i]['deptId'];
		}else{
			unset($rows[$i]['deptId']);
		}
	}
	$groupArr = array();
	for ($i=0;$i<count($rows);$i++){
		if(!in_array($rows[$i]['groupId'], $groupArr)){
			$groupArr[] = $rows[$i]['groupId'];
		}else{
			unset($rows[$i]['groupId']);
		}
	}
	$itemArr = array();
	for ($i=0;$i<count($rows);$i++){
		if(!in_array($rows[$i]['itemId'], $itemArr)){
			$itemArr[] = $rows[$i]['itemId'];
		}else{
			unset($rows[$i]['itemId']);
		}
	}
	
	$html = "<tr class='list_title'>";          
    $html .= "<th>部门</th>";
    $html .= "<th>小组</th>";
    $html .= "<th width='300'>事项</th>";
    $html .= "<th width='100'>负责人</th>";
    $html .= "<th width='150'>联系电话</th>";
    $html .= "<th width='200'>负责区域</th>";
    $html .= "</tr>";
    
    if(is_array($rows)){
    	$deptArrV = array_values($rows);
    	$deptNum = $deptArrV[count($rows)-3];		//部门数量
		$groupArrV = array_values($rows);
    	$groupNum = $groupArrV[count($rows)-2];		//小组数量
		$itemArrV = array_values($rows);
    	$itemNum = $itemArrV[count($rows)-1];		//事项数量
    }
    
    $count = count($rows)-3;
    if($count>0){
    	for ($i=0; $i<$count; $i++) {
    		$html .= "<tr>";
    		if(isset($rows[$i]['deptId'])){
    			$rowspanD = $deptNum[$rows[$i]['deptId']];
    			$html .= "<td rowspan='$rowspanD' style='background:#FFF;'>".$rows[$i]['deptName']."</td>";
    		}
    		if(isset($rows[$i]['groupId'])){
    			$rowspanG = $groupNum[$rows[$i]['groupId']];
    			$html .= "<td rowspan='$rowspanG' style='background:#FFF;'>".$rows[$i]['groupName']."</td>";
    		}
    		if(isset($rows[$i]['itemId'])){
    			$rowspanI = $itemNum[$rows[$i]['itemId']];
    			$html .= "<td rowspan='$rowspanI' style='background:#FFF;'>".$rows[$i]['itemName']."</td>";
    		}
    		$html .= "<td>".$rows[$i]['linkMan']."</td>";
    		$html .= "<td>".$rows[$i]['phones']."</td>";
    		$html .= "<td>".$rows[$i]['itemArea']."</td>";
    		$html .= "</tr>";
    	}
    }else{
    	$html .= "<tr><td colspan='6'>未找到记录</td></tr>";
    }
      
?>

<div class="header">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody>
	<tr>
		<td class="banner">
			<a href=""><img src="img/logo.png" style=" margin:0 0.5% 5px"></a>
		</td>
	</tr>
	<tr>
		<td align="center" height="1" colspan="2"></td>
	</tr>
</tbody>
</table>
</div>
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
                    <input id="deptId" name="deptId" type="hidden" value="<?php if(isset($_GET['deptId'])){echo $_GET['deptId'];}?>">
                    <input type="submit" class="btn" value="搜索">
                </td>
                <td>
                    
                </td>
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
            <?php echo $html; ?>
        </table>
    </td>
  </tr>
</table>
</div>

</body>
</html>

