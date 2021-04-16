<?php


namespace atpro\phpmvc;

use atpro\phpmvc\middlewares\BaseMiddleware;

/**
 * @Author Assane Dione
 * Controller General
 * Class Controller
 * @package atpro\phpmvc
 */
class Controller
{
    public string $layout = 'main';

    public string $action = '';

    /**
     * @var BaseMiddleware[]
     */
    protected array $middlewares =[];

    /**
     * @return BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
    /**
     * Permet d'initialiser un layout
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * Permet de rendre un vue avec des parametres possible
     * @param $view
     * @param array $params
     * @return mixed
     */
    public  function render($view, $params= [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}