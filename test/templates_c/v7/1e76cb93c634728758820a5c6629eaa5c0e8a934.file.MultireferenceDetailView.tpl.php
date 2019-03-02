<?php /* Smarty version Smarty-3.1.7, created on 2019-02-22 22:36:54
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Events\uitypes\MultireferenceDetailView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:231435c707986110383-71021200%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e76cb93c634728758820a5c6629eaa5c0e8a934' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Events\\uitypes\\MultireferenceDetailView.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '231435c707986110383-71021200',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RELATED_CONTACTS' => 0,
    'CONTACT_INFO' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c70798615eec',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c70798615eec')) {function content_5c70798615eec($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['CONTACT_INFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['CONTACT_INFO']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_CONTACTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['CONTACT_INFO']->key => $_smarty_tpl->tpl_vars['CONTACT_INFO']->value){
$_smarty_tpl->tpl_vars['CONTACT_INFO']->_loop = true;
?><a href='<?php echo $_smarty_tpl->tpl_vars['CONTACT_INFO']->value['_model']->getDetailViewUrl();?>
' title='<?php echo vtranslate("Contacts","Contacts");?>
'> <?php echo Vtiger_Util_Helper::getRecordName($_smarty_tpl->tpl_vars['CONTACT_INFO']->value['id']);?>
</a><br><?php } ?><?php }} ?>