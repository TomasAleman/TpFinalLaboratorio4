<?php

namespace Controllers;
use Controllers\AuthController as AuthController;

class HomeController
{
    public function Index(){
        $auth = new AuthController();
        if(isset($_SESSION["loggeduser"]))
        {
        $auth->showLandingPage($_SESSION["type"]);    
        }else
        {
        $auth->login();
        }
    }
}