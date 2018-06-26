<?php 
//dependencias do composer 
//o que o meu projeto precisa?
session_start();
require_once("vendor/autoload.php");
//namesapces e nomes das classes
use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
// Slim usado para rotas
$app = new Slim();

//linha 12 qual e a rota que estou chamando?  dentro do bloco 
$app->config('debug', true);
//quando chamar via get na pasta raiz sem nenhuma rota executa essa função 
$app->get('/', function() {
    
	//adiconar o header na tela
	$page = new Page(); 

	// adicionar o h1 
	$page->setTpl("index"); 

});

$app->get('/admin', function() {

	User::verifylogin();
    
	// a nova classe 
	$page = new PageAdmin(); 

	$page->setTpl("index"); 

});

$app->get('/admin/login', function() {
    
	// a nova classe 
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]); 

	$page->setTpl("login"); 

});

$app->post('/admin/login' , function(){

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");
	exit;

});

$app->get("/admin/users", function(){

	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users 

	));

});

$app->get("/admin/users/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");

});

$app->get("/admin/users/:iduser/delete", function($iduser){

	User::verifyLogin(); 

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");
	exit;

});


$app->get("/admin/users/:iduser", function($iduser){

	User::verifyLogin();

	$user = new User();

	$user->get($iduser);

	$page = new PageAdmin();

	
	$page->setTpl("users-update", array(
		"user"=>$user->getValues()

	));

});

$app->post("/admin/users/create", function(){

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($POST_["inadmin"]))?1:0;

	$user->setData($_POST);

	$user->save(); //excecutar o INSERT no banco de dados

	header("Location: /admin/users");
	exit;

});

$app->post("/admin/users/:iduser", function($iduser){

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($POST_["inadmin"]))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;


});


$app->run();

 ?>