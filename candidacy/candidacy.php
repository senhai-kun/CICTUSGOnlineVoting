<?php
	session_start();
	include("../connection.php"); 
	$back = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$_SESSION[idnum]' AND password = '$_SESSION[password]' ");
	$back_session = mysqli_num_rows($back);
	$update = mysqli_query($conn, "UPDATE usertable SET statusLock = '3' ");
	if($back_session  == 0 )
		header("Location:../index.php?return");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

	<title>CICTUSGOnlineVotingSignUp</title>
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1 style="background: mediumseagreen;color: white;">SIGN IN FORM CANDIDACY</h1>

    <div class="container pb-5">
    <?php 
    	$checkCandidacySql = "SELECT * FROM candidates WHERE idnum = '$_SESSION[idnum]' ";
    	$checkCandidacyRes = mysqli_query($conn, $checkCandidacySql);
    	if ( mysqli_num_rows($checkCandidacyRes) !== 0 ) {
    		include "notice.php"; // user already submitted their candidacy
    	} else {
    		echo '<h5 class="fw-bold" >REMINDER: Add reminder here like on filling up the form or something! (form.php line 4)</h5>';

    		include "form.php";
    		echo "<script type='text/javascript' src='candidacy.js' ></script>";
    	}
    ?>
    </div>
</body>
</html>