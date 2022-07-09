<?php 
	include "connection.php";
	session_start();
	if(isset($_GET['reset'])){
		$id = $_GET['reset'];
		$sql = mysqli_query($conn, "UPDATE usertable SET statusLock = 3 WHERE id = $id ");
				header("location:admin.php");

	}

?>

