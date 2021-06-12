<?php


namespace atpro\phpmvc;

/**
 * @Author Assane Dione
 * Class View
 * @package atpro\phpmvc
 */
class View
{
    public string $title = '';

    /**
     * @param string $view *la vue àrendre
     * @param array $params * les parametres à envoyer à la vue
     * @return array|false|string|string[]
     */
    public function renderView(string $view, array $params= [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Permet de rendre un layout
     * @return false|string
     */
    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }


        ob_start();
        include_once Application::$_ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    /**
     * @param $view *la vue à afficher
     * Exemple: accueil
     * @param $params * tableau de parametre à envoyer à la vue
     * @return false|string
     */
    protected function renderOnlyView($view, $params)
    {
        foreach($params as $key =>$value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$_ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}