<?php 

include "BDD.php";

Class API {
	//initialize the request
	function __construct() {
		$this->reqArgs();
	}
	
	// provides the response 
	function reqArgs() {
		// get the HTTP method, path and body of the request
		$method = $_SERVER['REQUEST_METHOD'];
		$request = $_SERVER['REQUEST_URI'];
		$input = file_get_contents('php://input');
		$table = null;
		$key = null;
		$set = null;
		$bdd = null;

		//echo '$input = ' . $input;
		
		if($request) {
			// retrieve the table and key from the path
			$exploded = explode('/', $request);

			$table = $exploded[2];
			$key = $exploded[3];
		}
		
		if($input) {
			$data = json_decode($input);

			// build the SET part of the SQL command
			$set = '';
			
			foreach ($data as $keyid => $value) {
				$set = $set . "`" . $keyid . "`='" . $value . "',";
			}

			$set = trim($set, ',');
		}
		
		if($method) {
			$bdd = new BDD();

			switch($method) {
				case 'GET':
					$bdd->getAction($table, $key);
					break;
				case 'POST':
					$bdd->postAction($table, $set);
					break;
				case 'PUT':
					$bdd->putAction($table, $key, $set);
					break;
				case 'DELETE':
					$bdd->deleteAction($table, $key);
					break;
			}
		}
	}
}

new API();

?>