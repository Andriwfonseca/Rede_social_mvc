<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class PostController extends Controller {

    private $loggedUser;

    public function __construct(){
        //Verifica se esta logado
        $this->loggedUser = UserHandler::checkLogin();
        
        if($this->loggedUser === false){
            $this->redirect('/login');
        }

       
    }

    //cria uma postagem
    public function new() {
    
        $body = filter_input(INPUT_POST, 'body');

        //salva no banco de dados
        if($body){
            PostHandler::addPost(
                $this->loggedUser->id,
                'text',
                $body
            );
        }

        $this->redirect('/');
    }

}