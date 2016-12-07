<?php 
include_once("config.php");
require_once "mailto_lm.php";
	$page	= $_GET['page']; // get the requested page
	$limit	= $_GET['rows']; // get how many rows we want to have into the grid
	if ( $limit < 1 )
	{
		$limit	= 1;
	}	
	$sidx = $_GET['sidx']; // get index row - i.e. user click to sort

	$sord = $_GET['sord']; // get the direction
	if ( !$sidx )
	{
		$sidx = 1;
	}
	if ( $sord < 1 )
	{
		$sord = 1;
	}
// POST variables	
	$dept_id					= $_POST['dept_id'];
	$sr_id						= $_POST['sr_id'];
	$comment					= trim($_POST['comment']);
	$status						= $_POST['status'];
	$current_status_id			= $_POST['current_status_id'];
	//$old_status_id			= '';
	$new_status					= '';
    $requestby_id				= $_POST['requestby_id'];
	$notification_subject		= 'Notification about sourcing request';
	$sql_request_update         = '';
	$result 					= false;
	$res 						= false;

	if ( $dept_id > 0 )
	{ 
		if	(	$status	!= '' )
		{
			if ( $status == "accept" )
			{
				if( CheckAvailability($dept_id) == "true" )
				{
							if( $current_status_id == $Awaiting_HR_Validation )
							{
								$new_status = $Sourcing_in_progress;
								//$sql_request_update = "UPDATE sourcing_requests SET sourcing_request_status_id = 2, comments = //'" .addslashes($comment). "' WHERE sourcing_request_id = " .$sr_id;
								$result = UpdateSourcingRequestStatus(2,$comment,$sr_id);
								if($result)
								{
									$res = UpdateSourceAndHeadCounters($dept_id);
									if ($res)
									{
										//email code
									}
									else
									{
										echo 'Headcounters could not be updated';
										exit;
									}
								}
								
							}
							else if ( $current_status_id == $Sourcing_in_progress )
							{
								$new_status = $Hiring_in_Progress;
								//$sql_request_update = "UPDATE sourcing_requests SET sourcing_request_status_id = 3, comments = '" .addslashes($comment). "' WHERE sourcing_request_id = " .$sr_id;
								$result = UpdateSourcingRequestStatus(3,$comment,$sr_id);
							}
							else if($current_status_id==$Hiring_in_Progress)
							{
								$new_status = $Appointment_Letter_Issued;
								//$sql_request_update = "UPDATE sourcing_requests SET sourcing_request_status_id = 4, comments = '" .addslashes($comment). "' WHERE sourcing_request_id = " .$sr_id;
								$result = UpdateSourcingRequestStatus(4,$comment,$sr_id);
							}
						
						/*else
						{
							//return error;
							echo "error : ".mysql_error();
							exit;
						}*/
				}
				else {
					echo "Head Count Changed, No Position Available";
					exit;
				}
			}
				
			else if ( $status == "pending" )
			{
				$new_status = $Reject_with_pending;
				//$sql_request_update = "UPDATE sourcing_requests SET sourcing_request_status_id = 8, comments = '" .addslashes($comment). "' WHERE sourcing_request_id = " .$sr_id;
				$result = UpdateSourcingRequestStatus(8,$comment,$sr_id);
			}
			else if ( $status == "permanent" )
			{
				$new_status = $Reject_Permanently;
				//$sql_request_update = "UPDATE sourcing_requests SET sourcing_request_status_id = 9, comments = '" .addslashes($comment). "' WHERE sourcing_request_id = " .$sr_id;
				$result = UpdateSourcingRequestStatus(9,$comment,$sr_id);
			}
			
			//$sql_request_update = "UPDATE sourcing_requests SET sourcing_request_status_id = ".$new_status.", comments = '" .addslashes($comment). "' WHERE sourcing_request_id = " .$sr_id;
			
			//echo $sql_request_update;
			
			if ( $result ) {
				//if (mysql_affected_rows() > 0)
				//{
					
					//------------------------------------------------------email section starts------------------------
					$from = $_SESSION['email_id'];
					$to  = GetEmailId($requestby_id);
					if ( $to !='') {		
						if ( SendMailtoLineManager($to,$from,$notification_subject,$comment) ) {
								$enid = SaveEmail($to,$from,$comment,1,$notification_subject); // 1= dispatch = true
								echo $new_status;
								//UpdateDispatch($enid);
								exit;
						}
						else {
							$enid = SaveEmail($to,$from,$comment,0,$notification_subject);
							echo "Failed dispatching email";
							exit;
						}
					}
					else
					{
						echo 'Email notification could not sent. There is no destination email address.';
					}
					//---------------------------------------------------------email section ends------------------------
				//}
				//else {
				//	echo "No Row Affected";
				//	exit;
				//}
			}
			else {
				echo "Error updating request status: ".mysql_error();
				exit;
			}
		
		
		}
		else
		{
			$res = CheckAvailability($dept_id);
			echo $res;
			exit;
		}
	}
