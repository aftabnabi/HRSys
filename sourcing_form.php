<?php 
include_once("config.php");

	$fid = '';
	if ( $_GET['fid'] != '' )
	{
		$fid     = $_GET['fid'];
		$sql_s_f = 'SELECT sourcing_form_id, sourcing_request_id, requestby , requestby_id,'
					.' approvedby, dated, division_id, department_id,' 
					.' timerequired, gender, jobtitle, grade ,'
					.' academic, specialization, salary,'
					.'age, reportsto, experienceyears, location,'
					.' jobdescription, essential_skills, desirable_skills'
					.', proficiency, otherdetails, personality,'
					.' technical,  general, existing_db, '
					.' company_posting, other_posting,newspaper_posting,'
					.' emp_referrals,	headhunters, internal_posting'  
					.' FROM  sourcing_forms '
					.' WHERE sourcing_request_id='.$fid;
		$res_f   = mysql_query($sql_s_f);
		$row_f   = mysql_fetch_array($res_f,MYSQL_ASSOC);
	}
?>
<h3 align="center">SOURCING REQUEST FORM</h3>
<form id="sourcing_form" action="sourcing_form_process.php" method="post" >

	<fieldset class="ui-tabs-panel ui-widget-content ui-corner-bottom">

    <p>Requested by:

