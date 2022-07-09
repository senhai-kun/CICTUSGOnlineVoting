<?php 
	include("../connection.php"); 

	if ( isset($_POST['searchID']) ) {

		$searchID = $_POST['searchID'];

		$searchsql = "SELECT * from usertable WHERE idnum LIKE '$searchID%' LIMIT 3";
		$searchres = mysqli_query($conn, $searchsql);

		// echo $searchID;

		?>
			
			<table class="table table-hover">
				<thead>
				    <tr>
						<th scope="col">ID</th>
						<th scope="col">Firstname</th>
						<th scope="col">Lastname</th>
						<th scope="col">Course</th>
						<th scope="col"></th>
				    </tr>
			  	</thead>
			  	<tbody>
			  		<?php 
			  		while($row = mysqli_fetch_assoc($searchres)) { ?>
				  		<tr class="text-uppercase">
				  			<th><?php echo $row['idnum']; ?></th>
				  			<td><?php echo $row['firstname'] ?></td>
				  			<td><?php echo $row['lastname'] ?></td>
				  			<td><?php echo $row['course'] ?></td>
				  			<td>
				  				<button onclick="selectCandidate('<?php echo $row['idnum'] ?>', '<?php echo $row['firstname'] ?>', '<?php echo $row['middlename'] ?>', '<?php echo $row['lastname'] ?>', '<?php echo $row['course'] ?>', '<?php echo $row['yearsec'] ?>')" class="btn btn-outline-success btn-sm" >Select</button>
				  			</td>
				  		</tr>
				  	<?php } ?>
					
			  	</tbody>

			</table>


			<?php 

	}
	

?>