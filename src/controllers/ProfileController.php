<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct(){
        //Verifica se esta logado
        $this->loggedUser = UserHandler::checkLogin();
        
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }

    public function index($atts = []) {//atts = atributos
        $page = intval(filter_input(INPUT_GET, 'page'));//converte o numero da pagina para int, pois se nao tiver nada, será 0.
        //salva meu id
        $id = $this->loggedUser->id;
        
        
        //se tiver algum id como parametro, ele substitui o id
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }

        //pega informacoes do usuario
        $user = UserHandler::getUser($id, true);

        if(!$user){
            $this->redirect("/");
        }
        //calcular idade
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today'); 
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        $feed = PostHandler::getUserFeed($id, $page, $this->loggedUser->id);

        $this->render('profile',[
            'loggedUser'=> $this->loggedUser,
            'user'=> $user,
            'feed'=> $feed
        ]);
    }

}