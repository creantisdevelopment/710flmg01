<?php /* Smarty version Smarty-3.1.7, created on 2019-02-20 22:30:58
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Vtiger\OperationNotPermitted.tpl" */ ?>
<?php /*%%SmartyHeaderCode:101545c6dd522bd4031-11952152%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05be30281b992e2efb49caedcf9614741aa21f14' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\OperationNotPermitted.tpl',
      1 => 1548189060,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101545c6dd522bd4031-11952152',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MESSAGE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c6dd522d1fe6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c6dd522d1fe6')) {function content_5c6dd522d1fe6($_smarty_tpl) {?>
<div style="margin:0 auto;width: 50em;">
	<table border='0' cellpadding='5' cellspacing='0' height='600px' width="700px">
	<tr><td align='center'>
		<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 80%; position: relative; z-index: 100000020;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tr>
			<td rowspan='2' width='11%'><img src="<?php echo vimage_path('denied.gif');?>
" ></td>
			<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
				<span class='genHeaderSmall'><?php echo vtranslate($_smarty_tpl->tpl_vars['MESSAGE']->value);?>
</span></td>
		</tr>
		<tr>
			<td class='small' align='right' nowrap='nowrap'>
				<a href='javascript:window.history.back();'><?php echo vtranslate('LBL_GO_BACK');?>
</a><br>
			</td>
		</tr>
		</table>
		</div>
	</td></tr>
	</table>
</div><?php }} ?>