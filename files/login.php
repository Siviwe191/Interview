<?php
if(isset($_POST["username"]) && !empty($_POST["password"])){
		$username = filter_input(INPUT_POST,'username');
		$password = filter_input(INPUT_POST,'password');
		htmlspecialchars($username);
		htmlspecialchars($password);
		require_once('../db_connect/db_con.php');
		$query_user = "select * from users where AES_DECRYPT(username,'$encrypt_key')='".$username."' && AES_DECRYPT(password,'$encrypt_key')='".$password."'";
		$statement = $conn->prepare($query_user);
		$statement->execute();
		$user = $statement->fetchAll();
		$statement->closeCursor();

				if(count($user) == 0){
					//$error="username or password are incorect,Please try again";
					//setcookie("user_error",$error,time()+3000,"/");
					//echo "<meta http-equiv=Refresh content=1;url=../login.html>";
					echo "<script>alert('username or password are incorect,Please try again');window.location.href='../login.html'</script>";
                 // header('Location: '.'../login.html');
			
					
				}else if(count($user) == 1){
	
					foreach($user as $users):
	
						setcookie("usercookie",$users["user_id"],time()+84600,"/");
						setcookie("username",$username,time()+84600,"/");
						setcookie("password",$password,time()+84600,"/");
			if(isset($_POST["remember"])){
		
					setcookie("userremember","remember me",time()+84600,"/");	
				}
							$newURL="../index.php";
							header('Location: '.$newURL);
								endforeach;
		}
	}
?>