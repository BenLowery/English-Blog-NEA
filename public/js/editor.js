function saveAsDraft() {
	// Get draft content and title and put them into localstorage
	localStorage.setItem('draft_title', document.getElementById("title").value);
	localStorage.setItem('draft_content', document.getElementById("content").innerHTML);
	alert('Saved'); // Note: only saved to current computer
	return;
}

function removeDraft() {
	// clear all of local storage
	localStorage.clear()
	// Add blank write prompt to editor and reset title as well
	localStorage.setItem('draft_title', '')
	localStorage.setItem('draft_content', "Write text here...");
	alert("Deleted");
	// reload page
	location.reload();
	return;
}

// Load cache into editor
function loadEditor() {
	document.getElementById("title").value = localStorage.getItem('draft_title');
	document.getElementById("content").innerHTML = localStorage.getItem('draft_content');
	console.log("Stop Looking at the console");
	return; 
}

// Execute editor function
function rule(action, extra) {
	// Although most browsers now use E2015, one that was tested didn't.
	// So i cant just assign a null value to extra in the function params
	extra = (typeof extra !== 'undefined') ?  extra : null;
	document.execCommand(action, false, extra);
}


// Creates a variable to store the link,
// pedantic but doesnt really work without it
function ShowLinkPopup() {
	SelectionRange = saveSelection();
	return;
}

// Create a link and apply it to selection
function createLink() {
	var link = document.getElementById("url").value;
	if (link.substr(0, 7) !== 'http://') {
		link = 'http://' + link;
	}
	restoreSelection(SelectionRange);
	rule('createLink', link);
	window.location = 'javascript: void(0)';
	return;
}




// Thanks to http://stackoverflow.com/questions/3315824/preserve-text-selection-in-contenteditable-while-interacting-with-jquery-ui-dial
	// Save input selection and then restore the selection when adding links
	function saveSelection() {
	    if (window.getSelection) {
	        sel = window.getSelection();
	        if (sel.getRangeAt && sel.rangeCount) {
	            return sel.getRangeAt(0);
	        }
	    } else if (document.selection && document.selection.createRange) {
	        return document.selection.createRange();
	    }
	    return null;
	    window.location = '#';
	}
	function restoreSelection(range) {
	    if (range) {
	        if (window.getSelection) {
	            sel = window.getSelection();
	            sel.removeAllRanges();
	            sel.addRange(range);
	        } else if (document.selection && range.select) {
	            range.select();
	        }
	    }
	}
// End of stackoverflow

/* Stuff for submiting and sending off form (for the create)*/
function submit() {
	// Lets just save the contents and title to cache in case sometihng goes wrong
	saveAsDraft();
	
	//  (IE 6-10 doesnt support constants so we just act like they are)
	var title = document.getElementById("title").value;
	var content = document.getElementById("content").innerHTML;
	var tags = document.getElementById("tags").value;


	// Put the title and contents into hidden form
	document.getElementById("hidden-area-title").value = title;
	document.getElementById("hidden-area-contents").value  = content;
	document.getElementById("hidden-area-tags").value = tags;
	// Finally submit the form
	document.getElementById("form").submit();
}

