<?php /* Smarty version Smarty-3.1.7, created on 2019-02-22 17:45:23
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Calendar\partials\SidebarHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:216765c7035335cbcc1-29910636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd8b8321b95433da29ad501f3ef024b7eb8ff66c' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Calendar\\partials\\SidebarHeader.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '216765c7035335cbcc1-29910636',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SELECTED_MENU_CATEGORY' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c7035335f324',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c7035335f324')) {function content_5c7035335f324($_smarty_tpl) {?>

<?php $_smarty_tpl->tpl_vars['APP_IMAGE_MAP'] = new Smarty_variable(Vtiger_MenuStructure_Model::getAppIcons(), null, 0);?>
<div class="col-sm-12 col-xs-12 app-indicator-icon-container app-<?php echo $_smarty_tpl->tpl_vars['SELECTED_MENU_CATEGORY']->value;?>
">
	<div class="row" title="<?php echo strtoupper(vtranslate("LBL_CALENDAR",$_smarty_tpl->tpl_vars['MODULE']->value));?>
">
		<span class="app-indicator-icon fa fa-calendar"></span>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("modules/Vtiger/partials/SidebarAppMenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>