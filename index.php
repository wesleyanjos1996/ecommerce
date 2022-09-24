<?php

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

//$app = new \Slim\Slim();
$app = new Slim();

$app->config('debug', true);

//Rota do site
$app->get('/', function()
{
	$page = new Page();
	$page->setTpl("index");
});

//View Admin
$app->get("/admin", function(){
	User::verifylogin();
	$page = new PageAdmin();
	$page->setTpl("index");
});

//Login
$app->get("/admin/login", function()
{
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("login");
});

$app->post("/admin/login", function(){
	User::login($_POST["login"], $_POST["password"]);
	
	header("Location: /admin");
	exit;
});

//Logout
$app->get("/admin/logout", function(){
	User::logout();
	header("Location: /admin");
});

$app->run();

 ?>