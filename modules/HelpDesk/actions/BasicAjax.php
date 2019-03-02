<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class HelpDesk_BasicAjax_Action extends Vtiger_Action_Controller {

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		$searchValue = $request->get('search_value');
		$searchModule = $request->get('search_module');

		$parentRecordId = $request->get('parent_id');
		$parentModuleName = $request->get('parent_module');
		$relatedModule = $request->get('module');

		//-Henry------------- para buscar cursos desde incidencias para citas =...........................
		$alumno_seccion = $request->get("alumno_seccion");
		if ( !empty($alumno_seccion) ) {
			$records = $this->searchRecord_custom($searchValue, $request, $parentRecordId, $parentModuleName, $relatedModule);
		} else {
			$searchModuleModel = Vtiger_Module_Model::getInstance($searchModule);
			$records = $searchModuleModel->searchRecord($searchValue, $parentRecordId, $parentModuleName, $relatedModule);
		}

		$baseRecordId = $request->get('base_record');
		$result = array();
		foreach($records as $moduleName=>$recordModels) {
			foreach($recordModels as $recordModel) {
				if ($recordModel->getId() != $baseRecordId) {
					$result[] = array('label'=>decode_html($recordModel->getName()), 'value'=>decode_html($recordModel->getName()), 'id'=>$recordModel->getId());
				}
			}
		}

		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}

	//---- se usa solo para buscar productos cuando viene desde el form de incidencias

	public function getSearchRecordsQuery_custom($searchValue,$searchFields, $request, $parentId=false, $parentModule=false) {
		//--Henry: para buscar productos desde incidencias
		//-- solo cuando src_module = 'HelpDesk'
		$apoderado_id = $request->get("apoderado_id");
		$alumno_id = $request->get("alumno_id");
		$alumno_nivel = $request->get("alumno_nivel");
		$alumno_grado = $request->get("alumno_grado");
		$alumno_seccion = $request->get("alumno_seccion");
		$alumno_anio = $request->get("alumno_anio");
		//-------------------
		$where = '';
		if ( !empty($alumno_seccion) ) {
			$where .= " AND productcategory IN ('".$alumno_nivel."','Todos') "; // nivel
			$where .= " AND cf_874 IN ('".$alumno_grado."', 'Todos') "; // grado
			$where .= " AND cf_876 IN ('".$alumno_seccion."', 'Todos') "; // seccion
			$where .= " AND cf_880 IN ('".$alumno_anio."', 'Todos') "; // año
			$where .= " AND ( (discontinued = '1' AND start_date <= CURDATE())"; // profesor activo y fecha de activación menor igual a actualidad
			$where .= " OR (discontinued = '0' AND expiry_date >= CURDATE()) )"; // profesor inactivo y fecha de inactivación sea mayor a la actual
		// echo $listQuery;die();
		}
		$fields = implode(',',$searchFields);
		$query = "SELECT $fields FROM vtiger_crmentity e 
				INNER JOIN vtiger_products p on e.crmid = p.productid 
				INNER JOIN vtiger_productcf cf on cf.productid = p.productid 
				WHERE label LIKE '%$searchValue%' AND e.deleted = 0 $where";
		return $query;
	}

	/**
	 * Function searches the records in the module, if parentId & parentModule
	 * is given then searches only those records related to them.
	 * @param <String> $searchValue - Search value
	 * @param <Integer> $parentId - parent recordId
	 * @param <String> $parentModule - parent module name
	 * @return <Array of Vtiger_Record_Model>
	 */
	public function searchRecord_custom($searchValue, $request, $parentId=false, $parentModule=false, $relatedModule=false) {
		$searchFields = array('crmid','label','setype');
		$db = PearDatabase::getInstance();
		// $db->setDebug(true);
		$result = $db->pquery($this->getSearchRecordsQuery_custom($searchValue,$searchFields, $request, $parentId, $parentModule), array());
		$noOfRows = $db->num_rows($result);

		// echo $noOfRows ;die();
		$moduleModels = array();
		$matchingRecords = array();
		for($i=0; $i<$noOfRows; ++$i) {
			$row = $db->query_result_rowdata($result, $i);
			if(Users_Privileges_Model::isPermitted($row['setype'], 'DetailView', $row['crmid'])){
				$row['id'] = $row['crmid'];
				$moduleName = $row['setype'];
				if(!array_key_exists($moduleName, $moduleModels)) {
					$moduleModels[$moduleName] = Vtiger_Module_Model::getInstance($moduleName);
				}
				$moduleModel = $moduleModels[$moduleName];
				$modelClassName = Vtiger_Loader::getComponentClassName('Model', 'Record', $moduleName);
				$recordInstance = new $modelClassName();
				$matchingRecords[$moduleName][$row['id']] = $recordInstance->setData($row)->setModuleFromInstance($moduleModel);
			}
		}
		
		return $matchingRecords;
	}
}
