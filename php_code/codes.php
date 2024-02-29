<?php
	class Cement{

		public function oncline_users_counts(){
			require '../../Connect/connection.php';
			$online_user_sql=mysqli_query($con,"SELECT * from online_users where status='ON'");
			$online_user_nums=mysqli_num_rows($online_user_sql);

			echo $online_user_nums;

		}

		//fetch users counts
		public function users_counts(){
			require '../../Connect/connection.php';
			$user_sql=mysqli_query($con,"SELECT * from users");
			$user_nums=mysqli_num_rows($user_sql);

			echo $user_nums;

		}


		//User php codes
		//raw materials counts

		public function raw_materials_count(){
			require '../../Connect/connection.php';
			$raw_mater_sql=mysqli_query($con,"SELECT * from raw_material");
			$raw_mater_nums=mysqli_num_rows($raw_mater_sql);

			echo $raw_mater_nums;
		}


		//report counts fetch to the users
		public function report_count(){
			require '../../Connect/connection.php';
    		$users_id=$_SESSION['u_id'];
			$report_sql=mysqli_query($con,"SELECT * from raw_material where quantity_consumed != 0 and user_fk_id=".$users_id."");
			$report_nums=mysqli_num_rows($report_sql);

			echo $report_nums;
		}

		//report counts fetch to admin panel
		public function report_count_on_admin(){
			require '../../Connect/connection.php';
    		
			$report_sql=mysqli_query($con,"SELECT * from raw_material where quantity_consumed!=0");
			$report_nums=mysqli_num_rows($report_sql);

			echo $report_nums;
		}


		//select raw_materials
		public function select_raw_material(){
			require '../../Connect/connection.php';
			$raw_mater_sql=mysqli_query($con,"SELECT * from raw_material");
			while ($row_select_raw_mater=mysqli_fetch_assoc($raw_mater_sql)) {
				$rm_id=$row_select_raw_mater['rm_id'];
				$rm_name=$row_select_raw_mater['name'];
				echo "<option value='".$rm_id."'>".$rm_name."</option>";
			}
		}



	}

?>