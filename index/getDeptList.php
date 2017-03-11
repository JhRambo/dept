<?php
	require_once '../common/conn.php';
	require_once '../common/function.php';
	function getDeptList(){
		$key = createGuid();
		$listSql = "SELECT GROUP_CONCAT(t1.id) AS groupIds, GROUP_CONCAT(t1.groupName) AS groupNames, t2.id AS deptId,t2.deptName,t2.newGuid FROM `bbs_group` t1 LEFT JOIN `bbs_dept` t2 ON t1.deptId = t2.id GROUP BY deptName ORDER BY deptName";
		$deptList = mysql_query($listSql);
		if($deptList){
			$data = array();
			while($row = mysql_fetch_array($deptList,MYSQL_ASSOC)){
				$data[] = $row;			
			}
			echo json_encode($data);
		}
	}
	
	getDeptList();