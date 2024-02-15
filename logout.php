<?php

	session_start();
	session_destroy();
	include_once('Connect/connection.php');

	$user_id=$_SESSION['u_id'];
	date_default_timezone_set("Afrika/Kigali");

	$tm=date("Y-m-d H:i:s");
	$status="OFF";

	$diplic_online_user_sql=mysqli_query($con,"SELECT * from online_users where user_fk_id='".$user_id."'");
	$diplic_online_user_nums=mysqli_num_rows($diplic_online_user_sql);

	if ($diplic_online_user_nums > 0) {
	    mysqli_query($con,"UPDATE online_users SET status='$status',period='$tm' where user_fk_id='".$user_id."' ");
	}

	header('location:Sign_in.php');

?>