<?php
session_start();

include '../../db/_db.php';

if(isset($_POST['OTP'])){
	$otp=$_POST['OTP'];
	
	$emailquery="SELECT * from `users` WHERE `otp`='$otp'";
	$query=mysqli_query($con, $emailquery);
	$count=mysqli_num_rows($query);

	if($count>0){
		$row=mysqli_fetch_assoc($query);
		$email = $row['email'];

		$updatequery="UPDATE `users` SET `status`='active' where `otp`='$otp'";
		$query= mysqli_query($con,$updatequery);

		$updatequery1="UPDATE `users` SET `otp`='0' where `otp`='$otp'";
		$query1= mysqli_query($con,$updatequery1);
		if($query){
			
			// echo 5;
			$dataset = array("status" => "success", "path" => "/auth/recover/recover.php");
			$dataJSON = json_encode($dataset);
			echo $dataJSON;
			$_SESSION['current_email']=$email;
		}
	}else{
		echo "OTP not matched!";
	}
}
