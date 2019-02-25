<?php
function vincularEventoAIncidencia($entity) {
	global $adb, $current_user;
	$data = $entity->data;
	// var_dump($data);
	$tickectid = explode("x", $data['id'])[1];
	$activityid = '';
	if ( !empty($data['cf_898']) ) {
		$activityid = explode("x", $data['cf_898'])[1];
		$obj = Vtiger_Record_Model::getInstanceById($activityid, 'Calendar');
		$acti = $obj->getData();
		$obj->set("mode","edit");
		$obj->set("parent_id", $tickectid);
		$obj->set("eventstatus", 'Planned'); // Cambia el evento a Planeado
		$obj->set("sendnotification", '1'); // Enviar notificación
		$obj->set("reminder_time", '30'); // Recordatorio 30min antes (Para el profesor)
		$obj->set("cf_902", '120'); // Recordatorio 2horas antes (Para el apoderado)
		//-- para el recordatorio a los apoderados he creado un servicios que se ejecuta con el cron llamado SendReminderApoderados.service, allí mismo se programa cada 2 horas
		$obj->save();
		// var_dump($obj->get("parent_id"));
		// var_dump($obj);
	}
	// die();

}