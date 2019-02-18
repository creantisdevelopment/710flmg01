<?php /* Smarty version Smarty-3.1.7, created on 2019-02-18 22:40:04
         compiled from "C:\wamp\www\710fleming01\includes\runtime/../../layouts/v7\modules\Vtiger\Footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13145c6b3444520035-44445912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0e768ddbef794a5c7404ef66fe919370e8b4099' => 
    array (
      0 => 'C:\\wamp\\www\\710fleming01\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\Footer.tpl',
      1 => 1548189820,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13145c6b3444520035-44445912',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LANGUAGE_STRINGS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5c6b34445874a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5c6b34445874a')) {function content_5c6b34445874a($_smarty_tpl) {?>

<footer class="app-footer">
	<p>
		VtigerCRM&nbsp;© - Creantis&nbsp;&nbsp;© <?php echo date('Y');?>
&nbsp;&nbsp;
		<a href="//www.creantis.com" target="_blank">Creantis Website</a>&nbsp;|&nbsp;
		<a href="https://www.facebook.com/creantis.pe" target="_blank">Creantis FB</a>
	</p>
</footer>
</div>
<div id='overlayPage'>
	<!-- arrow is added to point arrow to the clicked element (Ex:- TaskManagement), 
	any one can use this by adding "show" class to it -->
	<div class='arrow'></div>
	<div class='data'>
	</div>
</div>
<div id='helpPageOverlay'></div>
<div id="js_strings" class="hide noprint"><?php echo Zend_Json::encode($_smarty_tpl->tpl_vars['LANGUAGE_STRINGS']->value);?>
</div>
<div class="modal myModal fade"></div>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('JSResources.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>

</html><?php }} ?>