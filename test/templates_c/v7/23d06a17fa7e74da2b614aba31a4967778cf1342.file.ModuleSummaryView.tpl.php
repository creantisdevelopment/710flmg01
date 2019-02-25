<?php /* Smarty version Smarty-3.1.7, created on 2019-02-22 17:41:33
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\HelpDesk\ModuleSummaryView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:128165c70344df052c7-33420683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23d06a17fa7e74da2b614aba31a4967778cf1342' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\HelpDesk\\ModuleSummaryView.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128165c70344df052c7-33420683',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c70344df173e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c70344df173e')) {function content_5c70344df173e($_smarty_tpl) {?>
<div class="recordDetails"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewContents.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }} ?>