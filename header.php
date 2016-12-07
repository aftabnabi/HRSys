<link rel="stylesheet" type="text/css" media="screen" href="css/blue/jquery-ui-1.8.6.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/green/jquery-ui-1.8.8.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/brown/jquery-ui-1.8.8.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/red/jquery-ui-1.8.8.custom.css" />


<link rel="stylesheet" type="text/css" media="screen" href="js/src/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="js/src/css/jquery.searchFilter.css" />
<!-- Our Custom Styles-->
<link rel="stylesheet" type="text/css" media="screen" href="css/styles.css" />

<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/ui.datepicker.js" type="text/javascript"></script> 
<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>

<script src="js/jquery.jqGrid.js" type="text/javascript"></script>
<script src="js/jquery.json-2.2.min.js" type="text/javascript"></script> 
<script src="js/jquery.form.js" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
	
	$( "button, input, a", ".ui-form-button" ).button();
	
});

function showResponse(title, msg, type, target) {
	if (type == "ERROR") {
		$(target).html('<div class="ui-widget"><div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all"><p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span><strong>'+title+':&nbsp;</strong>'+msg+'</p></div></div>');
	}
	else if (type == "SUCCESS") {
		$(target).html('<div class="ui-widget"><div style="margin-top: 20px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all"> <p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-check"></span><strong>'+title+':&nbsp;</strong>'+msg+'</p></div></div>');
	}
	else {
		$(target).html('<div class="ui-widget"><div style="margin-top: 20px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all"> <p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span><strong>'+title+':&nbsp;</strong>'+msg+'</p></div></div>');
	}
	
	$(target).show('slow');
}
</script>