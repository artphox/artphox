<?php /* Smarty version Smarty-3.1.11, created on 2014-06-03 17:17:40
         compiled from "C:\xampp\htdocs\GitHub\artphox\coresystem\system\tpl\core.defaulterrorsite.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26056538de71458aba0-19636714%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aad0631f41ea5ff72706d9aed76e039ffa84b04b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\GitHub\\artphox\\coresystem\\system\\tpl\\core.defaulterrorsite.tpl',
      1 => 1401806136,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26056538de71458aba0-19636714',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_538de7145bd831_52779258',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538de7145bd831_52779258')) {function content_538de7145bd831_52779258($_smarty_tpl) {?><!DOCTYPE html>
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