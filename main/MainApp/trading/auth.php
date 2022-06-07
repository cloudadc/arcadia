<?php
	
	if(empty($_POST['username']) || empty($_POST['password']))
	{
		header("Location: login.php"); /* Redirect browser */
		exit();
	}

	$user=$_POST["username"];
	$pass=$_POST["password"];

	if ($user!="admin" || $pass!="admin")
	{
		header("Location: login.php"); /* Redirect browser */
		$_SESSION['error'] = 1;
			$_SESSION['error_msg'] = "You have entered the wrong username/password. Please try again";
	}
	else
	{
	
		$_SESSION['loggedin'] = true;
		header("Location: index.php"); /* Redirect browser */
		unset($_SESSION['error']);
		unset($_SESSION['error_msg']);
		unset($_SESSION['error_count']);
		exit();
	}
?>
