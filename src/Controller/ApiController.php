<?php
// src/Controller/ApiController.php
namespace App\Controller;
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Api Controller : process parameters validation, create response
*/
class ApiController extends Controller
{
	
	/**
	* Main api function controller
	*/
	public function index(Request $request)
    {
		$queryParameters = $request->query->all();
		
		// Check if existing cookies
		
		
		// Switch on GET or POST method
		switch ($request->getMethod()) {
			case 'GET':
				// Manage with a single data set
				
				// Check parameters and apply business rules
				
				// Create an appropriate response
				return $this->setResponse(['result' => 'OK', 'code' => 200, 'type' => 'Success', 'message' => 'All is good in the WorldWideWeb!']);
				break;
			case 'POST':
				// Manage with a array of data set
				break;
			default: 
		}

    }
	
	/**
	* Create an generic response
	*/
	protected function setResponse($contentResponse)
	{
		$response = new Response();
		$response->setContent(json_encode($contentResponse));
		$response->setStatusCode(Response::HTTP_OK);
		$response->headers->set('Content-Type', 'text/json');
		return $response;
	}
}