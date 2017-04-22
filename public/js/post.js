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
		
		// Appropriate response
		alert("You thought this post was " + response + "! \n thanks for your response");
		return;
		
	
	}

}