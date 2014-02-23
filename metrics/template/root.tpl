<!DOCTYPE HTML> 
<html> 
	<head> 
		<title><?=$this->title?></title> 
		<link rel="stylesheet" href="resource/style/default.css" />
	</head>
<body>
	<div id="header">
		<img src="resource/image/icon.png"> <h1><?=$this->heading?></h1>
	</div>
	<div id="nav">
		<?php 
			$nav = new View('navigation.tpl'); 
			$nav->render(); 
		?>
	</div>
<?php
	foreach ($this->items as $key => $item) 
		$item->render(); 
?>