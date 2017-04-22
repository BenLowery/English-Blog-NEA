// Run function all the time
window.onload = function() {
	var emoji = document.getElementById("emoji");
	// Once clicked check  we are clicking an emoji and not the surrounding div
	emoji.onclick = function(e) {
		var tagtype = e.target.tagName.toLowerCase();
		if(tagtype === "div") {
			return;
		} 
		
		// Get id of choice
		var response = e.target.id;

		// Change inner html of hidden form
		document.getElementById("hidden-comment").value = response;

		// submit a form
		document.getElementById("form").submit();
		
		// Appropriate response
		alert("thanks for your response");
		

		return; 
		
	}

}