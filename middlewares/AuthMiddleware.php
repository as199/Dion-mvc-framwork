<?php


namespace App\core\middlewares;


 use App\core\Application;
 use App\core\exceptions\ForbiddenException;

 class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];
     /**
      * AuthMiddleware constructor.
      */
     public function __construct(array $actions = [])
     {
         $this->actions = $actions;
     }

     public function execute()
     {
         if(Application::isGuest()){
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions, true)){
                throw new ForbiddenException();
            }
         }
     }
 }