if("querySelector" in document && 
	"addEventListener" in window && 
	"getComputedStyle" in window){
		window.document.documentElement.className += "javascript-enabled";
}

window.onload = function() {
	var navigation = document.getElementById("navigation");
	var navButton = document.getElementById("menuToggle");

	if(navButton){
		navButton.addEventListener("click", function(){
			if(navigation.className == "open"){
				navigation.className = "closed";
			} else{
				navigation.className = "open";
			}});
	}
}