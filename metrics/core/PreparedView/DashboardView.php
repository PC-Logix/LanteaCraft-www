<?php
namespace PreparedView;
use \View as View;
use \Page as Page;

class DashboardView extends Page {
	public function run() {
		$t = new View("root.tpl", array("heading" => "LanteaCraft Metrics Dashboard"));
		$t->items = array(new View("container.tpl"));
		$t->render();
	}
}