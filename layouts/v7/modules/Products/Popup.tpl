{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************}
{* modules/Vtiger/views/Popup.php *}

{strip}
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE={vtranslate($MODULE,$MODULE)}}
        <div class="modal-body">
            <div id="popupPageContainer" class="contentsDiv col-sm-12">
                <input type="hidden" id="parentModule" value="{$SOURCE_MODULE}"/>
                <input type="hidden" id="module" value="{$MODULE}"/>
                <input type="hidden" id="parent" value="{$PARENT_MODULE}"/>
                <input type="hidden" id="sourceRecord" value="{$SOURCE_RECORD}"/>
                <input type="hidden" id="sourceField" value="{$SOURCE_FIELD}"/>
                <input type="hidden" id="url" value="{$GETURL}" />
                <input type="hidden" id="multi_select" value="{$MULTI_SELECT}" />
                <input type="hidden" id="currencyId" value="{$CURRENCY_ID}" />
                <input type="hidden" id="relatedParentModule" value="{$RELATED_PARENT_MODULE}"/>
                <input type="hidden" id="relatedParentId" value="{$RELATED_PARENT_ID}"/>
                <input type="hidden" id="view" name="view" value="{$VIEW}"/>
                <input type="hidden" id="relationId" value="{$RELATION_ID}" />
                <input type="hidden" id="selectedIds" name="selectedIds">
                <!-- util cuando se busca un curso desde incidencias -->
                <input type="hidden" id="apoderado_id" value="{$APODERADO_ID}">
                <input type="hidden" id="alumno_id" value="{$ALUMNO_ID}">
                <input type="hidden" id="alumno_nivel" value="{$ALUMNO_NIVEL}">
                <input type="hidden" id="alumno_grado" value="{$ALUMNO_GRADO}">
                <input type="hidden" id="alumno_seccion" value="{$ALUMNO_SECCION}">
                <input type="hidden" id="alumno_anio" value="{$ALUMNO_ANIO}">
                {if !empty($POPUP_CLASS_NAME)}
                    <input type="hidden" id="popUpClassName" value="{$POPUP_CLASS_NAME}"/>
                {/if}
                <div id="popupContents" class="">
                    {include file='PopupContents.tpl'|vtemplate_path:$MODULE_NAME}
                </div>
                <input type="hidden" class="triggerEventName" value="{$smarty.request.triggerEventName}"/>
            </div>
        </div>
    </div>
</div>
{/strip}