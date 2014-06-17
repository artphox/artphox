<?php /* Smarty version Smarty-3.1.11, created on 2014-06-17 16:07:53
         compiled from "C:\xampp\htdocs\GitHub\artphox\coresystem\system\tpl\admin\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22352538ddd791270b9-96935227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4282cd4083e328eab52147e7662ec024664a207' => 
    array (
      0 => 'C:\\xampp\\htdocs\\GitHub\\artphox\\coresystem\\system\\tpl\\admin\\index.tpl',
      1 => 1403014073,
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
    'baseurl' => 0,
    'sidebardata' => 0,
    'navbar' => 0,
    'sidebartabs' => 0,
    'id' => 0,
    'sideitem' => 0,
    'stage' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_538ddd79159d42_70318985')) {function content_538ddd79159d42_70318985($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
	<title>Artphox - ACP</title>
	<base href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
">

	<link rel="stylesheet" href="../styles/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../styles/admin.css">

	<script src="../js/jquery.min.js"></script>
	<script src="../js/acp.js"></script>
	<script>
		acp.sidebar.setData(
			<?php echo $_smarty_tpl->tpl_vars['sidebardata']->value;?>

			);
	</script>
</head>
<body>

<div id="wrapper">
	<div id="header">
		<div id="navbar">
			<?php echo $_smarty_tpl->tpl_vars['navbar']->value;?>

		</div>
		<div id="logo"><img src="artphox.png" alt="logo"></div>
	</div>
	<div id="tabnav">
		<div id="tabs">
			<?php  $_smarty_tpl->tpl_vars['sideitem'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sideitem']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['sidebartabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sideitem']->key => $_smarty_tpl->tpl_vars['sideitem']->value){
$_smarty_tpl->tpl_vars['sideitem']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['sideitem']->key;
?>
				<div class="tabitem" data-tabid="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['sideitem']->value[0];?>
</div>
			<?php } ?>
		</div>
		<div id="stagenav">

		</div>
	</div>
	<div id="sidebar">
		<ul class="sidebar"></ul>
	</div>
	<div id="stage">
		<div id="stage-inner">
			<div id="stage-dialog">
			</div>
			<?php echo $_smarty_tpl->tpl_vars['stage']->value;?>

		</div>
	</div>

</div>
</body>
</html><?php }} ?>