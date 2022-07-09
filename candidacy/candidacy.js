
document.getElementById("imgFile").addEventListener("change", (e) => {
	let placeholder = document.getElementById("img-placeholder");

	let prev = URL.createObjectURL(e.target.files[0]);

	placeholder.src = prev;
} );


// document.getElementById("select-position").addEventListener("change", e => {
// 	console.log(e.target.value);

// 	if ( e.target.value === 'president' ) {
// 		document.getElementById("partylist").innerHTML = `
// 			<span class="input-group-text">Partylist</span>
// 			<input class="form-control" aria-label="PARTYLIST" placeholder="Enter your Partylist name*"></input>
// 		`
// 	}

// })