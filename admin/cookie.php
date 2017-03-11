<?php
if(empty($_COOKIE['userName'])){
	echo "<script language=\"javascript\">alert('缓存已失效，请重新登录');window.location.href='login.php';</script>";
}