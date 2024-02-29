<?php
	$con=mysqli_connect("localhost","root","","cementdb");
	if (!$con) {
		die("Database connection error !").mysqli_connect_error();
	}
?>