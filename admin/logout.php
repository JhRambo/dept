<?php
	
	setcookie('userName','',time()-3600);
	
	header("location:"."login.php");