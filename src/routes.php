<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');
$router->post('/login', 'LoginController@signinAction');

$router->get('/cadastro', 'LoginController@signup');
$router->post('/cadastro', 'LoginController@signupAction');

//rotas da pagina header
//$router->get('/pesquisa');
//$router->get('/perfil');
//$router->get('/sair');

//rotas da pagina sidebar
//$router->get('/amigos');
//$router->get('/fotos');
//$router->get('/config');

//rotas da pagina feed-editor
$router->post('/post/new', 'PostController@new');