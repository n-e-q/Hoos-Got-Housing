<?php
class DbUtil{
	public static $loginUser = "ak6eh"; 
	public static $loginPass = "5ag";
	public static $host = "mysql.cs.virginia.edu"; // DB Host
	public static $schema = "ak6eh_project"; // DB Schema
	
	public static function loginConnection(){
		$db = new mysqli(DbUtil::$host, DbUtil::$loginUser, DbUtil::$loginPass, DbUtil::$schema);
	
		if($db->connect_errno){
			echo("Could not connect to db");
			$db->close();
			exit();
		}
		
		return $db;
	}
	
}
?>

