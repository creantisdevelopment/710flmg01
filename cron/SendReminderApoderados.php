<?php
////////////////////////////////////////////////////
// PHPMailer - PHP email class
//
// Class for sending email using either
// sendmail, PHP mail(), or SMTP.  Methods are
// based upon the standard AspEmail(tm) classes.
//
// Copyright (C) 2001 - 2003  Brent R. Matzelle
//
// License: LGPL, see LICENSE
////////////////////////////////////////////////////
# chdir(dirname(__FILE__). '/../');
/**
 * PHPMailer - PHP email transport class
 * @package PHPMailer
 * @author Brent R. Matzelle
 * @copyright 2001 - 2003 Brent R. Matzelle
 */
ini_set("error_log", "service_apoderados_log.txt");

//file modified by richie

require_once 'includes/Loader.php';
require_once 'include/utils/utils.php';

vimport('includes.http.Request');
vimport('includes.runtime.Globals');
vimport('includes.runtime.BaseModel');
vimport ('includes.runtime.Controller');
vimport('includes.runtime.LanguageHandler');

require_once("config.php");
require_once("modules/Emails/class.phpmailer.php");
require_once("modules/Emails/mail.php");
require_once('include/logging.php');

$current_user = Users::getActiveAdminUser();
// Set the default sender email id
global $HELPDESK_SUPPORT_EMAIL_ID;
$from = $HELPDESK_SUPPORT_EMAIL_ID;
if(empty($from)) {
	// default configuration is empty?
	$from = "reminders@localserver.com";
}

// Get the list of activity for which reminder needs to be sent

global $adb;
global $log;
global $site_URL;
$log =& LoggerManager::getLogger('SendReminder');
$log->debug(" invoked SendReminder ");

// retrieve the translated strings.
if(empty($current_language))
	$current_language = 'en_us';
$app_strings = return_application_language($current_language);
//modified query for recurring events -Jag
$query="SELECT vtiger_crmentity.crmid, vtiger_crmentity.description, vtiger_crmentity.smownerid, vtiger_seactivityrel.crmid AS setype,vtiger_activity.*, acf.cf_902 FROM vtiger_activity 
		INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_activity.activityid 
		LEFT JOIN vtiger_activitycf acf ON vtiger_activity.activityid = acf.activityid 
		INNER JOIN vtiger_activity_reminder ON vtiger_activity.activityid=vtiger_activity_reminder.activity_id 
		LEFT OUTER JOIN vtiger_seactivityrel ON vtiger_seactivityrel.activityid = vtiger_activity.activityid 
		WHERE DATE_FORMAT(vtiger_activity.date_start,'%Y-%m-%d, %H:%i:%s') >= '".date('Y-m-d')."' AND vtiger_crmentity.crmid != 0 AND 
		(vtiger_activity.eventstatus is NULL OR vtiger_activity.eventstatus NOT IN ('Held','Cancelled')) 
		AND (vtiger_activity.status is NULL OR vtiger_activity.status NOT IN ('Completed', 'Deferred', 'Cancelled'))
		AND (acf.cf_906 = 'NO' OR acf.cf_906 = '') AND vtiger_activity_reminder.reminder_time != 0 
		GROUP BY vtiger_activity.activityid";