<?php 
		$requested = '';  
		$requested_by_id = '';
		
	if ( $row_f['requestby'] != '' )
	{
		$requested        = stripslashes($row_f['requestby']) ;
		$requested_by_id  = $row_f['requestby_id'] ;
	}	
	else
	{
		$requested 		  = $_SESSION['username'] ; 
		$requested_by_id  = $_SESSION['userid'] ; 
	}
	?>
        <input name ="requestby" type="text" value="<?php echo $requested ; ?>"/>            
		<input type = "hidden" name ="requestby_id" id="requestby_id" value= "<?php echo $requested_by_id ; ?>"/>
		<p>Approved by: 

        <input name="approvedby" type="text" disabled="disabled" value="<?php echo stripslashes($row_f['approvedby']) ; ?>"/>

		<p>Date:

        <input id="dated" name="dated" type="text" value=" <?php echo $row_f['dated'] ; ?>"/>

		<p>Division:<select id="division" name="division" >
        
	<?php 
			$sql_div = 'SELECT division_id, division_name '
						.' FROM divisions';
			
			$res = mysql_query($sql_div);
			
			if ( $res )
			{
				while( $row = mysql_fetch_array($res,MYSQL_ASSOC) )
					{
						if( $row_f['division_id'] != '' )
						{
							 if( $row_f['division_id'] == $row['division_id'] )
								echo "<option selected value='".$row["division_id"]."'>".$row["division_name"]."</option>";						
							else
								echo "<option value='".$row["division_id"]."'>".$row["division_name"]."</option>";
						}
						else
						{
							if( $_SESSION['division_id'] == $row['division_id'] )
							{
								echo "<option selected value='" .$row["division_id"]. "'>" .$row["division_name"]. "</option>";
							}	
							else
							{		
								echo "<option value='" .$row["division_id"]. "'>" .$row["division_name"]. "</option>";
							}	
					  	}
					}
				}	
			?>
			</select>
			
		<p>Department:<select id="department" name="department" >
		
		<?php 
			$sql_dept = " SELECT department_id,department_name "
						." FROM departments "
						." WHERE division_id = '" .$_SESSION['division_id']. "'";
			$res = mysql_query($sql_dept);
		
			if( $res )
			{
				while( $row = mysql_fetch_array($res,MYSQL_ASSOC) )
					{
						if( $row['department_id'] == $_SESSION['department_id'] )
						{
							echo "<option selected value='" .$row["department_id"]. "'>" .$row["department_name"]. "</option>";
						}	
						else
						{
							echo "<option value='" .$row['department_id']. "'>" .$row["department_name"]. "</option>";
						}	
					}
				}
		?>
              </select>  
			  
		<p>Turn Around Time Required:
        <input id="timerequired" name="timerequired" type="text" value="<?php echo stripslashes($row_f['timerequired']); ?>" />
		<p>Gender Preference for the Role (If any):
			<select id="gender" name="gender">
			
		<?php 
			if ( $row_f['gender'] == 'm' )
			{
		?>
						<option selected="selected" value="m">Male</option>
						<option value="f">Female</option>
		<?php
			}
			else if ( $row_f['gender'] == 'f' ) 
			{
		?>		
						<option value="m">Male</option>
						<option selected="selected" value="f">Female</option>
		<?php
			}
			else
			{
		?>
						<option selected="selected" value="m">Male</option>
						<option value="f">Female</option>
		<?php
			}
		?>	
			
			</select>
		</fieldset>
		
        <fieldset class="ui-tabs-panel ui-widget-content ui-corner-bottom">
			<legend><b>Job Classification</b> </legend>
			<p>1. Job/Role Title:
				<input name="jobtitle" type="text" value="<?php echo stripslashes($row_f['jobtitle'])?>"/>
			<p>2. Grade:
				<input name="grade" type="text" value="<?php echo stripslashes($row_f['grade'])?>"/>
			</p>
			
        </fieldset>
        <p>
        
        <fieldset class="ui-tabs-panel ui-widget-content ui-corner-bottom">
        <legend><b>Position Details:</b> </legend>
        <p>1. ACADEMIC QUALIFICATION:
            <input name="academic" type="text" value="<?php echo stripslashes($row_f['academic'])?>" />
        <p>2. AREA OF SPECIALIZATION:
            <input name="specialization" type="text" value="<?php echo stripslashes($row_f['specialization'])?>" />
        </p>
        <p>3. SALARY RANGE:
            <input name="salary" type="text" value="<?php echo stripslashes($row_f['salary'])?>" />
        </p>
        <p>4. AGE BRACKET:
            <input name="age" type="text" value="<?php echo stripslashes($row_f['age'])?>" />
        </p>
        <p>5. REPORTS TO:
            <input name="reportsto" type="text" value="<?php echo stripslashes($row_f['reportsto'])?>" />
        </p>
        <p>6. YEARS OF EXPERIENCE:
            <input name="experienceyears" type="text" value="<?php echo stripslashes($row_f['experienceyears']);?>" />
        </p>
        <p>7. LOCATION:
            <input name="location" type="text" value="<?php echo stripslashes($row_f['location']); ?>" />
        </p>
        <p>Job Description: </p>
        <p>
            <textarea name="jobdescription" cols="60" rows="5"><?php echo stripslashes($row_f['jobdescription'])?></textarea>
        </p>
        <p>
        </fieldset>
    
    	<fieldset class="ui-tabs-panel ui-widget-content ui-corner-bottom">
			<legend><b>Technical/Soft Skills</b></legend>
		<p>Essential Skills
			<input name="essential_skills" type="text" value="<?php echo stripslashes($row_f['essential_skills'])?>"/>
        
		<p>Desirable Skills
			<input name="desirable_skills" type="text" value="<?php echo stripslashes($row_f['desirable_skills'])?>"/>
        <p>Computer Proficiency
            <input name="proficiency" type="text" value="<?php echo stripslashes($row_f['proficiency'])?>"/>
        <p>Other Details/Skills
            <input name="otherdetails" type="text" value="<?php echo stripslashes($row_f['otherdetails'])?>"/>
        </fieldset>
		
		<fieldset class="ui-tabs-panel ui-widget-content ui-corner-bottom">
       
			<legend><b>Tests</b></legend>
		<p><b>Personality Assessment</b><br/>
					(Normally 40 minutes to 1 hour long, recommended for assessing 5
						or more candidates. Known to help determine personality traits
						suited for a given role.)
		<input name="personality" type="text" value="<?php echo stripslashes($row_f['personality'])?>"/>
		<p><b>Technical Assessment </b><br />
		<p>(Meant for testing a specific skill or knowledge, for instance, drafting
            skills, technical knowledge, etc. We have basic formats available
            with us and can also use a department specific test if provided with
            one) 
        <input name="technical" type="text" value="<?php echo stripslashes($row_f['technical'])?>"/>
        </p>
		<p><b>General Cognitive Ability (IQ)</b><br />
		<p>(Meant for testing the general intelligence level of a candidate.
            Can be conducted individually or in a group. Can be 15-45 minutes
            long depending on the version used. Known to help determine the level
            at which an individual learns, understands instructions and solves
            problems.)</p>
		<p>
			<input name="general" type="text" value="<?php echo stripslashes($row_f['general']);?>"/>
        </p>
        </fieldset>
        
		<fieldset class="ui-tabs-panel ui-widget-content ui-corner-bottom">
			<legend><b>For HR Use Only</b></legend>
        <p>Sourcing Channels activated:
		<p>Existing database
            <input name="existing_db" type="text" value="<?php echo stripslashes($row_f['existing_db']);?>"/>
        <p>Mobilink Job Portal Posting
            <input name="company_posting" type="text" value="<?php echo stripslashes($row_f['company_posting'])?>;" />
        <p>Posting on other portals
            <input name="other_posting" type="text" value="<?php echo stripslashes($row_f['other_posting'])?>" />
        <p>Newspaper Advertisement
            <input name="newspaper_posting" type="text" value="<?php echo stripslashes($row_f['newspaper_posting']);?>"/>
        <p>Employee Referrals
            <input name="emp_referrals" type="text" value="<?php echo stripslashes($row_f['emp_referrals']);?> "/>
        <p>Headhunters
            <input name="headhunters" type="text" value="<?php echo stripslashes($row_f['headhunters']);?> "/>
        <p>Internal Job Posting
            <input name="internal_posting" type="text" value="<?php echo stripslashes($row_f['internal_posting']);?> "/>
        </fieldset>
	</form>