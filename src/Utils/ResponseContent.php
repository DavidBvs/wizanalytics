<?php
// src/Utils/ResponseContent.php
namespace App\Utils;

class ResponseContent
{
	public $result;
	public $code;
	public $type;
	public $message;
	
	function __construct($properties) {
		foreach($properties as $property => $value) {
			if (isset($value) && !empty($value) && property_exists($this, $property)) {
				$this->{$property} = $value;
			}
		}
	}
	
	public function setProperty($property, $value) 
	{
		if (isset($value) && !empty($value) && property_exists($this, $property)) {
			$this->{$property} = $value;
		}
	}
}