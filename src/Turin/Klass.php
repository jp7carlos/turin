<?php
namespace Turin;

class Klass extends Base {
	private $open_visibility = false;

	function parse($term) {
		if (in_array($term, array('public', 'protected', 'private', 'var', 'static'))) {
			$this->open_visibility = true;
		} elseif ($this->open_visibility && trim($term) !== '' && $term !== 'function') {
			$this->open_visibility = false;
			// Delegate term to statement
			return $this->addChild('Statement')->parse($term);
		}
		
		switch ($term) {
			case 'function':
				$this->open_visibility = false;

				return $this->addChild('Funktion');
			case '}':
				return $this->close();
		}
		return parent::parse($term);
	}

	function before() {
		return 'class';
	}
	function after() {
		return '}';
	}
}