<?php
	
	class UserLogin{
		
		private $username;
		private $password;
		
		function __construct($username, $password){
			$this->username = $username;
			$this->password = $password;
		}
		
		public function login_User(){
			
			include "../includes/connectDB.inc.php";

			$username = mysqli_real_escape_string($conn, $this->username);
			$passw = mysqli_real_escape_string($conn, $this->password);

			//select the hashed password of the user's username input
			$query1 = "SELECT userPassw FROM users WHERE userName='$username'";

			$result1 = $conn->query($query1);
			$row1 = mysqli_fetch_assoc($result1);

			if($result1->num_rows == 1){
			
			//dehash his password and check if its corret
			if(password_verify($passw, $row1['userPassw'])){
			
			//select all the other data of this user
			$query = "SELECT * FROM users WHERE userName='$username' ";
			
			$result = $conn->query($query);
			$row = mysqli_fetch_assoc($result);
			
			//Check if user is signed up by checking if the previous query gives one row
			if($result->num_rows == 1){
				
				session_start();
				
				$_SESSION['userId'] = $row['userID'];
				$_SESSION['userRole'] = $row['role'];
				$_SESSION['name'] = $row['userFirstName'];
				
				header('Location: ../index.php?login=success');
				exit();
				
				} else {
					header("Location: ../index.php?login=failed");
					exit();
				}
				
		} else {
			header("Location: ../index.php?login=failed");
			exit();
		}
	} else {
		header("Location: ../index.php?login=notExists");
		exit();

	}
}
	}
	
	if(isset($_POST['login-submit'])){ //check if login button was pressed
		
		$u1 = new UserLogin($_POST['Lusername'], $_POST['Lpassword']);
		
		$u1->login_User();
		
	}		