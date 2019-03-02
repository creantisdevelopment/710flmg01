<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_GetRoles_Action extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		global $adb;
		// $record = $request->get('record');
		$sourceModule = $request->get('source_module');
		$response = new Vtiger_Response();

		$query = "SELECT roleid, rolename FROM vtiger_role WHERE roleid != 'H1'";
		$rs = $adb->pquery($query);

		$arr = array();
		while ($row = $adb->fetch_row($rs)) {
			$arr[] = array_map("decode_html", $row);
		}
		$response->setResult(array('success'=>true, 'data'=>$arr));
		$response->emit();
	}
}
