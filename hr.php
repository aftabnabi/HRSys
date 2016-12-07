<?php 
	include_once("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HR - Dashboard</title>
<?php include("header.php");?>
<script src="js/custom-sourcingform.js" type="text/javascript"></script>
<script type="text/javascript">

var currentiRow;
var currentiCol;
var newRowCount = 1;
var str='';
var lastsel;

$(function(){ // ready function

	//$("#progress-dialog").dialog({width: 300, height: 100, modal: true});

	$( "#tabs" ).tabs();
	var tabgridwidth 	= $("#tabs").width();
	var offsetgridwidth = 1;
	var gridwidth		= (tabgridwidth - offsetgridwidth);
	
	jQuery("#grid_new").jqGrid({
			url		 : "hr_process.php?q=1",
			datatype : "json",
			colNames : [ 
							'Id','Date', 'Line Manager', 'lm_id','r','Request', 'Job Title', 'Div', 'Dept', 'Progress Bar', 'HR Feedback','Action' 
					   ],
			colModel : [
							{name:'id',index:'id'},	
							{name:'date',index:'date', width:35,sorttype:'date',align:'center'}, 
							{name:'linemanager',index:'linemanager',width:45,sorttype:'text',align:'center'}, 
							{name:'requestby_id',index:'requestby_id' },
							{name:'requestid',index:'requestid'},
							{name:'request',index:'request', width:60,align:"center"},	
							{name:'jobtitle',index:'jobtitle', width:60,align:"center"},
							{name:'div',index:'div', width:60,align:"center"},
							{name:'dept',index:'dept', width:60,align:"center"},
							{name:'progressbar',index:'progressbar',width:100},
							{name:'hrfeedback',index:'hrfeedback',align:'center',width:40},
							{name:'Action',index:'action',align:'center',width:55}
						],
				//properties
			height   : '300', 
			width    : gridwidth, 
			sortname : 'name',
			sortorder: "asc",
			caption  : "HR Dashboard",
			loadonce : true, 
			sortable : true ,
			loadComplete: function(){ 
								var ids = jQuery("#grid_new").getDataIDs(); 
								// for each row loaded 
								for(var i=0;i<ids.length;i++){
									var cl = ids[i]; 
									// get the row data, this works best when you have to do this for multiple columns, otherwise you might use getCell  
								
								var status_cell=jQuery("#grid_new").getCell(cl,"requestid");
									if ( status_cell == <?php echo $Awaiting_HR_Validation?> ) //request_status
									{
										$("tr#"+cl).find('td').each(function(){
																				$(this).css('font-weight','bold');
																			//var objRowData = jQuery("#grid_new").getRowData(cl);
																			// for each column, give it a replacement or function that modifies the value 
																			//jQuery("#grid_new").setRowData(cl,objRowData,"myclass");
																		});
									}		
							} 
				},	
				pager     : jQuery('#pager_new'),
				pgbuttons : false,
				pgtext    : "",//viewrecords: true,
				pginput   : true,
				rowNum    : 10000,//show all ,-1 decrements, so use more than max//rowList:null,//rowList:[10,20,30]
		}).navGrid('#pager_new',
								{
									edit:false,
									add:false,
									del:false
								},
								{
									id:'myedit'
								}
				  ).hideCol("id").hideCol("requestid").hideCol("requestby_id");
				
//---------------------------------------------------------------------new ended---------------------
	  jQuery("#grid_filled").jqGrid({
			url      :"hr_process.php?q=2",
			datatype : "json",
			colNames :[
						'Id','Date', 'Line Manager', 'Request', 'Job Title', 'Div', 'Dept'
					  ],
			colModel:[
				{name:'id',index:'id'},
				{name:'date',index:'date', width:35,sorttype:'date'}, 
				{name:'linemanager',index:'linemanager',width:45,sorttype:'text'}, 
				{name:'request',index:'request', width:60,align:"right"},	
				{name:'jobtitle',index:'jobtitle', width:60,align:"right"},	
				{name:'div',index:'div', width:60,align:"right"},	
				{name:'dept',index:'dept', width:60,align:"right"}
				],
//properties
			height   : 300, 
			width    : gridwidth, 
			sortname : 'name',
			sortorder: "asc",
			caption  : "HR Dashboard In Progress ",			
			loadonce : true, // to enable sorting on client side
			sortable : true ,//to enable sorting
				
			pager    : jQuery('#pager_filled'),
			pgbuttons: false,
			pgtext   :"",//viewrecords: true,
			pginput  : true,
			rowNum   : 10000,
		}).navGrid('#pager_filled', 
									{
										edit:false,
										add:false,
										del:false
									},
									{
										id:'myedit'
									} 
				  ).hideCol("id");
//-------------------------------------------------------ended filled-----------------------------
	  jQuery("#grid_pending").jqGrid({
				url		 : "hr_process.php?q=3",
				datatype : "json",
				colNames :
					[
						'Id','Date', 'Line Manager', 'Request', 'Job Title', 'Div', 'Dept' 
					],
				colModel : [
							{name:'id',index:'id'},	
							{name:'date',index:'date', width:35,sorttype:'date'}, 
							{name:'linemanager',index:'linemanager',width:45,sorttype:'text'}, 
							{name:'request',index:'request', width:60,align:"right"},	
							{name:'jobtitle',index:'jobtitle', width:60,align:"right"},	
							{name:'div',index:'div', width:60,align:"right"},	
							{name:'dept',index:'dept', width:60,align:"right"}
					      ],
	//properties
				height	 : 300, 
				width	 : gridwidth, 
				sortname : 'name',
				sortorder: "asc",
				caption	 : "Dashboard - Pending Requests  ",
				loadonce : true, // to enable sorting on client side
				sortable : true ,//to enable sorting
					
				pager    : jQuery('#pager_pending'),
				pgbuttons: false,
				pgtext   :"",//viewrecords: true,
				pginput  : true,rowNum:10000,
		}).navGrid('#pager_pending',
									{
										edit:false,
										add:false,
										del:false
									}, 
									{
										id:'myedit'
									} 
				  ).hideCol("id");
//-------------------------------------------------------ended pending----------------------------
	  jQuery("#grid_rejected").jqGrid({
			url		 : "hr_process.php?q=4",
			datatype : "json",
			colNames :
					 [ 
						'Id','Date', 'Line Manager', 'Request', 'Job Title', 'Div', 'Dept'
					 ],
			colModel : [
						{name:'id',index:'id'},	
						{name:'date',index:'date', width:35,sorttype:'date'}, 
						{name:'linemanager',index:'linemanager',width:45,sorttype:'text'}, 
						{name:'request',index:'request', width:60,align:"right"},	
						{name:'jobtitle',index:'jobtitle', width:60,align:"right"},	
						{name:'div',index:'div', width:60,align:"right"},	
						{name:'dept',index:'dept', width:60,align:"right"}
					  ],
//properties
			height   : 300, 
			width    : gridwidth, 
			sortname : 'name',
			sortorder: "asc",
			caption  : "Rejected Requests ",			
			loadonce : true, // to enable sorting on client side
			sortable : true ,//to enable sorting
		
			pager    : jQuery('#pager_rejected'),
			pgbuttons: false,
			pgtext   :"",//viewrecords: true,
			pginput  : true,rowNum:10000,
		}).navGrid('#pager_rejected', 
									{
										edit: false,
										add : false,
										del : false
									}, 
									{
										id  :'myedit'
									} 
				 ).hideCol("id");
				   
//-------------------------------------------------------ended rejected---------------------------
		var acceptstatement="Your request has been accepted, the position will now be advertised.";
		var pendingstatement="Your request has been rejected because there were no open positions that matched the criteria you specified. It has been put in a pending state for future consideration. When a position becomes available with your specified criteria, your request will be Accepted and you shall be notified.";
		var rejectstatement="Your request has been rejected because there were no open positions that matched the criteria you specified.";
		validate_sourcing=function(stid,did,csid,lmid){
				
				$("#progress-dialog").dialog({width: 300, height: 100, modal: true});
			
				$.ajax({
						url:'hr_process.php',
						type:'POST',
						data:{dept_id:did},
						
					success:function(data){
						$("#progress-dialog").dialog("close");
						
						$("#sr_id").val(stid);
						$("#dept_id").val(did);
						$("#current_status_id").val(csid);		
						$("#requestby_id").val(lmid);
						var gotResponse = false;
						if(data.indexOf("true") != -1)
						{
							gotResponse = true;
							if($("input#positiontype1").attr('disabled')) {
								$("input#positiontype1").removeAttr('disabled');
							}
							$("input#positiontype1").attr('checked','true');
							$("#commentarea").val(acceptstatement);
							//flow diagram quotes that "Note:If there is an open position,HR should still have the option to reject
							//$("input#positiontype2").attr('disabled','disabled');
							//$("input#positiontype3").attr('disabled','disabled');
						}
						else if(data.indexOf("false") != -1)
						{
							gotResponse = true; //just shows if you for any response
							if($("input#positiontype2").attr('disabled')) {
								$("input#positiontype2").removeAttr('disabled');
							}
							
							$("input#positiontype2").attr('checked','true');
							$("input#positiontype3").removeAttr('disabled');
							$("#commentarea").val(pendingstatement);
							$("input#positiontype1").attr('disabled','disabled');
						}

						if (gotResponse) {
							//$("#validation-dialog").dialog('open');
							$("#validation-dialog").dialog({
								width: 400,
								height: 300,
								modal: true,
								buttons: {
									'Submit': function() { 
									
										$("#progress-dialog").dialog({width: 300, height: 100, modal: true});

										var options_form = {
											url:'hr_process.php',
											type:'POST',
											success:function(d){
												$("#progress-dialog").dialog("close");
												if(d > 0)
												{
													if(d==<?php echo $Reject_with_pending ?>) {
														$("#grid_pending").jqGrid('setGridParam',{url:"hr_process.php?q=3",datatype: "json"}).trigger("reloadGrid"); 
													}
													if(d==<?php echo $Reject_Permanently ?>) {
														$("#grid_rejected").jqGrid('setGridParam',{url:"hr_process.php?q=4",datatype: "json"}).trigger("reloadGrid"); 
													}
													jQuery("#grid_new").jqGrid('setGridParam',{url:"hr_process.php?q=1",datatype: "json"}).trigger('reloadGrid');
													//$("#grid_new").trigger("reloadGrid");
													$("#validation-dialog").dialog("close");
												}
												else {
													// showResponse("Error:","An error occurred during processing.","ERROR", //"#response-message"); 
													alert("Request Status could not be updated,Error value is:"+d);
												}				
											},
											error: function(xhr, status, error) {
												$("#progress-dialog").dialog("close");
												showResponse("Error Processing Validation", status, "ERROR", "#response-message");
											}
										};
										$("#validation_form").ajaxSubmit(options_form); 
										
									},
									'Cancel': function() { 
										$(this).dialog( "close" ); 
									}
								}
							});
						}//gotResponse
					},
					error: function(xhr, status, error) {
						$("#progress-dialog").dialog("close");
						showResponse("Error Processing Validation", status, "ERROR", "#response-message");
					}
				});

		}
		$("input[type='radio']").change( function() {
			if($("input#positiontype2").attr('checked'))
			$("#commentarea").val(pendingstatement);

			if($("input#positiontype3").attr('checked'))
			$("#commentarea").val(rejectstatement);

			if($("input#positiontype1").attr('checked'))
			$("#commentarea").val(acceptstatement);
		});
		

		
		//$("#validation_form").ajaxForm(options_form);

/*		
		var options_submit = { 
			target:        '#output2',   // target element(s) to be updated with server response 
			success:       function(){alert('submitted calleback');}  // post-submit callback 
		}
		 $('#validation_form').submit(function() { 
			// inside event callbacks 'this' is the DOM element so we first 
			// wrap it in a jQuery object and then invoke ajaxSubmit 
			$(this).ajaxSubmit(options_submit); 
	 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
*/


//$("#progress-dialog").dialog("close");
		
	}); //jquery ready method

	function onViewDetail (fid){ 
		$.ajax({
				url:'sourcing_form.php',
				type:'GET',
				data:{fid: fid},
				success:function(response){
					$("#dialog-modal_srform").html(response);
					$("#dialog-modal_srform").dialog({
														width: 700,
														height: 570,
														modal: true,
														buttons:false
					});
				}
		});		
	}
</script>
 
</head>
<body>

<?php include("top.php"); ?><div id="progress-dialog" style="display: none;"><div style="text-align: center;"><img src="images/loading.gif"><br>Loading...</div></div>
	<div id="tabs" style="width:100%;" >
            <ul>
	            <li><a href="#tabs-new">New Requests</a></li>
                <li><a href="#tabs-filled">Postitions Filled</a></li>
                <li><a href="#tabs-pending">Postions Pending</a></li>
                <li><a href="#tabs-rejected">Positions Rejected</a></li>
            </ul>
                <div id="tabs-new" >
              		<table id="grid_new"></table> <div id="pager_new"> </div> 
                </div>
                <div id="tabs-filled" >
                	<table id="grid_filled"></table> <div id="pager_filled"></div>
                </div> 
          		<div id="tabs-pending" >
                    <table id="grid_pending"></table><div id="pager_pending"></div>
                </div> 
                <div id="tabs-rejected" >
                    <table id="grid_rejected"></table><div id="pager_rejected"></div>
                </div> 
            
	</div>
	<div id="validation-dialog" title="Validate Request" style="display:none">

    		<div class="hiddenInViewSource" style="padding:20px;">
                    <form id="validation_form">
                    <input  type="radio" id="positiontype1" name="status" value="accept" default> Accept&nbsp;&nbsp;
					<input type="radio"  id="positiontype2" name="status" value="pending"> Reject Pending&nbsp;&nbsp;
                    <input type="radio"  id="positiontype3" name="status" value="permanent"> Reject Permanent&nbsp;&nbsp;
					<br>
					<br>
                    <textarea name="comment" id="commentarea" cols="60" rows="6" ></textarea><br />&nbsp;<br/>
					<input type='hidden' name='sr_id' id="sr_id"/>
					<input type='hidden' name='dept_id' id="dept_id" />
					<input type='hidden' name='current_status_id' id="current_status_id" />
					<input type='hidden' name='requestby_id' id='requestby_id' />
		<?php /* <input type="submit" value="Submit" class="ui-button" />&nbsp;<input type="button" value="Cancel" class="ui-button" onclick="javascript:window.close();return false;"/> */?>
    	           </form>
            </div>
                    
    </div>
	<div id="dialog-modal_srform" title="Sourcing Request Application Form" style="display:none"></div>


</div>
<?php include("footer.php");?>
</body>
</html>