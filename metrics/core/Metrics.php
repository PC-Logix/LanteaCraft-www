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
			throw new Exception("Can't __construct without cvarargContext param.");
		self::$instance = $this;
		$this->context_properties = $avarargContext;
	}
	
	public function run() {
		$viewContext = null;
		// todo: viewcontext as db_case
		
		$viewContext->run();
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