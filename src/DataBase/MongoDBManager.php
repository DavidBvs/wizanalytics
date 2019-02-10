<?php
// src/DataBase/MongoDBManager.php
namespace App\DataBase;

use Doctrine\MongoDB\Connection;

/**
* Class to connect and manage a DataBase MongoDB
*/
class MongoDBManager
{
	
	private static $_instance = null;
	private $database = 'analytic';
	private $collection = 'records';
	
	public static function getInstance() {

		if(is_null(self::$_instance)) {
			self::$_instance = new MongoDBManager();
		}

		return self::$_instance;
	}
	
	public function connectServer()
	{
		return new Connection('mongodb://localhost:27017');
	}
	
	/**
	* Insert a new record
	*/
	public function insertRecord($newRecord)
	{
		$records = $this->connectServer()->selectDatabase($this->database)->selectCollection($this->collection);
		$res = $records->insert($newRecord);
		
		return is_null($res['err']);
	}
	
	/**
	* Get last call where 'Hit Type' = $queryParameters['t'] AND 'Tracking Id' = $queryParameters['tid']
	* Issue : the function findOne doesn't return the last inserted element
	*/
	public function findLastCall($hitType, $trackingId)
	{
		$records = $this->connectServer()->selectDatabase($this->database)->selectCollection($this->collection);
		
		$record = $records->findOne(['t' => $hitType, 'tid' => $trackingId]);
		
		return $record;
	}

}