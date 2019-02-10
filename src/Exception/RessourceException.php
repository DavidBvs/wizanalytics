<?php
// src/Exception/RessourceException.php
namespace App\Exception;

use RuntimeException;

class RessourceException extends RuntimeException
{
	public $type = 'RessourceException';
    private $property;
	
	function __construct($property) {
		$this->property = $property;
		parent::__construct($this->format($property));
	}
	
	protected function format($property) {
	if (property_exists($property, 'format') && property_exists($property, 'name')) {
		return 'Missing parameter: ' . $property->format . ' (' . $property->name . ').';
	}
		return 'Missing parameter.';
	}
}
