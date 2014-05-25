<!DOCTYPE html>
<html>
<head>
	<title>Artphox - ACP</title>

	<script src="js/acp.js"></script>
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
			{$sidebartabs}
		</div>
		<div id="sidebarcontent">
		</div>
	</div>
	<div id="stage">
		{$stage}
	</div>
</body>
</html>