//-------------------

	if ( $_GET['q'] == 1 )//tab 1 - New Sourcing Requests
	{
		$sql_sr 	  = 'SELECT COUNT(*) AS count '
					   .' FROM sourcing_requests';
		$result_count = mysql_query($sql_sr);
		$count 		  = $row['count'];
		
		$id			  = '';
		$date		  =	''; 
		$linemanager  = '';
		$request	  = '';
		$jobtitle	  = '';
		$div		  = '';
		$dept		  = '';
		$progressbar  = '';
		$hrfeeback	  = '';
		$action		  = '';
	
		$sql_src_req  = " SELECT  sf.dated AS date, sf.requestby AS linemanager , sf.requestby_id, "
					   ." sr.sourcing_request_id, srs.sourcing_request_status_id, "
					   ." srs.sourcing_request_status  AS request, sr.sourcing_request_title"
					   ." AS jobtitle, d.department_name AS dept, sf.department_id,"
					   ." divi.division_name AS `div`, '' AS progressbar,'' AS  hrfeedback"
					   ." FROM sourcing_requests AS sr " 
					   ." INNER JOIN sourcing_forms sf ON sf.sourcing_request_id = sr.sourcing_request_id" 
					   ." INNER JOIN departments d ON sr.department_id=d.department_id "
					   ." INNER JOIN divisions divi ON divi.division_id=d.division_id "
					   ." INNER JOIN sourcing_request_status srs ON  "
					   ." sr.sourcing_request_status_id=srs.sourcing_request_status_id "
					   ." WHERE sr.sourcing_request_status_id NOT IN (".$Reject_with_pending.",".$Reject_Permanently.",".$Candidate_Declined.") "
					   ." ORDER BY sf.dated DESC";
			
		$result		   		= mysql_query($sql_src_req);
		$response->page 	= $page;
		$response->total 	= $total_pages;
		$response->records  = $count;
		$i	= 0;
		while ( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
		{
			$response->rows[$i]['id']=$row[sourcing_request_id];
			$response->rows[$i]['cell']=array($row[sourcing_request_id],
												date('d - M',strtotime($row[date])),
												stripslashes($row[linemanager]),
												stripslashes($row[requestby_id]),
												$row[sourcing_request_status_id],
												$row[request],
												stripslashes($row[jobtitle]), 
												$row[div],
												$row[dept],
												'<div class="green progressbar ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar"'
												.' aria-valuemin="0" aria-valuemax="100" aria-valuenow="'
												. (($row[sourcing_request_status_id]-1)*20)
												. '"><div class="ui-progressbar-value ui-widget-header '
												.((($row[sourcing_request_status_id]-1)*20 < 100 ) ? "ui-corner-left" : "ui-corner-all" )
												.'" style="width: '.(($row[sourcing_request_status_id]-1)*20).'%;"></div></div><div style="width:100%" > <span style="font-size:smaller;">'.$row[request].'</span></div>',
														
												'<a href="#" id="validate_'.$row[sourcing_request_id].'" class="ui-button ui-widget '
																									 .' ui-state-default ui-corner-all'
																									 .' ui-button-text-only" role="button" '
												.'onclick="validate_sourcing('.$row[sourcing_request_id]
																			.','.$row[department_id].','
																			. $row[sourcing_request_status_id]
																			.','.$row[requestby_id]
																			.');"><span class="ui-button-text">Validate</span></a>',
																			
												'<a href="#" onClick="onViewDetail('.$row[sourcing_request_id].');" '
												.' id = "vd_'.$row[sourcing_request_id].'" class = " vd ui-button  ui-widget ui-state-default '
																								 .'  ui-corner-all ui-button-text-only" '
												.' role="button"><span  class="ui-button-text">View Detail</span></a>');
					
					$i++;							
			}
			echo json_encode($response);
		}
		//-------------------------------------------new ended---------------------------
		if ( $_GET['q'] == 2 ) //tab 2 - Positions Filled
		{
			$sql_cnt_src    = 'SELECT COUNT(*) AS count '
							 .' FROM sourcing_requests' ;
			$result_count   = mysql_query($sql_cnt_src);
			$count 			= $row['count'];
			$id				= '';
			$date			= ''; 
			$linemanager	= ''; 
			$request		= ''; 
			$jobtitle		= ''; 
			$div			= ''; 
			$dept			= ''; 
			$progressbar	= ''; 
			$hrfeeback		= ''; 
			$action			= '';
	
			$sql_sourcing   = " SELECT  sf.dated AS date, sf.requestby AS linemanager ,"
							." sr.sourcing_request_id,srs.sourcing_request_status  AS request,"
							." sr.sourcing_request_title AS jobtitle, d.department_name AS dept,"
							." divi.division_name AS `div`, '' AS progressbar,'' AS  hrfeedback"
							." FROM sourcing_requests  AS sr "
							." INNER JOIN sourcing_forms sf ON sf.sourcing_request_id = sr.sourcing_request_id"
							." INNER JOIN departments d ON sr.department_id = d.department_id"
							." INNER JOIN divisions divi ON divi.division_id = d.division_id" 
							." INNER JOIN sourcing_request_status srs "
							." ON sr.sourcing_request_status_id = srs.sourcing_request_status_id "
							." WHERE sr.sourcing_request_status_id =" .$Candidate_Accepted;
			
			$result_2 			= mysql_query($sql_sourcing);
			$response->page 	= $page;
			$response->total 	= $total_pages;
			$response->records  = $count;
			$i = 0;
			if ( $result_2 )
			{
				while ( $row = mysql_fetch_array($result_2,MYSQL_ASSOC) )
				{
						$response->rows[$i]['id']	= $row[sourcing_request_id];
						$response->rows[$i]['cell'] = array($row[sourcing_request_id],
														stripslashes(date('d - M',strtotime($row[date]))),
														stripslashes($row[linemanager]),
														stripslashes($row[request]),
														stripslashes($row[jobtitle]), 
														$row[div],
														$row[dept],
														$row[progressbar],
														'<input type="submit" class="validate" value="Validate"'
														.' id="validate_'.$row[sourcing_request_id].'"/>',	
														'<a href="#" class="vd" id=' ."vd_". $row[sourcing_request_id]
														.'>View Detail</a>');
						$i++;							
				}
				echo json_encode($response);
			}	
		}
		//------------------------------------------filled ended--------------------------
		if ( $_GET['q'] == 3 ) //Fetch records for  - Rejectied with Pending (grid on tab 3)
		{
			$sql_cnt_sourcing = 'SELECT COUNT(*) AS count from sourcing_requests';
			$result_count 	  = mysql_query($sql_cnt_sourcing);
			$count 			  = $row['count'];
			$id				  = '';
			$date			  = ''; 
			$linemanager	  = ''; 
			$request		  = ''; 
			$jobtitle		  = ''; 
			$div			  = ''; 
			$dept			  = ''; 
			$progressbar	  = ''; 
			$hrfeeback		  = ''; 
			$action			  = '';
	
			$sql_sourcing	  = " SELECT  sf.dated AS date, sf.requestby AS linemanager ,"
							   ." sr.sourcing_request_id, srs.sourcing_request_status  AS request,"
							   ." sr.sourcing_request_title AS jobtitle, d.department_name AS dept, "
							   ." divi.division_name AS `div`, '' AS progressbar, '' AS  hrfeedback "
							   ." FROM sourcing_requests  AS sr "
							   ." INNER JOIN sourcing_forms sf ON sf.sourcing_request_id "
							   ." = sr.sourcing_request_id "
							   ." INNER JOIN departments d ON sr.department_id=d.department_id "
							   ." INNER JOIN divisions divi ON divi.division_id=d.division_id "
							   ." INNER JOIN sourcing_request_status srs ON"
							   ." sr.sourcing_request_status_id=srs.sourcing_request_status_id"
							   ." WHERE sr.sourcing_request_status_id =".$Reject_with_pending;
							   
			$result_3			= mysql_query($sql_sourcing);
			$response->page     = $page;
			$response->total    = $total_pages;
			$response->records  = $count;
			$i = 0;
			
			if($result_3)
			{
				while($row=mysql_fetch_array($result_3,MYSQL_ASSOC))
				{
						$response->rows[$i]['id']   = $row[sourcing_request_id];
						$response->rows[$i]['cell'] = array($row[sourcing_request_id],
															date('d - M',strtotime($row[date])),
															stripslashes($row[linemanager]),
															stripslashes($row[request]),
															stripslashes($row[jobtitle]), 
															$row[div],
															$row[dept]
															);
						
					$i++;							
				}
				echo json_encode($response);
			}	
		}
		//----------------------------------------------pending ended-------------------------
		if($_GET['q']==4) //tab 4 - Positions Rejected
		{
			$sql_cnt='SELECT COUNT(*) AS count'
					.'FROM sourcing_requests';
			
			$result_count = mysql_query($sql_cnt);
			$count = $row['count'];
			$id='';
			$date=''; 
			$linemanager=''; 
			$request=''; 
			$jobtitle=''; 
			$div=''; 
			$dept=''; 
			$progressbar=''; 
			$hrfeeback=''; 
			$action='';
	
			$sql_sourcing_reject = 'SELECT  sf.dated AS date, sf.requestby AS linemanager ,'
								 .' sr.sourcing_request_id,srs.sourcing_request_status  AS request,'
								 .' sr.sourcing_request_title AS jobtitle, d.department_name AS dept,'
							     .' divi.division_name AS `div`, "" AS progressbar,"" AS  hrfeedback '
								 .' FROM sourcing_requests  AS sr' 
								 .' INNER JOIN sourcing_forms sf ON sf.sourcing_request_id=sr.sourcing_request_id'
								 .' INNER JOIN departments d ON sr.department_id=d.department_id '
								 .' INNER JOIN divisions divi ON divi.division_id=d.division_id '
								 .' INNER JOIN sourcing_request_status srs ON '
								 .' sr.sourcing_request_status_id=srs.sourcing_request_status_id '
								 .' WHERE sr.sourcing_request_status_id ='.$Reject_Permanently;
			
			$result_4			= mysql_query($sql_sourcing_reject);
			$response->page     = $page;
			$response->total    = $total_pages;
			$response->records  = $count;
			
			$i	=  0;
			if ( $result_4 )
			{
			
				while ( $row = mysql_fetch_array($result_4,MYSQL_ASSOC) )
				{
					
				$response->rows[$i]['id']   = $row[sourcing_request_id];
						$response->rows[$i]['cell'] = array($row[sourcing_request_id],
															 stripslashes(date('d - M',strtotime($row[date]))),
															 stripslashes($row[linemanager]),
															 stripslashes($row[request]),
															 stripslashes($row[jobtitle]), 
															 $row[div],
															 $row[dept],
															 $row[progressbar],
															 '<input type="submit" class="validate" value="Validate" id="validate_' .$row[sourcing_request_id].'"/>',	'<a href="#" class="vd" id='.    "vd_".$row[sourcing_request_id].'>View Detail</a>'
															 );
						$i++;							
				}
				echo json_encode($response);
			}
		}
		//------------------------------------------------rejected ended-------------------------
function CheckAvailability($dept_id)
{
	$sql_counts = ' SELECT open_head_count, sourcing_request_count '
				 . ' FROM departments '
				 . ' WHERE department_id='.$dept_id;
	$res_stid   = mysql_query($sql_counts);

	if ( $res_stid )
	{
		while ( $row = mysql_fetch_array($res_stid,MYSQL_ASSOC) )
		{
				return (($row[open_head_count]) > ($row[sourcing_request_count])) ? "true" : "false"; 		
	
		}
			
	}
	else
		return "false";			

}	
// ----------------get email id of lm---------
function GetEmailId($userid)
{
	$sql_email_id  = ' SELECT email_id'
					.' FROM users '
					.' WHERE users_id='.$userid; 
	$sql_exec  = mysql_query($sql_email_id);
	while ( $row = mysql_fetch_array($sql_exec, MYSQL_ASSOC))
	{
		return stripslashes($row['email_id']);
	}
	return '';
}
//-----------save email----------------	
function SaveEmail($to,$from,$comment,$dispatch,$subject)
{
   $sql_insert_email = ' INSERT INTO email_notifications (dispatch, `subject`,'
					  .' `content`, requestedby_id, approvedby_id)'
					  .' VALUES ('
					  . $dispatch.','.addslashes($subject).','.addslashes($comment).','.addslashes($to).','.addslashes($from).')';  
   $sql_res = mysql_query($sql_insert_email);
   return  mysql_insert_id();
}
function UpdateDispatch($enid)
{
	$sql_update = ' UPDATE email_notifications '
				. ' SET dispatch = 1'
				. ' WHERE email_notification_id ='.$enid;
	mysql_query($sql_update);
}
//------------------------------------------update counter-------
function UpdateSourceAndHeadCounters($dept_id)
{
	$sql_dept_update = " UPDATE `departments` "
					 . " SET `departments`.`open_head_count` = `departments`.`open_head_count` - 1 "
					 . " ,`departments`.`sourcing_request_count`=`departments`.`sourcing_request_count`+1"
					 . " WHERE `departments`.`department_id`=" .$dept_id ;

	if ($dept_updated=mysql_query($sql_dept_update)) 
	{
		return true;

	}
	return false;
}
//----------------------------update request status ----------------
function UpdateSourcingRequestStatus($status_id,$comment,$sr_id)
{

	$sql_request_update = " UPDATE sourcing_requests SET sourcing_request_status_id = "
						. $status_id . ", comments = '" .addslashes($comment)
						. "' WHERE sourcing_request_id = " .$sr_id;
	if ( mysql_query($sql_request_update)  )
	{
		return true;
	}
	return false;
}						
//------------------------------------------
/*function SendMailtoLineManager($mesg)
{
        $from      = "<from.gmail.com>";
        $to        = "aftab.pucit@gmail.com";
        $subject   = "Sourcing Request Status updated!";
        $body      = $mesg;

        $host      = "ssl://smtp.gmail.com";
        $port      = "465";
        $username  = "aftab@dot5ive.com";
        $password  = "recall123";

        $headers   = array ('From'      => $from,
							  'To'      => $to,
							  'Subject' => $subject
							);
        $smtp      = Mail::factory('smtp',
									  array ('host'     => $host,
											 'port'     => $port,
											 'auth'     => true,
											 'username' => $username,
											 'password' => $password
											)
							 );

        $mail      = $smtp -> send($to, $headers, $body);

        if ( PEAR::isError($mail) )
		{
          echo("<p>" . $mail->getMessage() . "</p>");
        }
		else 
		{
          return 1;
        }
}*/
?>