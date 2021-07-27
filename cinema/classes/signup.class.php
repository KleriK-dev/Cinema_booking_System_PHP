<?php 

class UserSignup{
	
	private $firstName;
	private $lastName;
	private $email;
	private $username;
	private $password;
	private $phoneNumber;
	private $userRole;
	
	function __construct($firstName, $lastName, $email, $username, $password, $phoneNumber, $userRole){
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;
		$this->phoneNumber = $phoneNumber;
		$this->userRole = $userRole;
	}
	
	public function insert_new_user(){
		
		//connecting to database
		include "../includes/connectDB.inc.php";

		    $firstname = mysqli_real_escape_string($conn, $this->firstName);
			$lastname = mysqli_real_escape_string($conn, $this->lastName);
			$email = mysqli_real_escape_string($conn, $this->email);
			$username = mysqli_real_escape_string($conn, $this->username);
			$password = mysqli_real_escape_string($conn, $this->password);
			$phone = mysqli_real_escape_string($conn, $this->phoneNumber);

		//first select all the emails and usernames that exists in database
		$query1 = "SELECT userName, userEmail FROM users";

		$result1 = $conn->query($query1);
		$row1 = mysqli_fetch_assoc($result1);
			
		if($result1->num_rows > 0){

			foreach($result1 as $row1){

				//check if the input of user exists on the database
				if($username == $row1['userName']){
					header("Location: ../index.php?signup=userNameExists");
					exit;
				} else if($email == $row1['userEmail']){
					header("Location: ../index.php?signup=emailExists");
					exit;
				}

			}
			

		//before inserting the data we need to hash user's password
		$hashedPassw = password_hash($password, PASSWORD_DEFAULT);
		
		//insert the data to database
		$query = "INSERT INTO users (userFirstName, userLastName, userEmail, userName, userPassw, userPhone) 
			VALUES ('$firstname', '$lastname', '$email', '$username', '$hashedPassw', '$phone')";
		
		//Check sign up insertion
		if($conn->query($query) == true){
			header("Location: ../index.php?signup=succes");
			exit();
		}else{
			header("Location: ../index.php?signup=failed");
			exit();
		}

	}

	 

	}

	public function insert_new_user_admin(){
		
		//connecting to database
		include "../includes/connectDB.inc.php";

		//first select all the emails and usernames that exists in database
		$query1 = "SELECT userName, userEmail FROM users";

		$result1 = $conn->query($query1);
		$row1 = mysqli_fetch_assoc($result1);
			
		if($result1->num_rows > 0){

			foreach($result1 as $row1){

				//check if the input of user exists on the database
				if($this->username == $row1['userName']){
					header("Location: ../index.php?signup=userNameExists");
					exit;
				} else if($this->email == $row1['userEmail']){
					header("Location: ../index.php?signup=emailExists");
					exit;
				}

			}

		//before inserting the data we need to hash user's password
		$hashedPassw = password_hash($this->password, PASSWORD_DEFAULT);
		
		//insert the data to database
		$query = "INSERT INTO users (userFirstName, userLastName, userEmail, userName, userPassw, userPhone, role) 
		VALUES ('$this->firstName', '$this->lastName', '$this->email', '$this->username', '$hashedPassw', '$this->phoneNumber', '$this->userRole')";
		
		//Check sign up insertion
		if($conn->query($query) == true){
			header("Location: ../addUser.php?userAdded=succes");
			exit();
		}else{
			header("Location: ../addUser.php?userAdded=failed");
			exit();
		}

	}

	}
	
}

//check if submit button and recaptcha checkbox is pressed 
if(isset($_POST['signup-submit']) && !empty($_POST['g-recaptcha-response'])){

	$secret = '6LcIX8QaAAAAAJyj7s-cihTWf0uK9tpz3s72d-LL';
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' .$_POST['g-recaptcha-response']);
	$responseData = json_decode($verifyResponse);

	if($responseData->success){

		$newUser = new UserSignup($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['phonenumber'], null);
	
		$newUser->insert_new_user();

	} else {
		header("Location: ../index.php?signup=failedreCAPTCHA");
	}
	
} else {
	header("Location: ../index.php?signup=failedEmptyreCAPTCHA");
}

//check if submit button and recaptcha checkbox is pressed from administrator
if(isset($_POST['signup-submit-admin']) && !empty($_POST['g-recaptcha-response'])){

	$secret = '6LcIX8QaAAAAAJyj7s-cihTWf0uK9tpz3s72d-LL';
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' .$_POST['g-recaptcha-response']);
	$responseData = json_decode($verifyResponse);

	if($responseData->success){

		$newUserAdmin = new UserSignup($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['phonenumber'], $_POST['userRole']);
	
		$newUserAdmin->insert_new_user_admin();

	} 
	
} 