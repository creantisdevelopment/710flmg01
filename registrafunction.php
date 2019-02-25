<?php
require_once 'include/utils/utils.php';
require 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
$emm = new vtentitymethodmanager($adb);

die(var_dump("AQUI HAY UN DIE :)"));


// $emm->addentitymethod("HelpDesk", "Vincular Evento", "workflows/HelpDesk/vincularEventoAIncidencia.inc", "vincularEventoAIncidencia");
echo 'HelpDesk <br>';
echo 'Agregado!!';
?>