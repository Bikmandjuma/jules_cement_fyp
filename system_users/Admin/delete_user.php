<?php
    
    include "../../Connect/connection.php";
    $user_id=$_REQUEST['user_id'];
	$sql=mysqli_query($con,"DELETE FROM users where u_id=".$user_id."");
	if ($sql == true) {
		?>
			<script>
				window.location.href="users.php";
			</script>
		<?php
	}

?>