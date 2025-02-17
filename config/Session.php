<?php
class Session{

    public static function init(){
        session_start();
    }

    public static function set($key, $val){
        $_SESSION[$key]= $val;
    }

    public static function get($key){

        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }

    public static function checkSession(){
        self::init();
        if(self::get('login') != true || self::get('user_type') != 'admin'){
            self::logout();
        }
    }

    public static function logout(){
        session_destroy();
        header("Location:/ecomerce/admin/auth/login.php"); 
        exit();
    }
}