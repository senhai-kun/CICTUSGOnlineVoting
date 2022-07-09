<?php
include("connection.php");
session_start();
$back = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$_SESSION[idnum]' AND password = '$_SESSION[password]' ");
	$back_session = mysqli_num_rows($back);
	$update = mysqli_query($conn, "UPDATE usertable SET statusLock = '3' WHERE idnum = '$_SESSION[idnum]' ");
	if($back_session  == 0 )
		header("Location:index.php?return");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CICTUSGOnlineVotingAdminPage</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		table, td, th {
 		 border: 1px solid black;
	}

	table {
 		 border-collapse: collapse;
 		 width: fit-content;

	}

	th {
 		 height: 4vh;
	}
	</style>
</head>
<body>
	<h1 style="background: mediumseagreen;color: white;">WELCOME ADMIN </h1>
	<table class="table bg-white">
  <thead>
    <tr>
      <th scope="col">FIRSTNAME</th>
      <th scope="col">MIDDLE NAME</th>
      <th scope="col">LASTNAME</th>
      <th scope="col">COURSE</th>
      <th scope="col">YR & SECTION</th>
	  <th scope="col">ID NUMBER</th>
	  <th scope="col">PASSWORD</th>
	  <th scope="col">USER TYPE</th>
	  <th scope="col">LOGIN ATTEMPT</th>
	  <th colspan="2">ACTION</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php

		$column = mysqli_query($conn, "SELECT * FROM usertable");

		while($rows = mysqli_fetch_array($column)){

			echo "<tr>";
			echo "<td>" . $rows['firstname'] . "</td> " ;
			echo "<td>" .  $rows['middlename'] . "</td>";
			echo "<td>" .  $rows['lastname'] . "</td>";
			echo "<td>" . $rows['course'] . "</td>";
			echo "<td>" . $rows['yearsec'] . "</td>" ;
			echo "<td>" . $rows['idnum'] . "</td>" ; 
			echo "<td>" . $rows['password'] . "</td>" ; 
			echo "<td>" . $rows['userType'] . "</td>" ; 
			echo "<td>" . $rows['statusLock'] . "</td>" ; 
			echo "<td><a class='btn btn-primary' href='update.php?id=".$rows['idnum']."' role='button'>Edit</a></td>";
			echo "<td><a class='btn btn-danger' href='delete.php?delete=".$rows['idnum']."' role='button'>Delete</a></td>";
			echo "<td><a class='btn btn-success' href='reset.php?reset=".$rows['idnum']."' role='button'>Reset</a></td>";
			echo "</tr>";
			
		}
	?>
    </tr>
  </tbody>
</table>
	<form method="POST">
		<input class="btn btn-danger" type="submit" name="logout" value="Logout">
		<a class="btn btn-secondary" href="candidate/candidate.php"role="button">Candidates</a>
	
	</form>
	<?php
		if(isset($_POST['logout'])){
			session_destroy();
			header("location:index.php");
		}
	?>	
</body>
</html>