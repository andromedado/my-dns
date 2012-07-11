<?php

class AppResponse extends Response {
	protected $appVars = array(
		'title' => 'Homepage',
		'navLinks' => array(),
		'errors' => array(),
	);
	
	protected function load() {
		parent::load();
		$this->set('baseHref', '<base href="http://' . SITE_HOST . '/" />');
		$this->set('debug', DEBUG);
	}
	
}

?>