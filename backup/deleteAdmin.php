<?php
require 'core/init.php';
$general->logged_out_protect();
 
	$admin_id =$_REQUEST['admin_id'];
	
	$admin->deleteAdmin($admin_id);
	
	Print '<script>alert("Admin Successfully Deleted");;
	window.location.assign("home.php")</script>';	
	
?>