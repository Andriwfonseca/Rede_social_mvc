<?php
namespace src\handlers;

use \src\models\User;


class UserHandler{

    //verifica se esta logado e ja retorna os dados do usuario
    public static function checkLogin(){

        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];
            $data = User::select()->where('token', $token)->one();
            if(count($data) > 0){

                $loggedUser = new User();

                $loggedUser->id = $data['id'];
                $loggedUser->email = $data['email'];
                $loggedUser->name = $data['name'];
                $loggedUser->avatar = $data['avatar'];
                
                
                return $loggedUser;
            }

        }else{
            return false;
        }
    }

    //verifica login e salva no token
    public static function verifyLogin($email, $password){
        //verifica se email existe
        $user = User::select()->where('email', $email)->one();
        //se email existir, verifica a senha. Se senha confere, cria um token e salva no banco e retorna esse token
        if($user){
            if(password_verify($password, $user['password'])){
                $token = md5(time().rand(0,999999).time());

                User::update()->set('token', $token)->where('email', $email)->execute();
                return $token;
            }
        }   

        return false;
    }

    //verifica se email ja existe
    public static function emailExists($email){
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;
    }

    //verifica se o usuario existe
    public static function idExists($id){
        $user = User::select()->where('id', $id)->one();
        return $user ? true : false;
    }

    //pega informacoes do usuario
    public static function getUser($id){
        $data = User::select()->where('id', $id)->one();

        if($data){
            $user = new User();
            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->birthdate = $data['birthdate'];
            $user->city = $data['city'];
            $user->work = $data['work'];
            $user->avatar = $data['avatar'];
            $user->cover = $data['cover'];

            return $user;
        }

        return false;
    }
    //adiciona usuario no banco de dados
    public static function addUser($name, $email, $password, $birthdate){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,999999).time());

        User::insert([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthdate,
            'token' => $token
        ])->execute();

        return $token;
    }

}