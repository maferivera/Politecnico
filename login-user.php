<?php
require_once 'includes/connect.php';
session_start();
if(isset($_POST["submit"])){
	$doc = trim($_POST["Document"]);
	$password = sha1($_POST["Password"]);

	$sql = "SELECT * FROM Estudiante WHERE Document = '{$doc}' AND Password = '{$password}'";
	$login = mysqli_query($db, $sql);

	if($login && mysqli_num_rows($login) == 1){
		$_SESSION["logged"] = mysqli_fetch_assoc($login);

		if(isset($_SESSION["error_login"])){
			unset($_SESSION["error_login"]);
		}

		header("Location: index.php");
	}else{
		$_SESSION["error_login"] = "Login incorrect!!";
	}
}
header("Location: login.php");
?>
