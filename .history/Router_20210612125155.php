<?php


namespace atpro\phpmvc;

use atpro\phpmvc\exceptions\ForbiddenException;
use atpro\phpmvc\exceptions\NotFoundException;

/**
 * @Author Assane Dione
 * Class Router
 * Gerer le routage de l'appl
 * @package atpro\phpmvc
 */
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get(string $path, $callback)
    {
        $this->routes['get'][$path]= $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path]= $callback;
    }

    public function resolve(): string
    {
      $path= $this->request->getPath();
      $method = $this->request->method();

      $callback = $this->routes[$method][$path] ?? false;
      if($callback === false){
         throw new NotFoundException();
      }
      if(is_string($callback)){
          return Application::$app->view->renderView($callback);
      }
      if(is_array($callback)){
          /** @var \atpro\phpmvc\Controller $controller */
          $controller = new $callback[0]();
          Application::$app->controller = $controller;
          $controller->action = $callback[1];
          $callback[0] = $controller;
          foreach($controller->getMiddlewares() as $middleware){
              $middleware->execute();
          }

      }

      return call_user_func($callback, $this->request, $this->response);
    }

}