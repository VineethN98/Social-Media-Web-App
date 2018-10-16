<?php
//Declaring variables to prevent errors
$fname = "";	//First Name
$lname = "";	//Last Name
$em = "";		//Email
$em2 = "";		//Email 2
$password = "";	//Password
$password2 = "";//Password 2
$date = "";		// Sign Up Date
$error_array = array();//Holds Error Messages

if(isset($_POST['register_button'])){

	//Registration form values

	//First Name
	$fname = strip_tags($_POST['reg_fname']);	//Remove HTML tags
	$fname = str_replace(' ', '', $fname);		//Remove the spaces
	$fname = ucfirst(strtolower($fname));		//Uppercase first letter
	$_SESSION['reg_fname'] = $fname;			//Stores the first name into session variables

	//Last Name
	$lname = strip_tags($_POST['reg_lname']);	//Remove HTML tags
	$lname = str_replace(' ', '', $lname);		//Remove the spaces
	$lname = ucfirst(strtolower($lname));		//Uppercase first letter
	$_SESSION['reg_lname'] = $lname;			//Stores the last name into session variables

	//Email
	$em = strip_tags($_POST['reg_email']);		//Remove HTML tags
	$em = str_replace(' ', '', $em);			//Remove the spaces
	$em = ucfirst(strtolower($em));				//Uppercase first letter
	$_SESSION['reg_email'] = $em;				//Stores the email into session variables
	
	//Email 2
	$em2 = strip_tags($_POST['reg_email2']);	//Remove HTML tags
	$em2 = str_replace(' ', '', $em2);			//Remove the spaces
	$em2 = ucfirst(strtolower($em2));			//Uppercase first letter
	$_SESSION['reg_email2'] = $em2;				//Stores the email2 into session variables
	
	//Password
	$password = strip_tags($_POST['reg_password']);	//Remove HTML tags

	//Password 2
	$password2 = strip_tags($_POST['reg_password2']);	//Remove HTML tags

	//Date
	$date = date("d-m-Y");	//Current Date

	if($em == $em2){

		//Check if email is in valid format
		if(filter_var($em,FILTER_VALIDATE_EMAIL)){

			$em = filter_var($em,FILTER_VALIDATE_EMAIL);
			
			//Check if Email already exists
			$e_check = mysqli_query($con,"select email from users where email = '$em'");

			//Count the number of rows returned 
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows>0){

				array_push($error_array,"Email already in use<br>");
			}
		}
		else{
			array_push($error_array,"Invalid Email format<br>");
		}

	}
	else{
		array_push($error_array,"Emails dont match<br>");
	}

	if(strlen($fname) > 25 || strlen($fname)  < 2){

		array_push($error_array,"Your first name should be between 2 and 25 characters<br>");
	}

	if(strlen($lname) > 25 || strlen($lname)  < 2){

		array_push($error_array,"Your last name should be between 2 and 25 characters<br>");
	}

	if($password != $password2){

		array_push($error_array,"Passwords do not match<br>");
	}
	else{
		if(preg_match('/[^A-Za-z0-9]/', $password)){

			array_push($error_array,"Your password can contain only alphanumeric characters<br>");
		}	
	}

	if(strlen($password) > 30 || strlen($password) < 5){

		array_push($error_array,"Your password must be between 5 and 30 characters<br>");
	}

	if(empty($error_array)){
		$password = md5($password);		// Encrypts the password before sending to the database

		//Generate username by concatenating first and last name

		$username = strtolower($fname . "_" . $lname);
		$check_username_query = mysqli_query($con,"select username from users where username = '$username'");

		$i = 0;
		//if username exists add number to the username
		while(mysqli_num_rows($check_username_query) != 0){
			$i++;
			$username = $username . "_" .$i;
			$check_username_query = mysqli_query($con,"select username from users where username = '$username'");
		}

		//proflie pic assignment
		$rand = rand(1,2);

		if($rand == 1)
			$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
		else if($rand == 2)
			$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";

		$query = mysqli_query($con, "insert into users values ('', '$fname', '$lname', '$username', '$em', '$password', '$date', 
			'$profile_pic', '0', '0', 'no', ',')");
		array_push($error_array, "<span style = 'color:#14C800;'>You are all set! Go ahead and login!</span><br>");

		// Clear Session Variables
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
	}
}
?>