$result = $adb->pquery($query, array());
error_log(print_r($query,true));
if($adb->num_rows($result) >= 1)
{
	$reminderFrequency = 1; // en segundos tiempo de ejecución del cron (15min)

	// Retriving the reminder email content from emailtemplates table
	$templateQuery='SELECT body FROM vtiger_emailtemplates WHERE subject=? AND systemtemplate=?';
	error_log(print_r("templateQuery: ".$templateQuery,true));
	$templateResult = $adb->pquery($templateQuery, array('Apoderado', '1'));
	$eventReminderBody=decode_html($adb->query_result($templateResult,0,'body'));
	var_dump($eventReminderBody);

	// Retriving the reminder email content from emailtemplates table
	// $templateQuery='SELECT body FROM vtiger_emailtemplates WHERE subject=? AND systemtemplate=?';
	// $templateResult = $adb->pquery($templateQuery, array('Activity Reminder', '1'));
	$todoReminderBody=$eventReminderBody;

	while($result_set = $adb->fetch_array($result))
	{
		$date_start = $result_set['date_start'];
		$time_start = $result_set['time_start'];
		if ( empty($result_set['cf_902']) ) $result_set['cf_902'] = 120;
		$reminder_time = $result_set['cf_902']*60;
		$date = new DateTimeField( null );
		$userFormatedString = $date->getDisplayDate();
		$timeFormatedString = $date->getDisplayTime();
		$dBFomatedDate = DateTimeField::convertToDBFormat($userFormatedString);
		$curr_time = strtotime($dBFomatedDate." ". $timeFormatedString);
		$activity_id = $result_set['activityid'];
		$activitymode = ($result_set['activitytype'] == "Task")?"Task":"Events";
		$parent_type = $result_set['setype'];
		$activity_sub = $result_set['subject'];
		$to_addr='';

		if($parent_type!='')
		$parent_content = getParentInfo($parent_type)."\n";
		else
		$parent_content = "";
		//code included for recurring events by jaguar starts
		$recur_id = $result_set['recurringid'];
		$current_date=date('Y-m-d');
		if($recur_id == 0)
		{
			$date_start = $result_set['date_start'];
		}
		else
		{
			$date_start = $result_set['recurringdate'];
		}
		error_log(print_r("Parent type: $parent_type",true));
		error_log(print_r("Parent content: $parent_content",true));
		error_log(print_r("date_start: $date_start",true));
		error_log(print_r("time_start: $time_start",true));
		//code included for recurring events by jaguar ends
		$date = new DateTimeField("$date_start $time_start");
		error_log(print_r($date,true));
		$userFormatedString = $date->getDisplayDate();
		$timeFormatedString = $date->getDisplayTime();
		$dBFomatedDate = DateTimeField::convertToDBFormat($userFormatedString);
		$activity_time = strtotime($dBFomatedDate.' '.$timeFormatedString);
		$differenceOfActivityTimeAndCurrentTime = ($activity_time - $curr_time);
		error_log(print_r("activity_time: $activity_time",true));
		error_log(print_r("curr_time: $curr_time",true));
		error_log(print_r("differenceOfActivityTimeAndCurrentTime: $differenceOfActivityTimeAndCurrentTime",true));
		error_log(print_r("reminder_time: $reminder_time",true));
		error_log(print_r("reminderFrequency: $reminderFrequency",true));
		if (($differenceOfActivityTimeAndCurrentTime > 0) && (($differenceOfActivityTimeAndCurrentTime <= $reminder_time) || ($differenceOfActivityTimeAndCurrentTime <= $reminderFrequency)))
		{
			$log->debug(" InSide REMINDER");
			$query_user="SELECT first_name, last_name FROM vtiger_users WHERE vtiger_users.id = ?";
			$user_profesor = $adb->pquery($query_user, array($result_set['smownerid']));
			$user_profesor = $adb->query_result($user_profesor, 0, 'first_name') . " " . $adb->query_result($user_profesor, 0, 'last_name');
			error_log(print_r("query_user: $query_user",true));

			$query_apoderado="SELECT a.accountid, a.accountname, a.email1,a.email2 FROM vtiger_troubletickets tt
						INNER JOIN vtiger_account a on tt.parent_id = a.accountid
						WHERE tt.ticketid = ?";
			error_log(print_r("query_apoderado: $query_apoderado" ." [$parent_type]",true));
			$apoderador_result = $adb->pquery($query_apoderado, array($parent_type));
			// $invitedUsersList = array();
			$nombre_apoderado = '';
			if($adb->num_rows($apoderador_result)>=1)
			{
				while($apoderador_result_row = $adb->fetch_array($apoderador_result))
				{
					if($apoderador_result_row['email1']!='' || $apoderador_result_row['email1'] !=NULL)
					{
						$to_addr[$apoderador_result_row['accountid']] = $apoderador_result_row['email1'];
					}
					$nombre_apoderado = decode_html($apoderador_result_row['accountname']);
					// $invitedUsersList[] = $apoderador_result_row['accountid'];
				}
			}

			// $ownerId = $result_set['smownerid'];
			// if (!in_array($ownerId, $invitedUsersList)) {
			// 	$ownerId = $invitedUsersList[0];
			// }
			$ownerFocus = CRMEntity::getInstance('Users');
			$ownerFocus->retrieve_entity_info(1, 'Users');
			$ownerTimeZone = getTranslatedString($ownerFocus->column_fields['time_zone'], 'Users');

			$dateTime = new DateTimeField($result_set['date_start'] .' '. $result_set['time_start']);
			$dateTimeInOwnerFormat = $dateTime->getDisplayDateTimeValue($ownerFocus);

			$enddateTime = new DateTimeField($result_set['due_date'] .' '. $result_set['time_end']);
			$enddateTimeInOwnerFormat = $enddateTime->getDisplayDateTimeValue($ownerFocus);

			//get related contact names
			$cont_qry = "SELECT * FROM vtiger_cntactivityrel WHERE activityid=?";
			error_log(print_r("cont_qry: $cont_qry",true));
			$cont_res = $adb->pquery($cont_qry, array($activity_id));
			$noofrows = $adb->num_rows($cont_res);
			$cont_id = array();
			if($noofrows > 0) {
				for($i=0; $i<$noofrows; $i++) {
					$cont_id[] = $adb->query_result($cont_res,$i,"contactid");
				}
			}
			$cont_name = '';
			foreach($cont_id as $key=>$id) {
				if($id != '') {
					$contact_name = Vtiger_Util_Helper::getRecordName($id);
					$cont_name .= $contact_name .', ';
				}
			}
			$cont_name = trim($cont_name,', ');
			$result_set['subject'] = decode_html($result_set['subject']);
			error_log(print_r("activity type: ". $result_set['activitytype'],true));
			if($result_set['activitytype'] == "Task") {
				$enddateInOwnerFormat = $enddateTime->getDisplayDate($ownerFocus);
				$list = $todoReminderBody;				
				$list = str_replace('$calendar-subject$',$result_set['subject'],$list);
				$list = str_replace('$calendar-description$',$result_set['description'],$list);
				$list = str_replace('$calendar-date_start$', $dateTimeInOwnerFormat.' '.$ownerTimeZone, $list);
				$list = str_replace('$calendar-due_date$', $enddateInOwnerFormat.' '.$ownerTimeZone, $list);

				$contents = getMergedDescription($list, $activity_id, 'Calendar',true);
				$subject = vtranslate('Activity Reminder', 'Calendar').': '.$result_set['subject'] . " @ $dateTimeInOwnerFormat";
			} else { // eventos
				$list = $eventReminderBody;
				$list = str_replace('$accounts-accountname$',$nombre_apoderado,$list);
				$list = str_replace('$events-subject$',decode_html($result_set['subject']),$list);
				$list = str_replace('$events-description$',decode_html($result_set['description']),$list);
				$list = str_replace('$events-date_start$', $dateTimeInOwnerFormat.' '.$ownerTimeZone, $list);
				$list = str_replace('$events-due_date$', $enddateTimeInOwnerFormat.' '.$ownerTimeZone, $list);
				$list = str_replace('$events-contactid$', $cont_name, $list);
				$list = str_replace('$events-eventstatus$', decode_html($result_set['eventstatus']), $list);
				$list = str_replace('$events-profesor$', decode_html($user_profesor), $list);

				$contents = getMergedDescription($list, $activity_id, 'Events',true);
				$subject = vtranslate('Reminder', 'Calendar').': '.$result_set['subject'] . " @ $dateTimeInOwnerFormat";
			}
			error_log(print_r("CONTENTS",true));
			error_log(print_r($contents,true));
			error_log(print_r($activity_id,true));
			error_log(print_r($list,true));
			
			// $recordModel = Vtiger_Record_Model::getInstanceById($activity_id, 'Calendar');
			// $recordDetailViewLink = $recordModel->getDetailViewUrl();
			if(count($to_addr) >=1)
			{
				error_log(print_r($to_addr,true));
				send_email($to_addr,$from,$subject,$contents,$mail_server,$mail_server_username,$mail_server_password);
				$upd_query = "UPDATE vtiger_activitycf SET cf_906 = 'SI' WHERE activityid = ? ";
				$upd_params = array($activity_id);
				
				error_log(print_r("upd_query: ". $upd_query." [$activity_id]",true));
				$adb->pquery($upd_query, $upd_params);

			}
		}
	}
}


