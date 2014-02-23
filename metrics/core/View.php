<?php
class View {
	protected $template_base = "template/";
	protected $vars = array();
	protected $template_label;
	
	public function __construct($renderer = null, $settings = null) {
		if ($renderer !== null)
			$this->template_label = $renderer;
		if ($settings !== null)
			foreach ($settings as $keyOf => $valueOf)
				$this->vars[$keyOf] = $valueOf;
	}
	
	public function render() {
		if (file_exists($this->template_base . $this->template_label)) {
			include $this->template_base . $this->template_label;
		} else
			throw new Exception("No such template label `" . $this->template_label . "`.");
	}
	
	public function __set($var, $literal) {
		$this->vars[$var] = $literal;
	}
	
	public function __get($var) {
		return $this->vars[$var]; 
	}
	
}