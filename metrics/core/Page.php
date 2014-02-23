<?php
class Page {
	
	public function run() {
		$t = new View("root.tpl", array("heading" => "LanteaCraft Metrics Dashboard"));
		$t->items = array(new View("container.tpl"));
		$t->render();
	}
}