<?php

class AppResponse extends Response {
	protected $appVars = array(
		'errors' => array(),
		'base_url' => BASE_URL,
	);
	
	protected function load() {
		parent::load();
		$this->set('debug', DEBUG);
	}
	
}

?>