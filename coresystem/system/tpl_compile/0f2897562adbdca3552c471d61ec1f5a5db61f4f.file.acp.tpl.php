<?php /* Smarty version Smarty-3.1.11, created on 2014-05-05 15:31:54
         compiled from "C:\xampp\htdocs\apx\core03\system\tpl\admin\acp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:285795364f73a8b1440-40496390%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f2897562adbdca3552c471d61ec1f5a5db61f4f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\apx\\core03\\system\\tpl\\admin\\acp.tpl',
      1 => 1399296713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '285795364f73a8b1440-40496390',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5364f73aa3fba7_01966472',
  'variables' => 
  array (
    'menu' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5364f73aa3fba7_01966472')) {function content_5364f73aa3fba7_01966472($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
	<title>Artphox Admin Control Panel</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="../styles/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="../scripts/bootstrap.min.js"></script>

</head>
<body>
	<div class="container" id="acpwrapper">
		<header class="row" id="acpheader">ACP</header>
		<div class="row">
			<nav class="col-md-3" id="acpnav"><?php echo $_smarty_tpl->tpl_vars['menu']->value;?>
</nav>
			<div class="col-md-9" id="acpcontent">
				<?php echo printPage(array(),$_smarty_tpl);?>

			</div>
		</div>
	</div>
</body>
</html><?php }} ?>