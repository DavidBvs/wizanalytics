<?php
// src/Controller/ApiController.php
namespace App\Controller;
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;

use App\Config\Business;
use App\Exception\RessourceException;
use App\Utils\ResponseContent;

use Doctrine\MongoDB\Connection;

/**
* Api Controller : process parameters validation, create response
*/
class ApiController extends Controller
{
	protected $originDevice;
	
	/**
	* Main api function controller for POST method
	* Manage with an array of data set
	*/
	public function apiPost(Request $request) :Response
    {
		return new Response(
			'<html><body>Here process for an array of data set. Same process and function as apitGet are used, but dealing with an array.</body></html>'
        );
	}
	
	/**
	* Main api function controller for GET method
	* Manage with a single data set
	*/
	public function apiGet(Request $request) :Response
    {
		$queryParameters = $request->query->all();
		
		$this->originDevice = $this->detectOriginDevice($_SERVER['HTTP_USER_AGENT']);
		
		// Check if existing cookies
		$this->getAndSetCookies($queryParameters, $request->cookies);
		
		// Check parameters and apply business rules
		$contentResponse = $this->parametersValidation($queryParameters);
		
		// Get last call where 'Hit Type' = $queryParameters['t'] AND 'Tracking Id' = $queryParameters['tid']
		// if timelaps < 1sec do nothing // else save 
		
		// Create an appropriate response
		return $this->setResponse($contentResponse);
    }
	
	/**
	* Detect the origin device
	* @param string $httpUserAgent
	* @return string mobile / browser
	*/
	protected function detectOriginDevice($httpUserAgent) {
		// Liste of browser (have a look to a best list)
		$browserUserAgent = array(
			'/msie/i'       =>  'Internet Explorer',
			'/firefox/i'    =>  'Firefox',
			'/safari/i'     =>  'Safari',
			'/chrome/i'     =>  'Chrome',
			'/opera/i'      =>  'Opera',
			'/netscape/i'   =>  'Netscape',
			'/maxthon/i'    =>  'Maxthon',
			'/konqueror/i'  =>  'Konqueror',
			'/mobile/i'     =>  'Handheld Browser'
		);
		
		//Return true if Mobile User Agent is detected
		foreach($browserUserAgent as $browserKey => $browserOS){
			if(preg_match($browserKey, $httpUserAgent)){
				return 'browser';
			}
		}
		
		// Default
		return 'mobile';
	}
	
	/**
	* Create an generic response
	* @param array $contentResponse the elements to put into a json in the response request
	*/
	protected function setResponse($contentResponse)
	{
		$response = new Response();
		$response->setContent(json_encode([$contentResponse->result, $contentResponse->message]));
		//$response->setStatusCode(Response::HTTP_OK);
		$response->setStatusCode($contentResponse->code);
		$response->headers->set('Content-Type', 'text/json');
		return $response;
	}
	
	/**
	* Get cookies and put them into corresponding parameters
	* @param array &$queryParameters
	*/
	protected function getAndSetCookies(&$queryParameters)
	{
		
	}
	
	/**
	* Check parameters and apply business rules
	* @param array $queryParameters
	* @return array content response
	*/
	protected function parametersValidation($queryParameters)
	{
		try {
			// Max one call per second for a unique event
			
			// Check if we've got all mandatory fields
			$result = $this->checkMandatoryFields($queryParameters);
			
			// Check that the user exists
			$result = $this->checkUser($queryParameters);
			
			// Check qt value
			$result = $this->checkQt($queryParameters);
			
			// Check version value
			$result = $this->checkVersion($queryParameters);
			
		} catch (Exception $e) {
			return new ResponseContent(array(
				'result' => 'ERROR',
				'code' => Response::HTTP_BAD_REQUEST,
				'type' => get_class($e),
				'message' => $e->getMessage()
			));
		} catch (RessourceException $e) {
			
			return new ResponseContent(array(
				'result' => 'ERROR',
				'code' => Response::HTTP_BAD_REQUEST,
				'type' => $e->type,
				'message' => $e->getMessage()
			));
		}
		
		return new ResponseContent(array(
			'result' => 'SUCCESS',
			'code' => Response::HTTP_OK,
			'type' => 'Process successfull',
			'message' => null
		));;
	}
	
	/**
	* Check if we've got all mandatory fields
	* @param array $queryParameters
	*/
	private function checkMandatoryFields($queryParameters) {
		
		$fieldsConfig = business::getFieldsConfig();
		
		foreach ($fieldsConfig as $fieldConfig) {
			
			// If parameter exits, do nothing ; else check condition(s) mandatory
			if (isset($queryParameters[$fieldConfig->format]) === false) {
				
				// If no mandatory, do nothing, else check condition(s) mandatory
				if ($fieldConfig->mandatory !== false) {
			
					if ($fieldConfig->mandatory === true) {
						// Mandatory
						throw new RessourceException($fieldConfig);
						
					} elseif (is_array($fieldConfig->mandatory) && !empty($fieldConfig->mandatory)) {
						// Mandatory with conditions
						
						// Check for each condition if the it's valide
						foreach ($fieldConfig->mandatory as $field => $value) {
							
							// Have a look if the field is in request parameters
							if (in_array($field, array_keys($queryParameters)) && $queryParameters[$field] == $value) {
								
								throw new RessourceException($fieldConfig);
								
							} elseif (property_exists($this, $field) && $this->{$field} == $value) {
								
								throw new RessourceException($fieldConfig);
								
							}
						}
					}
				}
			}
		}
	}
	
	/**
	* Check that the user exists
	* @param array $queryParameters
	*/
	private function checkUser($queryParameters) 
	{
		$parameter = Business::getFieldsConfig('format', 'wui');
		if (isset($queryParameters['wui']) && !empty($queryParameters['wui'])) {
			if (in_array($queryParameters['wui'], $this->getUsersWizbii())) {
				return array('result' => true, 'message' => 'Utilisateur Wizbii.');
			} else {
				throw new Exception('Utilisateur ' . $queryParameters['wui'] . ' inconnu.');
			}
		}
		throw new RessourceException($parameter);
	}
	
	/**
	* Check qt value
	* @param array $queryParameters
	*/
	private function checkQt($queryParameters) 
	{
		$parameter = Business::getFieldsConfig('format', 'qt');
		if (isset($queryParameters['qt']) && !empty($queryParameters['qt'])) {
			if ($queryParameters['qt'] <= Business::QUEUE_TIME_MAX_DELAY) {
				return array('result' => true, 'message' => 'Qt ok.');
			} else {
				throw new Exception('Qt hors délai (délai max : ' . Business::QUEUE_TIME_MAX_DELAY . ').');
			}
		}
		throw new RessourceException($parameter);
	}
	
	/**
	* Check version value
	* @param array $queryParameters
	*/
	private function checkVersion($queryParameters) 
	{
		$parameter = Business::getFieldsConfig('name', 'Version');
		if (isset($queryParameters['v']) && !empty($queryParameters['v'])) {
			if (floatval($queryParameters['v']) === floatval(Business::SUPPORTED_VERSION)) {
				return array('result' => true, 'message' => 'Version ok.');
			} else {
				throw new Exception('Version non supportée (version courante : ' . Business::SUPPORTED_VERSION . ').');
			}
		}
		throw new RessourceException($parameter);
	}
	
	private function getUsersWizbii() {
		return array('dav', 'eric', 'bruno');
	}
}