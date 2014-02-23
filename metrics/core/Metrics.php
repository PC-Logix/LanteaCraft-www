<?php
class Metrics {
	# Singleton
	private static $instance;
	
	public static function instance() {
		if (!self::$instance)
			throw new Exception("No such singleton of Metrics.");
		return self::$instance;
	}
	
	protected $context_property;
	protected $dpdo_dbc = array();
	
	public function __construct($varargContext) {
		if ($varargContext == null)
			throw new Exception("Can't __construct without varargContext param.");
		self::$instance = $this;
		$this->context_properties = $varargContext;
	}
	
	public function run() {
		$viewContext = null;
		// todo: viewcontext as db_case
		
		$__testPage = new PreparedView\DashboardView();
		$viewContext = $__testPage;
		
		if ($viewContext !== null)
			$viewContext->run();
		else
			throw new Exception("No View for this context!");
	}
	
	public function getProperty($key) {
		return $this->context_property[$key];
	}
	
	public function dbc($context) {
		if ($context == null)
			throw new Exception("Can't create DBC closure without context name!");
		if ($this->dpdo_dbc[$context] === null)
			$this->dpdo_dbc[$context] = new PDO(
				"mysql:" .
					"host=" . $this->context_property["dbc"]["source"] . ";" .
					"dbname=" . $context,
				$this->context_property["dbc"]["identity"], 
				$this->context_property["dbc"]["password"]);
		return ($this->dpdo_dbc[$context]);
	}
	
}