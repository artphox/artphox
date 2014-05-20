<?php /* Smarty version Smarty-3.1.11, created on 2014-04-13 13:30:34
         compiled from "C:\xampp\htdocs\apx\core03\system\tpl\core.defaulterrorsite.tpl" */ ?>
<?php /*%%SmartyHeaderCode:34955347ba4cf21c86-91239086%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '394dbfe6d6ed26ce39fbb81fcb2858bbb659c76f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\apx\\core03\\system\\tpl\\core.defaulterrorsite.tpl',
      1 => 1397299635,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34955347ba4cf21c86-91239086',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5347ba4cf21c87_68075319',
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5347ba4cf21c87_68075319')) {function content_5347ba4cf21c87_68075319($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<title>Error</title>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="generator" content="Artphox">
		<style>
			.error {
				color: red;
				background-color: #ffeeee;
				margin: 50px auto;
				max-width: 500px;
				text-align: center;
				padding: 20px;
				border: 2px dotted red;
			}
		</style>

	</head>
	<body>

		<section class="error">
			&lt;Artphox&gt;<br><br>
			<p><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
		</section>

	</body>
</html><?php }} ?>