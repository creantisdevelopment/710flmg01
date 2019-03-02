<?php /* Smarty version Smarty-3.1.7, created on 2019-02-22 17:41:34
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\HelpDesk\DetailViewSummaryContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:248415c70344e0bef14-92564943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3829272968c65648feb38fe6b7d107f45105e1d2' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\HelpDesk\\DetailViewSummaryContents.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '248415c70344e0bef14-92564943',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c70344e0d181',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c70344e0d181')) {function content_5c70344e0d181($_smarty_tpl) {?>
<form id="detailView" method="POST"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewWidgets.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form><?php }} ?>