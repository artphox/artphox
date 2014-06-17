<!DOCTYPE html>
<html>
<head>
	<title>Artphox - ACP</title>
	<base href="{$baseurl}">

	<link rel="stylesheet" href="../styles/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../styles/admin.css">

	<script src="../js/jquery.min.js"></script>
	<script src="../js/acp.js"></script>
	<script>
		acp.sidebar.setData(
			{$sidebardata}
			);
	</script>
</head>
<body>

<div id="wrapper">
	<div id="header">
		<div id="navbar">
			{$navbar}
		</div>
		<div id="logo"><img src="artphox.png" alt="logo"></div>
	</div>
	<div id="tabnav">
		<div id="tabs">
			{foreach key=id item=sideitem from=$sidebartabs}
				<div class="tabitem" data-tabid="{$id}">{$sideitem[0]}</div>
			{/foreach}
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
			{$stage}
		</div>
	</div>

</div>
</body>
</html>