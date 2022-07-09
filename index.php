
<?php
    include "connection.php";
    session_start();
?>

<html>
<head>
	<title>CICTUSGOnlineVotingLoginPage</title>
	<?php  if(isset($_GET['login'])){ ?><script type="text/javascript">alert('Successfully Saved'); <?php } ?></script>
	
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
	
    <h1 style="background: mediumseagreen;color: white;">LOGIN FORM</h1>
	<form method="POST" style="margin-top:10%;margin-left:30%;margin-right: 30%;">
	<div class="input-group mb-3">
  	<span class="input-group-text" id="basic-addon1">ID NUMBER</span>
 	<input type="text" class="form-control"  name="idnum" placeholder="ID NUMBER" aria-label="ID NUM" aria-describedby="basic-addon1"required>
	</div>
	<div class="input-group mb-3">
  	<span class="input-group-text" id="basic-addon1">PASSWORD</span>
  	<input type="password" class="form-control"  name="password" placeholder="PASSWORD" aria-label="PASSWORD" aria-describedby="basic-addon1" required>
	</div>
			
			
	<input class="btn btn-primary" type="submit" name="login" value="Login">
	<a class="btn btn-primary" href="registration.php" role="button">Register</a>
			
	</form>
	


	<?php
		if(isset($_POST['login'])){
			 $idnum = $_POST['idnum'];
       		 $password = $_POST['password'];
       		 $encrypted_pw = sha1($password);

       		 $checkIdNum = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$idnum' ");
			$showIdNum =  mysqli_num_rows($checkIdNum);
			 if($showIdNum == 1){
			 	$_SESSION['idnum'] = $idnum;
			 	$id = $_SESSION['idnum'];

			 	$checkPass = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$id' AND password = '$encrypted_pw' AND statusLock != 0 ");
				$showPass =  mysqli_num_rows($checkPass);
				
				if($showPass == 1){
			 	$_SESSION['password'] = $encrypted_pw;

			 	$row2 = mysqli_fetch_array($checkPass);
			 	if($row2['userType'] == 'admin'){	
			 		$_SESSION['userType'] = $row2['userType'];
			 		header("Location:admin.php");
			 	}elseif($row2['userType'] == user){
			 		header("Location:homepage.php");
			 	}
			 	}else{
			 		
					$result = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$id' ");
					$row = mysqli_fetch_array($result);
						$status = $row['statusLock'];
					if($status == 0){
						 echo"<label style='background-color: green;'>Your Account has been blocked! </label>";
					}else{
						//  "wrong password";
						$statusUpdate = $status -1;
					mysqli_query($conn, "UPDATE  usertable SET statusLock = '$statusUpdate' WHERE idnum = '$id' ");
					header("Location:index.php?attempt");
					}

				}

			 }else{
			 	header("Location:?return");
			 }	
	}
		if(isset($_GET['attempt'])){
				$sqlStatus = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$_SESSION[idnum]' ");
					$row = mysqli_fetch_array($sqlStatus);
						$status = $row['statusLock'];
					
					echo "Remaining attempt:  ". $status;
			}
				if(isset($_GET['return'])){
			echo "
			<script>alert('You need to Register or Login first!!!')</script>";
		}


	?>

</body>

</html>