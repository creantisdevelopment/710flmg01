<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_GetDataTemas_Action extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		global $adb;
		$record = $request->get('record');
		$sourceModule = $request->get('source_module');
		$parent_id = $request->get('parent_id');
		$contact_id = $request->get('contact_id');
		$product_id = $request->get('product_id');
		$accion_selected = $request->get('accion_selected');
		// var_dump($request);die();
		$curso = array();
		$arr_users = array();
		$arr_roles = array();
		// error_reporting(E_ERROR);
		// $adb->setDebug(true);
		if ( !empty($product_id) ) {
			$curso = Vtiger_Record_Model::getInstanceById($product_id, 'Products')->getData();
			// $curso = array_map("decode_html", $curso);
			$rs0 = $adb->pquery("SELECT u.id userid, u.first_name, u.last_name, ur.roleid  
					INNER JOIN vtiger_user2role ur on u.id = ur.userid 
					FROM vtiger_users where id = ?", array($curso['assigned_user_id']));
			$usr = $adb->query_result_rowdata($rs0);
			$arr_users[$usr['userid']] = array_map("decode_html", $usr);
			$arr_roles[$usr['userid']] = $arr_users[0]['roleid'];
		} elseif ( !empty($contact_id) ) {
			$query_seccion = "SELECT vtiger_almsecc.* 
					FROM vtiger_almsecc 
					INNER JOIN vtiger_crmentity on almseccid = crmid and deleted = 0 
					WHERE 
					almsecc_tks_alumno = ? 
					and almsecc_tks_ano = YEAR(CURDATE()) 
					and almsecc_tks_estado = 'Activo' LIMIT 1";
			$rs1 = $adb->pquery($query_seccion, array($contact_id));
			$row_1 = $adb->query_result_rowdata($rs1);
			if ( !empty($row_1) ) {
				$query_curso = "SELECT u.id userid, u.first_name, u.last_name, ur.roleid 
					FROM vtiger_products p 
					INNER JOIN vtiger_crmentity e on p.productid = e.crmid and e.deleted = 0
					INNER JOIN vtiger_productcf cf on p.productid = cf.productid
					INNER JOIN vtiger_users u on e.smownerid = u.id
					INNER JOIN vtiger_user2role ur on u.id = ur.userid
					WHERE 
					p.productcategory = ? 
					and cf.cf_874 = ? 
					and cf.cf_876 = ? 
					and cf.cf_880 = YEAR(CURDATE()) 
					and p.discontinued = 1";
				$rs2 = $adb->pquery($query_curso, array( $row_1['almsecc_tks_nivel'], $row_1['almsecc_tks_grado'], $row_1['almsecc_tks_seccion'] ));
				while ($row = $adb->fetch_row($rs2)) {
					$arr_users[$row['userid']] = array_map("decode_html", $row);
					$arr_roles[$row['userid']] = $row['roleid'];
				}
			}
		}
		// var_dump($arr_users);
		// var_dump($arr_roles);
		$response = new Vtiger_Response();

		$tema = Vtiger_Record_Model::getInstanceById($record, $sourceModule)->getData();
		$tema = array_map("decode_html", $tema);

		$query = "SELECT accionesid, acciones_tks_accion, acciones_tks_rolresponsable, acciones_tks_titulo FROM vtiger_acciones where acciones_tks_tema = ?";
		$rs = $adb->pquery($query, array($tema['id']));

		$acciones = array();
		while ($row = $adb->fetch_row($rs)) {
			$row = array_map("decode_html", $row);
			$roleid = explode("-", $row['acciones_tks_rolresponsable'])[0];
			$user =  array();
			$user_id = array_search($roleid, $arr_roles);
			// echo "[[$user_id]]";
			// var_dump($arr_users[$user_id]);
			$row['user_accion'] = $arr_users[$user_id];
			$acciones[] = $row;
		}
		// var_dump($acciones);
		// die();
		$tema['acciones'] = $acciones;
		$response->setResult(array('success'=>true, 'data'=>$tema));
		$response->emit();
	}
}