/**
 This function is used to assign parameters to the mail object and send it.
 It takes the following as parameters.
	$to as string - to address
	$from as string - from address
	$subject as string - subject if the mail
	$contents as text - content of the mail
	$mail_server as string - sendmail server name
	$mail_server_username as string - sendmail server username
	$mail_server_password as string - sendmail server password

*/
function send_email($to,$from,$subject,$contents,$mail_server,$mail_server_username,$mail_server_password)
{
	global $adb;
	global $log;
	$log->info("This is send_mail function in SendReminder.php(vtiger home).");
	global $root_directory;

	$mail = new PHPMailer();


	$mail->Subject	= $subject;
	$mail->Body		= nl2br($contents);//"This is the HTML message body <b>in bold!</b>";

	$mail->IsSMTP();// set mailer to use SMTP
	$mailserverresult=$adb->pquery("select * from vtiger_systems where server_type='email'", array());
	$mail_server = $adb->query_result($mailserverresult,0,'server');
	$mail_server_username = $adb->query_result($mailserverresult,0,'server_username');
	$mail_server_password = $adb->query_result($mailserverresult,0,'server_password');
	$smtp_auth = $adb->query_result($mailserverresult,0,'smtp_auth');

	$_REQUEST['server']=$mail_server;
	$log->info("Mail Server Details => '".$mail_server."','".$mail_server_username."','".$mail_server_password."'");

	$mail->Host = $mail_server;	// specify main and backup server
	if($smtp_auth == 'true' || $smtp_auth == '1')
		$mail->SMTPAuth = true;
	else
		$mail->SMTPAuth = false;
	$mail->Username = $mail_server_username ;	// SMTP username
	$mail->Password = $mail_server_password ;	// SMTP password
	$mail->From = $from;
	$mail->FromName = $initialfrom;
	$log->info("Mail sending process : From Name & email id => '".$initialfrom."','".$from."'");
	foreach($to as $pos=>$addr)
	{
		error_log(print_r("Para: $addr",true));
		$mail->AddAddress($addr);// name is optional
		$log->info("Mail sending process : To Email id = '".$addr."' (set in the mail object)");

	}
	$mail->WordWrap = 50;// set word wrap to 50 characters

	$mail->IsHTML(true);// set email format to HTML

	$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

	// To Support TLS
	$serverinfo = explode("://", $mail_server);
	$smtpsecure = $serverinfo[0];
	if($smtpsecure == 'tls'){
		$mail->SMTPSecure = $smtpsecure;
		$mail->Host = $serverinfo[1];
	}
	// End
	error_log(print_r($mail,true));
	$flag = MailSend($mail);
	error_log(print_r($flag,true));
	$log->info("After executing the mail->Send() function.");
}

/**
 This function is used to get the Parent type and its Name
 It takes the input integer - crmid and returns the parent type and its name as string.
*/
function getParentInfo($value)
{
	global $adb;
	$parent_module = getSalesEntityType($value);
	if($parent_module == "Leads")
	{
		$sql = "select * from vtiger_leaddetails where leadid=?";
		$result = $adb->pquery($sql, array($value));
		$first_name = $adb->query_result($result,0,"firstname");
		$last_name = $adb->query_result($result,0,"lastname");

		$parent_name = $last_name.' '.$first_name;
	}
	elseif($parent_module == "Accounts")
	{
		$sql = "select * from vtiger_account where accountid=?";
		$result = $adb->pquery($sql, array($value));
		$account_name = $adb->query_result($result,0,"accountname");

		$parent_name =$account_name;
	}
	elseif($parent_module == "Potentials")
	{
		$sql = "select * from vtiger_potential where potentialid=?";
		$result = $adb->pquery($sql, array($value));
		$potentialname = $adb->query_result($result,0,"potentialname");

		$parent_name =$potentialname;
	}
	return $parent_module ." : ".$parent_name;
}
?>
