<?php 
//dependencias do composer 
//o que o meu projeto precisa?
require_once("vendor/autoload.php");
//namesapces e nomes das classes
use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
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
    
	// a nova classe 
	$page = new PageAdmin(); 

	$page->setTpl("index"); 

});

$app->run();

 ?>