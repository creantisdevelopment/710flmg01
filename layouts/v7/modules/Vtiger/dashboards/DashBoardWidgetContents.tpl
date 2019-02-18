{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
    {if count($DATA) gt 0 }
        <input class="widgetData" type=hidden value='{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($DATA))}' />
        <input class="yAxisFieldType" type="hidden" value="{$YAXIS_FIELD_TYPE}" />
        <div style="margin:0px 10px;">
            <div>
                {*Henry - Para alto de grafico, solo la primera vez que se carga el widget, original margin: 0 auto; *}
                {assign 'except' ["Funnel Amount", "Total Revenue"]}
                <div class="widgetChartContainer" name='chartcontent' data-type='{$WIDGET->get("linklabel")}' style="height:220px;min-width:300px; {if !$WIDGET->get('linklabel')|in_array:$except} width: 87%; {/if} margin: 0;"></div>
                <br>
            </div>
        </div>
    {else}
        <span class="noDataMsg">
            {vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
        </span>
    {/if}
{/strip}