<?php

	$dbHost = "127.0.0.1";
	$dbUser = "root";
	$dbPass = "061300";
	$dbName = "school";
	
	$con = new mysqli($dbHost,$dbUser,$dbPass,$dbName);
	
	if($con->connect_error){
		die("连接失败: " . $con->connect_error);
	}
	
	$login_account = $_POST['account'];
	
	$login_pass = $_POST['pass'];
	
	// $login_account = $_GET['account'];
	
	// $login_pass = $_GET['pass'];
		
	$sql = "select * from user where user_account = " .$login_account; //查询是否有这个账号
	
	$result = $con->query($sql);
	
	$user = new UerBean();
	
	$user->account = $login_account;
	
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		if($row['user_password'] == $login_pass){
			$user->name = $row['user_name'];
			$user->account = $row['user_account'];
			$user->email = $row['user_email'];
			$user->qq = $row['user_qq'];
			$user->token = $row['user_token'];
			$user->address = $row['user_address'];
			$user->status = '0';
			$user->error = '登陆成功';
		}else{
			$user->status = '1';
			$user->error = '密码错误';
		}
	}else{
		$user->status = '2';
		$user->error = '用户还未注册';
	}
	
	echo json_encode($user);
	
	$con->close();
	
	class UerBean{
		public $name = '';
		public $account = '';
		public $email = '';
		public $qq = '';
		public $token = '';
		public $address = '';
		public $status = '';
		public $error = '';
	}
?>