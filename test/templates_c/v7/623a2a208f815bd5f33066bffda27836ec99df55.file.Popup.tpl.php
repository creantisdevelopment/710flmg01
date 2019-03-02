<?php /* Smarty version Smarty-3.1.7, created on 2019-02-25 18:28:27
         compiled from "/var/www/html/710fleming01/includes/runtime/../../layouts/v7/modules/Products/Popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3570119235c7433cb5952f4-17161153%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '623a2a208f815bd5f33066bffda27836ec99df55' => 
    array (
      0 => '/var/www/html/710fleming01/includes/runtime/../../layouts/v7/modules/Products/Popup.tpl',
      1 => 1551113882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3570119235c7433cb5952f4-17161153',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'SOURCE_MODULE' => 0,
    'PARENT_MODULE' => 0,
    'SOURCE_RECORD' => 0,
    'SOURCE_FIELD' => 0,
    'GETURL' => 0,
    'MULTI_SELECT' => 0,
    'CURRENCY_ID' => 0,
    'RELATED_PARENT_MODULE' => 0,
    'RELATED_PARENT_ID' => 0,
    'VIEW' => 0,
    'RELATION_ID' => 0,
    'APODERADO_ID' => 0,
    'ALUMNO_ID' => 0,
    'ALUMNO_NIVEL' => 0,
    'ALUMNO_GRADO' => 0,
    'ALUMNO_SECCION' => 0,
    'ALUMNO_ANIO' => 0,
    'POPUP_CLASS_NAME' => 0,
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c7433cb7fe7c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c7433cb7fe7c')) {function content_5c7433cb7fe7c($_smarty_tpl) {?>


<div class="modal-dialog modal-lg"><div class="modal-content"><?php ob_start();?><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("ModalHeader.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('TITLE'=>$_tmp1), 0);?>
<div class="modal-body"><div id="popupPageContainer" class="contentsDiv col-sm-12"><input type="hidden" id="parentModule" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_MODULE']->value;?>
"/><input type="hidden" id="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
"/><input type="hidden" id="parent" value="<?php echo $_smarty_tpl->tpl_vars['PARENT_MODULE']->value;?>
"/><input type="hidden" id="sourceRecord" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_RECORD']->value;?>
"/><input type="hidden" id="sourceField" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_FIELD']->value;?>
"/><input type="hidden" id="url" value="<?php echo $_smarty_tpl->tpl_vars['GETURL']->value;?>
" /><input type="hidden" id="multi_select" value="<?php echo $_smarty_tpl->tpl_vars['MULTI_SELECT']->value;?>
" /><input type="hidden" id="currencyId" value="<?php echo $_smarty_tpl->tpl_vars['CURRENCY_ID']->value;?>
" /><input type="hidden" id="relatedParentModule" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_PARENT_MODULE']->value;?>
"/><input type="hidden" id="relatedParentId" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_PARENT_ID']->value;?>
"/><input type="hidden" id="view" name="view" value="<?php echo $_smarty_tpl->tpl_vars['VIEW']->value;?>
"/><input type="hidden" id="relationId" value="<?php echo $_smarty_tpl->tpl_vars['RELATION_ID']->value;?>
" /><input type="hidden" id="selectedIds" name="selectedIds"><!-- util cuando se busca un curso desde incidencias --><input type="hidden" id="apoderado_id" value="<?php echo $_smarty_tpl->tpl_vars['APODERADO_ID']->value;?>
"><input type="hidden" id="alumno_id" value="<?php echo $_smarty_tpl->tpl_vars['ALUMNO_ID']->value;?>
"><input type="hidden" id="alumno_nivel" value="<?php echo $_smarty_tpl->tpl_vars['ALUMNO_NIVEL']->value;?>
"><input type="hidden" id="alumno_grado" value="<?php echo $_smarty_tpl->tpl_vars['ALUMNO_GRADO']->value;?>
"><input type="hidden" id="alumno_seccion" value="<?php echo $_smarty_tpl->tpl_vars['ALUMNO_SECCION']->value;?>
"><input type="hidden" id="alumno_anio" value="<?php echo $_smarty_tpl->tpl_vars['ALUMNO_ANIO']->value;?>
"><?php if (!empty($_smarty_tpl->tpl_vars['POPUP_CLASS_NAME']->value)){?><input type="hidden" id="popUpClassName" value="<?php echo $_smarty_tpl->tpl_vars['POPUP_CLASS_NAME']->value;?>
"/><?php }?><div id="popupContents" class=""><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('PopupContents.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><input type="hidden" class="triggerEventName" value="<?php echo $_REQUEST['triggerEventName'];?>
"/></div></div></div></div><?php }} ?>