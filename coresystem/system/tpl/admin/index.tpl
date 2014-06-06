<!DOCTYPE html>
<html>
<head>
	<title>Artphox - ACP</title>
	<base href="{$baseurl}">

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
			{$sidebardata}
			);
	</script>
</head>
<body>
	<div id="navbar">
		{$navbar}
	</div>
	<div id="sidebar">
		<div id="sidebartabs">
			<div id="sidebarhead">
			{foreach key=id item=sideitem from=$sidebartabs}
				<div class="sidebarbutton" data-tabid="{$id}">{$sideitem[0]}</div>
			{/foreach}
			</div>
		</div>
		<div id="sidebarcontent">
			<ul class="sidebarul">

			</ul>
		</div>
	</div>
	<div id="stage">
		{$stage}
	</div>
</body>
</html>