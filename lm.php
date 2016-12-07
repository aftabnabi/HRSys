<?php 
	include_once("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Line Manager - Dashboard</title>
<?php include("header.php");?>

<link rel="stylesheet" href="css/demos.css" />

<script src="js/custom-sourcingform.js" type="text/javascript"></script>
	<script src="js/jquery.ui.tooltip.js" type="text/javascript"></script>

<script type="text/javascript">

var currentiRow;
var currentiCol;
var newRowCount = 1;
var str='';
var lastsel;

$(function(){ // ready function

$( "#tabs" ).tabs();
	
 jQuery("#grid_new").jqGrid({
						url		  : "lm_process.php?q=1",
						datatype  : "json",

						colNames  : [
										'Id','Date', 'req','Request', 'Job Title', 'Div', 'Dept', 'Progress', 'HR Feedback'
									],

						colModel  : [
										{name:'id',index:'id'},	
										{name:'date',index:'date', width:35,sorttype:'date'}, 
										{name:'request_status_id',index:'request_status_id'},
										{name:'request',index:'request', width:60,align:"right"},	
										{name:'jobtitle',index:'jobtitle', width:60,align:"right"},	
										{name:'div',index:'div', width:60,align:"right"},	
										{name:'dept',index:'dept', width:60,align:"right"}, 
										{name:'progress',index:'progress',width:100}, 
										{name:'hrfeedback', index:'hrfeedback',width:40, align:"right"}
									],

									//properties
						height    : 300,
						width     : 970, 
						sortname  : 'name',
						sortorder : "asc",
						caption   : "Line Manager Dashboard ",
						cellEdit  : true,
						cellsubmit: 'clientArray',
						loadonce  : true, // to enable sorting on client side
						sortable  : true ,//to enable sorting
						loadComplete : function(){ 
											var ids = jQuery("#grid_new").getDataIDs(); 
														// for each row loaded 
											for(var i=0;i<ids.length;i++){
													
													var cl = ids[i]; 
														// get the row data, this works best when you have to do this for multiple columns, otherwise you might use getCell  
													var status_val=jQuery("#grid_new").getCell(cl,"request_status_id");
											
													if(status_val==<?php echo $Awaiting_HR_Validation?>){ //request_status
															$("tr#"+cl).find('td').each(function(){
																$(this).css('font-weight','bold');
															//var objRowData = jQuery("#grid_new").getRowData(cl);
															// for each column, give it a replacement or function that modifies the value 
															//jQuery("#grid_new").setRowData(cl,objRowData,"myclass");
														});
													}
													/*
													if(status_val==<?php echo $Awaiting_HR_Validation; ?>) //request_status
													{
														$(".progressbar" ).progressbar({
																						value: 0,
																						create: function(event, ui) {  }
																					});
								
													}
													if(status_val==<?php echo $Sourcing_in_progress; ?>) //request_status
													{
														$(".progressbar" ).progressbar({
																						value: 20,
																						create: function(event, ui) {  }
																					});
								
													}
												*/							
												} 
										},
							pager : jQuery('#pager_new'),
						pgbuttons : false,
						   pgtext : "",//viewrecords: true,
						  pginput : true,
						  rowNum  : 10000,//show all ,-1 decrements, so use more than max//rowList:null,//rowList:[10,20,30]
		})
		.navGrid(
					'#pager_new',
					{
						edit:false,
						add:false,
						del:false
					},
					{
						id:'myedit'
					}
				)
		.hideCol("id").hideCol("request_status_id");
		//--------
    $("#create_request a").click(function(){
							    
				$("#dialog-modal_srform").dialog({
														
						width  : 700,
						height : 570,
						modal  : true,
						buttons: {
															
								'Submit': function(){
																							 
										var options_form = {
												
												success : function(response){
																																																	$("#progress-dialog").dialog("close");
																$("#grid_new").jqGrid('setGridParam',
																					  {
																						   url:"lm_process.php?q=1",
																						   datatype: "json"
																					   }
																					   ).trigger("reloadGrid");
																$("#response-message").html(response);
																$("#dialog-modal_srform").dialog("close");
															}
										};

										$("#progress-dialog").dialog({width: 300, height: 100, modal: true});
										$("#sourcing_form").ajaxSubmit(options_form); 

								},
								'Cancel':function(){
													   $(this).dialog("close");
												   }
					   }
					});

	});
		//$("#grid").trigger("reloadGrid");

}); //jquery ready method

</script>
</head>
<body>
<div id="myalert"></div>
<div id="progress-dialog" style="display: none;"><div style="text-align: center;"><img src="images/loading.gif"><br>Loading...</div></div>
<div id="main-container">
<?php include("top.php"); ?>
<div id="top-buttons">
<div id="create_request" class="ui-form-button green"><a href="#" ><span class="ui-icon ui-icon-plusthick" style="float: left;"></span>Create Sourcing Request</a></div>
<div style="clear:both"></div>
</div>
<div id="tabs">
	<ul>
        <li><a href="#tabs-new">New Requests</a></li>
	</ul>
	<div id="tabs-new" >
       	<table id="grid_new" ></table> 
        <div id="pager_new"> </div> 
     </div>
</div>
<div id="dialog-modal_srform" title="Sourcing Request Application Form" style="display:none">
	<?php include("sourcing_form.php");?>	
</div>

<?php include("footer.php");?>
<div style="clear: both"></div>
</div>
</body>
</html>