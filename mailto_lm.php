<?php
/*
require_once "Mail.php";
function SendMailtoLineManager($mesg)
{
        $from      = "<from.gmail.com>";
        $to        = "aftab.pucit@gmail.com";
        $subject   = "Sourcing Request Status updated!";
        $body      = $mesg;

        $host      = "ssl://smtp.gmail.com";
        $port      = "587";
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
          echo("<p>Message successfully sent!</p>");
        }
}*/

// multiple recipients
function SendMailtoLineManager($to,$from,$subj,$mesg)
{


		
		// subject
		$subject = $subj;
		
		// message
		$message = $mesg;
		
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$to . "\r\n";
		$headers .= 'From: '.$from. "\r\n";
		
		
		// Mail it
		return mail($to, $subject, $message, $headers);
}		
?>