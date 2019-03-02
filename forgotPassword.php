<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ********************************************************************************** */

require_once 'includes/main/WebUI.php';
require_once 'include/utils/utils.php';
require_once 'include/utils/VtlibUtils.php';
require_once 'modules/Vtiger/helpers/ShortURL.php';
// require_once 'vtlib/Vtiger/Mailer.php';
//-- Creantis - Henry: para que envíe correo con el link para resetear password
require_once "modules/Emails/mail.php";
require_once "modules/Users/Users.php";

// global $adb;
global $adb, $current_user, $HELPDESK_SUPPORT_EMAIL_ID;
$adb = PearDatabase::getInstance();
$current_user = new Users();
$current_user->id = 1;

if (isset($_REQUEST['username']) && isset($_REQUEST['emailId'])) {
	$username = vtlib_purify($_REQUEST['username']);
	$result = $adb->pquery('select email1 from vtiger_users where user_name= ? ', array($username));
	if ($adb->num_rows($result) > 0) {
		$email = $adb->query_result($result, 0, 'email1');
	}

	if (vtlib_purify($_REQUEST['emailId']) == $email) {
		$time = time();
		$options = array(
			'handler_path' => 'modules/Users/handlers/ForgotPassword.php',
			'handler_class' => 'Users_ForgotPassword_Handler',
			'handler_function' => 'changePassword',
			'handler_data' => array(
				'username' => $username,
				'email' => $email,
				'time' => $time,
				'hash' => md5($username.$time)
			)
		);
		$trackURL = Vtiger_ShortURL_Helper::generateURL($options);
		date_default_timezone_set("America/Lima");
		$date = date("Y-m-d H:i:s");
		date_default_timezone_set("UTC");
		$content = 'Estimado usuario,<br><br> 
						Recientemente solicit&oacute; un restablecimiento de contrase&ntilde;a para su cuenta de VtigerCRM.<br> 
						Para crear una nueva contrase&ntilde;a, haga clic en el enlace <a target="_blank" href='.$trackURL.'>aqu&iacute;</a>. 
						<br><br> 
						Esta solicitud se realiz&oacute; el '.$date.' y expirará en las próximas 24 horas.<br><br> 
						Saludos,<br> 
						Equipo de Soporte VtigerCRM - Creantis.<br>';

		$subject = 'Vtiger CRM: Password Reset';
		// $mail = new Vtiger_Mailer();
		// $mail->IsHTML();
		// $mail->Body = $content;
		// $mail->Subject = $subject;
		// $mail->AddAddress($email);
		// $status = $mail->Send(true);
		//-- Creantis - Henry: para que envíe correo con el link para resetear password
		$result = $adb->pquery("SELECT * FROM vtiger_systems WHERE server_type=?", Array('email'));
		$fromEmail = $adb->query_result($result, 0, 'from_email_field');
		if (empty($fromEmail)) $fromEmail = $HELPDESK_SUPPORT_EMAIL_ID;
		$status = send_mail('Users', $email, 'CRM', $fromEmail, $subject, $content);
		if ($status === 1 || $status === true) {
			header('Location:  index.php?modules=Users&view=Login&mailStatus=success');
		} else {
			header('Location:  index.php?modules=Users&view=Login&error=statusError');
		}
	} else {
		header('Location:  index.php?modules=Users&view=Login&error=fpError');
	}
}
