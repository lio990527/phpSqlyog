function getFrameDom(name){
	var frame = window.parent.document.getElementsByName(name);
	if(frame.length == 0){
		return false;
	}
	return frame[0].contentDocument;
}