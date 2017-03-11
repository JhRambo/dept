<?php
	require_once '../common/conn.php';
	require_once '../common/function.php';
	require_once 'cookie.php';
	$arr = array(
			'status' => 0,
			'msg'	 => ''
	);
	$itemId = addslashes($_POST['id']);
	$newGuid = addslashes($_POST['guid']);
	if (!empty($itemId) && !empty($newGuid)){
		$sql = "delete from `bbs_dept` where id = '$itemId' and newGuid = '$newGuid'";
		$res = mysql_query($sql);
		if($res){
			$arr = array(
					'status' => 1,
					'msg'	 => urlencode('删除成功')
			);
			echo urldecode(json_encode($arr));
		}
	}
	