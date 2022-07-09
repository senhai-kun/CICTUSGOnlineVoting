<?php
	session_start();
	include("connection.php"); 
	$back = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$_SESSION[idnum]' AND password = '$_SESSION[password]' ");
	$back_session = mysqli_num_rows($back);
	$update = mysqli_query($conn, "UPDATE usertable SET statusLock = '3' ");
	if($back_session  == 0 )
		header("Location:index.php?return");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CICTUSGOnlineVotingHomePage</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
<style type="text/css">
	#basic-addon1{
		width: 200px;
	}
	.input-group mb-3{
		width: 300px;
	}

	table, td, th {
 		 border: 1px solid black;
	}

	table {
 		 border-collapse: collapse;
 		 width: 100%;
	}

	th {
 		 height: 70px;
	}
</style>
</head>
<body>
	<h1 style="background: mediumseagreen;color: white;">WELCOME!
	<?php 
		$fullname = mysqli_query($conn,"SELECT firstname, lastname from usertable where idnum= '$_SESSION[idnum]'");
		while ($rows = mysqli_fetch_array($fullname))
		echo $rows['firstname'] . " " . $rows['lastname'];
	?> </h1>

	<div class="container" >
		<form  method="post">
			<div class="d-flex justify-content-between mb-5" >
				<div class="d-flex gap-4">
					<a class="btn btn-secondary" href="candidate/candidate.php"role="button">CANDIDATES</a>
					<a class="btn btn-primary" href="voting/voting.php"role="button">VOTE</a>
					<a class="btn btn-outline-success" href="result/result.php"role="button">VIEW RESULTS</a>
				</div>

				<input class="btn btn-danger" type="submit" name="logout" value="Logout">
				<?php
					if(isset($_POST['logout'])){
						session_destroy();
						header("Location:index.php");
					}
				?>
			</div>


			<input class="p-2" type="text" name="word">
			<input class="btn btn-primary" type="submit" name="search" value="search">

			<?php
				if(isset($_POST['search'])){
			?>
			<table class="table bg-white mt-3">
				<thead>
					<tr>
					<th scope="col">FIRSTNAME</th>
					<th scope="col">MIDDLE NAME</th>
					<th scope="col">LASTNAME</th>
					<th scope="col">COURSE</th>
					<th scope="col">YR & SECTION</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$word = $_POST['word'];
						$result = mysqli_query($conn, "SELECT * FROM usertable WHERE firstname LIKE '%$word%' OR lastname LIKE '%$word%'");
						while($rows = mysqli_fetch_array($result)){
						echo "<tr>";
						echo "<td>" . $rows['firstname'] . "</td> " ;
						echo "<td>" .  $rows['middlename'] . "</td>";
						echo "<td>" .  $rows['lastname'] . "</td>";
						echo "<td>" . $rows['course'] . "</td>";
						echo "<td>" . $rows['yearsec'] . "</td>" ;
						echo "</tr>";
						}
					}
					?>
				</tbody>
			</table>
		</form>
	</div>
</body>
</html>