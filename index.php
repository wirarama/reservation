<?
include('module.php');
$valid = login_verify();
$out = page_structure('head');
?>
<html>
<head>
	<title>Room Reservation System</title>
	<? non_php_include(); ?>
</head>
<body>
<div align="center">
<? page(); ?>
</div>
</body>
</html>
