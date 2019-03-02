<?php /* Smarty version Smarty-3.1.7, created on 2019-02-20 16:09:00
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Contacts\ModuleSummaryView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:230675c6d7b9ce57d29-86763795%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24d3cce5a454397fcb8594f81cadc3fde27fbd8f' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Contacts\\ModuleSummaryView.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '230675c6d7b9ce57d29-86763795',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c6d7b9ce7bb2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c6d7b9ce7bb2')) {function content_5c6d7b9ce7bb2($_smarty_tpl) {?>

<div class="recordDetails"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewContents.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }} ?>