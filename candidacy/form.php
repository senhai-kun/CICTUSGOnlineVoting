
<div class="mt-5" >
	<?php 

		$sql = "SELECT * from usertable WHERE idnum = '$_SESSION[idnum]' ";
		$res = mysqli_query($conn, $sql);

		$student = mysqli_fetch_assoc($res);?>


	<form method="POST" action="" enctype="multipart/form-data" >
		<input class="d-none" name="position" id="position" value="president" ></input>

		<h4 >Basic Information</h4>

		<div class="input-group mb-3"> 
			<span class="input-group-text" id="basic-addon1">ID NUMBER</span>
			<input type="text" class="form-control" name="idnum" id="idnum" placeholder="ID NUMBER" aria-label="ID NUM" aria-describedby="basic-addon1" value="<?php echo $student['idnum']; ?>" disabled >
		</div>


		<div class="input-group  mb-3">
			<span class="input-group-text" id="basic-addon1">FULL NAME</span>
			<input type="text" class="form-control text-uppercase" name="fullname" placeholder="Fullname* ex. Juan D. Dela Cruz" aria-label="Fullname" aria-describedby="basic-addon1" value="<?php echo $student['firstname'] . " " . $student['middlename'] . " " . $student['lastname']; ?>" disabled>
		</div>

		<div class="input-group  mb-3">
			<span class="input-group-text" id="basic-addon1">SECTION</span>
			<input type="text" class="form-control text-uppercase" name="section" placeholder="Section* ex. 3G" aria-label="Section" aria-describedby="basic-addon1" value="<?php echo $student['course'] . " " . $student['yearsec']; ?>" disabled>
		</div>

		<h4 class="mb-2 mt-5">Candidate Information</h4>

		<div class="input-group mb-3">
			<span class="input-group-text">VISION</span>
			<textarea name="vision" rows="1" class="form-control" aria-label="VISION" placeholder="Enter your Vision*" required></textarea>
		</div>

		<div class="input-group mb-3">
			<span class="input-group-text">MISSION</span>
			<textarea name="mission" rows="1" class="form-control" aria-label="MISSION" placeholder="Enter your Mission*" required></textarea>
		</div>

		<div class="input-group mb-3">
			<span class="input-group-text">AGENDA</span>
			<textarea name="agenda" rows="2" class="form-control" aria-label="AGENDA" placeholder="Write your own agenda..." required></textarea>
		</div>

		<label for="select-position">Position</label>

		<select id="select-position" name="position" class="form-select text-uppercase" aria-label="Position" required>
			<option selected value="" class="bb-4" >Select your Position</option>
			<?php 
				include "../utils.php";
				foreach ( $candidate_position as $position ) {
					echo "<option class='text-uppercase' value='".$position."'>" . $position . "</option>";
				};
			?>
		</select>

		<div id="partylist" class="input-group mb-3 mt-3">
			<!-- <span class="input-group-text">Partylist</span>
			<input class="form-control" aria-label="PARTYLIST" placeholder="Enter your Partylist name*"></input> -->
		</div>

		<script type="text/javascript">
			document.getElementById("select-position").addEventListener("change", e => {
				console.log(e.target.value);

				if( e.target.value === "0" ) {
					document.getElementById("partylist").innerHTML = "";
				} else if ( e.target.value === "president" ) {
					document.getElementById("partylist").innerHTML = `
						<span class="input-group-text">Partylist</span>
						<input name="add-partylist" class="form-control" aria-label="PARTYLIST" placeholder="Enter your Partylist name* Please Note: " required></input>
					`
				} else {
					<?php 
						$partysql = "SELECT * from partylist";
						$partyres = mysqli_query($conn, $partysql);
					?>
					document.getElementById("partylist").innerHTML = `
							<label for="select-partylist" class="w-100">Partylist</label>
							<select name="select-partylist" id="select-partylist" class="form-select text-uppercase" aria-label="Partylist" required>
								<option selected value="" class="bb-4" >Select your Partylist</option>
								<?php 
									while ( $row = mysqli_fetch_assoc($partyres) ) { ?>
										<option value="<?php echo $row['partylistName']; ?>" ><?php echo $row['partylistName']; ?></option>
									<?php } ?>
								<option value="independent" class="bb-4" >INDEPENDENT (Select this if you don't have partylist)</option>	
							</select>
					`;
				}

			})
		</script>


		<h4 class="mb-2 mt-5">Upload Picture</h4>

		<div class="mb-3">
			<p id="asd"></p>
			<label  class="form-label">
				<img 
					id="img-placeholder" 
					src="https://brocku.ca/applied-health-sciences/nursing/wp-content/uploads/sites/131/99-998739_dale-engen-person-placeholder-hd-png-download.png?x82918" 
					alt="prev" 
					width="200px"
				>
			</label>

			<input class="form-control" type="file" name="imgFile" id="imgFile" required>
		</div>

		<div class="text-end" >
			<a class="btn btn-danger" href="index.php" role="button">Exit</a>
			<button type="submit" class="btn btn-primary" name="submitCandidacy" id="submitCandidacy">Submit</button>	
		</div>
		
  	</form>

  	<?php 
		$uploadDir = "../uploads/";
		$extensions = array('jpg', 'jpeg', 'png', 'gif');

		if( isset($_POST['submitCandidacy']) ) {

			$idnumCandidate = $_SESSION['idnum'];					
			$position = $_POST['position'];
			$vision = $_POST['vision'];
			$mission = $_POST['mission'];
			$agenda = $_POST['agenda'];

			echo $idnumCandidate;

			$exists = mysqli_query($conn, "SELECT * FROM candidates WHERE idnum = '$idnumCandidate' ");
			if( mysqli_num_rows($exists) !== 0 ) {
				// candidate already exists
				echo "<script>alert('Candidate Already Exists!')</script>";
				die();
				return false;
			}

			$fileName = $_FILES['imgFile']['name'];
			$fileTmp = $_FILES['imgFile']['tmp_name'];
			$fileSize = $_FILES['imgFile']['size'];
			$fileError = $_FILES['imgFile']['error'];
			$fileType = $_FILES['imgFile']['type'];

			$split = explode(".", $fileName);		
			
			$fileExt = strtolower(end($split));

			if( in_array($fileExt, $extensions) ) { // check extension
				if( $fileError === 0 ) { // check uploading errors
					if( $fileSize < 5000000 ) { // 5mb limit

						if( in_array($split[0], scandir("../uploads/")) ) { // check if filename already exist
							// if filename is duplicate delete the old and replace it with new image

							$getImages = scandir("../uploads/");

							$imageIndex = array_search($idnumCandidate, $getImages);
							$existingFile = $getImages[$imageIndex];
		
							unlink( $uploadDir . $existingFile);
						}
		
						$fileToUpload = $uploadDir . $idnumCandidate . "." . $fileExt;
						move_uploaded_file($fileTmp, $fileToUpload); // upload img to folder

						// add partylist if candidate runs on president
						if( $position === "president" ) {
							$partylist = $_POST['add-partylist'];

							$insertPartylistSql = "INSERT INTO partylist values ('$partylist', '$idnumCandidate')"; 
							$insertPartylistRes = mysqli_query($conn, $insertPartylistSql);

							if (!$insertPartylistRes) {
								echo "<script type='text/javascript'>alert('Error: Partylist could not be added!');</script>";
								echo mysqli_error($conn);
							}

						} else {
							$partylist = $_POST['select-partylist'];
						}

						$insertCandidateSql = "INSERT INTO candidates (idnum, img, position, vote, partylistName, vision, mission, agenda) values ($idnumCandidate, '$fileToUpload', '$position', 0, '$partylist', '$vision', '$mission', '$agenda')";
						$insertCandidateResult = mysqli_query($conn, $insertCandidateSql);

						if(!$insertCandidateResult){
							echo "<script type='text/javascript'>alert('Error: Candidate not uploaded!" . $idnumCandidate ."');</script>";
							echo mysqli_error($conn);
						} else {
							echo "File Uploaded";
							// header("Location:../homepage.php");
							echo "<script type='text/javascript'>alert('Success: Candidate added. " . $idnumCandidate ."');</script>";
							echo "<script type='text/javascript'>window.location.reload(true);</script>";
						}
					} else {
						echo "File too large!";
					}

				} else {
					echo "There was an error uploading your image";
				}

			} else {
				echo "File type is not supported!";
			}
		}	
	?>
</div>

