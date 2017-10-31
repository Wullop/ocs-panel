<?php
session_start();

require '../application/third_party/password_compat-master/lib/password.php';

class Database {

	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');
		
		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Create the prepared statement
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);

		// Close the connection
		$mysqli->close();
		return true;
	}

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Open the default SQL file
		$query = file_get_contents('assets/install.sql');

		// Execute a multi query
		if ($mysqli->multi_query($query)) {
			$mysqli->close();
			sleep(3);
			$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
			$u=$data['user']; $e=$data['email']; $p=$this->hashpwd($data['pwd']);
			$sql = "INSERT INTO users (username,email,password, is_admin) VALUES ('$u','$e', '$p', TRUE)";
			$mysqli->query($sql);
			$mysqli->close();
			return true;
		}
		else { return false;}

		// Close the connection
		
	}
	function hashpwd($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}

	function create_admin($data) {
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		if(mysqli_connect_errno()) {return false;}
		
		
		$u=$data['user']; $e=$data['email']; $p=$this->hashpwd($data['pwd']);
		
		$sql = "INSERT INTO users (username,email,password, is_admin) VALUES ('$u','$e', '$p', TRUE)";
		
		$mysqli->query($sql);
		
		$mysqli->close();
		return true;
	}
}
