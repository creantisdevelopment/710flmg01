<?php
/***********************************************************************************************
** The contents of this file are subject to the Vtiger Module-Builder License Version 1.3
 * ( "License" ); You may not use this file except in compliance with the License
 * The Original Code is:  Technokrafts Labs Pvt Ltd
 * The Initial Developer of the Original Code is Technokrafts Labs Pvt Ltd.
 * Portions created by Technokrafts Labs Pvt Ltd are Copyright ( C ) Technokrafts Labs Pvt Ltd.
 * All Rights Reserved.
**
*************************************************************************************************/

include_once 'modules/Vtiger/CRMEntity.php';

class Acciones extends Vtiger_CRMEntity {
	var $table_name = 'vtiger_acciones';
	var $table_index= 'accionesid';

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_accionescf', 'accionesid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'vtiger_acciones', 'vtiger_accionescf');
	
	
	/**
	 * Other Related Tables
	 */
	var $related_tables = Array( 
					'vtiger_accionescf' => Array('accionesid')
					);

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'vtiger_acciones'   => 'accionesid',
	    'vtiger_accionescf' => 'accionesid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Acciones No' => Array('acciones', 'accionesno'),
/*FIELDSTART*/'Accion'=> Array('acciones', 'acciones_tks_titulo'),/*FIELDEND*/
		'Assigned To' => Array('crmentity','smownerid')
	);
	var $list_fields_name = Array (
		/* Format: Field Label => fieldname */
		'Acciones No' => 'accionesno',
/*FIELDSTART*/'Accion'=> 'acciones_tks_titulo',/*FIELDEND*/
		'Assigned To' => 'assigned_user_id'
	);

	// Make the field link to detail view
	var $list_link_field = 'acciones_tks_titulo';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Acciones No' => Array('acciones', 'accionesno'),
