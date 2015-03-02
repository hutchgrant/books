<?php
/*
*  MySQL Connection/Query Library example
*	Copyright 2015 GPLv3 Licensed by Grant Hutchinson
*/


class dbconnect
{

	function sqlConn(){
		include_once('config.php');
		$db = new PDO("mysql".":host=".dbAddress.";dbname=".dbName, dbUser, dbPass);
		return $db;
	}
	function addTables(){
		$db  = $this->sqlConn();
		$stmt = $db->prepare("CREATE table Contacts  (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), UserID varchar(50),ContactName varchar(100), ContactEmail varchar(100), ContactPhone varchar (20))");
		$stmt->execute();
	}
	function addRow($userid, $contactName, $contactPhone, $contactEmail){
		$db  = $this->sqlConn();
		$stmt = $db->prepare("INSERT into Contacts (UserID, ContactName, ContactEmail, ContactPhone) values (:userid, :name, :email, :phone)");
		$stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
		$stmt->bindValue(':name', $contactName, PDO::PARAM_STR);
		$stmt->bindValue(':email', $contactEmail, PDO::PARAM_STR);
		$stmt->bindValue(':phone', $contactPhone, PDO::PARAM_STR);
		$stmt->execute();
	}
	function displayRow($username){
	
		try {
			$contact = array();
			$db  = $this->sqlConn();
			$stmt = $db->prepare("SELECT ContactName, ContactEmail, ContactPhone FROM Contacts WHERE ContactName=:username");
			$stmt->bindValue(':username', $username, PDO::PARAM_STR);
			$stmt->execute();

			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(is_array($rows) AND count($rows) == 1) {
					$row = $rows[0];
				if(isset($row['ContactName'])){
					$contact['name'] = $row['ContactName'];
					$contact['email'] = $row['ContactEmail'];
					$contact['phone'] = $row['ContactPhone'];
				}
			}
 		} catch (exception $e) {
            echo $e;
    	}
		return $contact;
	}
	function updateRow($userid, $contactName, $contactPhone, $contactEmail){
		$db  = $this->sqlConn();

		$stmt = $db->prepare("UPDATE Contacts set ContactName = :name, ContactEmail = :email, ContactPhone = :phone WHERE UserID = :userid");
		$stmt->bindValue(':userid', $userid , PDO::PARAM_INT );
		$stmt->bindValue(':name', $contactName ,  PDO::PARAM_STR);
		$stmt->bindValue(':phone', $contactPhone ,  PDO::PARAM_STR);
		$stmt->bindValue(':email', $contactEmail ,  PDO::PARAM_STR);
		$stmt->execute();
	}
	function removeRow($username){
		$db  = $this->sqlConn();
		$stmt = $db->prepare("DELETE FROM Contacts WHERE ContactName =:name");
		$stmt->execute(array(':name' => $username));
	}
}

?>
