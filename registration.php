<?php
	include("connection.php");
	session_start();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CICTUSGOnlineVotingRegistration</title>
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
	<h1 style="background: mediumseagreen;color: white;">REGISTRATION FORM</h1>
<form method="POST" class="w-50 m-auto">
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
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">PASSWORD</span>
  <input type="password" class="form-control"  name="password" placeholder="PASSWORD" aria-label="PASSWORD" aria-describedby="basic-addon1" required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">CONFIRM PASSWORD</span>
  <input type="password" class="form-control"  name="cpassword" placeholder="CONFIRM PASSWORD" aria-label="CONFIRM PASSWORD" aria-describedby="basic-addon1" required>
</div>

<?php
if(isset($_POST['register'])){
$fname = $_POST['firstname'];
$mname = $_POST['middlename'];
$lname = $_POST['lastname'];
$course = $_POST['course'];
$yearsec = $_POST['yearsec'];
$idnum = $_POST['idnum'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];


	$patternName = "//";
	$patternCourse = "//";
	$patternYearSec = "//";
	$patternIdnum = "//";
	$patternPassword =  "//";

	// $patternName = "/^[a-zA-Z\s]+$/";
	// $patternCourse = "/^[A-Z]{3,4}?$/";
	// $patternYearSec = "/^[0-9A-Z\s]{2}$/";
	// $patternIdnum = "/^[0-9]{10}$/";
	// $patternPassword =  "/^(?=.*[A-Z])(?=.*[a-z])[\s\S \d]{4,8}$/";

	if(preg_match($patternName, $fname)){
		if(preg_match($patternName, $mname)){
			if(preg_match($patternName, $lname)){
				if(preg_match($patternCourse, $course)){
					if(preg_match($patternYearSec, $yearsec)){
						if(preg_match($patternIdnum, $idnum)){
							if(preg_match($patternPassword, $password)){
								if($cpassword == $password){
									$password = sha1($cpassword);

									$query = "SELECT * FROM usertable WHERE idnum='$idnum'";
      								  $sql = mysqli_query($conn,$query);
     
         							 if(mysqli_num_rows($sql) == 1){
       								  $message = "Id Number already exist.";
       								  echo "<label class='red'>" .$message. "</label>";
    							 }else{
    							 	$sql = "INSERT INTO `usertable`( `firstname`, `middlename`, `lastname`, `course`, `yearsec`, `idnum`, `password`, `userType`, `statusLock`) VALUES ('$fname','$mname','$lname','$course','$yearsec','$idnum','$password', 'user', 3)";
    							 	$insertsql = mysqli_query($conn, $sql);
    							 	if(!$insertsql){
    							 		echo "<script type='text/javascript'>alert('Can't save ');</script>";
    							 	}else{

    							 			$_SESSION['idnum'] = $idnum;
    							 			$_SESSION['password'] = $password;
    							 		
    							 			header("Location:index.php?login");
    							 	}
    							 }
								}else{
									echo"<label style='background-color: green;'>Password did not match</label>";
								}

							}else{
								echo "<label style='background-color: green;'>Password:Must be 4-8 characters consists of Uppercase and lowercase letter and atleast 1 digit</label>";
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


}


?>


<input class="btn btn-primary" type="submit" name="register" value="Register">
<a class="btn btn-primary" href="index.php" role="button">Login</a>
	






</form>
</body>
</html>