<?php
	session_start();
	include("../connection.php"); 
	include "../utils.php";
	$back = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$_SESSION[idnum]' AND password = '$_SESSION[password]' ");
	$back_session = mysqli_num_rows($back);
	$update = mysqli_query($conn, "UPDATE usertable SET statusLock = '3' ");
	if($back_session  == 0 )
		header("Location:../index.php?return");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

	<title>CICTUSGOnlineVotingResult</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<h1 style="background: mediumseagreen;color: white;">VOTING RESULTS</h1>

	<div class="container text-dark mb-5">

		<?php 
			$totalVotersSql = "SELECT count(voted) as totalVoters from usertable WHERE userType = 'user'";
			$votersRes = mysqli_query($conn, $totalVotersSql);

			$totalVoters = mysqli_fetch_assoc( mysqli_query($conn, $totalVotersSql) )['totalVoters'];

			$votersSql = "SELECT count(voted) as voters from usertable WHERE userType = 'user' AND voted = false ";
			$voters = mysqli_fetch_assoc( mysqli_query($conn, $votersSql) )['voters'];

			$votedSql = "SELECT count(voted) as voted from usertable WHERE userType = 'user' AND voted = true ";
			$voted = mysqli_fetch_assoc( mysqli_query($conn, $votedSql) )['voted'];

			$totalVoted = round( ($voted * 100) / $totalVoters );
			$votersLeft = round( ($voters * 100) / $totalVoters );

		?>
		<div class="mb-5">
			<div class="d-flex justify-content-between">
				<h4>Total Voted: <?php echo $totalVoted; ?>%</h4>
				<h4>Voters Left: <?php echo $votersLeft; ?>%</h4>
			</div>
			<div class="progress">
				<div class="progress-bar progress-bar-striped bg-success  progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $totalVoted; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $totalVoted; ?>%">
					<?php echo $totalVoted; ?>%
				</div>
				<div class="progress-bar bg-warning progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $votersLeft; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $votersLeft; ?>%">
					<?php echo $votersLeft; ?>%
				</div>
			</div>
		</div>

		<?php 
			include "../utils.php";

			$categories = $candidate_position;
			
			foreach ( $categories as $category ) {
				echo "<div class='mt-5  overflow-hidden' >";
				echo 	"<div class='bg-success ps-3 pe-3 rounded' >";
				echo 		"<h3 class='text-light p-2 m-0 text-capitalize  text-center'  >" . $category ."</h3>";
				echo "</div>";
				echo 	"<div class='d-flex align-items-center gap-5 flex-wrap bg-light p-2 row row-cols-xl-6 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-xs-2'>";

							$sql = "SELECT usertable.*, candidates.* from usertable inner join candidates on usertable.idnum = candidates.idnum where position = '$category' ORDER BY vote DESC ";
							$getCandidate = mysqli_query($conn, $sql);

							if ( mysqli_num_rows($getCandidate) === 0 ) { // use placeholder if there's no candidate
								echo "<div class='text-center'>";
								echo  	"<div >";
								echo 		"<i class='bi bi-person-circle display-4'></i>	";				
								echo	"</div>";
								echo 	"<h5 class='name fw-bold text-capitalize'>Please Add Candidate</h5>";
								echo "</div>";
							} else {
								while ( $row = mysqli_fetch_assoc($getCandidate) ) {
									$independent = "";
									if ( $row['partylistName'] !== "independent" ) {
										$independent = "Partylist";
									}
								?>
									<div class='text-center col' >
									 	<div >
											<img class='img rounded-circle	' src="<?php echo $row['img']; ?>" width='100px' height='100px' >				
										</div>
										<h5 class='fw-bold text-capitalize mt-2 mb-0'><?php echo $row['firstname'] . " " . $row['middlename'][0] . ". " . $row['lastname']; ?></h5>
										<h5 class='text-capitalize mb-0'><?php echo  "" . $row['partylistName'] . " " . $independent; ?></h5>
										<p class='mb-2 text-uppercase'><?php echo $row['course'] . " " . $row['yearsec']; ?> </p>
										<p class='mb-0 text-uppercase fw-bold'>VOTE Count: <?php echo $row['vote']; ?> </p>
										<p class='mb-0 text-uppercase fw-bold'>
										<?php 
											if( mysqli_num_rows($getCandidate) > 1 ) {	
												$diffSql = "SELECT SUM(vote) as positionTotalVote from candidates WHERE position = '$category' ";
												$diffRes = mysqli_query($conn, $diffSql);

												$positionTotalVote = mysqli_fetch_assoc($diffRes)['positionTotalVote'];

												echo round(( $row['vote'] / $positionTotalVote ) * 100) . "% ";
											} else {
												echo "100%";
											}
										?>
										</p>
									</div>
									<?php 
								}
							}

				echo 		"<div class='text-center' >";
				echo 		"</div>";
				echo 	"</div>";
				echo "</div>";
			}

		?>

	</div>
</body>
</html>