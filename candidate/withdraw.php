<?php 
	include("../connection.php"); 

	if ( isset($_POST['withdrawID']) ) {

		$getCandidateDatailsSql = "SELECT * from candidates WHERE idnum = '$_POST[withdrawID]' ";
		$getCandidateRes = mysqli_query($conn, $getCandidateDatailsSql);

		$candidate = mysqli_fetch_assoc($getCandidateRes);
		echo mysqli_error($conn);

		// echo $candidate['position'];
		// echo $_POST['withdrawID'];

		unlink($candidate['img']); // delete candidate profile image

		// withdraw candidate to database
		$withdraw = "DELETE FROM candidates WHERE idnum = '$_POST[withdrawID]'";
		if( mysqli_query($conn, $withdraw) ) {
			echo `
				<script>alert('Candidate Has Been Withdrawn!')</script>
				<script>window.location.reload(true)</script>
			`;
		} else {
			echo "Error!" . mysqli_error($conn);
		}

	}

?>
