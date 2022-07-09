<?php 
	include "connection.php";
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
		$delete = mysqli_query($conn, "DELETE FROM usertable WHERE id = '$id'");
		if($delete)
			header("location:admin.php");
		else
			echo "
			<script>alert('Unable to delete!!!')</script>";
				header("location:admin.php");

	}
?>