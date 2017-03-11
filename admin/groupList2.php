<?php
	require_once '../common/conn.php';	
	$deptId = $_GET['deptId'];
	if(!empty($deptId) && is_numeric($deptId)){
		$groupSql = "select id,groupName from `bbs_group` where deptId = '$deptId'";
	}
	$groupList = mysql_query($groupSql);
	$data = array();
	while($row = mysql_fetch_array($groupList,MYSQL_ASSOC)){
		$data[] = $row;		
	}		
	echo json_encode($data);
	
	