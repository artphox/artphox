<?php
namespace lib\model\front\core;

use lib\universal\ArtphoxException;

abstract class Module {

	protected $properties = array();

	function __construct($params) {
		if (is_array($params)) {
			foreach ($params as $key => $value) {
				if (property_exists($this, $key)) {
					$this->$key = $value;
				}
			}
		}
	}

	function getProperties() {
		return $this->properties;
	}

	function hasLoadedProperty($key) {
		return array_key_exists($key, $this->properties);
	}

	function getProperty($key) {
		if (! $this->hasLoadedProperty($key)) {
			throw new ArtphoxException('ERR_PROPERTY_NOT_FOUND', array(get_class($this), $this->getId(), $key));
		}
		return $this->properties[$key];
	}

	function addProperty($key, $value) {
		$this->properties[$key] = $value;
	}

	abstract function getId();

}

?>