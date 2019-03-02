<?php /* Smarty version Smarty-3.1.7, created on 2019-02-20 16:09:01
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Contacts\DetailViewSummaryContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:188335c6d7b9d013d39-46598482%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a08ec60a055a5379e9dfcc49dbe71af282df2d9c' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Contacts\\DetailViewSummaryContents.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188335c6d7b9d013d39-46598482',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c6d7b9d0509d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c6d7b9d0509d')) {function content_5c6d7b9d0509d($_smarty_tpl) {?>

<form id="detailView" class="clearfix" method="POST" style="position: relative"><div class="col-lg-12 resizable-summary-view"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewWidgets.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></form><?php }} ?>