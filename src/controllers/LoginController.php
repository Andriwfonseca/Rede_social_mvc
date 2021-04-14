<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class LoginController extends Controller {

    //pagina de login
    public function signin(){
        $flash = "";
        //se tiver uma msg na flash, salva na variavel flash e manda para o login. E limpa a session pra nao ficar repetindo
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signin', [
            'flash' => $flash
        ]);

    }

    //checa login com email e senha
    public function signinAction(){
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password){

            $token = UserHandler::verifyLogin($email, $password);

            if($token){
                $_SESSION['token'] = $token;
                $this->redirect('/');
            }else{
                $_SESSION['flash'] = 'E-mail e/ou senha não conferem!';
                $this->redirect('/login');
            }

        }else{
            $this->redirect('/login');
        }
    }

    //pagina de cadastro
    public function signup(){
        $flash = "";
        //se tiver uma msg na flash, salva na variavel flash e manda para o login. E limpa a session pra nao ficar repetindo
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signup', [
            'flash' => $flash
        ]);
    }

    //faz o cadastro do usuario
    public function signupAction(){
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $birthdate = filter_input(INPUT_POST, 'birthdate');

        if($name && $email && $password && $birthdate){
            //tira as '/' e transforma a data em um array
            $birthdate = explode("/", $birthdate);
            
            if(count($birthdate) != 3){ //a data precisa ter 3 numeros: ano/mes/dia
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/cadastro');
            }   
                //converter data para formato americano
                $birthdate = $birthdate[2]."-".$birthdate[1]."-".$birthdate[0];
                //confere se essa data é invalida
                if(strtotime($birthdate) === false){
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/cadastro');
                }

                if(UserHandler::emailExists($email) === false){
                    //se email não existe no banco, ele cadastra o usuario e ja salva no token para ficar logado
                    $token = UserHandler::addUser($name, $email, $password, $birthdate);
                    $_SESSION['token'] = $token;
                    $this->redirect('/');
                }else{
                    $_SESSION['flash'] = 'E-mail já cadastrado!';
                    $this->redirect('/cadastro');
                }
            
        }else{
            $this->redirect('/cadastro');
        }

    }

    //remove a sessao e volta para pagina de login
    public function logout(){
        $_SESSION['token'] = '';
        $this->redirect('/login');
    }

}
