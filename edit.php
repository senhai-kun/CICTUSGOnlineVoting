<?php
	include("")
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>edit</title>
		<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style type="text/css">
	#basic-addon1{
		width: 200px;
	}
	.input-group mb-3{
		width: 300px;
	}
</style>
</head>
<body>
	<h1 style="background: mediumseagreen;color: white;">EDIT FORM</h1>
<form method="POST" style="margin-top:10%;margin-left:30%;margin-right: 30%;">

	<?php 
		include "connection.php";
	



		if(isset($_GET['id'])){
			$edit_specific = mysqli_query($conn, "SELECT * FROM usertable WHERE id = '$_GET[id]'");
			while($row = mysqli_fetch_array($edit_specific)){
				$name = $row['name'];
				$email = $row['email'];
				$password = $row['password'];
				$gender = $row['gender'];
			}
			
	?>
 <div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1" >FIRSTNAME</span>
  <input type="text" name="firstname" class="form-control" placeholder="FIRSTNAME" aria-label="FIRSTNAME" aria-describedby="basic-addon1" value="<?php echo $fname; ?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">MIDDLE NAME</span>
  <input type="text"  name="middlename"class="form-control" placeholder="MIDDLE NAME" aria-label="MIDDLE NAME" aria-describedby="basic-addon1" value="<?php echo $mname; ?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">LASTNAME</span>
  <input type="text" class="form-control"  name="lastname"placeholder="LASTNAME" aria-label="LASTNAME" aria-describedby="basic-addon1" value="<?php echo $lname; ?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">COURSE</span>
  <input type="text" class="form-control"  name="course" placeholder="COURSE" aria-label="COURSE" aria-describedby="basic-addon1" value="<?php echo $course; ?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">YEAR & SECTION</span>
  <input type="text" class="form-control"  name="yearsec" placeholder="YEAR & SECTION" aria-label="YEAR & SECTION" aria-describedby="basic-addon1" value="<?php echo $yearsec; ?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">ID NUMBER</span>
  <input type="text" class="form-control"  name="idnum" placeholder="ID NUMBER" aria-label="ID NUM" aria-describedby="basic-addon1" value="<?php echo $idnum; ?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">PASSWORD</span>
  <input type="password" class="form-control"  name="password" placeholder="PASSWORD" aria-label="PASSWORD" aria-describedby="basic-addon1" value="<?php echo $password; ?>" >
</div>
	<input class="btn btn-secondary" type="submit" name="save" value="Save">
	</form>

	 <?php 
	 	if(isset($_POST['save'])){
	 		$fname = $_POST['firstname'];
	 		$mname = $_POST['middlename'];
	 		$lname = $_POST['lastname'];
	 		$course = $_POST['course'];
	 		$yearsec = $_POST['yearsec'];
	 		$mname = $_POST['idnum'];
	 		$password = $_POST['password'];
	 		

	 		$update_info = mysqli_query($conn, "UPDATE usertable SET firstname = '$fname', middlename = '$mname', lastname = '$lname', course = '$course', yearsec = '$yearsec', idnum = '$idnum' password = '$password' WHERE id='$_GET[id]'");

	 		if($update_info){
	 			header("location:homepage.php");
	 		}else{
	 			die("unable to update");
	 		}
	 	}

	  ?>
	
</body>
</html>