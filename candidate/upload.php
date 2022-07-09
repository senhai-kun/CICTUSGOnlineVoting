<?php 
	include("../connection.php"); 

	if( isset($_POST['submit']) ) {
		$file = $_FILES['file'];

		$fileName = $_FILES['file']['name'];

		echo $fileName;
		print_r($file);
	}

	// $name = "";
	// $section = "";

	if ( isset($_POST['findID']) ) {

		// $id = $_POST['idnum'];

		// $searchsql = "SELECT * from usertable";
		// $searchres = mysqli_query($conn, $searchsql);


		// while($row = mysqli_fetch_assoc($searchres)) {
		// 	echo "id: " . $row["idnum"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		// }

	}

	echo "asd";

	
?>