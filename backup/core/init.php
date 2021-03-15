<?php 
session_start();
require 'connect/database.php';
require 'classes/general.php';
require 'classes/bcrypt.php';
require 'classes/admin.php';
require 'classes/province.php';
require 'classes/city.php';
require 'classes/suburb.php';
// error_reporting(0);

$admin 		= new Admin($db);
$province	= new Province($db);
$city 		= new City($db);
$suburb		= new Suburb($db);
$general 	= new General();
$bcrypt 	= new Bcrypt(12);

$errors = array();

if ($general->logged_in() === true)  
{
	$admin_id 		= $_SESSION['id'];
	$user 		= $admin->admin_data($admin_id);
}

ob_start(); // Added to avoid a common error of 'header already sent'