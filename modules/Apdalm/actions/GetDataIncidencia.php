<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Apdalm_GetDataIncidencia_Action extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		$record = $request->get('record');
		$sourceModule = $request->get('source_module');
		$response = new Vtiger_Response();

		$permitted = Users_Privileges_Model::isPermitted($sourceModule, 'DetailView', $record);
		if($permitted) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $sourceModule);
			$data = $recordModel->getData();

			$alumno_id = $data['apdalm_tks_alumno'];
			$data_alumno_seccion = array();
			if ( !empty($alumno_id) && intval($alumno_id) != 0 ) {
				$alm = Vtiger_Record_Model::getInstanceById($alumno_id, 'Contacts')->getData();
				$data_alumno_seccion = $this->getAlumnoSeccion($alumno_id);
				if (!empty($data_alumno_seccion)) {
					$data_alumno_seccion['fullname'] = $alm['firstname']." ".$alm['lastname'];
					$data_alumno_seccion = array_map("decode_html", $data_alumno_seccion);
				}
			}

			$apoderado_id = $data['apdalm_tks_apoderado'];
			$data_apoderado = array();
			if ( !empty($apoderado_id) && intval($apoderado_id) != 0 ) {
				$record_apoderado = Vtiger_Record_Model::getInstanceById($apoderado_id, 'Accounts');
				$data_apoderado = $record_apoderado->getData();
				$data_apoderado = array_map("decode_html", $data_apoderado);
			}

			$response->setResult(array('success'=>true, 'data'=> array("alumno_seccion" => $data_alumno_seccion, "apoderado" => $data_apoderado) ));

		} else {
			$response->setResult(array('success'=>false, 'message'=>vtranslate('LBL_PERMISSION_DENIED')));
		}
		$response->emit();
	}

	public function getAlumnoSeccion($alumno_id) {
		global $adb;
		$anio_actual = date("Y");
		// $adb->setDebug(true);
		$rs = $adb->pquery("SELECT almseccid FROM vtiger_almsecc INNER JOIN vtiger_crmentity ON almseccid = crmid AND deleted = 0 WHERE almsecc_tks_alumno = ? AND almsecc_tks_ano = ? AND almsecc_tks_estado = 'Activo' LIMIT 1", array($alumno_id, $anio_actual));
		$almseccid = $adb->query_result($rs, 0, 'almseccid');
		// die();
		if ( !empty($almseccid) ) {
			return Vtiger_Record_Model::getInstanceById($almseccid, 'Almsecc')->getData();
		}
		return array();
	}


}
