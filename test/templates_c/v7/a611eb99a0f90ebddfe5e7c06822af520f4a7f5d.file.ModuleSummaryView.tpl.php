<?php /* Smarty version Smarty-3.1.7, created on 2019-02-25 18:35:09
         compiled from "/var/www/html/710fleming01/includes/runtime/../../layouts/v7/modules/HelpDesk/ModuleSummaryView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11470646105c74355df18a58-73315101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a611eb99a0f90ebddfe5e7c06822af520f4a7f5d' => 
    array (
      0 => '/var/www/html/710fleming01/includes/runtime/../../layouts/v7/modules/HelpDesk/ModuleSummaryView.tpl',
      1 => 1551113882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11470646105c74355df18a58-73315101',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c74355df290f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c74355df290f')) {function content_5c74355df290f($_smarty_tpl) {?>
<div class="recordDetails"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewContents.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }} ?>