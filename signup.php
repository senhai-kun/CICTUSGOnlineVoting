<?php
	include("connection.php");
	session_start();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CICTUSGOnlineVotingCandidateSignUp</title>
	<!-- CSS only -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
<link rel="stylesheet" type="text/css" href="style.css">
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
	<h1 style="background: mediumseagreen;color: white;">SIGN IN FORM CANDIDACY</h1>
<form method="POST" style="margin-top:3%;margin-left:30%;margin-right: 30%;">
	<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1" >FIRSTNAME</span>
  <input type="text" name="firstname" class="form-control" placeholder="FIRSTNAME" aria-label="FIRSTNAME" aria-describedby="basic-addon1"required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">MIDDLE NAME</span>
  <input type="text"  name="middlename"class="form-control" placeholder="MIDDLE NAME" aria-label="MIDDLE NAME" aria-describedby="basic-addon1"required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">LASTNAME</span>
  <input type="text" class="form-control"  name="lastname"placeholder="LASTNAME" aria-label="LASTNAME" aria-describedby="basic-addon1"required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">COURSE</span>
  <input type="text" class="form-control"  name="course" placeholder="COURSE" aria-label="COURSE" aria-describedby="basic-addon1"required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">YEAR & SECTION</span>
  <input type="text" class="form-control"  name="yearsec" placeholder="YEAR & SECTION" aria-label="YEAR & SECTION" aria-describedby="basic-addon1"required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">ID NUMBER</span>
  <input type="text" class="form-control"  name="idnum" placeholder="ID NUMBER" aria-label="ID NUM" aria-describedby="basic-addon1"required>
</div>
<select name="position" class="form-select" aria-label="Default select example">
  <option selected>POSITION</option>
  <option value="1">President</option>
  <option value="2">Vice President</option>
  <option value="3">Chairman</option>
  <option value="4">Vice Chairman</option>
  <option value="5">Secretary</option>
  <option value="6">Auditor</option>
  <option value="7">Treasurer</option>
  <option value="8">Business Manager</option>
  <option value="9">P.R.O</option>
  <option value="10">1st Year Representative</option>
  <option value="11">2nd Year Representative</option>
  <option value="12">3rd Year Representative</option>
   <option value="13">4th Year Representative</option>
</select>


<?php
if(isset($_POST['signup'])){
$fname = $_POST['firstname'];
$mname = $_POST['middlename'];
$lname = $_POST['lastname'];
$course = $_POST['course'];
$yearsec = $_POST['yearsec'];
$idnum = $_POST['idnum'];
$password = $_POST['password'];
$selected = $_POST['position'];



	$patternName = "/^[a-zA-Z\s]+$/";
	$patternCourse = "/^[A-Z]{3,4}?$/";
	$patternYearSec = "/^[0-9A-Z\s]{2}$/";
	$patternIdnum = "/^[0-9]{10}$/";
	

	if(preg_match($patternName, $fname)){
		if(preg_match($patternName, $mname)){
			if(preg_match($patternName, $lname)){
				if(preg_match($patternCourse, $course)){
					if(preg_match($patternYearSec, $yearsec)){
						if(preg_match($patternIdnum, $idnum)){
							
									// $query = "SELECT * FROM candidatetable WHERE idnum='$idnum'";
      			// 					  $sql = mysqli_query($conn,$query);
     
         // 							 if(mysqli_num_rows($sql) == 1){
       		// 						  $message = "Id Number already exist.";
       		// 						  echo "<label class='red'>" .$message. "</label>";
    					// 		 }else{
    							 	$sql = "INSERT INTO `candidatetable`( `firstname`, `middlename`, `lastname`, `course`, `yearsec`, `idnum`, `password`, `position`) VALUES ('$fname','$mname','$lname','$course','$yearsec','$idnum','$password', '$selected')";
    							 	$insertsql = mysqli_query($conn, $sql);
    							 	if(!$insertsql){
    							 		echo "<script type='text/javascript'>alert('Can't save ');</script>";
    							 	}else{

    							 			$_SESSION['idnum'] = $idnum;
    							 		
    							 			header("Location:index.php?login");
    							 	}
								}else{
									echo"<label style='background-color: green;'>Password did not match</label>";
								}

						}else{
							echo "<label style='background-color: green;'>Id number must be 10 digits only</label>";
						}

					}else{
						echo "<label style='background-color: green;'>Year&Section: 1 Digit and 1 Uppercase letter only</label>";
					}

				}else{
					echo "<label style='background-color: green;'>Course: Uppercase letter only</label>";
				}

			}else{
				echo "<label style='background-color: green;'>Lastname: Uppercase and lowercase letter only</label>";
			}

		}else{
			echo "<label style='background-color: green;'>Middlename: Uppercase and lowercase letter only</label>";
		}
	}else{
		echo "<label style='background-color: green;'>Firstname: Uppercase and lowercase letter only</label>";
	}





?>


<input class="btn btn-primary" type="submit" name="signup" value="Sign Up">
<a class="btn btn-danger" href="index.php" role="button">Exit</a>
	






</form>
</body>
</html>