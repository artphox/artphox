<?php /* Smarty version Smarty-3.1.11, created on 2014-06-02 18:49:51
         compiled from "C:\xampp\htdocs\apx\core03\system\tpl\core.defaulterrorsite.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15370538cab2fc68a25-22232161%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '15370538cab2fc68a25-22232161',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_538cab2fcc6631_56556979',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538cab2fcc6631_56556979')) {function content_538cab2fcc6631_56556979($_smarty_tpl) {?><!DOCTYPE html>
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