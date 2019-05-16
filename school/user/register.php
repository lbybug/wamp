<?php

	$dbHost = "127.0.0.1";
	$dbUser = "root";
	$dbPass = "061300";
	$dbName = "school";
	
	$con = new mysqli($dbHost,$dbUser,$dbPass,$dbName);
	
	if($con->connect_error){
		die("连接失败: " . $con->connect_error);
	}
	
	$register_account = $_POST['account'];
	
	$register_pass = $_POST['pass'];
	
	$register_email = $_POST['email'];
	
	$register_qq = $_POST['qq'];
	
	$register_address = $_POST['address'];
		
	// $register_account = $_GET['account'];
	
	// $register_pass = $_GET['pass'];
	
	// $register_email = $_GET['email'];
	
	// $register_qq = $_GET['qq'];
	
	// $register_address = $_GET['address'];
		
	$sql = "select * from user where user_account = " .$register_account; //查询是否有这个账号
	
	$result = $con->query($sql);
	
	$user = new UerBean();
		
	if($result->num_rows > 0){
		$user->status = '1';
		$user->error ='用户已注册';
	}else{
		if($register_account != null
		&& $register_pass != null
		&& $register_email != null
		&& $register_qq != null
		&& $register_address != null){
			$md5Pass = md5($register_pass);
			$md5Token = md5($register_account);
			
			$insert_sql = "INSERT INTO user ".
			"(user_account,user_password, user_name,user_email,user_qq,user_address,user_token,user_status) ".
			"VALUES ".
			"('$register_account','$md5Pass','$register_account','$register_email','$register_qq','$register_address','$md5Token','0')";
				
			if($con->query($insert_sql) == true){
				$user->status = '0';
				$user->error ='注册成功';
			}else{
				$user->status = '2';
				$user->error ='注册失败';
			}
		}else{
			$user->status = '2';
			$user->error ='注册失败';
		}
	}
	
	echo json_encode($user);
	
	$con->close();
	
	class UerBean{
		public $status = '';
		public $error = '';
	}
?>