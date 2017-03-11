<?php
	error_reporting(E_ALL & ~E_NOTICE);
	
	//连接数据库
	$host = "localhost";
	$user = "root";
	$pwd = "root";
	$db = "sf_deptsys";
	$conn = mysql_connect($host, $user, $pwd) or mysql_error();
	mysql_select_db($db, $conn);
	mysql_query("set names utf8"); //使用utf8中文编码;
	
?>