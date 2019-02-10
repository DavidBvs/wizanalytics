<?php
// src/Config/Business.php
namespace App\Config;

/**
* Business is a config class for business parameters
*/
class Business
{
	
	/**
	* Return the description of the authorized API parameters
	*
	* @return array   config fields
	*/
	public static function getFieldsConfig() {
		// Debug array
		return array(
			array('label' => 'Version', 'name' => 'v', 'mandatory' => true), 
			array('label' => 'Wizbii User Id', 'name' => 'wui', 'mandatory' => true), 
			array('label' => 'Queue Time', 'name' => 'qt', 'mandatory' => false), 
			array('label' => 'Document Location', 'name' => 'dl', 'mandatory' => true), 
		);
		
		// Complete array
		/*
		return array(
			array('label' => 'Version', 'name' => 'v', 'mandatory' => true), 
			array('label' => 'Hit Type', 'name' => 't', 'mandatory' => true), 
			array('label' => 'Document Location', 'name' => 'dl', 'mandatory' => false), 
			array('label' => 'Document Referer', 'name' => 'dr', 'mandatory' => false), 
			array('label' => 'Wizbii Creator Type', 'name' => 'wct', 'mandatory' => true), 
			array('label' => 'Wizbii User Id', 'name' => 'wui', 'mandatory' => true), 
			array('label' => 'Wizbii Uniq User Id', 'name' => 'wuui', 'mandatory' => true), 
			array('label' => 'Event Category', 'name' => 'ec', 'mandatory' => true), 
			array('label' => 'Event Action', 'name' => 'ea', 'mandatory' => true), 
			array('label' => 'Event Label', 'name' => 'el', 'mandatory' => false), 
			array('label' => 'Event Value', 'name' => 'ev', 'mandatory' => false), 
			array('label' => 'Tracking Id', 'name' => 'tid', 'mandatory' => true), 
			array('label' => 'Data Source', 'name' => 'ds', 'mandatory' => true), 
			array('label' => 'Campaign Name', 'name' => 'cn', 'mandatory' => false), 
			array('label' => 'Campaign Source', 'name' => 'cs', 'mandatory' => false), 
			array('label' => 'Campaign Medium', 'name' => 'cm', 'mandatory' => false), 
			array('label' => 'Campaign Keyword', 'name' => 'ck', 'mandatory' => false), 
			array('label' => 'Campaign Content', 'name' => 'cc', 'mandatory' => false), 
			array('label' => 'Screen Name', 'name' => 'sn', 'mandatory' => true), 
			array('label' => 'Application Name', 'name' => 'an', 'mandatory' => true), 
			array('label' => 'Application Version', 'name' => 'av', 'mandatory' => false), 
			array('label' => 'Queue Time', 'name' => 'qt', 'mandatory' => false), 
			array('label' => 'Cache Burster', 'name' => 'z', 'mandatory' => false)
		);
		*/
	}
}