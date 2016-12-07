<?php include('dbconfig.php'); 
session_start();
include_once("systemconfig.php");
//Declarations
	$requestby         = '';
	$approvedby        = '';
	$dated             = '';	
	$division          = '';
	$department        = '';
	$timerequired      = '';
	$gender            = '';
	$jobtitle          = '';
	$grade             = '';
	$academic          = '';
	$specialization    = '';
	$salary            = '';
	$age               = '';
	$reportsto         = '';		
	$experienceyears   = '';
	$location          = '';
	$jobdescription    = '';
	$essential_skills  = '';
	$desirable_skills  = '';
	$proficiency       = '';
	$otherdetails      = '';
	$personality       = '';
	$technical         = '';
	$general           = '';	
	$existing_db       = '';
	$company_posting   = '';
	$other_posting     = '';
	$newspaper_posting = '';
	$emp_referrals     = '';	
	$headhunters       = '';
	$internal_posting  = '';

	$hr_comment        = 'This Request has been sent to HR for validation.';


if( $_POST['department'] != '' )
{

			if ( $_POST['requestby']    != '' ) $requestby=$_POST['requestby'];
			if ( $_POST['requestby_id'] != '' ) $requestby_id=$_POST['requestby_id'];
			if($_POST['approvedby']     != '' ) $approvedby=$_POST['approvedby'];
			if($_POST['dated']!='')	
			{$dated=$_POST['dated'];$dated=date('Y-m-d',strtotime($dated));}
			if($_POST['division']!='') 	$division=$_POST['division'];
			if($_POST['department']!='') $department=$_POST['department'];
			if($_POST['timerequired']!='') 	$timerequired=$_POST['timerequired'];
			if($_POST['gender']!='') 	$gender=$_POST['gender'];
			if($_POST['jobtitle']!='') 	$jobtitle=$_POST['jobtitle'];
			if($_POST['grade']!='') $grade=$_POST['grade'];
			if($_POST['academic']!='') 	$academic=$_POST['academic'];
			if($_POST['specialization']!='') $specialization=$_POST['specialization'];
			if($_POST['salary']!='') $salary=$_POST['salary'];
			if($_POST['age']!='') 	$age=$_POST['age'];
			if($_POST['reportsto']!='') $reportsto=$_POST['reportsto'];
			if($_POST['experienceyears']!='') 	$experienceyears=$_POST['experienceyears'];
			if($_POST['location']!='') 	$location=$_POST['location'];
			if($_POST['jobdescription']!='') $jobdescription=$_POST['jobdescription'];
			if($_POST['essential_skills']!='') 	$essential_skills=$_POST['essential_skills'];
			if($_POST['desirable_skills']!='') 	$desirable_skills=$_POST['desirable_skills'];
			if($_POST['proficiency']!='') 	$proficiency=$_POST['proficiency'];
			if($_POST['otherdetails']!='') 	$otherdetails=$_POST['otherdetails'];
			if($_POST['personality']!='') $personality=$_POST['personality'];
			if($_POST['technical']!='') 	$technical=$_POST['technical'];
			if($_POST['general']!='') 	$general=$_POST['general'];
			if($_POST['existing_db']!='') 	$existing_db=$_POST['existing_db'];
			if($_POST['company_posting']!='')  	$company_posting=$_POST['company_posting'];
			if($_POST['other_posting']!='') $other_posting=$_POST['other_posting'];
			if($_POST['newspaper_posting']!='') $newspaper_posting=$_POST['newspaper_posting'];
			if($_POST['emp_referrals']!='') $emp_referrals=$_POST['emp_referrals'];
			if($_POST['headhunters']!='') 	$headhunters=$_POST['headhunters'];
			if($_POST['internal_posting']!='') 	$internal_posting=$_POST['internal_posting'];
			

			$sql_insert_requests = " INSERT INTO sourcing_requests(`sourcing_request_title`,`department_id`,`sourcing_request_status_id`,`comments`)VALUES('".addslashes ($jobtitle)."','". $_POST['department']."',".$Awaiting_HR_Validation.",'".addslashes ($hr_comment)."')";

			$res_jobs = mysql_query($sql_insert_requests) or die("error1: ".mysql_error());

			$id = mysql_insert_id();
			if($res_jobs)
			{
				$sql_insert_form="INSERT INTO sourcing_forms(`sourcing_request_id`,`requestby` , `requestby_id`,`approvedby` , `dated` , `division_id` , `department_id` , `timerequired` , `gender` , `jobtitle` , `grade` , `academic` , `specialization` , `salary` , `age` , `reportsto` , `experienceyears` , `location` , `jobdescription` , `essential_skills` , `desirable_skills` , `proficiency` , `otherdetails` , `personality` , `technical` , `general` , `existing_db` , `company_posting` , `other_posting` , `newspaper_posting` , `emp_referrals` , `headhunters` , `internal_posting`) VALUES('".$id."','".addslashes($requestby)."',".addslashes ($requestby_id).",'".addslashes ($approvedby)."','".addslashes ($dated)."','".$division."','".$department."','".addslashes ($timerequired)."','".$gender."','".addslashes ($jobtitle)."','".addslashes ($grade)."','".addslashes ($academic)."','".addslashes ($specialization)."','".addslashes ($salary)."','".addslashes ($age)."','".addslashes ($reportsto)."','".addslashes ($experienceyears)."','".addslashes ($location)."','".addslashes ($jobdescription)."','".addslashes ($essential_skills)."','".addslashes ($desirable_skills)."','".addslashes ($proficiency)."','".addslashes ($otherdetails)."','".addslashes ($personality)."','".addslashes ($technical)."','".addslashes ($general)."','".addslashes ($existing_db)."','".addslashes ($company_posting)."','".addslashes ($other_posting)."','".addslashes ($newspaper_posting)."','".addslashes ($emp_referrals)."','".addslashes ($headhunters)."','".addslashes ($internal_posting)."')";

				$res_sr = mysql_query($sql_insert_form) or die("Error Creating New Sourcing Request: ".mysql_error());
				if($res_sr)
				{
					$res_counters=mysql_query('select total_head_count, existing_head_count, open_head_count,'
										.' sourcing_request_count, hiring_request_count, appointment_letter_issued_count,'
										.' candidate_accepted_count, candidate_joined_count '
										.' FROM DEPARTMENTS '
										.' WHERE department_id='.$department);
					$row=mysql_fetch_array($res_counters,MYSQL_ASSOC);
					if($res_counters)
					{
						$souring_counter=$row[sourcing_request_count];
						//increment
						$souring_counter=$souring_counter+1;
						$res_src_req_count_update=mysql_query('UPDATE departments
																SET sourcing_request_count='.$souring_counter 
																.' WHERE department_id='.$department
															 );
					
						if($res_src_req_count_update)
						{
							$_SESSION['submitted']=true;
							echo "Successfully Created New Sourcing Request.";
							exit;	
						}
					}
				}
				else
				{
						header("location:sourcing_form.php");
						//echo 'not';
						exit;
				}
			}
			else
			{
						header("location:sourcing_form.php?res=".$sql);
						//echo "couldnot submit request form infos : ".$sql;
						exit;
			}
		
}
?>