<?php /* Smarty version Smarty-3.1.11, created on 2014-06-02 16:31:29
         compiled from "C:\xampp\htdocs\apx\core03\system\tpl\admin\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:242595381f4ee66cc46-51753628%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '907e17d0ff0ae73223e79aa3fe950df6debb820a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\apx\\core03\\system\\tpl\\admin\\index.tpl',
      1 => 1401719480,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '242595381f4ee66cc46-51753628',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5381f4ee860cc7_79381078',
  'variables' => 
  array (
    'sidebardata' => 0,
    'navbar' => 0,
    'sidebartabs' => 0,
    'stage' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5381f4ee860cc7_79381078')) {function content_5381f4ee860cc7_79381078($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
	<title>Artphox - ACP</title>

	<style>
		.sidebarli {
			cursor: pointer;
		}

		.sidebarli:hover {
			background-color: #ccc;
		}
	</style>

	<script src="../js/jquery.min.js"></script>
	<script src="../js/acp.js"></script>
	<script>
		acp.sidebar.setData(
			<?php echo $_smarty_tpl->tpl_vars['sidebardata']->value;?>

			);
	</script>
</head>
<body>
	<div id="navbar">
		<?php echo $_smarty_tpl->tpl_vars['navbar']->value;?>

	</div>
	<div id="sidebar">
		<div id="sidebartabs">
			<?php echo $_smarty_tpl->tpl_vars['sidebartabs']->value;?>

		</div>
		<div id="sidebarcontent">
			<ul class="sidebarul">

			</ul>
		</div>
	</div>
	<div id="stage">
		<?php echo $_smarty_tpl->tpl_vars['stage']->value;?>

	</div>
</body>
</html><?php }} ?>