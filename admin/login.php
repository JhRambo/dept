<?php 
	require_once '../common/conn.php';
	require_once '../common/config.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$userName = addslashes($_POST['pwuser']);
		$userPwd = addslashes($_POST['pwpwd']);
		if(in_array($userName, $deptMngUser)){
			$sql = "select userId,userName,userPwd from `bbs_user` where userName = '$userName'";
			$res = mysql_query($sql);
			$row = mysql_fetch_array($res, MYSQL_ASSOC);
			if($row){
				if($userName==$row['userName'] && $userPwd==$row['userPwd']){
					setcookie('userName',$userName,time()+3600);
					$date = date('Y-m-d H:i:s');
					$ip = $_SERVER["REMOTE_ADDR"];
					$userId = $row['userId'];
					$upSql = "update `bbs_user` set lastTime = '$date',lastIp='$ip' where userId= '$userId'";
					mysql_query($upSql);
					echo "<script language=\"javascript\">alert('登录成功');window.location.href='deptList.php'</script>";
				}else{		
					echo "<script language=\"javascript\">alert('登录失败');history.go(-1);</script>";
				}
			}
		}else{
			echo "<script language=\"javascript\">alert('登录失败');history.go(-1);</script>";
		}
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>  深信服科技内部论坛  - powered by phpwind.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="phpwind,forum,bbs,bulletin board,php,mysql,forums" />
<meta name="description" content="深信服内部论坛." />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
<style type="text/css">
body{font-family:Tahoma;font-size:12px;background:#fff;}
h1,h2,h3,h4,h5,h6,form,body{padding:0;margin:0}
td,th,div{word-break:break-all;word-wrap:break-word}
table{empty-cells:show;}
img{border:0}
h3,h2{display:inline;font-size:1.0em;}
h3{font-weight:normal}
h2 a,h3 a{color:#000}
h4{margin:20px 0 10px;font-size:1.1em}
textarea,input,select{font:12px Arial;padding:1px 3px 0 3px;vertical-align:middle;margin-bottom:1px}
.c{clear:both;height:0;font:0/0 Arial;}
.b{font-weight:bold}
.tal{text-align:left}
.tac{text-align:center}
.tar{text-align:right}
.fr{float:right}
.fl{float:left}
/*a link 基本连接颜色*/
a{text-decoration:none;color:#2f5fa1}
a:hover{text-decoration:underline;}
/*字体大小*/
.f9{font-size:11px;}
.f10{font-size:11px;}
.f12{font-size:12px}
.f14{font-size:14px}
.fn,.fn a{font-weight:normal}
/*span color 数值自定义*/
.s1{color:#008000;}
.s2{color:#984B98;}
.s3{color:#FA891B;}
.s4{color:#0033FF;}
.s5{color:#659B28}
.gray{color:#818a89} /*次要文字颜色-可定义*/
/*main color 数值自定义*/
.f_one,.t_one,.r_one{background:#ffffff;}
.f_two,.t_two,.r_two{background:#F4FBFF;}
/*form*/
textarea,input,select{font:12px Arial;padding:1px 3px 0 3px;vertical-align:middle;margin-bottom:1px}
select{border:solid 1px #e4e8eb;}
.btn{background:#2f5fa1;color:#ffffff;border-width:1px;padding-left:15px;padding-right:15px;vertical-align:middle}
.input{border:solid 1px #2f5fa1;padding:2px 0px 2px 1px;font-size:1.0em;vertical-align:middle}
form{display:inline;}
textarea{border:solid 1px #2f5fa1;}
/*header*/
#header{width:98%;margin:auto}
/*toolbar*/
.toptool{border-bottom:1px solid #a6cbe7;}
.toptool span{padding:1px 5px;line-height:150%}
/*banner*/
.banner{padding-right:3%}
.banner img{vertical-align:middle;}
/*guide*/
.guide{}
/*table*/
.t{border:1px solid #2f5fa1;margin:0px auto 8px;}
.t table{border:1px solid #fff;margin:0 auto;width:99.98%;}
.t2{border-top:#2f5fa1 1px solid;margin:0px auto 5px;}
.t3{margin:auto}
.t4{padding:1px 0 1px 1px}
/*table head*/
.h{border-bottom:4px solid #a6cbe7;background:#84aace;text-align:left;color:#ffffff;padding:5px 7px 3px 7px;}
.h span{font-weight:normal;}
.h h2{font-weight:bold}
.h a{font-family:Arial;color:#ffffff}
.h span a,.h span{color:#2f5fa1;}
.h a.a2{margin-left:12px;}
/*table tr1*/
.tr1 th{padding:5px 10px;text-align:left;vertical-align:top;font-weight:normal;}
.tr1 td.td1{border:1px solid #e4e8eb;}
/*table tr2*/
.tr2{background:#e4e8eb;color:#000000;}
.tr2 td,.tr2 th{line-height:21px;border-bottom:1px solid #a6cbe7;padding:0px 6px 0px;border-top:1px solid #2f5fa1;}
.tr2 a{color:#000000;margin:2px}
/*table tr3*/
.tr3 td,.tr3 th{border-bottom:1px solid #e4e8eb;padding:5px 8px}
.tr3 th{text-align:left;font-weight:normal;}
.tr4{background:#84aace;color:#ffffff;}
.tr4 td{padding:4px 10px;}
.tr td,.tr th{padding:2px}
/*topic content tips*/
.tpc_content{font-size:14px;font-family:Arial;padding:0 2% 0 0.5%;margin:0 0 2%}
.tips{background:#F4FBFF;border:#e4e8eb 1px solid;padding:5px;margin:0 1% 1% 0;float:left;text-align:center;}
.tiptop{border-bottom:1px solid #e4e8eb;padding:0 0 5px 0;vertical-align:middle;}
.tipad{border-top:1px solid #e4e8eb;margin:10px 0 0;padding:5px 0 0;}
.quote{font-size:70%;color:#ffffff;margin:2px;padding:0}
blockquote{width:92%;font-size:85%;color:#81888c;border:1px solid #e4e8eb;border-left-width:3px;padding:5px;margin:0 0 1%}
/*menu*/
.menu{position:absolute;background:#fff;border:1px solid #2f5fa1;}
.menu td, .menu li,.menu ul{background:#84aace;padding:0; margin:0}
.menu li{list-style:none;}
.menu a{display:block;padding:3px 15px 3px 15px}
.menu a:hover{background:#2f5fa1;text-decoration:none;color:#fff;}
.menu ul.ul1 li a{display:inline;padding:0}
/*pages*/
.pages{margin:3px 0;font:11px/12px Tahoma}
.pages *{vertical-align:middle;}
.pages a{padding:1px 4px 1px;border:1px solid #2f5fa1;margin:0 1px 0 0;text-align:center;text-decoration:none;font:normal 12px/14px verdana;}
.pages a:hover{border:#000000 1px solid;background:#e4e8eb;text-decoration:none;color:#ffffff}
.pages input{margin-bottom:0px;border:1px solid #000000;height:15px;font:bold 12px/15px Verdana;padding-bottom:1px;padding-left:1px;margin-right:1px;color:#000000;}
/*footer*/
#footer{width:98%;text-align:right;border-top:2px solid #a6cbe7;margin:auto;padding:5px 0;border-bottom:#e4e8eb 12px solid}
#main{width:98%;margin:auto;}
</style><!--css-->

<style type="text/css">/*竖线风格输出*/
.tr3 td,.tr3 th{border-right:1px solid #e4e8eb;}
.y-style{text-align:center;}
.t table{border:0;width:100%;}
.tr1 th{border-right:1px solid #e4e8eb;}
.tr1 td.td1{border-left:0}
.t{padding:1px}
</style>
<!--[if IE]>
<style type="text/css">
.t table{border:1px solid #fff;}
</style><![endif]-->

<!--[if IE]>
<style type="text/css">
.btn{border:3px double #2f5fa1; height:21px;padding-left:0.15em;padding-right:0.15em;}
.tr1 td.td1{border-top:0}
.t4{padding:0}
.pages a{padding:1px 4px 2px;}
.t table{width:100%;border-collapse:collapse;}
.t {padding:0}
.menu a{height:14px}
</style>
<![endif]-->
</head><body>
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

<div class="t3"><table width="100%" cellspacing="0" cellpadding="0" align="center">
<tr><td align="left">
<img src="img/home.gif" align="absbottom" /> <b><a href="">深信服科技内部论坛</a> &raquo; 论坛提示</b></td></tr></table></div>
<div class="t" style="margin-top:15px;">
<table width="100%" cellspacing="0" cellpadding="0" align="center">
<tr><td class="h" colspan="2">深信服科技内部论坛</td></tr>

<tr class="tr1">
<th><br />
<div style="padding:0px 0px 15px 45px; line-height:150%;">
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="login">
<fieldset style="margin:0% 22% 0% 22%;border:1px solid #e4e8eb">
<legend style="padding:0 5px 0 5px;">登录</legend>
<table width="85%" align="center">
<tr>
	<td width="30%" style="height:30px;padding-left:10px;">用户名</td><td> <input class="input" type="text" size="40" tabindex="1" name="pwuser" /></td>
</tr>
<tr>
	<td style="height:30px;padding-left:10px;">密码</td><td> <input class="input" type="password" size="40" tabindex="2" name="pwpwd" /></td>
</tr>

</table>
</fieldset><br />
<center><input class="btn" type="submit" value="登 录" tabindex="4" /></center>
</form><br />
<script language="JavaScript">
document.login.pwuser.focus();
</script>
</th></tr>

</table></div><br />

</div>

<center class="gray">
<small>Total 0.021214(s) query 0, Time now is:10-14 09:03, Gzip enabled <br />
Powered by <a href="http://www.phpwind.net/" target="_blank"><b>PHPWind</b></a> <a href="http://www.phpwind.net/" target="_blank"><b style="color:#FF9900">v5.3</b></a> <a href="http://www.phpwind.com/certificate.php?host=200.200.0.20"><b>Certificate</b></a> Code &copy; 2003-07 <a href="http://www.phpwind.com/" target="_blank"><b>PHPWind.com</b></a> Corporation</small>
</center><br />
<div id="footer">
	<span class="f12 fl"></span><a href="http://bbs">Contact us</a> | <a href="../wap/index.php">Wap</a> | <a href="javascript:scroll(0,0)">Top</a>
</div>
</body></html>

