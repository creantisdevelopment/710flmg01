<?php /* Smarty version Smarty-3.1.7, created on 2019-02-20 16:08:11
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Accounts\DetailViewSummaryContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:252935c6d7b6bf17920-18156544%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a74c6304c3cca8e34e171a3fa655e6b9521dd0b0' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Accounts\\DetailViewSummaryContents.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '252935c6d7b6bf17920-18156544',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c6d7b6c01595',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c6d7b6c01595')) {function content_5c6d7b6c01595($_smarty_tpl) {?>

<form id="detailView" class="clearfix" method="POST" style="position: relative"><div class="col-lg-12 resizable-summary-view"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewWidgets.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></form><?php }} ?>