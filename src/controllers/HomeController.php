<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class HomeController extends Controller {

    private $loggedUser;

    public function __construct(){
        //Verifica se esta logado
        $this->loggedUser = UserHandler::checkLogin();
        
        if($this->loggedUser === false){
            $this->redirect('/login');
        }

       
    }

    public function index() {

        $page = intval(filter_input(INPUT_GET, 'page'));//converte o numero da pagina para int, pois se nao tiver nada, será 0.


        $feed = PostHandler::getHomeFeed(
            $this->loggedUser->id,
            $page

        );

        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed
            ]);
    }

}