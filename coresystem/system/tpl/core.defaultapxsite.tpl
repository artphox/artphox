<!DOCTYPE html>
<html>
<head>
	<title>{$das_completetitle}</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="generator" content="Artphox">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
	<![endif]-->
	<!--URLA-Scripts-->
	<base href="{$das_baseurl}">
	<link href="styles/{$das_styleobjid}.css?{$das_styletimestamp}" rel="stylesheet" type="text/css">
	<script src="js/jquery.min.js"></script>
	{if $das_adaption == true}
	<script src="js/adaption.js"></script>
	<script>
		//Adaption starten!
		adaption.init('{$das_slug}', '{$das_sitetitle}', '{apx_configdata name="DAS_TITLE_PATTERN_NORMAL"}', '{apx_configdata name="DAS_TITLE_PATTERN_ERROR"}', '{apx_configdata name="ADAPTION_FADE_DURATION"}', '{apx_configdata name="ADAPTION_FADE_EASING"}');
	</script>
	{/if}

	{$das_headcode}
</head>
<body>
	{$das_bodycode}
</body>
</html>