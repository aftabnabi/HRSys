<?php include_once("config.php");
//DECLARATIONS
	
	$page		= $_GET['page']; // get the requested page
	$limit		= $_GET['rows']; // get how many rows we want to have into the grid
	$sidx		= $_GET['sidx']; // get index row - i.e. user click to sort
	$sord     	= $_GET['sord']; // get the direction
	$id			  = '';
	$date		  = ''; 
	$linemanager  = ''; 
	$request	  = ''; 
	$jobtitle	  = ''; 
	$div		  = ''; 
	$dept		  = ''; 
	$progressbar  = ''; 
	$hrfeeback	  = ''; 
	$action		  = '';
	$flag_bar     = false;
	
	
	
	
//Default for grid laoding	
	if ( $limit < 1 )
	{
		 $limit = 1;
	}
	
	if ( !$sidx )
	{
		 $sidx  = 1;
	}
	if ( $sord < 1 )
	{
		  $sord = 1;
	}
	// connect to the database

	$sql_sourcing = 'SELECT COUNT(*) AS count '
				   .'FROM sourcing_requests' ;
	$result_count = mysql_query($sql_sourcing);
	$count 		  = $row['count'];
	
	$sql_src_req  = ' SELECT  sf.dated AS date, sf.requestby AS linemanager ,'
				   .' sr.sourcing_request_id, sr.sourcing_request_status_id,'
				   .' srs.sourcing_request_status  AS request, sr.sourcing_request_title'
				   .' AS jobtitle, d.department_name AS dept ,divi.division_name AS `div` , comments'
				   .' FROM sourcing_requests  AS sr '
				   .' INNER JOIN sourcing_forms sf on sf.sourcing_request_id = sr.sourcing_request_id'
				   .' INNER JOIN departments d ON sr.department_id = d.department_id'
				   .' INNER JOIN divisions divi ON divi.division_id= d.division_id'
				   .' INNER JOIN sourcing_request_status srs '
				   .' ON sr.sourcing_request_status_id= srs.sourcing_request_status_id' 
				   .' ORDER BY sf.dated DESC ';
	
	$result			   = mysql_query($sql_src_req);
	$response->page    = $page;
	$response->total   = $total_pages;
	$response->records = $count;
	$i 				   = 0;
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
	{
			$response->rows[$i]['id']	= $row[sourcing_request_id];
			$response->rows[$i]['cell'] = array($row[sourcing_request_id],
											date('d - M',strtotime($row[date])),
											$row[sourcing_request_status_id],
											stripslashes($row[request]),
											stripslashes($row[jobtitle]), 
											$row[div],
											$row[dept],
											DrawProgressBar($row[sourcing_request_status_id],$row[request]),	
											'<div style="width: 16px; height: 16px; margin-left:30px" title="'.$row[comments].'" class="green ui-state-default ui-corner-all" ><span class="ui-icon ui-icon-info" ></span></div>'
											);
											
			$i++;				
	}
	echo json_encode($response);
	
	function DrawProgressBar($status_id,$status_name)
	{
	
		$htmlstr = '<div class="';
	
		if ( 8 == $status_id ) // $Reject_with_pending=8
		{
			
			$htmlstr .= 'brown progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar"';
			$htmlstr .= ' aria-valuemin="0" aria-valuemax="100" aria-valuenow="';
			  $width  = 100;
		}	
		else if	((  7 == $status_id ) || (  9 == $status_id ) 
			  || (  10 == $status_id ) ) //$Candidate_Rejected=7,$Reject_Permanently=9,$Candidate_Declined=10
		{
			
			$htmlstr .= 'red progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar"';
			$htmlstr .= ' aria-valuemin="0" aria-valuemax="100" aria-valuenow="';
			$width    = 100;
		}
		else 	
		{
			$htmlstr .= 'green progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar"';
			$htmlstr .= ' aria-valuemin="0" aria-valuemax="100" aria-valuenow="';
			$width    = (($status_id - 1 )* 20 );
		}			
		
		
		$htmlstr .=  $width. '"><div class="ui-progressbar-value ui-widget-header ';
		$htmlstr .= ( ( $width < 100 ) ? "ui-corner-left" : "ui-corner-all" );
		
		$htmlstr .=	'" style="width: '.$width.'%;"></div></div>';
		$htmlstr .= '<div style="width:100%" > <span style="font-size:smaller;">'.$status_name.'</span></div>'; 
	
	    return $htmlstr;
	
	
	}
?>