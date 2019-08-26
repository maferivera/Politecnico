<?php
session_start();
if(isset($_SESSION["logged"]) && $_SESSION["logged"]["Rol"] == 1){
	require_once 'includes/connect.php';

	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$delete = mysqli_query($db, "DELETE FROM Estudiante WHERE user_id = {$id}");
	}
}
header("Location: index.php");
?>
