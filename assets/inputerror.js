function makeChanges(error,message,inputTarget,errorTarget){
	if(error==1){
		inputTarget.css('border-bottom','2px solid red');
		errorTarget.text(message);
	}else{
		inputTarget.css('border-bottom','none');
		errorTarget.text(message);
	}
}

function checkInputOnSubmit(minlength,inputTarget,errorTarget){
	var input = inputTarget.val();
	if(hasWhiteSpace(input)){
		makeChanges(1,"no white spaces allowed",inputTarget,errorTarget);
		return 0;
	}else if(input.length<minlength){
		makeChanges(1,"min "+minlength+" letters required",inputTarget,errorTarget);
		return 0;
	}else{
		makeChanges(0,"",inputTarget,errorTarget);
		return 1;
	}
}

function hasWhiteSpace(s) {
	return /\s/g.test(s);
}

function onInputListener(maxlength,inputTarget,errorTarget){
	var input = inputTarget.val();
	if(input.length==maxlength){
		makeChanges(1,"maximum "+maxlength+" letters allowed",inputTarget,errorTarget);
	}else{
		makeChanges(0,"",inputTarget,errorTarget);
	}
}
