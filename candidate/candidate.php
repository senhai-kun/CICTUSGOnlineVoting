<?php
	session_start();
	include("../connection.php"); 
	$back = mysqli_query($conn, "SELECT * FROM usertable WHERE idnum = '$_SESSION[idnum]' AND password = '$_SESSION[password]' ");

	$user = mysqli_fetch_assoc($back);

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

	<title>CICTUSGOnlineCandidates</title>
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1 style="background: mediumseagreen;color: white;">CANDIDATES</h1>

    <div class="container mb-5 p-0">
		<?php 
			include "../utils.php";

			$categories = $candidate_position;
			
			foreach ( $categories as $category ) {
				echo "<div class='mt-5  overflow-hidden' >";
				echo 	"<div class='bg-primary  d-flex justify-content-between align-items-center ps-3 pe-3' >";
				echo 		"<h3 class='text-light p-2 m-0 text-capitalize'  >" . $category ."</h3>";
				echo "</div>";
				echo 	"<div class='d-flex align-items-center gap-5 flex-wrap bg-light p-2 row row-cols-xl-6 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-xs-2'>";

							$sql = "SELECT usertable.*, candidates.* from usertable inner join candidates on usertable.idnum = candidates.idnum where position = '$category' ";
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
									$editBtn = "";
									$addBtn = "";
									$independent = "";

									if ( $row['partylistName'] !== "independent" ) {
										$independent = "Partylist";
									}

									if ( $user['userType'] === "admin" ) {
										$editBtn = '<button onclick="editCandidate(\'' . $row['idnum'] . '\', \'' . $row['firstname'] . " " . $row['middlename'][0] . ". " . $row['lastname'] . '\', \'' . $row['course'] . '\', \'' . $row['img'] . '\',\'' . $row['position'] . '\', \'' . $row['vision'] . '\', \'' . $row['mission'] . '\', \'' . $row['agenda'] . '\')" class="btn btn-outline-secondary btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#editCandidate" >Edit</button>';
										$addBtn = '<button type="button" onclick="openForm(\'' . $category . '\')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCandidate" ><i class="bi bi-plus-lg"></i> Add Candidate </button>';
									} 


								?>
									<div class='text-center col' >
									 	<div >
											<img class='img rounded-circle	' src="<?php echo $row['img']; ?>" width='100px' height='100px' >				
										</div>
										<h5 class='fw-bold text-capitalize mt-2 mb-0'><?php echo $row['firstname'] . " " . $row['middlename'][0] . ". " . $row['lastname']; ?></h5>
										<h5 class='text-capitalize mb-0'><?php echo  "" . $row['partylistName'] . " " . $independent; ?></h5>
										<p class='mb-2 text-uppercase'><?php echo $row['course'] . " " . $row['yearsec']; ?> </p>
										<p class='mb-0 text-uppercase'>Vision: <?php echo $row['vision']; ?> </p>
										<p class='mb-0 text-uppercase'>Mission: <?php echo $row['mission']; ?> </p>
										<p class='mb-0 text-uppercase'>Agenda: <?php echo $row['agenda']; ?> </p>
										<?php echo $editBtn; ?>
									</div>
									<?php 
								}
							}

				echo 		"<div class='text-center' >";
				// echo 		 	$addBtn;
				echo 		"</div>";
				echo 	"</div>";
				echo "</div>";
			}

		?>
	
    </div>

	<?php 
		$uploadDir = "../uploads/";
		$extensions = array('jpg', 'jpeg', 'png', 'gif');

		if( isset($_POST['submitCandidate']) ) {

			$idnumCandidate = $_POST['idnum-candidate'];
			$fullname = strtolower($_POST['fullname']);
			$section = strtoupper($_POST['section']);
			$position = $_POST['position'];

			$exists = mysqli_query($conn, "SELECT * FROM candidates WHERE idnum = '$idnumCandidate' ");
			if( $exists === 1 ) {
				// candidate already exists
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

						$insertCandidateSql = "INSERT INTO candidates (idnum,fullname, section, img, position, vote) values ($idnumCandidate, '$fullname', '$section', '$fileToUpload', '$position', 0)";
						$insertCandidateResult = mysqli_query($conn, $insertCandidateSql);

						if(!$insertCandidateResult){
							echo "<script type='text/javascript'>alert('Error: Candidate not uploaded!" . $idnumCandidate . $fullname ."');</script>";
							echo mysqli_error($conn);
						} else {
							echo "File Uploaded";
							echo "<script type='text/javascript'>alert('Success: Candidate added. " . $idnumCandidate . $fullname ."');</script>";
							echo "<meta http-equiv='refresh' content='0'>"; // refresh page
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


	<!-- Edit Candidate Modal -->
	<div class="modal fade" id="editCandidate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCandidateModal" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
			<div>
	        	<h5 class="modal-title fw-bold" id="editCandidateModal">Edit Candidate (<span id="edit-title" class="text-capitalize" ></span>)</h5>
				<p class="mb-0 fs-5 text-capitalize" id="edit-position-title" ></p>
			</div>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
			<form method="POST" action="" enctype="multipart/form-data" >
				<label class="form-label" >Basic Information</label>

				<input class="d-none" name="position" id="edit-position" ></input>

				<div class="input-group mb-3"> 
					<span class="input-group-text" id="basic-addon1">ID NUMBER</span>
					<input type="text" class="form-control " readonly  name="editIdnum" id="editIdnum" placeholder="ID NUMBER" aria-label="ID NUM" aria-describedby="basic-addon1"  >
				</div>


				<div class="input-group  mb-3">
					<span class="input-group-text" id="basic-addon1">FULL NAME</span>
					<input type="text" class="form-control text-capitalize" readonly  name="editFullname" id="editFullname"  placeholder="Fullname* ex. Juan D. Dela Cruz" aria-label="Fullname" aria-describedby="basic-addon1"required>
				</div>

				<div class="input-group mb-4"> <span class="input-group-text"
				id="basic-addon1">SECTION</span> <input type="text"
				class="form-control text-uppercase" readonly 
				name="editSection" id="editSection"
				placeholder="Section* ex. 3G" aria-label="Section"
				aria-describedby="basic-addon1"required> </div>

				<label class="form-label">Candidate Information</label>
				<div class="input-group  mb-3">
					<span class="input-group-text" id="basic-addon1">VISION</span>
					<textarea rows="1" type="text" class="form-control text-uppercase" name="editVision" id="editVision"  placeholder="Enter your Vision*" aria-label="Section" aria-describedby="basic-addon1"required></textarea>
				</div>
				<div class="input-group  mb-3">
					<span class="input-group-text" id="basic-addon1">MISSION</span>
					<textarea rows="1" type="text" class="form-control text-uppercase" name="editMission" id="editMission"  placeholder="Enter your Mission*" aria-label="Section" aria-describedby="basic-addon1"required></textarea>
				</div>
				<div class="input-group  mb-4">
					<span class="input-group-text" id="basic-addon1">AGENDA</span>
					<textarea rows="2" type="text" class="form-control text-uppercase" name="editAgenda" id="editAgenda"  placeholder="Write your own agenda..." aria-label="Section" aria-describedby="basic-addon1"required></textarea>
				</div>

				<p class="mb-2">Upload Picture</p>

				<div class="mb-3">
					<p id="asd"></p>
					<label  class="form-label">
						<img 
							id="edit-img-placeholder" 
							src="https://brocku.ca/applied-health-sciences/nursing/wp-content/uploads/sites/131/99-998739_dale-engen-person-placeholder-hd-png-download.png?x82918" 
							alt="prev" 
							width="200px"
						>
					</label>

					<input class="form-control" type="file" name="editImgFile" id="editImgFile">

					<script type="text/javascript">
						document.getElementById("editImgFile").addEventListener("change", (e) => {
							let placeholder = document.getElementById("edit-img-placeholder");

							let prev = URL.createObjectURL(e.target.files[0]);

							placeholder.src = prev;
						} );

					</script>
				</div>

			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" name="withdraw" id="withdraw" class="btn btn-outline-danger w-50">Withdraw Candidate</button>

				<div>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="editCandidate" id="editCandidate">Save</button>
				</div>
			</div>
		  	</form>
	    </div>
	  </div>
	</div>

	<?php 

		if( isset($_POST['editCandidate']) ) {
			$selectCandidate = "SELECT * from candidates WHERE idnum = '$_POST[editIdnum]'";
			$selectCandidateRes = mysqli_query($conn, $selectCandidate);

			$selectedCandidate = mysqli_fetch_assoc($selectCandidateRes);
			$imgName = explode("/",$selectedCandidate['img'])[2];

			if ( !$_FILES['editImgFile']['name'] ) { // checks if user uploaded an image
				$updateCandidate = "UPDATE candidates set vision='$_POST[editVision]', mission='$_POST[editMission]', agenda='$_POST[editAgenda]' WHERE idnum = '$_POST[editIdnum]' ";
				if ( mysqli_query($conn, $updateCandidate) ) {
					echo "<script>alert('Candidate successfully updated!');</script>";
					echo "<meta http-equiv='refresh' content='0'>";

				} else {
					echo "<script>alert('Error!" . mysqli_error($conn) . "');</script>";
				}

			} else {
				$fileName = $_FILES['editImgFile']['name'];
				$fileTmp = $_FILES['editImgFile']['tmp_name'];
				$fileSize = $_FILES['editImgFile']['size'];
				$fileError = $_FILES['editImgFile']['error'];
				$fileType = $_FILES['editImgFile']['type'];

				$split = explode(".", $fileName);		
				
				$fileExt = strtolower(end($split));

				if( in_array($fileExt, $extensions) ) { // check extension
					if( $fileError === 0 ) { // check uploading errors
						if( $fileSize < 5000000 ) { // 5mb limit

							if( in_array($split[0], scandir("../uploads/")) ) { // check if filename already exist
								// if filename is duplicate delete the old and replace it with new image

								$getImages = scandir("../uploads/");

								$imageIndex = array_search($_POST['editIdnum'], $getImages);
								$existingFile = $getImages[$imageIndex];
			
								unlink( $uploadDir . $existingFile);
							}
			
							$fileToUpload = $uploadDir . $_POST['editIdnum'] . "." . $fileExt;
							move_uploaded_file($fileTmp, $fileToUpload); // upload img to folder

							$updateCandidateImg = "UPDATE candidates SET img='$fileToUpload' vision='$_POST[editVision]', mission='$_POST[editMission]', agenda='$_POST[editAgenda]' WHERE idnum = '$_POST[editIdnum]' ";
							if ( mysqli_query($conn, $updateCandidateImg) ) {
								echo "<script>alert('Candidate successfully updated!');</script>";
								echo "<meta http-equiv='refresh' content='0'>";

							} else {
								echo "<script>alert('Error!" . mysqli_error($conn) . "');</script>";
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

		}

	?>

	<!-- Modal -->
	<div class="modal fade " id="alertMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="alertMessageLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			<div class="modal-header bg-success ">
				<h5 class="modal-title text-light" id="alertMessageLabel">Alert!</h5>
			</div>
			<div class="modal-body">
				<h5 class="fw-bold" >Candidate Successfully Added!</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">DONE</button>
			</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="candidate.js" ></script>

</body>
</html>

