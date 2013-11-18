<?php
require "/home/sgcraft/protected/db_cnf.php";
require_once('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
$localdb = new PDO("mysql:host=" . $local_host . ";port=3306;dbname=" . $local_dbnm , 
	$local_user, $local_pass, array( PDO::ATTR_PERSISTENT => false));


$tally = array();
$tally["CLIENT"] = array();
$tally["SERVER"] = array();

$qclient = $localdb->prepare("SELECT * FROM  `analytics` WHERE `analytics`.`side` = 'CLIENT' ORDER BY `analytics`.`date` ASC LIMIT 0, 300000");
$qserver = $localdb->prepare("SELECT * FROM  `analytics` WHERE `analytics`.`side` = 'SERVER' ORDER BY `analytics`.`date` ASC LIMIT 0, 300000");

$qclient->execute();
$qrowclient = $qclient->fetchAll();
$qserver->execute();
$qrowserver = $qserver->fetchAll();
$qdates = array();

foreach ($qrowclient as $row) {
	if (array_search($row["date"], $qdates) === false) {
		if (sizeof($qdates) > 30) break;
		array_push($qdates, $row["date"]);
	}
	$i = array_search($row["date"], $qdates);
	$tally["CLIENT"][$i] += 1;
}

foreach ($qrowserver as $row) {
	if (array_search($row["date"], $qdates) === false) {
		if (sizeof($qdates) > 30) break;
		array_push($qdates, $row["date"]);
	}
	$i = array_search($row["date"], $qdates);
	$tally["SERVER"][$i] += 1;
}

	
$wx = (is_numeric($_REQUEST['wx']) && $_REQUEST['wx'] > 0) ? $_REQUEST['wx'] : 400;
$hx = (is_numeric($_REQUEST['hx']) && $_REQUEST['hx'] > 0) ? $_REQUEST['hx'] : 300;

$graph = new Graph($wx, $hx);
$graph->SetShadow();
$graph->SetScale("textlin");
$graph->img->SetMargin(40, 30, 20, 40);

$p1 = new LinePlot($tally["SERVER"]);
$p1->SetFillColor("lightgreen@0.2");
$p1->SetLegend("Server");

$p2 = new LinePlot($tally["CLIENT"]);
$p2->SetFillColor("lightblue@0.2");
$p2->SetLegend("Client");

$gbplot = new AccLinePlot(array($p1, $p2));
$graph->Add($gbplot);


$graph->title->set("Activations by Forge Side");
$graph->xaxis->title->Set("Date");
$graph->yaxis->title->Set("Sessions");

$graph->legend->SetFrameWeight(1);
$graph->legend->SetColumns(2);
$graph->legend->SetColor('#4E4E4E','#00A78A');

$graph->xaxis->SetTickLabels($qdates);
$graph->xaxis->SetLabelAngle(-45);

$graph->Stroke();