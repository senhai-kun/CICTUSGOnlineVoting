
function preview(e) {
	let placeholder = document.getElementById("img-placeholder");
	console.log(e);
	let prev = URL.createObjectURL(e.target.files[0]);
	console.log(prev);

	placeholder.innerHTML = `<img src="${prev}" alt="preview" />`;

}


document.getElementById("imgFile").addEventListener("change", (e) => {
	let placeholder = document.getElementById("img-placeholder");

	let prev = URL.createObjectURL(e.target.files[0]);

	placeholder.src = prev;
	e.value = prev;
} );


function openForm(position) {

	document.getElementById("form-title").innerText = position;

	document.getElementById("position").value = position;


}

function editCandidate(idnum, fullname, section, img, position, vision, mission, agenda ) {

	document.getElementById("edit-title").innerText = fullname;
	document.getElementById("edit-position-title").innerText = position;

	document.getElementById("edit-position").value = position;
	document.getElementById("editIdnum").value = idnum;
	document.getElementById("editFullname").value = fullname;
	document.getElementById("editSection").value = section;
	document.getElementById("edit-img-placeholder").src = img;
	document.getElementById("editVision").value = vision;
	document.getElementById("editMission").value = mission;
	document.getElementById("editAgenda").value = agenda;


	console.log(idnum, fullname);
}

document.getElementById("submitCandidate").addEventListener("click", (message) => {
	var alertMessage = new bootstrap.Modal(document.getElementById("alertMessage"));

	alertMessage.show();
} )

$(document).ready( () => {

	$("#findID").click( (e) => {
		let searchID = $("#search-idnum").val();

		$.ajax({
			type: 'POST',
			url: 'search.php',
			data: { searchID: searchID },
			success: function (data) {
				$("#asd").html(data);
				console.log("Find ID", e, searchID);
			}
		});

		e.preventDefault();
	} )

	$("#withdraw").click( (e) => {
		$("#withdraw").html(` <div class='spinner-border text-danger spinner-border-sm' role='status'>
		  <span class='visually-hidden'>Loading...</span>
		</div> Withdrawing...`);

		let withdrawID = $("#edit-idnum").val();

		$.ajax({
			type: 'POST',
			url: 'withdraw.php',
			data: { withdrawID: withdrawID },
			success: function (data) {
				// $("#withdraw").html(data);
				// console.log("Find ID", data);
				location.reload(true);
			}
		});

		e.preventDefault();


	} )


} )

function selectCandidate(idnum, first, middle, last, course, yearsec) {
	console.log(idnum);
}



