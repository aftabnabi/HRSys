$(function(){
	
	mydatefunction=function(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;//January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){dd='0'+dd}
		if(mm<10){mm='0'+mm}
		return mm+"/"+dd+"/"+yyyy;
	}
	if( $('#dated') && $('#dated').val()=="") {
		$('#dated').val(mydatefunction());
	}

	$('#dated').datepicker();
	if($('#timerequired')) {
		$('#timerequired').focus();
	}
	
});