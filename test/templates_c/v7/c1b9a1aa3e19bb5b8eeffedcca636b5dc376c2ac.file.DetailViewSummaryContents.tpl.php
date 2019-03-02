<?php /* Smarty version Smarty-3.1.7, created on 2019-02-25 18:35:10
         compiled from "/var/www/html/710fleming01/includes/runtime/../../layouts/v7/modules/HelpDesk/DetailViewSummaryContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15780376895c74355e16e7a0-70821547%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1b9a1aa3e19bb5b8eeffedcca636b5dc376c2ac' => 
    array (
      0 => '/var/www/html/710fleming01/includes/runtime/../../layouts/v7/modules/HelpDesk/DetailViewSummaryContents.tpl',
      1 => 1551113882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15780376895c74355e16e7a0-70821547',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c74355e17d21',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c74355e17d21')) {function content_5c74355e17d21($_smarty_tpl) {?>
<form id="detailView" method="POST"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewWidgets.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form><?php }} ?>