/*FIELDSTART*/'Accion'=> Array('acciones', 'acciones_tks_titulo'),/*FIELDEND*/
		'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
	);
	var $search_fields_name = Array (
		/* Format: Field Label => fieldname */
		'Acciones No' => 'accionesno',
/*FIELDSTART*/'Accion'=> 'acciones_tks_titulo',/*FIELDEND*/
		'Assigned To' => 'assigned_user_id',
	);

	// For Popup window record selection
	var $popup_fields = Array ('acciones_tks_titulo');

	// For Alphabetical search
	var $def_basicsearch_col = 'acciones_tks_titulo';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'acciones_tks_titulo';

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('acciones_tks_titulo','assigned_user_id');

	var $default_order_by = 'acciones_tks_titulo';
	var $default_sort_order='ASC';

	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
	function vtlib_handler($moduleName, $eventType) {
		global $adb;
 		if($eventType == 'module.postinstall') {
			// TODO Handle actions after this module is installed.
			Acciones::checkWebServiceEntry();
		} else if($eventType == 'module.disabled') {
			// TODO Handle actions before this module is being uninstalled.
		} else if($eventType == 'module.preuninstall') {
			// TODO Handle actions when this module is about to be deleted.
		} else if($eventType == 'module.preupdate') {
			// TODO Handle actions before this module is updated.
		} else if($eventType == 'module.postupdate') {
			// TODO Handle actions after this module is updated.
			Acciones::checkWebServiceEntry();
		}
 	}
	
	/*
	 * Function to handle module specific operations when saving a entity
	 */
	function save_module($module)
	{
		global $adb;
		$q = 'SELECT '.$this->def_detailview_recname.' FROM '.$this->table_name. ' WHERE ' . $this->table_index. ' = '.$this->id;
		
		$result =  $adb->pquery($q,array());
		$cnt = $adb->num_rows($result);
		if($cnt > 0) 
		{
			$label = $adb->query_result($result,0,$this->def_detailview_recname);
			$q1 = 'UPDATE vtiger_crmentity SET label = \''.$label.'\' WHERE crmid = '.$this->id;
			$adb->pquery($q1,array());
			/**
			* Creantis: Henry
			* 2017-12-18
			* Crea relación con los módulos correspondientes
			*/
			$records = $this->getRelatedRecords();
			// consultar los nombres de los campos relacionales
			$cl = "SELECT a.relmodule, b.fieldid, b.columnname, b.tablename, b.uitype, b.fieldname, b.fieldlabel
				FROM vtiger_fieldmodulerel a
				INNER JOIN vtiger_field b on a.fieldid = b.fieldid
				WHERE a.module = ?";
			$rs = $adb->pquery($cl,array($module));
			while ($row = $adb->fetch_row($rs)) { // recorre los campos relacionales
				if ( !empty($this->column_fields[trim($row['columnname'])]) ) { // que no esté vacío el campo relacional
					foreach ($records as $key => $value) { // recorre los registros actualmente relacionados
						if ( $value['relmodule'] == $this->getModuleIdByRecord($this->column_fields[trim($row['columnname'])]) ) { // el Modulo del que está en DB es igual al que estoy ingresando
							if ( $value['relcrmid'] != $this->column_fields[trim($row['columnname'])] ) { // el ID del registro relacionado es diferente al que estoy ingresando 
								$this->delete_related_module($module, $this->id, $value['relmodule'], $value['relcrmid']);
							}
						}
					}
					$this->save_related_module($module, $this->id, $row['relmodule'], $this->column_fields[trim($row['columnname'])]);
				} else {
					$adb->pquery("DELETE FROM vtiger_crmentityrel WHERE (crmid=? AND module=? AND relmodule=?)", [$this->id, $module, $row['relmodule']]);
				}
			}//FIN Creantis
		}
	}
	/**
	 * Function to check if entry exsist in webservices if not then enter the entry
	 */
	static function checkWebServiceEntry() {
		global $log;
		$log->debug("Entering checkWebServiceEntry() method....");
		global $adb;

		$sql       =  "SELECT count(id) AS cnt FROM vtiger_ws_entity WHERE name = 'Acciones'";
		$result   	= $adb->query($sql);
		if($adb->num_rows($result) > 0)
		{
			$no = $adb->query_result($result, 0, 'cnt');
			if($no == 0)
			{
				$tabid = $adb->getUniqueID("vtiger_ws_entity");
				$ws_entitySql = "INSERT INTO vtiger_ws_entity ( id, name, handler_path, handler_class, ismodule ) VALUES".
						  " (?, 'Acciones','include/Webservices/VtigerModuleOperation.php', 'VtigerModuleOperation' , 1)";
				$res = $adb->pquery($ws_entitySql, array($tabid));
				$log->debug("Entered Record in vtiger WS entity ");	
			}
		}
		$log->debug("Exiting checkWebServiceEntry() method....");					
	}
	/**
	* Creantis: Henry
	* 2017-12-18	
	* Obtiene todos los módulos con los que tiene relación
	* getRelatedModules
	*/
	function getRelatedModules() {
		global $adb;
		$q = "SELECT related_tabid as tabid, c.name  FROM vtiger_relatedlists a 
				INNER JOIN vtiger_tab b ON a.tabid = b.tabid 
				INNER JOIN vtiger_tab c ON a.related_tabid = c.tabid 
				WHERE b.name = ? ORDER BY sequence";
		$rs = $adb->pquery($q, [$this->getModuleName()]);
		$arr = [];
		while ($row = $adb->fetch_row($rs)) {
			$arr[] = $row;
		}
		return $arr;
	}
	/**
	* Creantis: Henry
	* 2017-12-18	
	* Obtiene todos los registros relacionados
	* getRelatedRecords
	*/
	function getRelatedRecords() {
		global $adb;
		$q = "SELECT crmid, module, relcrmid, relmodule FROM vtiger_crmentityrel WHERE module = ? AND crmid = ?";
		$rs = $adb->pquery($q, [$this->moduleName, $this->id]);
		$arr = [];
		while ($row = $adb->fetch_row($rs)) {
			$arr[] = $row;
		}
		return $arr;
	}
	/**
	* Creantis: Henry
	* 2017-12-18	
	* Obtiene el nombre del módulo a tavés de un ID
	* getModuleIdByRecord
	*/
	function getModuleIdByRecord($record_id) {
		global $adb;
		$sqlresult = $adb->pquery("SELECT setype FROM vtiger_crmentity WHERE crmid = ?",array($record_id));
		if($adb->num_rows($sqlresult)) return $adb->query_result($sqlresult, 0, 'setype');
		return null;
	}
}