<?php /* Smarty version Smarty-3.1.7, created on 2019-02-21 17:43:15
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Vtiger\RedirectToEditView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:316545c6ee3331981c2-94985291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6818e79bce0e75a9cb0fdea3a3b443970b429d5e' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\RedirectToEditView.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '316545c6ee3331981c2-94985291',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'REQUEST_URL' => 0,
    'REQUEST_DATA' => 0,
    'FIELD_NAME' => 0,
    'FIELD_VALUE' => 0,
    'VALUE' => 0,
    'KEY' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c6ee33328bed',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c6ee33328bed')) {function content_5c6ee33328bed($_smarty_tpl) {?>

<form id="redirectForm" method="post" action="<?php echo $_smarty_tpl->tpl_vars['REQUEST_URL']->value;?>
" enctype="multipart/form-data"><?php  $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['REQUEST_DATA']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_VALUE']->key => $_smarty_tpl->tpl_vars['FIELD_VALUE']->value){
$_smarty_tpl->tpl_vars['FIELD_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME']->value = $_smarty_tpl->tpl_vars['FIELD_VALUE']->key;
?><?php if ($_smarty_tpl->tpl_vars['FIELD_NAME']->value=='returnrelatedModule'){?><?php $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_variable('returnrelatedModuleName', null, 0);?><?php }?><?php if (is_array($_smarty_tpl->tpl_vars['FIELD_VALUE']->value)){?><?php  $_smarty_tpl->tpl_vars['VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['KEY'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['FIELD_VALUE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['VALUE']->key => $_smarty_tpl->tpl_vars['VALUE']->value){
$_smarty_tpl->tpl_vars['VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['KEY']->value = $_smarty_tpl->tpl_vars['VALUE']->key;
?><?php if (is_array($_smarty_tpl->tpl_vars['VALUE']->value)){?><?php $_smarty_tpl->tpl_vars['VALUE'] = new Smarty_variable(Zend_Json::encode($_smarty_tpl->tpl_vars['VALUE']->value), null, 0);?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['KEY']->value;?>
]" value='<?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
'><?php }else{ ?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['KEY']->value;?>
]" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['VALUE']->value);?>
"><?php }?><?php } ?><?php }elseif($_smarty_tpl->tpl_vars['FIELD_NAME']->value=='notecontent'){?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" value='<?php echo decode_html($_smarty_tpl->tpl_vars['FIELD_VALUE']->value);?>
' ><?php }else{ ?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['FIELD_VALUE']->value);?>
"><?php }?><?php } ?></form>
		<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#redirectForm').submit();
			});
		</script>
	<?php }} ?>