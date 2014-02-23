<?php
class Page {
	
	public function run() {
		$t = new View("root.tpl", array(
			"heading" => "Test!",
			"title" => "Dashboard"));
		$t->items = array();
		$t->render();
	}
}