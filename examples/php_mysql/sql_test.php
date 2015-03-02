<?php
require('dbconnect.php');

/* Initialize database object */
$db = new dbconnect();

/* Create tables */
$db->addTables();

/* Insert new  Row */
$db->addRow(1, 'Joe', '432 322 2234', 'joe@mailinator.com');

/* Display Row */
$user = array();
$user = $db->displayRow("Joe");
var_dump($user);

/* Delete Row */
$db->removeRow("Joe");

?>
