<?php
// src/Config/Business.php
namespace App\Config;

/**
* Business is a config class for business parameters
*/
class Business
{
	
	const QUEUE_TIME_MAX_DELAY = 3600;
	const SUPPORTED_VERSION = 1;
	
	/**
	* Return the description of the authorized API parameters
	* @param string $property
	* @param string $value
	* @return mixed   all config fields in an array, or the the first element find with $property = $value
	*/
	public static function getFieldsConfig(string $property = null, string $value = null) {
		
		// Debug array
		//*
		$fieldsConfig = array(
			(Object) ['name' => 'Version', 'format' => 'v', 
					'example' => 'v=1', 'description' => 'Version of the API. Only 1 is currently supported',
					'mandatory' => true], 
			(Object) ['name' => 'Hit Type', 'format' => 't', 
					'example' => 't=pageview', 'description' => 'Possible values : pageview, screenview, event', 
					'mandatory' => false],
			(Object) ['name' => 'Wizbii Creator Type', 'format' => 'wct', 
					'example' => 'wct=profile', 'description' => 'One value from : "profile", "recruiter", "visitor" and "wizbii_employee"', 
					'mandatory' => ['originDevice' => 'mobile']], 
			(Object) ['name' => 'Wizbii User Id', 'format' => 'wui', 
					'example' => 'wui=emeric-wasson', 'description' => 'For "profile", "recruiter" and "wizbii_employee" : their slug. For visitor, the value stored in visitor cookie', 
					'mandatory' => ['originDevice' => 'mobile']], 
			(Object) ['name' => 'Event Action', 'format' => 'ea', 
					'example' => 'ea=client', 'description' => 'Specifies the event action. Must not be empty.', 
					'mandatory' => ['t' => 'event']], 
			(Object) ['name' => 'Queue Time', 'format' => 'qt', 
					'example' => 'av=560', 'description' => 'Used to collect offline / latent hits. The value represents the time delta (in milliseconds) between when the hit being reported occurred and the time the hit was sent. The value must be greater than or equal to 0', 
					'mandatory' => false], 
		);
		//*/
		
		if (!is_null($property) && !is_null($value)) {
			
			$filtered_array = array_filter($fieldsConfig, function ($config) use ($property, $value) { 
				return ($config->{$property} == $value); 
			} ); 
			
			return array_shift($filtered_array);
			
		} else {
			
			return $fieldsConfig;
			
		}
		
		// Full array
		/*
		return array(
			(Object) ['name' => 'Version', 'format' => 'v', 
					'example' => 'v=1', 'description' => 'Version of the API. Only 1 is currently supported',
					'mandatory' => true], 
			(Object) ['name' => 'Hit Type', 'format' => 't', 
					'example' => 't=pageview', 'description' => 'Possible values : pageview, screenview, event', 
					'mandatory' => true], 
			(Object) ['name' => 'Document Location', 'format' => 'dl', 
					'example' => 'dl=http%3A%2F%2Fwww.wizbii.com%2Fcompany%2Fwizbii', 'description' => 'A valid URI reprensenting the current page', 
					'mandatory' => false], 
			(Object) ['name' => 'Document Referer', 'format' => 'dr', 
					'example' => 'dr=http%3A%2F%2Fwww.jobijoba.com%2F/whatever', 'description' => 'A valid URI representing the traffic source', 
					'mandatory' => false], 
			(Object) ['name' => 'Wizbii Creator Type', 'format' => 'wct', 
					'example' => 'wct=profile', 'description' => 'One value from : "profile", "recruiter", "visitor" and "wizbii_employee"', 
					'mandatory' => ['originDevice' => 'mobile']], 
			(Object) ['name' => 'Wizbii User Id', 'format' => 'wui', 
					'example' => 'wui=emeric-wasson', 'description' => 'For "profile", "recruiter" and "wizbii_employee" : their slug. For visitor, the value stored in visitor cookie', 
					'mandatory' => ['originDevice' => 'mobile']], 
			(Object) ['name' => 'Wizbii Uniq User Id', 'format' => 'wuui', 
					'example' => 'wuui=38b728b0e0b4f594760d4b3e58797ae1', 'description' => 'For "profile", "recruiter", "wizbii_employee" and "visitor", the value stored in "uniqUserId" cookie', 
					'mandatory' => ['originDevice' => 'browser']], 
			(Object) ['name' => 'Event Category', 'format' => 'ec', 
					'example' => 'ec=bdo', 'description' => 'Specifies the event category. Must not be empty', 
					'mandatory' => ['t' => 'event']], 
			(Object) ['name' => 'Event Action', 'format' => 'ea', 
					'example' => 'ea=client', 'description' => 'Specifies the event action. Must not be empty.', 
					'mandatory' => ['t' => 'event']], 
			(Object) ['name' => 'Event Label', 'format' => 'el', 
					'example' => 'el=MastHead-Logo', 'description' => 'Specifies the event label.', 
					'mandatory' => false], 
			(Object) ['name' => 'Event Value', 'format' => 'ev', 
					'example' => 'ev=55', 'description' => 'Specifies the event value. Values must be a non-negative integer.', 
					'mandatory' => false], 
			(Object) ['name' => 'Tracking Id', 'format' => 'tid', 
					'example' => 'tid=UA-XXXX-Y', 'description' => 'The tracking ID / web property ID. The format is UA-XXXX-Y. All collected data is associated by this ID.', 
					'mandatory' => true], 
			(Object) ['name' => 'Data Source', 'format' => 'ds', 
					'example' => 'ds=web', 'description' => 'Indicates the data source of the hit. Possible values are : web, apps and backend', 
					'mandatory' => true], 
			(Object) ['name' => 'Campaign Name', 'format' => 'cn', 
					'example' => 'cn=client-bpce-erasmus', 'description' => 'Specifies the campaign name.', 
					'mandatory' => false], 
			(Object) ['name' => 'Campaign Source', 'format' => 'cs', 
					'example' => 'cs=wizbii', 'description' => 'Specifies the campaign source.', 
					'mandatory' => false], 
			(Object) ['name' => 'Campaign Medium', 'format' => 'cm', 
					'example' => 'cm=web', 'description' => 'Specifies the campaign medium.', 
					'mandatory' => false], 
			(Object) ['name' => 'Campaign Keyword', 'format' => 'ck', 
					'example' => 'ck=banque', 'description' => 'Specifies the campaign keyword.', 
					'mandatory' => false], 
			(Object) ['name' => 'Campaign Content', 'format' => 'cc', 
					'example' => 'cc=foobar', 'description' => 'Specifies the campaign content.', 
					'mandatory' => false], 
			(Object) ['name' => 'Screen Name', 'format' => 'sn', 
					'example' => 'sn=/jobs', 'description' => 'This parameter is optional on web properties, and required on mobile properties for screenview hits, where it is used for the \'Screen Name\' of the screenview hit.', 
					'mandatory' => ['t' => 'screenview']], 
			(Object) ['name' => 'Application Name', 'format' => 'an', 
					'example' => 'an=WizbiiStudentAndroid', 'description' => 'Specifies the application name', 
					'mandatory' => null], // Don't understand the rule
			(Object) ['name' => 'Application Version', 'format' => 'av', 
					'example' => 'av=1.2.1', 'description' => 'Specifies the application version.', 
					'mandatory' => false], 
			(Object) ['name' => 'Queue Time', 'format' => 'qt', 
					'example' => 'av=560', 'description' => 'Used to collect offline / latent hits. The value represents the time delta (in milliseconds) between when the hit being reported occurred and the time the hit was sent. The value must be greater than or equal to 0', 
					'mandatory' => false], 
			(Object) ['name' => 'Cache Burster', 'format' => 'z', 
					'example' => 'z=[random]', 'description' => 'Used to send a random number in GET requests to ensure browsers and proxies don\'t cache hits. It should be sent as the final parameter of the request since we\'ve seen some 3rd party internet filtering software add additional parameters to HTTP requests incorrectly. This value is not used in reporting.', 
					'mandatory' => false], 
		);
		//*/
	}
}