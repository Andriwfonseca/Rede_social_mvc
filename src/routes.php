<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');
$router->post('/login', 'LoginController@signinAction');

$router->get('/cadastro', 'LoginController@signup');
$router->post('/cadastro', 'LoginController@signupAction');

$router->get('/perfil/{id}', "ProfileController@index");
$router->get('/perfil', "ProfileController@index");


//rotas da pagina header
//$router->get('/pesquisa');

//$router->get('/sair');

//rotas da pagina sidebar
//$router->get('/amigos');
//$router->get('/fotos');
//$router->get('/config');

//rotas da pagina feed-editor
$router->post('/post/new', 'PostController@new');