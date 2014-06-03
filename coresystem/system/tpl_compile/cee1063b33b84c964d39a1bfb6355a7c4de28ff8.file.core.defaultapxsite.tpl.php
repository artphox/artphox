<?php /* Smarty version Smarty-3.1.11, created on 2014-06-03 16:36:34
         compiled from "C:\xampp\htdocs\GitHub\artphox\coresystem\system\tpl\core.defaultapxsite.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11266538ddd72b24387-20461161%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cee1063b33b84c964d39a1bfb6355a7c4de28ff8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\GitHub\\artphox\\coresystem\\system\\tpl\\core.defaultapxsite.tpl',
      1 => 1401806136,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11266538ddd72b24387-20461161',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'das_completetitle' => 0,
    'das_baseurl' => 0,
    'das_styleobjid' => 0,
    'das_styletimestamp' => 0,
    'das_adaption' => 0,
    'das_slug' => 0,
    'das_sitetitle' => 0,
    'das_headcode' => 0,
    'das_bodycode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_538ddd72bd7eb5_21159454',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538ddd72bd7eb5_21159454')) {function content_538ddd72bd7eb5_21159454($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['das_completetitle']->value;?>
</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="generator" content="Artphox">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
	<![endif]-->
	<!--URLA-Scripts-->
	<base href="<?php echo $_smarty_tpl->tpl_vars['das_baseurl']->value;?>
">
	<link href="styles/<?php echo $_smarty_tpl->tpl_vars['das_styleobjid']->value;?>
.css?<?php echo $_smarty_tpl->tpl_vars['das_styletimestamp']->value;?>
" rel="stylesheet" type="text/css">
	<script src="js/jquery.min.js"></script>
	<?php if ($_smarty_tpl->tpl_vars['das_adaption']->value==true){?>
	<script src="js/adaption.js"></script>
	<script>
		//Adaption starten!
		adaption.init('<?php echo $_smarty_tpl->tpl_vars['das_slug']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['das_sitetitle']->value;?>
', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['apx_configdata'][0][0]->apxConfigData(array('name'=>"DAS_TITLE_PATTERN_NORMAL"),$_smarty_tpl);?>
', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['apx_configdata'][0][0]->apxConfigData(array('name'=>"DAS_TITLE_PATTERN_ERROR"),$_smarty_tpl);?>
', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['apx_configdata'][0][0]->apxConfigData(array('name'=>"ADAPTION_FADE_DURATION"),$_smarty_tpl);?>
', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['apx_configdata'][0][0]->apxConfigData(array('name'=>"ADAPTION_FADE_EASING"),$_smarty_tpl);?>
');
	</script>
	<?php }?>

	<?php echo $_smarty_tpl->tpl_vars['das_headcode']->value;?>

</head>
<body>
	<?php echo $_smarty_tpl->tpl_vars['das_bodycode']->value;?>

</body>
</html><?php }} ?>