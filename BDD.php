<?php 

Require_once 'config.php';

Class BDD {
	//PDO connection is reached from the singleton class

	//get the selected row
	public Function getAction($table, $key)	{
		try {
			$query = singleton::getInstance()->prepare("SELECT * FROM :table WHERE id = :id");
			$query->bindParam(':table', $table);
			$query->bindParam(':id', $key);
			
			$success = $query->execute();

			if ($success) {
				$result = $query->fetchObject();
				echo json_encode($result);
			}
		}
		catch (PDOException $e) {
    		echo "Error on GET : " . $e->getMessage();
		exit;
		}
	}

	//update selected table 
	public Function putAction($table, $key, $set) {
		try {
			echo "UPDATE $table SET $set WHERE `id`=$key";
			$query = singleton::getInstance()->prepare("UPDATE $table SET $set WHERE `id`=$key");
			$query->execute();
		}
		catch (PDOException $e) {
    		 echo "Error on PUT : " . $e->getMessage();
    	exit;
		}
	}

	//insert a row from selected table
	public Function postAction($table, $set) {	
		try {
			$query = singleton::getInstance()->prepare("INSERT INTO $table SET $set");
			//$query->bindParam(':table', $table);
			//$query->bindParam(':set', $set);
			$query->execute();
		}
		catch (PDOException $e) {
    		echo "Error on POST : " . $e->getMessage();
    	exit;
		}
	}

	//delete a row from selected table
	public Function deleteAction($table, $key) {
		try {
			$query = singleton::getInstance()->prepare("DELETE FROM $table WHERE `id`=$key");
			$query->execute();
		}
		catch (PDOException $e) {
    		echo "Error on DELETE : " . $e->getMessage();
		exit;
		}
	}
}

?>