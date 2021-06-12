<?php


namespace atpro\phpmvc\middlewares;


 use atpro\phpmvc\Application;
 use atpro\phpmvc\exceptions\ForbiddenException;

 /**
  * @Author Assane Dione
  * Class AuthMiddleware
  * @package atpro\phpmvc\middlewares
  */
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

     /**
      * @throws ForbiddenException
      */
     public function execute()
     {
         if(Application::isGuest()){
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions, true)){
                throw new ForbiddenException();
            }
         }
     }
 }