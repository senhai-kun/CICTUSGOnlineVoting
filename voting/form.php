<div>
    <h5>Please Note: Add Instructions here!</h5>
</div>

<form  method="POST" class="container mb-5 p-0">
	<?php 
		include "../utils.php";

		$categories = $candidate_position;
		
		foreach ( $categories as $category ) {
			echo "<div class='mt-5  overflow-hidden' >";
			echo 	"<div class='bg-primary  d-flex justify-content-between align-items-center ps-3 pe-3' >";
			echo 		"<h3 class='text-light p-2 m-0 text-capitalize'  >" . $category ."</h3>";
			echo "</div>";
			echo 	"<div class='d-flex align-items-start gap-5 flex-wrap bg-light p-2 row row-cols-xl-6 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-xs-2'>";

						$sql = "SELECT usertable.*, candidates.* from usertable inner join candidates on usertable.idnum = candidates.idnum where position = '$category' ORDER BY usertable.firstname ASC ";
						$getCandidate = mysqli_query($conn, $sql);

						if ( mysqli_num_rows($getCandidate) === 0 ) { // use placeholder if there's no candidate
							echo "<div class='text-center'>";
							echo  	"<div >";
							echo 		"<i class='bi bi-person-circle display-4'></i>	";				
							echo	"</div>";
							echo 	"<h6 class='name fw-bold'>There's no candidate applied for this position.</h6>";
							echo "</div>";
						} else {
							while ( $row = mysqli_fetch_assoc($getCandidate) ) {
								if ( $row['partylistName'] === "independent") {
									$partylist = "<h5 class='fw-bold text-capitalize mb-0'>" . $row['partylistName'] . "</h5>";
								} else {
									$partylist = "<h5 class='fw-bold text-capitalize mb-0'>" . $row['partylistName'] . " Partylist </h5>";
								}
								?>
								<div class='text-center col' >
								 	<div >
										<img class='img rounded-circle	' src="<?php echo $row['img']; ?>" width='100px' height='100px' >				
									</div>
									<h4 class='fw-bold text-capitalize mt-2 mb-0'><?php echo $row['firstname'] . " " . $row['middlename'][0] . "." . " " . $row['lastname']; ?></h4>
									<?php echo $partylist; ?>
									<p class='mb-2 text-uppercase'><?php echo $row['course'] . " " . $row['yearsec']; ?> </p>
									<p class='mb-0 text-uppercase'>Vision: <?php echo $row['vision']; ?> </p>
									<p class='mb-0 text-uppercase'>Mission: <?php echo $row['mission']; ?> </p>
									<p class='mb-0 text-uppercase'>Agenda: <?php echo $row['agenda']; ?> </p>

									<div>
										<label class="fw-bold" for="<?php echo $category.$row['idnum']; ?>" >VOTE: 
											<span>
												<input class="form-check-input" type="radio" name="<?php echo $category; ?>" id="<?php echo $category.$row['idnum']; ?>" value="<?php echo $row['idnum']; ?>" aria-label="vote" required>
											</span>
										</label>
										
									</div>
									
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
	
	<div class="mt-5 mb-5 text-center" >
		<button type="submit" name="submit" class="btn btn-success btn-lg">Submit</button>
	</div>
</form>

<?php 
	if( isset( $_POST['submit'] ) ) {
		
		$votedSql = "UPDATE usertable SET voted=1 WHERE idnum = '$_SESSION[idnum]' ";
		if( mysqli_query($conn, $votedSql) ) {
			echo "success";
		} else {
			echo "Error!" . mysqli_error($conn);
		}

		foreach ( $candidate_position as $position ) {
			$pos = str_replace(" ", "_", $position);
    		$sql = "UPDATE candidates SET vote=vote+1 where idnum='$_POST[$pos]'";
    		if( mysqli_query($conn, $sql) ) {
				echo "success";
			} else {
				echo "Error!" . mysqli_error($conn);
			}
		}

		echo "<meta http-equiv='refresh' content='0'>";
	}

?>