<?php /* Smarty version Smarty-3.1.11, created on 2014-06-03 16:40:26
         compiled from "C:\xampp\htdocs\GitHub\artphox\coresystem\system\tpl\admin\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22352538ddd791270b9-96935227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4282cd4083e328eab52147e7662ec024664a207' => 
    array (
      0 => 'C:\\xampp\\htdocs\\GitHub\\artphox\\coresystem\\system\\tpl\\admin\\index.tpl',
      1 => 1401806424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22352538ddd791270b9-96935227',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_538ddd79159d42_70318985',
  'variables' => 
  array (
    'sidebardata' => 0,
    'navbar' => 0,
    'sidebartabs' => 0,
    'stage' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538ddd79159d42_70318985')) {function content_538ddd79159d42_70318985($_smarty_tpl) {?><!DOCTYPE html>
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

		.sidebarbutton {
			cursor: pointer;
		}

		.sidebarbutton:hover {
			background-color: #fcc;
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