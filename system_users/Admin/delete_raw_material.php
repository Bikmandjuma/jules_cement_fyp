<?php
    
    include "../../Connect/connection.php";
    $raw_material_id=$_REQUEST['raw_material_id'];
	$sql=mysqli_query($con,"DELETE FROM raw_material where rm_id=".$raw_material_id."");
	if ($sql == true) {
		?>
			<script>
				window.location.href="raw_material.php";
			</script>
		<?php
	}

?>