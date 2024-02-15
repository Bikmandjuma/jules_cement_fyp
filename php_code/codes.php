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

}


?>